<?php
// Обработка входа

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$pdo = get_db();
$stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user || !verify_password($password, $user['password'])) {
    $_SESSION['flash'] = 'Неверное имя пользователя или пароль.';
    header('Location: ../frontend/login.php');
    exit;
}

$_SESSION['user_id'] = (int) $user['id'];
header('Location: ../frontend/dashboard.php');
exit;
