<?php
  require('db.php');

$productId = $_GET['id'];

if ($query = $db->query("SELECT * FROM products WHERE id='$productId'")) {
    $info = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
      print_r($db->errorInfo());
    }
  
    foreach ($info as $images): 
      $pic = $images['image'];
      $image= explode(",", $pic);
    endforeach;

    foreach ($info as $data):
    endforeach;

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

    <div class="product-container">
            <div class="pictures" >
             <?php foreach ($image as $elem): ?>
                <img src="<?=$elem?>" class="pic" alt="">
            <?php endforeach; ?>  
            </div>
            <div class="big-pic" >
                <img src="<?=$image[0]?>" alt="" id="big-pic">
            </div>  
            <div class="information">
                <h1>
                    <?=$data['title']?>
                </h1>
                <div class="interection">
                    <p>
                        <?=$data['price']?>
                    </p> 
                    <?php if (isset($_SESSION['user']['user_id'])) {  ?>
                    <div class="btn_count">
                        <button class="count_btn card_cart" data-id="<?=$data['id']?>"></button>
                        <h6>В наличии <?=$data['count']?> шт.</h6>
                    </div>
                    <button class="heart like" data-id="<?=$data['id']?>">
                      <svg width="32" height="30" viewBox="0 0 28 26" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8 2C4.6868 2 2 4.73373 2 8.10648C2 10.8291 3.05 17.2909 13.3856 23.8229C13.5707 23.9387 13.7833 24 14 24C14.2167 24 14.4293 23.9387 14.6144 23.8229C24.95 17.2909 26 10.8291 26 8.10648C26 4.73373 23.3132 2 20 2C16.6868 2 14 5.70089 14 5.70089C14 5.70089 11.3132 2 8 2Z"/>
                      </svg>
                    </button>
                  <?php } else { ?>
                    <div class="btn_count">
                        <a class="count_btn" href="login.php">     
                          В КОРЗИНУ
                        </a>
                        <h6>В наличии <?=$data['count']?> шт.</h6>
                    </div>
                    <a href="login.php" class="heart">
                    <svg width="32" height="30" viewBox="0 0 28 26" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8 2C4.6868 2 2 4.73373 2 8.10648C2 10.8291 3.05 17.2909 13.3856 23.8229C13.5707 23.9387 13.7833 24 14 24C14.2167 24 14.4293 23.9387 14.6144 23.8229C24.95 17.2909 26 10.8291 26 8.10648C26 4.73373 23.3132 2 20 2C16.6868 2 14 5.70089 14 5.70089C14 5.70089 11.3132 2 8 2Z"/>
                      </svg>
                    </a>
                  <?php } ?>
                </div>
                <div class="desc_params">
                    <button id="desc_btn" class="desc_params_param desc-param_active" >Описание</button>
                    <button id="param_btn" class="desc_params_param">Характеристики</button>
                </div>
                <div class="description">
                    <h4><?=nl2br($data['description'])?></h4>
                </div>
                <div class="parametr hidden">
                  <h4>Автор<br>
                    Издательство<br>
                    Количество страниц<br>
                    ISBN<br>
                    Тип обложки<br>
                    Размер<br>
                    Возрастные ограничения</h4>
                  <h4><?=$data['autor']?><br>
                    <?=$data['publisher']?><br>
                    <?=$data['pages']?><br>
                    <?=$data['isbn']?><br>
                    <?=$data['cover']?><br>
                    <?=$data['size']?><br>
                    <?=$data['age_limit']?></h4>
                </div>   
        </div>
    </div>    
    <form method="POST" action="main.php" id="myForm">
    <input type="hidden" id="myFavBtn" name="myFavBtn" value="">
    </form>       
    <form method="POST" action="cartpage.php" id="myCartForm">
      <input type="hidden" id="myCartBtn" name="myCartBtn" value="">
    </form>       
  <script src="script.js" defer></script>
</body>
</html>