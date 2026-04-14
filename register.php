<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$conn = mysqli_connect('localhost', 'root', '', 'Gamesdb');
$err = '';
$ok  = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $email = $_POST['email'];
    $pass  = $_POST['password'];
    $pass2 = $_POST['password2'];

    if ($pass != $pass2) {
        $err = 'Hasła się nie zgadzają.';
    } elseif (strlen($pass) < 8) {
        $err = 'Hasło musi mieć co najmniej 8 znaków.';
    } else {
        $check = mysqli_query($conn, "SELECT id FROM Users WHERE login = '$login' OR email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            $err = 'Login lub e-mail jest już zajęty.';
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            mysqli_query($conn, "INSERT INTO Users (login, email, password) VALUES ('$login', '$email', '$hash')");
            $ok = 'Konto założone! Możesz się teraz zalogować.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Rejestracja – GamesWeb</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <img src="logo.svg" id="logo" alt="GamesWeb">
  <h1>GamesWeb</h1>
  <nav><a href="dashboard.php">Biblioteka</a></nav>
  <div class="hbtns">
    <a href="login.php">Zaloguj się</a>
    <a href="register.php" class="reg">Rejestracja</a>
  </div>
</header>

<div class="auth-page">
  <div class="auth-box">
    <h2>Utwórz konto</h2>
    <?php if ($err) echo '<p class="err">' . $err . '</p>'; ?>
    <?php if ($ok)  echo '<p class="ok">'  . $ok  . '</p>'; ?>
    <form method="post">
      <div class="fg">
        <label>Nazwa użytkownika</label>
        <input type="text" name="login" required>
      </div>
      <div class="fg">
        <label>E-mail</label>
        <input type="email" name="email" required>
      </div>
      <div class="fg">
        <label>Hasło</label>
        <input type="password" name="password" required>
      </div>
      <div class="fg">
        <label>Powtórz hasło</label>
        <input type="password" name="password2" required>
      </div>
      <button type="submit" class="btn">Zarejestruj się</button>
    </form>
    <p class="switch">Masz konto? <a href="login.php">Zaloguj się</a></p>
  </div>
</div>

<footer><p>Kontakt: <a href="mailto:kontakt@gamesweb.pl">kontakt@gamesweb.pl</a></p></footer>
</body>
</html>
