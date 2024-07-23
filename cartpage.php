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

<div class="order-container ">
  <h1 class="heading"><?= $_SESSION['namepage']?></h1>
    <div class="main_part">
      <div class="myPurchases container">
        <?php
        foreach ($info as $data): ?>
          <div class="purchase_card my_card" data-id="<?=$data['id']?>" >
              <a href="product.php?id=<?=$data['id']?>">
                <img src="<?php $cover= explode(",", $data['image']); print_r($cover[0])?>">
              </a>
              <a href="product.php?id=<?=$data['id']?>" class="card_title">
                  <h5><?=$data['title']?></h5>
              </a>
              <h3 id="myNewPrice"><?=$data['price'] . "&nbsp;"?></h3>
              <div class="counter">
                  <button id="minus" data-id="<?=$data['id']?>">
                      <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <rect width="40" height="40" rx="12" fill="#D2F2FF"/>
                          <path d="M12 20H28" stroke="#26A9E0" stroke-width="3" stroke-linecap="round"/>
                      </svg>
                  </button>
                  <input class="counter_input" maxlength="4" value="1" count="<?=$data['count']?>" data-id="<?=$data['id']?>">
                  <button id="plus" data-id="<?=$data['id']?>">
                      <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <rect width="40" height="40" rx="12" fill="#D2F2FF"/>
                          <path d="M12 20H28" stroke="#26A9E0" stroke-width="3" stroke-linecap="round"/>
                          <path d="M20 28V12" stroke="#26A9E0" stroke-width="3" stroke-linecap="round"/>
                      </svg>
                  </button>
              </div>
              <button class="delete_btn" data-id="<?=$data['id']?>">
              <svg width="26" height="28" viewBox="0 0 26 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2 6.79999H4.4H23.6" />
                  <path d="M21.2 6.8L20.1171 23.6C20.1171 24.2365 19.8642 24.847 19.4141 25.2971C18.9641 25.7471 18.3536 26 17.7171 26H7.8829C7.24638 26 6.63593 25.7471 6.18585 25.2971C5.73576 24.847 5.4829 24.2365 5.4829 23.6L4.39999 6.8M7.99999 6.8V4.4C7.99999 3.76348 8.25285 3.15303 8.70294 2.70294C9.15303 2.25286 9.76347 2 10.4 2H15.2C15.8365 2 16.447 2.25286 16.897 2.70294C17.3471 3.15303 17.6 3.76348 17.6 4.4V6.8"/>
              </svg>
              </button>
              <button class="fav_btn like" data-id="<?=$data['id']?>">
              <svg width="28" height="26" viewBox="0 0 28 26" xmlns="http://www.w3.org/2000/svg">
              <path d="M8 2C4.6868 2 2 4.73373 2 8.10648C2 10.8291 3.05 17.2909 13.3856 23.8229C13.5707 23.9387 13.7833 24 14 24C14.2167 24 14.4293 23.9387 14.6144 23.8229C24.95 17.2909 26 10.8291 26 8.10648C26 4.73373 23.3132 2 20 2C16.6868 2 14 5.70089 14 5.70089C14 5.70089 11.3132 2 8 2Z"/>
              </svg>
              </button>
          </div>
        <?php endforeach;?>
      </div>
      <div class="total">
              <div class="total_price">
                  <h2>Итого:</h2>
                  <h2 id="total_price"></h2>
              </div>
              <form method="POST" action="orderpage.php" id="confirmform">
              <input type="hidden" id="confirmBtn" name="confirmBtn" value="">
              <button type="submit" class="total_btn">Оформить заказ</button></form>
      </div>
    </div>
</div>
    <form method="POST" action="main.php" id="myForm">
      <input type="hidden" id="myFavBtn" name="myFavBtn" value="">
    </form>
    <form method="POST" action="" id="myCartForm">
      <input type="hidden" id="myCartBtn" name="myCartBtn" value="">
    </form>
    <form method="POST" action="" id="countForm">
      <input type="hidden" id="countBtn" name="countBtn" value="">
    </form>
  <script src="script.js" defer></script>
</body>
</html>