<?php
require_once 'config.php';

// Если уже авторизован — на главную
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Заполните все поля.';
    } elseif ($password !== $confirm) {
        $error = 'Пароли не совпадают.';
    } elseif (strlen($password) < 4) {
        $error = 'Пароль должен быть не менее 4 символов.';
    } else {
        // Проверка на существование пользователя
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'Пользователь с таким логином уже существует.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hash]);
            $success = 'Регистрация успешна! <a href="login.php">Войти</a>';
        }
    }
}

require_once 'header.php';
?>

<div class="form-box">
    <h2>Регистрация</h2>
    <?php if ($error): ?>
        <p class="red"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
        <p class="green"><?= $success ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Логин" value="<?= htmlspecialchars($username ?? '') ?>" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
</div>

<?php require_once 'footer.php'; ?>