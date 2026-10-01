<?php

require_once __DIR__ . '/../backend/db.php';
require_once __DIR__ . '/../backend/auth.php';

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/style.css">
    <title>Вход</title>
</head>
<body>
    <div class="card">
        <h2>Вход</h2>
        <?php if ($flash): ?>
            <div class="flash"><?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>
        <form action="../backend/login.php" method="post">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="password" name="password" placeholder="Пароль" required>

            <div class="wrap">
            <button type="submit">
                Войти
            </button>
        </div>
        </form>
        <div class="link">Нет аккаунта? <a href="register.php">Регистрация</a></div>
    </div>
</body>
</html>
