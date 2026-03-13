<!-- <?php
require_once 'db.php';
require_once 'auth.php';

if (isLoggedIn()) {
    header("Location: cursos.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            $redirect = $_SESSION['redirect_after_login'] ?? 'cursos.php';
            unset($_SESSION['redirect_after_login']);

            header("Location: " . $redirect);
            exit;
        } else {
            $error = 'Credenciales incorrectas.';
        }
    } else {
        $error = 'Por favor, completa todos los campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Academia Carolina Navarrete</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/cursos.css">
</head>

<body class="auth-page">
    <div class="auth-container reveal active">
        <a href="index.php" class="logo auth-logo"><img src="images/Logo_amarillo.png" alt="Logo"> Carolina
            <span>Navarrete</span></a>
        <h2>Iniciar Sesión</h2>
        <p class="auth-subtitle">Accede a tus cursos y material exclusivo</p>

        <?php if ($error): ?>
<div class="auth-error"><i class="fas fa-exclamation-circle"></i>
    <?php echo htmlspecialchars($error); ?>
</div>
<?php endif; ?>

<form method="POST" action="login.php" class="auth-form">
    <div class="form-group">
        <label for="email">Correo Electrónico</label>
        <div class="input-icon">
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" name="email" required placeholder="tu@correo.com"
                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="password">Contraseña</label>
        <div class="input-icon">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Entrar a la Academia</button>
</form>

<div class="auth-links">
    <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
    <p><a href="index.php"><i class="fas fa-arrow-left"></i> Volver al inicio</a></p>
</div>
</div>
</body>

</html> -->