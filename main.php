<?php
  require('db.php');
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

    <div class="justify_container">
      <h1 class="heading"><?= $_SESSION['namepage']?></h1>
      <form action="" method="GET"> 
        <div class="sorting">
          <h5>Сортировка</h5>
          <img src="image/sort_icon.svg" alt="" draggable="false">
        </div>
        <div class="formbtn2">
          <button class='form-btn' type='submit' name="sort" value="price DESC" >по убыванию цены</button>
          <button class='form-btn' type='submit' name="sort" value="price ASC" >по возрастанию цены</button>
          <button class='form-btn' type='submit' name="sort" value="title" >по алфавиту</button>
          <button class='form-btn' type='submit' name="sort" value="id" >по умолчанию</button>
        </div>
      </form>
    </div>

    <div class="cards-container container">
    <?php 
      if ((isset($_GET['category']) || isset($_GET['sort'])) && $_SESSION['change_category'] !== null ) {
          foreach ($info as $data): ?>
          <div class="card my_card" data-id="<?=$data['id']?>">
                <a href="product.php?id=<?=$data['id']?>" class="card_img">
                <img src="<?php $cover= explode(",", $data['image']); print_r($cover[0])?>"    alt="">
                </a>
                <a href="product.php?id=<?=$data['id']?>">
                  <h5>
                    <?=$data['title']?>
                  </h5>
                </a>
                <div class="card_bottom">
                  <h1>
                  <?=$data['price']?>
                  </h1>
                  <?php if (isset($_SESSION['user']['user_id'])) {  ?>
                  <button class="fav_btn like" data-id="<?=$data['id']?>">
                  <svg width="28" height="26" viewBox="0 0 28 26" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8 2C4.6868 2 2 4.73373 2 8.10648C2 10.8291 3.05 17.2909 13.3856 23.8229C13.5707 23.9387 13.7833 24 14 24C14.2167 24 14.4293 23.9387 14.6144 23.8229C24.95 17.2909 26 10.8291 26 8.10648C26 4.73373 23.3132 2 20 2C16.6868 2 14 5.70089 14 5.70089C14 5.70089 11.3132 2 8 2Z"/>
                  </svg>
                  </button>
                  <button class="card_cart" data-id="<?=$data['id']?>">
                  <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="62" height="62" rx="31" />
                  <path d="M26 41.0001C26.5523 41.0001 27 40.5523 27 40.0001C27 39.4478 26.5523 39.0001 26 39.0001C25.4477 39.0001 25 39.4478 25 40.0001C25 40.5523 25.4477 41.0001 26 41.0001Z" fill="white" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M37 41.0001C37.5523 41.0001 38 40.5523 38 40.0001C38 39.4478 37.5523 39.0001 37 39.0001C36.4477 39.0001 36 39.4478 36 40.0001C36 40.5523 36.4477 41.0001 37 41.0001Z" fill="white" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M18 20H22L24.68 33.39C24.7714 33.8504 25.0219 34.264 25.3875 34.5583C25.7532 34.8526 26.2107 35.009 26.68 35H36.4C36.8693 35.009 37.3268 34.8526 37.6925 34.5583C38.0581 34.264 38.3086 33.8504 38.4 33.39L40 25H23" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  </button>
                  <?php } else { ?>
                    <a href="login.php">
                    <svg width="28" height="26" viewBox="0 0 28 26" fill="#ffffff" xmlns="http://www.w3.org/2000/svg">
<path d="M8 2C4.6868 2 2 4.73373 2 8.10648C2 10.8291 3.05 17.2909 13.3856 23.8229C13.5707 23.9387 13.7833 24 14 24C14.2167 24 14.4293 23.9387 14.6144 23.8229C24.95 17.2909 26 10.8291 26 8.10648C26 4.73373 23.3132 2 20 2C16.6868 2 14 5.70089 14 5.70089C14 5.70089 11.3132 2 8 2Z" stroke="#9C9C9C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
      
                    </a>
                    <a href="login.php">
                    <img src="image/cart_button.svg" alt="">

                    </a>
                  <?php } ?>
                </div>
            </div>
            <?php endforeach; } else 
        {
          foreach ($info as $data): ?>
            <div class="card my_card" data-id="<?=$data['id']?>">
                <a href="product.php?id=<?=$data['id']?>" class="card_img">
                <img src="<?php $cover= explode(",", $data['image']); print_r($cover[0])?>"    alt="">
                </a>
                <a href="product.php?id=<?=$data['id']?>">
                  <h5>
                    <?=$data['title']?>
                  </h5>
                </a>
                <div class="card_bottom">
                  <h1>
                  <?=$data['price']?>
                  </h1>
                  <?php if (isset($_SESSION['user']['user_id'])) {  ?>
                  <button class="fav_btn like" data-id="<?=$data['id']?>">
                  <svg width="28" height="26" viewBox="0 0 28 26" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8 2C4.6868 2 2 4.73373 2 8.10648C2 10.8291 3.05 17.2909 13.3856 23.8229C13.5707 23.9387 13.7833 24 14 24C14.2167 24 14.4293 23.9387 14.6144 23.8229C24.95 17.2909 26 10.8291 26 8.10648C26 4.73373 23.3132 2 20 2C16.6868 2 14 5.70089 14 5.70089C14 5.70089 11.3132 2 8 2Z"/>
                  </svg>
                  </button>
                  <button class="card_cart" data-id="<?=$data['id']?>">
                  <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="62" height="62" rx="31" />
                  <path d="M26 41.0001C26.5523 41.0001 27 40.5523 27 40.0001C27 39.4478 26.5523 39.0001 26 39.0001C25.4477 39.0001 25 39.4478 25 40.0001C25 40.5523 25.4477 41.0001 26 41.0001Z" fill="white" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M37 41.0001C37.5523 41.0001 38 40.5523 38 40.0001C38 39.4478 37.5523 39.0001 37 39.0001C36.4477 39.0001 36 39.4478 36 40.0001C36 40.5523 36.4477 41.0001 37 41.0001Z" fill="white" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M18 20H22L24.68 33.39C24.7714 33.8504 25.0219 34.264 25.3875 34.5583C25.7532 34.8526 26.2107 35.009 26.68 35H36.4C36.8693 35.009 37.3268 34.8526 37.6925 34.5583C38.0581 34.264 38.3086 33.8504 38.4 33.39L40 25H23" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  </button>
                  <?php } else { ?>
                    <a href="login.php">
                    <svg width="28" height="26" viewBox="0 0 28 26" fill="#ffffff" xmlns="http://www.w3.org/2000/svg">
<path d="M8 2C4.6868 2 2 4.73373 2 8.10648C2 10.8291 3.05 17.2909 13.3856 23.8229C13.5707 23.9387 13.7833 24 14 24C14.2167 24 14.4293 23.9387 14.6144 23.8229C24.95 17.2909 26 10.8291 26 8.10648C26 4.73373 23.3132 2 20 2C16.6868 2 14 5.70089 14 5.70089C14 5.70089 11.3132 2 8 2Z" stroke="#9C9C9C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
      
                    </a>
                    <a href="login.php">
                    <img src="image/cart_button.svg" alt="">

                    </a>
                  <?php } ?>
                </div>
            </div>
            <?php endforeach; } ?>
         
    </div>                  
    <form method="POST" action="" id="myForm">
    <input type="hidden" id="myFavBtn" name="myFavBtn" value="">
    </form>
    <form method="POST" action="cartpage.php" id="myCartForm">
      <input type="hidden" id="myCartBtn" name="myCartBtn" value="">
    </form>
  <script src="script.js" defer></script>
</body>
</html>