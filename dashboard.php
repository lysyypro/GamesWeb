<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'GamesWeb');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>GamesWeb</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div id="wcag-bar">
<span>Tekst:</span>
<button class="wcag-a" data-size="small">A</button>
<button class="wcag-a" data-size="medium">A+</button>
<button class="wcag-a" data-size="large">A++</button>
<button id="theme-toggle">☀️</button>
</div>
<header>
<img src="logo.svg" id="logo" alt="GamesWeb">
<h1>GamesWeb</h1>
<nav>
<a href="dashboard.php">Biblioteka</a>
<a href="#kontakt">Kontakt</a>
</nav>
<?php if (isset($_SESSION['user_id'])): ?>
<div class="userinfo">
    Zalogowany jako <strong><?= htmlspecialchars($_SESSION['user_login']) ?></strong>
<?php if (!empty($_SESSION['user_avatar'])): ?>
<img src="<?= htmlspecialchars($_SESSION['user_avatar']) ?>" alt="avatar">
<?php else: ?>
<img src="default.jpg" id="avatar" alt="avatar">
<?php endif; ?>
<a href="logout.php">Wyloguj</a>
</div>
<?php else: ?>
<div class="hbtns">
<a href="login.php">Zaloguj się</a>
<a href="register.php" class="reg">Rejestracja</a>
</div>
<?php endif; ?>
</header>
<div id="wrap">
<main>
<h2>Biblioteka gier</h2>
<div class="gry">

  <a href="gtav.php" class="gra">
    <div class="okl"><img src="zdj/gtav/MainG.jpg" alt="GTA V"></div>
    <div class="gi">
      <h3>GTA V</h3>
      <p>Action · 2013</p>
      <span class="score">9.5</span>
    </div>
  </a>

  <a href="rdr2.php" class="gra">
    <div class="okl"><img src="zdj/rdr2/MainR.gif" alt="RDR2"></div>
    <div class="gi">
      <h3>Red Dead Redemption 2</h3>
      <p>Action · 2018</p>
      <span class="score">9.8</span>
    </div>
  </a>

  <a href="gowr.php" class="gra">
    <div class="okl"><img src="zdj/GoWR/MainG.jpg" alt="God of War Ragnarök"></div>
    <div class="gi">
      <h3>God of War Ragnarök</h3>
      <p>Action · 2022</p>
      <span class="score">9.7</span>
    </div>
  </a>

  <a href="beyond.php" class="gra">
    <div class="okl"><img src="zdj/b2s/MainB.jpg" alt="Beyond: Two Souls"></div>
    <div class="gi">
      <h3>Beyond: Two Souls</h3>
      <p>Adventure · 2013</p>
      <span class="score">8.5</span>
    </div>
  </a>

</div>
</main>
<aside>
<p style="font-size:.75rem;color:var(--muted);margin-bottom:6px">Reklamy</p>
<div class="rek">Reklama</div>
<div class="rek">Reklama</div>
</aside>
</div>
<footer id="kontakt">
<p>Kontakt: <a href="mailto:kontakt@gamesweb.pl">kontakt@gamesweb.pl</a></p>
</footer>
<script src="wcag.js"></script>
</body>
</html>