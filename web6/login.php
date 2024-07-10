<?php

  /**
   * Файл login.php для не авторизованного пользователя выводит форму логина.
   * При отправке формы проверяет логин/пароль и создает сессию,
   * записывает в нее логин и id пользователя.
   * После авторизации пользователь перенаправляется на главную страницу
   * для изменения ранее введенных данных.
   **/

  // Отправляем браузеру правильную кодировку,
  // файл login.php должен быть в кодировке UTF-8 без BOM. 
  header('Content-Type: text/html; charset=UTF-8');
  session_start();
  // В суперглобальном массиве $_SESSION хранятся переменные сессии.
  // Будем сохранять туда логин после успешной авторизации.
  if (!empty($_SESSION['login'])) {
    // Если есть логин в сессии, то пользователь уже авторизован.
    // TODO: Сделать выход (окончание сессии вызовом session_destroy()
    //при нажатии на кнопку Выход).
    // Делаем перенаправление на форму.
    header('Location: ./');
    exit();
  }


  $error = '';

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  }
  else{
    // TODO: Проверть есть ли такой логин и пароль в базе данных.
    // Выдать сообщение об ошибках.
    require('connection.php');
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    try {
      $stmt = $db->prepare("SELECT id FROM users WHERE login = ? and password = ?");
      $stmt->execute([$login, $password]);
      $its = $stmt->rowCount();
      if($its){
        $uid = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['id'];
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['user_id'] = $uid;
        // Делаем перенаправление.
        header('Location: ./');
      }
      else{
        $error = 'Неверный логин или пароль';
      }
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
  }

  // В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
  // и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="libs/bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style8.css">
    <script src="libs/jquery-3.4.1.min.js"></script>
    <title>Задание 5</title>
</head>
<body>
  <div class="pform pformAuth">
    <form action="" method="post">
      <div class="message" style="color: red;"><?php echo $error; ?></div>
      <h3>Авторизация</h3>
        <div>
          <input class="w100" type="text" name="login" placeholder="Логин">
        </div>
        <div>
          <input class="w100" type="text" name="password" placeholder="Пароль">
        </div>
        <button type="submit">Войти</button>
    </form>
  </div>
</body>
</html>