<?php
session_start();

$db = new PDO("mysql:host=localhost;dbname=comics; charset=utf8", "root", "12345");


$info = [];
$category = [];

$sort = 'id';

$namepage= 'Главная';


//если ткнули просто на категорию присваиваем категорию и сохраняем в сессии//
if (isset($_GET['category'])) {
  $_GET['category'] === 'Комиксы Marvel' ? $change_category='1' : '';
  $_GET['category'] === 'Комиксы DC'? $change_category='2' : '';
  $_GET['category'] === 'Комиксы для детей' ? $change_category='3' : '';
  $_GET['category'] === 'Комиксы по франшизам' ? $change_category='4' : '';
  $_GET['category'] === 'Фэнтези и фантастика' ? $change_category='5' : '';
  $_GET['category'] === 'Супергеройка' ? $change_category='6' : '';
  $_GET['category'] === 'Альтернатива' ? $change_category='7' : '';
  $_GET['category'] === 'Комиксы русских авторов' ? $change_category='8' : '';
  $_SESSION['change_category'] = $change_category ;
 
} 

if (isset($_GET['category'])) {
  $_GET['category'] === 'Комиксы Marvel' ? $namepage = $_GET['category'] : '';
  $_GET['category'] === 'Комиксы DC'? $namepage = $_GET['category'] : '';
  $_GET['category'] === 'Комиксы для детей' ? $namepage = $_GET['category'] : '';
  $_GET['category'] === 'Комиксы по франшизам' ? $namepage = $_GET['category'] : '';
  $_GET['category'] === 'Фэнтези и фантастика' ? $namepage = $_GET['category'] : '';
  $_GET['category'] === 'Супергеройка' ? $namepage = $_GET['category'] : '';
  $_GET['category'] === 'Альтернатива' ? $namepage = $_GET['category'] : '';
  $_GET['category'] === 'Комиксы русских авторов' ? $namepage = $_GET['category'] : '';
  $_SESSION['namepage'] = $namepage;
} 


//если просто ткнули сортировку сортируем//
if (isset($_GET['sort'])) {
  $_GET['sort'] === 'price DESC' ? $sort='price DESC' : '';
  $_GET['sort'] === 'price ASC'? $sort='price ASC' : '';
  $_GET['sort'] === 'title' ? $sort='title' : '';
  $_GET['sort'] === 'id' ? $sort='id' : '';
}

//если хотим отсортировать поиск//
if ( $_SESSION['title'] !==null && isset($_GET['sort']) ){
  $title = $_SESSION['title'];
  if ($query = $db->query("SELECT * FROM products WHERE title LIKE '%$title%' ORDER BY $sort")) {
  $info = $query->fetchAll(PDO::FETCH_ASSOC);
  if (!empty($info)){
  $_SESSION['namepage']= "Результаты по запросу: ". $title;}
  else { $_SESSION['namepage']= "Результаты по запросу: ". $title. " не найдены"; }
}}

//если зашли и сразу на поиск//
if (isset($_GET['search'])){
  $title = $_GET['search'];
  $_SESSION['main']=null;
  $_SESSION['title']=$title;
  $_SESSION['change_category'] = null ;
  $_SESSION['myCartBtn']= null;
  if ($query = $db->query("SELECT * FROM products WHERE title LIKE '%$title%' ORDER BY $sort")) {
  $info = $query->fetchAll(PDO::FETCH_ASSOC);
  if (!empty($info)){
  $_SESSION['namepage']= "Результаты по запросу: ". $_GET['search'];}
  else { $_SESSION['namepage']= "Результаты по запросу: ". $_GET['search']. " не найдены"; }
}}

//если ткнули сортировку уже в каталоге//
 if (isset($_SESSION['change_category']) && isset($_GET['sort'])) {
  $change_category = $_SESSION['change_category'];
 if ($query = $db->query("SELECT * FROM products WHERE id_category='$change_category' ORDER BY $sort")) {
    $info = $query->fetchAll(PDO::FETCH_ASSOC);
  } else {
  print_r($db->errorInfo());
  }}

//если вышли на главную после каталога//
  if (!isset($_GET['sort']) && !isset($_GET['category']) && !isset($_GET['search']) && !isset($_POST['countBtn'])) {
    $_SESSION['main']='1';
    $_SESSION['namepage'] = 'Главная';
    $_SESSION['title']= null;
    $_SESSION['change_category']= null;
    $_SESSION['myCartBtn']= null;
    if ($query = $db->query("SELECT * FROM products ORDER BY $sort")) {
      $info = $query->fetchAll(PDO::FETCH_ASSOC);
  } else {
    print_r($db->errorInfo());
  }}

  //сортировка когда вышли на главную после каталога//
  if (isset($_GET['sort']) && $_SESSION['change_category']===null && $_SESSION['main'] !== null) {
    if ($query = $db->query("SELECT * FROM products ORDER BY $sort")) {
      $info = $query->fetchAll(PDO::FETCH_ASSOC);
      $_SESSION['title']= null;
  } else {
    print_r($db->errorInfo());
  };
}

  //крафтим массив данных если нажали на категорию//
  if (isset($_GET['category'])) {
   if ($query = $db->query("SELECT * FROM products WHERE id_category='$change_category' ORDER BY $sort")) {
      $info = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
    print_r($db->errorInfo());
    }
    $_SESSION['main']= null;
    $_SESSION['title']= null;
    $_SESSION['myCartBtn']= null; }
 

//крафтим массив данных для кнопок каталога//
if ($query_category = $db->query("SELECT * FROM category")) {
  $category = $query_category->fetchAll(PDO::FETCH_ASSOC);
} else {
print_r($db->errorInfo());
}

if (isset($_POST['myFavBtn'])) {
  if ($_POST['myFavBtn'] === 'empty') {
    $_SESSION['namepage'] = 'Вы пока ничего не добавили в избранное';
    $info = $query->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $myValue = implode( ", " ,json_decode($_POST['myFavBtn']));
    $_SESSION['namepage'] = 'Избранное ' . '(' . count(explode(",", $myValue)) . ')';
    $query = $db->query("SELECT * FROM products WHERE id IN ($myValue) ORDER BY FIELD (id, $myValue)");
    $info = $query->fetchAll(PDO::FETCH_ASSOC);
  }
  $_SESSION['myCartBtn']= null;
}

if (isset($_POST['myCartBtn'])) {
    $_SESSION['myCartBtn'] = $_POST['myCartBtn'];
    if ($_POST['myCartBtn'] === 'empty') {
      $_SESSION['namepage'] = 'Вы пока ничего не добавили в корзину';
      $info = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
      $myCartValue = implode( ", " ,json_decode($_SESSION['myCartBtn']));
      $_SESSION['namepage'] = 'Корзина ' . '(' . count(explode(",", $myCartValue)) . ')';
      $query = $db->query("SELECT * FROM products WHERE id IN ($myCartValue) ORDER BY FIELD (id, $myCartValue)");
      $info = $query->fetchAll(PDO::FETCH_ASSOC);
    }
  }

  if ($_SESSION['myCartBtn'] !== null) {
    $_POST['myCartBtn'] = $_SESSION['myCartBtn'];
    if ($_POST['myCartBtn'] === 'empty') {
      $_SESSION['namepage'] = 'Вы пока ничего не добавили в корзину';
      $info = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
      $myCartValue = implode( ", " ,json_decode($_SESSION['myCartBtn']));
      $_SESSION['namepage'] = 'Корзина ' . '(' . count(explode(",", $myCartValue)) . ')';
      $query = $db->query("SELECT * FROM products WHERE id IN ($myCartValue) ORDER BY FIELD (id, $myCartValue)");
      $info = $query->fetchAll(PDO::FETCH_ASSOC);
    }
  }



  
if (isset($_POST['modal_fio'])) {
  $name = $_POST['modal_fio'];
  $email = $_POST['modal_email'];
  $password = $_POST['modal_password'];
      addOldValue( 'name', $name);    
      addOldValue( 'email', $email);
  
      $_SESSION['validation'] = [];

  if (!filter_var($email , filter: FILTER_VALIDATE_EMAIL)){

    $_SESSION['validation']['email'] = 'Некорректная почта';
  } else {
  $query = $db->prepare( query: "SELECT * FROM users WHERE email = :email ");
  $query ->execute(['email'=> $email]);
  $user = $query->fetch(PDO::FETCH_ASSOC);
  if ($user) {
    $_SESSION['validation']['email'] = 'Этот email уже используется';
  }
  }
  if (empty($_SESSION['validation'])){
      $newQuery = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
      $params = [
        'name' => $name ,
        'email' => $email ,
        'password' => password_hash($password, algo: PASSWORD_DEFAULT) ,
      ];
      $stmt = $db->prepare($newQuery);
      try {
      $stmt->execute($params);
      } catch (\Exeption $e) {
        die($e->getMessage());
      }
    header(header: 'Location: login.php' );
      die();
  }
}

if (isset($_POST['email'])) {
  $emailauth = $_POST['email'];
  $passwordauth = $_POST['password'];   
  addOldValue( 'email', $emailauth);
  $_SESSION['validation'] = [];
if (!filter_var($emailauth , filter: FILTER_VALIDATE_EMAIL)){
    $_SESSION['validation']['emailauth'] = 'Некорректная почта';
  }
if (empty($_SESSION['validation'])){
  $queryauth = $db->prepare( query: "SELECT * FROM users WHERE email = :email ");
  $queryauth ->execute(['email'=> $emailauth]);
  $user = $queryauth->fetch(PDO::FETCH_ASSOC);
  if (!$user) {
    $_SESSION['validation']['user'] = 'Такой пользователь не зарегистрирован';
  } else {
  if (password_verify($passwordauth, $user['password'])){
  $_SESSION['user']['user_id']= $user['user_id'];
  header(header: 'Location: main.php' );
  die();} else {
    $_SESSION['validation']['passwordauth'] = 'Неверный пароль!';
} } 
}
}


function addOldValue( string $key, mixed $value)
{
  $_SESSION['old'][$key]=$value;
}
function old( string $key)
{
  return $_SESSION['old'][$key] ?? '';
}






if (isset($_POST["checkout"])) {
$user_id =  $_SESSION["user"]['user_id'];
$cart = implode(", ", json_decode($_POST['checkout']));
      $userFC = $db->query("UPDATE users SET cart = '$cart' WHERE user_id = '$user_id'");
} 


if (isset($_POST["checkoutfav"])) {
  $user_id =  $_SESSION["user"]['user_id'];
  $favs = implode(", ", json_decode($_POST['checkoutfav']));
        $userFC = $db->query("UPDATE users SET favorite = '$favs' WHERE user_id = '$user_id'");
  } 

  if (isset($_SESSION["user"]['user_id'])){
  $user_id =  $_SESSION["user"]['user_id'];
  $userF = $db->query("SELECT (favorite) FROM users WHERE user_id = '$user_id'")->fetchAll(PDO::FETCH_ASSOC);
  $userC = $db->query("SELECT (cart) FROM users WHERE user_id = '$user_id'")->fetchAll(PDO::FETCH_ASSOC);
    if ($userF[0]['favorite'] !== "") {
      print_r('<div class="hidden" id="userF">' . $userF[0]['favorite'] . '</div>');
    } else {
      print_r('<div class="hidden" id="userF">' . 'empty' . '</div>');
    }

    if ($userC[0]['cart'] !== "") {
      print_r('<div class="hidden" id="userC">' . $userC[0]['cart'] . '</div>');
    } else {
      print_r('<div class="hidden" id="userC">' . 'empty' . '</div>');
    }
   
    print_r('<div class="hidden" id="user_id">' . $user_id . '</div>');
    
} else {
      print_r('<div class="hidden" id="user_id">' . 'empty' . '</div>');
    }








    if (isset($_POST['change_email'])) {
      $email = $_POST['change_email'];
      $password = $_POST['change_password'];   
          addOldValue( 'email', $email);
      
          $_SESSION['validation'] = [];
    
          if (!filter_var($email , filter: FILTER_VALIDATE_EMAIL)){
            $_SESSION['validation']['email'] = 'Некорректная почта';
          }
        if (empty($_SESSION['validation'])){
          $queryauth = $db->prepare( query: "SELECT * FROM users WHERE email = :email ");
          $queryauth ->execute(['email'=> $email]);
          $user = $queryauth->fetch(PDO::FETCH_ASSOC);
          if (!$user) {
            $_SESSION['validation']['user'] = 'Такой пользователь не зарегистрирован';
          } else {
            $newQuery = "UPDATE users SET password = :password WHERE  email='$email'";
            $params = [
              'password' => password_hash($password, algo: PASSWORD_DEFAULT) ,
            ];
            $stmt = $db->prepare($newQuery);
            try {
            $stmt->execute($params);
            } catch (\Exeption $e) {
              die($e->getMessage());
            }
          header(header: 'Location: login.php' );
            die();
          } 
        }
    }
    




  ?>