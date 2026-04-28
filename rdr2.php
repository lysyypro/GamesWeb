<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'GamesWeb');

$game = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT t.*, g.name AS genre, d.name AS developer, d.country
    FROM Titles t
    LEFT JOIN Genres g ON t.genre_id = g.id
    LEFT JOIN Developers d ON t.developer_id = d.id
    WHERE t.id = 9
"));

$cast = mysqli_fetch_all(mysqli_query($conn, "
    SELECT p.first_name, p.last_name, p.birth_date, ch.character_name, ch.type
    FROM Casting ca
    JOIN Characters ch ON ca.character_id = ch.id
    JOIN Performers p  ON ca.performer_id = p.id
    WHERE ch.title_id = 9
"), MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_comment_id']) && isset($_SESSION['user_id'])) {
    $cid = (int)$_POST['delete_comment_id'];
    $uid = (int)$_SESSION['user_id'];
    mysqli_query($conn, "DELETE FROM Critiques WHERE id = $cid AND user_id = $uid");
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $content = trim(mysqli_real_escape_string($conn, $_POST['content']));
    $score   = (int)$_POST['score'];
    $uid     = (int)$_SESSION['user_id'];
    if ($content && $score >= 1 && $score <= 10) {
        mysqli_query($conn, "
            INSERT INTO Critiques (title_id, user_id, score, content)
            VALUES (9, $uid, $score, '$content')
        ");
        $flash = 'ok:Komentarz dodany!';
    } else {
        $flash = 'err:Wypełnij treść i ocenę.';
    }
}

$comments = mysqli_fetch_all(mysqli_query($conn, "
    SELECT c.id, c.content, c.score, c.added_at, c.user_id, u.login
    FROM Critiques c
    JOIN Users u ON c.user_id = u.id
    WHERE c.title_id = 9
    ORDER BY c.added_at DESC
"), MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Red Dead Redemption 2 – GamesWeb</title>
  <link rel="stylesheet" href="game_style.css">
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
  <nav><a href="dashboard.php">Biblioteka</a></nav>
  <?php if (isset($_SESSION['user_id'])): ?>
    <div class="userinfo">
      Zalogowany jako <strong><?= htmlspecialchars($_SESSION['user_login']) ?></strong>
      <div class="avatar-wrap" id="avatar-btn">
        <img src="<?= !empty($_SESSION['user_avatar']) ? htmlspecialchars($_SESSION['user_avatar']) : 'default.jpg' ?>" alt="avatar">
        <span class="avatar-hint">Zmień avatar</span>
      </div>
      <a href="logout.php">Wyloguj</a>
    </div>
  <?php else: ?>
    <div class="hbtns">
      <a href="login.php">Zaloguj się</a>
      <a href="register.php" class="reg">Rejestracja</a>
    </div>
  <?php endif; ?>
</header>

<?php if (isset($_SESSION['user_id'])): ?>
<div id="avatar-modal">
  <div class="modal-box">
    <h3>Zmień avatar</h3>
    <input type="file" id="avatar-file" accept="image/*">
    <br>
    <button class="mbtn" id="avatar-upload-btn">Prześlij</button>
    <button class="mcancel" id="avatar-cancel">Anuluj</button>
    <p class="modal-msg" id="avatar-msg"></p>
  </div>
</div>
<?php endif; ?>

<div class="game-hero">
  <img class="hero-img" src="zdj/rdr2/MainR.gif" alt="Red Dead Redemption 2">
  <div class="hero-overlay"></div>
  <div class="hero-title">
    <h2><?= htmlspecialchars($game['title']) ?></h2>
    <p class="meta">
      <?= htmlspecialchars($game['genre']) ?> &middot; <?= $game['release_year'] ?>
      <span class="score-badge"><?= $game['avg_score'] ?></span>
    </p>
  </div>
</div>

<div class="game-wrap">
  <main>

    <div class="game-desc">
      <h3>O grze</h3>
      <p><?= htmlspecialchars($game['description']) ?></p>
    </div>

    <div class="cast-section">
      <h3>Obsada</h3>
      <div class="cast-grid">
        <?php foreach ($cast as $c):
          $base = str_replace(' ', '', trim($c['first_name']) . trim($c['last_name']));
          $imgFile = file_exists('zdj/rdr2/' . $base . '.webp') ? $base . '.webp' : $base . '.jpg';
          $born = $c['birth_date'] ? date('Y', strtotime($c['birth_date'])) : '—';
        ?>
        <div class="cast-card">
          <img src="zdj/rdr2/<?= $imgFile ?>" alt="<?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?>">
          <div class="cast-info">
            <div class="cast-name"><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></div>
            <div class="cast-born">ur. <?= $born ?></div>
            <div class="cast-role"><?= htmlspecialchars($c['character_name']) ?></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="comments-section">
      <h3>Komentarze</h3>
      <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($flash): [$ftype, $fmsg] = explode(':', $flash, 2); ?>
          <p class="flash <?= $ftype ?>"><?= htmlspecialchars($fmsg) ?></p>
        <?php endif; ?>
        <div class="comment-form">
          <form method="post">
            <div class="score-row">
              <label>Ocena:</label>
              <select name="score">
                <?php for ($i = 10; $i >= 1; $i--): ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <textarea name="content" placeholder="Napisz komentarz..."></textarea>
            <button type="submit">Dodaj komentarz</button>
          </form>
        </div>
      <?php else: ?>
        <div class="login-notice">
          Aby dodać komentarz, <a href="login.php">zaloguj się</a> lub <a href="register.php">utwórz konto</a>.
        </div>
      <?php endif; ?>
      <div class="comment-list">
        <?php if (empty($comments)): ?>
          <p style="font-size:.85rem;color:var(--muted)">Brak komentarzy. Bądź pierwszy!</p>
        <?php endif; ?>
        <?php foreach ($comments as $cm): ?>
        <div class="comment-item">
          <div class="c-header">
            <span class="c-author"><?= htmlspecialchars($cm['login']) ?></span>
            <span class="c-date"><?= $cm['added_at'] ?></span>
            <span class="c-score"><?= $cm['score'] ?>/10</span>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $cm['user_id']): ?>
            <form method="post" style="margin-left:auto;display:flex">
              <input type="hidden" name="delete_comment_id" value="<?= $cm['id'] ?>">
              <button type="submit" class="c-delete" onclick="return confirm('Usunąć komentarz?')">🗑</button>
            </form>
            <?php endif; ?>
          </div>
          <p class="c-text"><?= htmlspecialchars($cm['content']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

  </main>

  <aside>
    <div class="game-info-box">
      <h4>Informacje</h4>
      <div class="info-row"><span class="label">Tytuł</span><span class="value"><?= htmlspecialchars($game['title']) ?></span></div>
      <div class="info-row"><span class="label">Rok</span><span class="value"><?= $game['release_year'] ?></span></div>
      <div class="info-row"><span class="label">Gatunek</span><span class="value"><?= htmlspecialchars($game['genre']) ?></span></div>
      <div class="info-row"><span class="label">Deweloper</span><span class="value"><?= htmlspecialchars($game['developer']) ?></span></div>
      <div class="info-row"><span class="label">Kraj</span><span class="value"><?= htmlspecialchars($game['country']) ?></span></div>
      <div class="info-row"><span class="label">Ocena</span><span class="value"><?= $game['avg_score'] ?>/10</span></div>
    </div>
  </aside>
</div>

<footer><p>Kontakt: <a href="mailto:kontakt@gamesweb.pl">kontakt@gamesweb.pl</a></p></footer>

<script src="wcag.js"></script>
<?php if (isset($_SESSION['user_id'])): ?>
<script>
const modal   = document.getElementById('avatar-modal');
const btn     = document.getElementById('avatar-btn');
const cancel  = document.getElementById('avatar-cancel');
const upBtn   = document.getElementById('avatar-upload-btn');
const fileInp = document.getElementById('avatar-file');
const msg     = document.getElementById('avatar-msg');
btn.addEventListener('click', () => modal.classList.add('open'));
cancel.addEventListener('click', () => modal.classList.remove('open'));
upBtn.addEventListener('click', async () => {
  if (!fileInp.files[0]) { msg.textContent = 'Wybierz plik.'; msg.className = 'modal-msg err'; return; }
  const fd = new FormData();
  fd.append('avatar', fileInp.files[0]);
  const r = await fetch('avatar_upload.php', { method: 'POST', body: fd });
  const d = await r.json();
  if (d.ok) {
    msg.textContent = 'Avatar zmieniony!';
    msg.className = 'modal-msg ok';
    document.querySelectorAll('.avatar-wrap img').forEach(i => i.src = d.path + '?t=' + Date.now());
    setTimeout(() => modal.classList.remove('open'), 1200);
  } else {
    msg.textContent = d.error || 'Błąd uploadu.';
    msg.className = 'modal-msg err';
  }
});
</script>
<?php endif; ?>
</body>
</html>
