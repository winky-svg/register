<?php
// Обработка регистрации

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];
if (strlen($username) < 3) {
    $errors[] = 'Имя пользователя должно быть не короче 3 символов.';
}
if (strlen($password) < 6) {
    $errors[] = 'Пароль должен быть не короче 6 символов.';
}

if ($errors) {
    $_SESSION['flash'] = implode(' ', $errors);
    header('Location: ../frontend/register.php');
    exit;
}

try {
    $pdo = get_db();

    // Проверка занятости имени
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $_SESSION['flash'] = 'Это имя уже занято.';
        header('Location: ../frontend/register.php');
        exit;
    }

    // Создание пользователя
    $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);

    header('Location: ../frontend/login.php');
    exit;

} catch (Throwable $e) {
    // Временно показываем ошибку прямо на экран
    http_response_code(500);
    echo '<pre>Ошибка при регистрации: ' . htmlspecialchars($e->getMessage()) . '</pre>';
    exit;
}
