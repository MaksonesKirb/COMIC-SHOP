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
<?php if (isset($_SESSION['validation'])) {
foreach ($_SESSION['validation'] as $errors):?>
<div class='error_message'>
      <h3><?= $errors ?></h3>
    </div>
    <?php endforeach;}?>
    <div class="modal">
      <div class="modal_box">
        <form class="modal_form" method="POST" action="">
            <h1>Смена пароля</h1>
            <div class="modal_input">
            <h4>E-mail:</h4>
            <input type="text"  placeholder="example@gmail.com" value="<?= old(key: 'email')?>" name="change_email" id="change_email" required >
          </div>
          <div class="modal_input">
            <h4>Пароль:</h4>
            <input type="password"  placeholder="password" value="" name="change_password" id="change_password" required>
          </div>
          <button class="modal_btn" type="submit">Отправить данные</button>        
        </form>
      </div>
    </div>
    <?php $_SESSION['validation'] = []?>
  <script src="script.js" defer></script>
</body>
</html>