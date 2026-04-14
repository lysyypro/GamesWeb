<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'Gamesdb');

$games = mysqli_fetch_all(mysqli_query($conn, '
    SELECT t.id, t.title, t.release_year, t.avg_score, g.name AS genre
    FROM Titles t
    LEFT JOIN Genres g ON t.genre_id = g.id
    ORDER BY t.avg_score DESC
'), MYSQLI_ASSOC);

$colors = ['#c0273a','#a455cc','#1a7fc1','#2a9d6a','#d4762a'];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>GamesWeb</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <img src="logo.svg" id="logo" alt="GamesWeb">
  <h1>GamesWeb</h1>
  <nav>
    <a href="dashboard.php">Biblioteka</a>
    <a href="#kontakt">Kontakt</a>
  </nav>
  <?php if (isset($_SESSION['user_id'])): ?>
    <div class="userinfo">
      Zalogowany jako <strong><?= $_SESSION['user_login'] ?></strong>
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
      <?php foreach ($games as $i => $g): ?>
      <a href="game.php?id=<?= $g['id'] ?>" class="gra">
        <div class="okl" style="--ac:<?= $colors[$i % 5] ?>"></div>
        <div class="gi">
          <h3><?= $g['title'] ?></h3>
          <p><?= $g['genre'] ?> · <?= $g['release_year'] ?></p>
          <span class="score"><?= $g['avg_score'] ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </main>
  <aside>
    <p style="font-size:.75rem;color:#7279a0;margin-bottom:6px">Reklamy</p>
    <div class="rek">Reklama</div>
    <div class="rek">Reklama</div>
  </aside>
</div>

<footer id="kontakt">
  <p>Kontakt: <a href="mailto:kontakt@gamesweb.pl">kontakt@gamesweb.pl</a></p>
</footer>

</body>
</html>
