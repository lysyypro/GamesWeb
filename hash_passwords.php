<?php
$conn = mysqli_connect('localhost', 'root', '', 'Gamesdb');

$users = mysqli_fetch_all(mysqli_query($conn, 'SELECT id, password FROM Users'), MYSQLI_ASSOC);

foreach ($users as $user) {
    $hash = password_hash($user['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE Users SET password = '$hash' WHERE id = " . $user['id']);
}

echo 'Gotowe! Hasła zostały zahashowane.';
?>
