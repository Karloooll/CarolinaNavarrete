<?php
require_once 'db.php';
require_once 'auth.php';

$stmt = $pdo->query("SELECT * FROM courses");
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia | Carolina Navarrete</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/cursos.css">
</head>

<body>

    <!-- Nav -->
    <nav id="navbar" class="scrolled">
        <a href="index.php" class="logo"><img src="images/Logo_amarillo.png" alt="Carolina Navarrete Logo"
                style="height: 50px; width: auto; object-fit: contain;"> Carolina <span>Navarrete</span></a>
        <button class="hamburger" id="hamburger">
            <i class="bi bi-list"></i>
        </button>
        <ul class="nav-links" id="nav-links">
            <li><button class="close-menu" id="close-menu"><i class="bi bi-x"></i></button></li>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="cursos.php" style="color: var(--primary);">Academia</a></li>
            <?php if ($user): ?>
                <li><a href="mis_cursos.php">Mis Cursos</a></li>
                <li><a href="logout.php" class="btn-login"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn-login"><i class="fas fa-user"></i> Entrar</a></li>
            <?php endif; ?>
        </ul>
        <div class="overlay" id="overlay"></div>
    </nav>

    <!-- Academy Hero -->
    <section class="academy-hero">
        <div class="academy-hero-content reveal active">
            <h1>Academia Carolina Navarrete</h1>
            <p>El conocimiento es el activo más seguro para escalar tu negocio. Aprende a tu ritmo las estrategias que
                los grandes usan para crecer sustentablemente.</p>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="courses-container">
        <div class="section-header reveal active">
            <h2>Nuestros Cursos Disponibles</h2>
            <p>Selecciona un programa para comenzar tu transformación profesional.</p>
        </div>

        <div class="courses-grid">
            <?php foreach ($courses as $course): ?>
                <div class="course-card reveal active">
                    <div class="course-image"
                        style="background-image: url('<?php echo htmlspecialchars($course['image_url']); ?>')">
                        <div class="course-price">$
                            <?php echo number_format($course['price'], 2); ?> MXN
                        </div>
                    </div>
                    <div class="course-content">
                        <h3>
                            <?php echo htmlspecialchars($course['title']); ?>
                        </h3>
                        <p>
                            <?php echo htmlspecialchars($course['short_description']); ?>
                        </p>

                        <div class="course-meta">
                            <span><i class="fas fa-chalkboard-teacher"></i>
                                <?php echo htmlspecialchars($course['instructor']); ?>
                            </span>
                        </div>

                        <a href="curso_detalle.php?id=<?php echo $course['id']; ?>" class="btn btn-primary btn-block">Ver
                            detalles del curso <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-bottom" style="margin-top: 0; padding-top: 30px;">
            <p>&copy; 2025 Consultoría Carolina Navarrete. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script src="js/cursos.js"></script>
</body>

</html>