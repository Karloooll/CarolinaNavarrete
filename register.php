<?php
require_once 'db.php';
require_once 'auth.php';

if (isLoggedIn()) {
    header("Location: cursos.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($name && $email && $password && $confirm) {
        if ($password !== $confirm) {
            $error = 'Las contraseñas no coinciden.';
        } elseif (strlen($password) < 6) {
            $error = 'La contraseña debe tener al menos 6 caracteres.';
        } else {
            // Check if email exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = 'Este correo ya está registrado.';
            } else {
                // Register
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                if ($stmt->execute([$name, $email, $hashed])) {
                    $user_id = $pdo->lastInsertId();
                    // Auto login
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;

                    header("Location: cursos.php");
                    exit;
                } else {
                    $error = 'Error al crear la cuenta. Intenta de nuevo.';
                }
            }
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
    <title>Registro | Academia Carolina Navarrete</title>
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
        <h2>Crear Cuenta</h2>
        <p class="auth-subtitle">Únete para transformar el futuro de tu negocio</p>

        <?php if ($error): ?>
            <div class="auth-error"><i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php" class="auth-form">
            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" name="name" required placeholder="Tu Nombre"
                        value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                </div>
            </div>
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
                    <input type="password" id="password" name="password" required placeholder="Mínimo 6 caracteres">
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Contraseña</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirm_password" name="confirm_password" required
                        placeholder="Repite tu contraseña">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Registrarse Gratis</button>
        </form>

        <div class="auth-links">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
            <p><a href="index.php"><i class="fas fa-arrow-left"></i> Volver al inicio</a></p>
        </div>
    </div>
</body>

</html>