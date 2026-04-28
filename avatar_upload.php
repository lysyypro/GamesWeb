<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['ok' => false, 'error' => 'Nie jesteś zalogowany.']);
    exit;
}

if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['ok' => false, 'error' => 'Błąd przesyłania pliku.']);
    exit;
}

$file = $_FILES['avatar'];

$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$finfo   = finfo_open(FILEINFO_MIME_TYPE);
$mime    = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mime, $allowed)) {
    echo json_encode(['ok' => false, 'error' => 'Dozwolone formaty: JPG, PNG, GIF, WEBP.']);
    exit;
}

if ($file['size'] > 10 * 1024 * 1024) {
    echo json_encode(['ok' => false, 'error' => 'Plik nie może przekraczać 10 MB.']);
    exit;
}
$dir = __DIR__ . '/avatars/';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

$ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = 'user_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
$dest     = $dir . $filename;

if (!move_uploaded_file($file['tmp_name'], $dest)) {
    echo json_encode(['ok' => false, 'error' => 'Nie udało się zapisać pliku.']);
    exit;
}

$conn = mysqli_connect('localhost', 'root', '', 'GamesWeb');
$path = 'avatars/' . $filename;
$uid  = (int)$_SESSION['user_id'];
mysqli_query($conn, "UPDATE Users SET avatar = '$path' WHERE id = $uid");

$_SESSION['user_avatar'] = $path;

echo json_encode(['ok' => true, 'path' => $path]);