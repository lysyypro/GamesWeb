<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$conn = mysqli_connect('localhost', 'root', '', 'Gamesdb');
$err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $q    = mysqli_query($conn, "SELECT id, login, password FROM Users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($q);

    if (!$user) {
        $err = 'Nie znaleziono konta z tym e-mailem.';
    } elseif (!password_verify($pass, $user['password'])) {
        $err = 'Błędne hasło.';
    } else {
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_login'] = $user['login'];
        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Logowanie – GamesWeb</title>
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
    <h2>Zaloguj się</h2>
    <?php if ($err) echo '<p class="err">' . $err . '</p>'; ?>
    <form method="post">
      <div class="fg">
        <label>E-mail</label>
        <input type="email" name="email" required>
      </div>
      <div class="fg">
        <label>Hasło</label>
        <input type="password" name="password" required>
      </div>
      <button type="submit" class="btn">Zaloguj się</button>
    </form>
    <p class="switch">Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
  </div>
</div>

<footer><p>Kontakt: <a href="mailto:kontakt@gamesweb.pl">kontakt@gamesweb.pl</a></p></footer>
</body>
</html>
