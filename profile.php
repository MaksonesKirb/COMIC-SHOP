<?php
  require('db.php');

  $idArray = [];
  $idArrays = [];
  $price_array = [];
  $count_array = [];
  $counts_array = [];


$query = $db->query("SELECT * FROM products");
  $info = $query->fetchAll(PDO::FETCH_ASSOC);
if (isset($_SESSION["user"]['user_id'])){
    $user_id =  $_SESSION["user"]['user_id'];
    $user = $db->query("SELECT * FROM users WHERE user_id = '$user_id'")->fetchAll(PDO::FETCH_ASSOC);
    $orders = $db->query("SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY `orders`.`id` DESC")->fetchAll(PDO::FETCH_ASSOC);
    foreach ( $orders as $data):
    $a = explode("; ", $data['order_info']);
    $aa = explode(": ", $a[array_key_last($a)]);
    $aaa = explode(" ",  $aa[array_key_last($aa)]);
    array_push($price_array, $aaa[array_key_first($aaa)]); 
    foreach ( $a as $aaaa):
    $aaaaa = explode(" кол-во: ", $aaaa);
    if (count($aaaaa)> 1 ){
      array_push($count_array, $aaaaa[1]);
    }
    foreach ( $aaaaa as $ab):
    $infoo = $db->query("SELECT * FROM products WHERE title LIKE '%$ab%'")->fetchAll(PDO::FETCH_ASSOC); 
    foreach ( $infoo as $ac):
    array_push($idArray, $ac['id']); 
    endforeach;
    endforeach;
    endforeach;
    array_push($idArrays, $idArray);
    $idArray = []; 
    array_push($counts_array, $count_array);
    $count_array = [];
    endforeach;
}

if (isset($_POST["cancel"])) {
  $order_id = $_POST["order_id"];
  $cancel = $_POST["cancel"];
        $cancelupdate = $db->query("UPDATE orders SET status = '$cancel' WHERE id = '$order_id'");
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
                    <a href="login.php" class="user-nav_link" id="exit">
                      <img src="image/profile.svg" alt="">
                      <h6>Выйти</h6></a>
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
      <h1 class="heading">Заказы</h1> 
      <div class="main_part">
          <div class="myOrder">
                <?php for ($i=0; $i<count($orders); $i++) { ?>
                  <div class="orders_card">
                  <div class="order_list_info">
                    <h5 id='status'>Заказ №<?=$orders[$i]['id']?> от <?=$orders[$i]['date']?><br>Статус заказа: <?=$orders[$i]['status']?></h5>

                    <div class="cancel" id="cancel" order_id="<?=$orders[$i]['id']?>">
                    <h5>Отменить</h5></div>
                    <h2><?=$price_array[$i]?></h2>
                </div>
                    <div class="order_list">
                    <?php for ($j=0; $j<count($idArrays[$i]); $j++) {foreach ($info as $datas):  if ($idArrays[$i][$j] == $datas['id']) {?>
                      <div class="order_list_count">
                    <a href="product.php?id=<?=$datas['id']?>" >
                    <img src="<?php $cover= explode(",", $datas['image']); print_r($cover[0])?>"    alt="">
                    </a> 
                    <h6><?=$counts_array[$i][$j]?></h6> </div>    
                    <?php } endforeach;}  ?>
                    </div>
              </div>
              <?php }?>
              </div>
              <div class="total">
              
                  <h2>Ваше имя: <?=$user[0]['name']?></h2>
                  <h2>Ваша почта: <?=$user[0]['email']?></h2>
                  <a href='change.php'>Сменить пароль</a>
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