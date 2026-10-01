<?php
// Вспомогательные функции: хеширование, проверка, сессии

session_start();

/** Безопасный хеш пароля */
function hash_password(string $plain): string {
    return password_hash($plain, PASSWORD_DEFAULT);
}

/** Проверка пароля */
function verify_password(string $plain, string $hash): bool {
    return password_verify($plain, $hash);
}

/** Текущий пользователь или null */
function current_user(): ?array {
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT id, username, created_at FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    return $user ?: null;
}

/** Редирект, если не авторизован */
function require_auth(): void {
    if (!current_user()) {
        header('Location: login.php');
        exit;
    }
}
