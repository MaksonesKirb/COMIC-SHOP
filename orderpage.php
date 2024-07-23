<?php
  require('db.php');

  $prices= [];
  $itemArray = [];
  $idArray = [];

  date_default_timezone_set("Europe/Samara");
  $months = [
    'января',
    'февраля',
    'марта',
    'апреля',
    'мая',
    'июня',
    'июля',
    'августа',
    'сентября',
    'октября',
    'ноября',
    'декабря'
  ];

  $month = date('n')-1;
  $date = date('d').' '.$months[$month].' '.date('Y');


  if (isset($_POST['confirmBtn'])) {
    $_SESSION['confirmBtn'] = $_POST['confirmBtn'];
  }
    foreach (json_decode($_SESSION['confirmBtn'],true) as $item):
      array_push($idArray, $item['getID']);
      array_push($prices, $item['totalPrice']);
      array_push($itemArray, $item);
    endforeach;    
    $newIdArray = implode(', ',$idArray);
  
  $query = $db->query("SELECT * FROM products WHERE id IN ($newIdArray) ORDER BY FIELD (id, $newIdArray)");
  $info = $query->fetchAll(PDO::FETCH_ASSOC);

  if (isset($_POST['user_info'])) {
    $user_info =  $_POST['user_info'];
    $arrayuserinfo= '';
    for ($i=0; $i < count($user_info); $i++) {
        if ($user_info[$i]['getID'] == $info[$i]['id']) {
        $arrayuserinfo .= $info[$i]['title'];
        $arrayuserinfo .= ' кол-во: '.$user_info[$i]['count'].' шт; ';
        }
      } 
      $arrayuserinfo .= ' ИТОГ: '.array_sum($prices).' руб';
      $newQuery = "INSERT INTO orders (user_id, order_info, date) VALUES (:user_id, :order_info, :date)";
      $params = [
        'user_id' => $user_id ,
        'order_info' => $arrayuserinfo ,
        'date' => $date ,
      ];
      $stmt = $db->prepare($newQuery);
      try {
      $stmt->execute($params);
      } catch (\Exeption $e) {
        die($e->getMessage());
      }
    header(header: 'Location: orderpage.php' );
      die();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Comics</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style1.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<div class='ordersucces hidden'>
      <h3>Заказ успешно оформлен!</h3>
    </div>
<header class="header">
  <div class="header_container">
      <a href="main.php" class="logo">
        <img src="image/logo.svg" alt="">
      </a>
      <div class="header_center">
        <form action="main.php" method="GET">
          <div class="catalog"> 
            <img src="image/catalog_icon.svg" alt="" draggable="false">
            <h5>Каталог</h5>
          </div>
          <div class="formbtn">
              <?php foreach ($category as $data_category): ?>
                <button class='form-btn' type='submit' name="category" value="<?=$data_category['name']?>">
                  <?=$data_category['name']?>
              </button>
              <?php endforeach; ?>
          </div>
        </form>
        <form action="main.php" method="GET">
          <div class="search">
            <img src="image/search_icon.svg" alt="">
            <input name="search" type="text" class="search-input" placeholder="Поиск">
          </div>
        </form>
      </div>
      <div class="user-nav">
      <?php if (isset($_SESSION['user']['user_id'])) {  ?>
                    <a href="profile.php" class="user-nav_link" id="exit">
                      <img src="image/profile.svg" alt="">
                      <h6>Профиль</h6></a>
                  <?php } else { ?>
                    <a href="login.php" class="user-nav_link" id="">
                      <img src="image/profile.svg" alt="">
                      <h6>Войти</h6>
                    </a>
                  <?php } ?>
          <a href="#" class="user-nav_link" id="favor">
            <img src="image/like_icon.svg" alt="">
            <h6>Избранное</h6>
          </a>
          <a href="#" class="user-nav_link" id="cart">
            <img src="image/cart_icon.svg" alt="">
            <h6>Корзина</h6>
          </a>  
      </div>
    </div>
</header>
    <div class="order-container">
      <h1 class="heading">Оформление заказа</h1>
        <div class="main_part">
          <div class="myOrder">
              <?php foreach ($info as $data): ?>
                  <div class="order_card" data-id="<?=$data['id']?>" >
                    <img src="<?php $cover= explode(",", $data['image']); print_r($cover[0])?>">
                    <h5><?=$data['title']?></h5>
                    <h3 ><span class='h4' ><?php for ($i=0; $i<count($itemArray); $i++) {
                      if ($itemArray[$i]['getID'] == $data['id']) {
                        print_r ($itemArray[$i]['count']);
                      }
                      }?> х</span> <?=$data['price'] . "&nbsp;"?></h3>
                  </div>
              <?php endforeach;?>
              <div class="order-total">
                  <h2>Итого:</h2>
                  <h2><?= number_format(array_sum($prices), 0, ' ', ' ');
                      ?></h2>
              </div>
          </div>
          <div class="delivery">
              <h4><span class='h3'>Доставка:</span> в пункт выдачи по адресу г. Тольятти, ул. 70 лет Октября, 11</h4>
              <h4><span class='h3'>Оплата: </span>в пункте выдачи заказов</h4>
              <h4><span class='h3'>Сроки доставки: </span>4-7 дней</h4>
              <button id="readyBtn" >Подтвердить заказ</button>
          </div>
        </div>
    </div>
    <form method="POST" action="main.php" id="myForm">
      <input type="hidden" id="myFavBtn" name="myFavBtn" value="">
    </form>
    <form method="POST" action="cartpage.php" id="myCartForm">
      <input type="hidden" id="myCartBtn" name="myCartBtn" value="">
    </form>
    <form method="POST" action="" id="countForm">
      <input type="hidden" id="countBtn" name="countBtn" value="">
    </form>
  <script src="script.js" defer></script>
</body>
</html>