<?php
  require('db.php');
  $_SESSION['user']=[];
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
<?php if (isset($_SESSION['validation'])) {
foreach ($_SESSION['validation'] as $errors):?>
<div class='error_message'>
      <h3><?= $errors ?></h3>
    </div>
    <?php endforeach;}?>
    <div class="modal">
      <div class="modal_box">
        <form class="modal_form" method="POST" action="">
            <h1>Вход</h1>
          <div class="modal_input">
          <input type="text"  placeholder="example@gmail.com" value="<?= old(key: 'email')?>" name="email" id="email" required >
          </div>
          <div class="modal_input">
            <input type="password"  placeholder="Пароль" value="" name="password" id="password" required>
          </div>
          <button class="modal_btn" type="submit">Войти</button>        
          <a href='register.php'> Нет аккаунта </a>
          <a href='change.php'> Забыли пароль? </a>
        </form>
      </div>
    </div>
    <?php $_SESSION['validation'] = []?>
  <script src="script.js" defer></script>
</body>
</html>