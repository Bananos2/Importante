<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="container head">
        <a href="index.php" class="logo">🛍️ SHOP</a>
        <nav>
            <a href="index.php">Главная</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                Привет, <?= htmlspecialchars($_SESSION['username']) ?>!
                <a href="logout.php">Выйти</a>
            <?php else: ?>
                <a href="login.php">Войти</a>
                <a href="register.php">Регистрация</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container">