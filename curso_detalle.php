<?php
require_once 'db.php';
require_once 'auth.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: cursos.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$id]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    header("Location: cursos.php");
    exit;
}

$user = getCurrentUser();
$hasPurchased = $user ? userHasPurchasedCourse($pdo, $user['id'], $course['id']) : false;
$featuresList = explode("|", $course['features']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo htmlspecialchars($course['title']); ?> | Academia Carolina Navarrete
    </title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/cursos.css">
</head>

<body class="bg-light">

    <!-- Nav -->
    <nav id="navbar" class="scrolled">
        <a href="index.php" class="logo"><img src="images/Logo_amarillo.png" alt="Carolina Navarrete Logo"
                style="height: 50px; width: auto; object-fit: contain;"> Carolina <span>Navarrete</span></a>
        <button class="hamburger" id="hamburger">
            <i class="bi bi-list"></i>
        </button>
        <ul class="nav-links" id="nav-links">
            <li><button class="close-menu" id="close-menu"><i class="bi bi-x"></i></button></li>
            <li><a href="cursos.php" style="color: var(--primary);"><i class="fas fa-arrow-left"></i> Catálogo</a></li>
            <?php if ($user): ?>
                <li><a href="logout.php" class="btn-login"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn-login"><i class="fas fa-user"></i> Entrar</a></li>
            <?php endif; ?>
        </ul>
        <div class="overlay" id="overlay"></div>
    </nav>

    <!-- Detail Header -->
    <div class="course-detail-header"
        style="background-image: linear-gradient(to right, rgba(25, 42, 61, 0.95), rgba(34, 123, 195, 0.8)), url('<?php echo htmlspecialchars($course['image_url']); ?>');">
        <div class="detail-header-content reveal active">
            <h1>
                <?php echo htmlspecialchars($course['title']); ?>
            </h1>
            <p class="instructor">Con <i class="fas fa-chalkboard-teacher"></i>
                <?php echo htmlspecialchars($course['instructor']); ?>
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="course-detail-container">

        <!-- Left Column: Info & Content -->
        <div class="course-main-info reveal active">

            <?php if ($hasPurchased): ?>
                <!-- Purchased State -->
                <div class="course-player-card">
                    <div class="player-header">
                        <h2>¡Bienvenido al curso!</h2>
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Curso Adquirido</span>
                    </div>
                    <div class="video-wrapper">
                        <iframe width="100%" height="450" src="<?php echo htmlspecialchars($course['video_url']); ?>"
                            title="Course Video" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="course-materials mt-4">
                    <h3>Materiales del Curso</h3>
                    <ul class="materials-list">
                        <li><a href="#"><i class="fas fa-file-pdf"></i> Cuaderno de Trabajo.pdf</a></li>
                        <li><a href="#"><i class="fas fa-file-excel"></i> Plantilla_Proyección.xlsx</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <!-- Not Purchased State -->
                <div class="about-course card">
                    <h2>Acerca de este curso</h2>
                    <div class="description-body">
                        <?php echo $course['full_description']; // Stored as trusted HTML ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- Right Column: Sidebar Checkout/Status -->
        <div class="course-sidebar reveal active">
            <div class="sidebar-card">
                <?php if ($hasPurchased): ?>
                    <div class="status-box success">
                        <i class="fas fa-graduation-cap display-icon"></i>
                        <h3>Tu Progreso</h3>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 25%;"></div>
                        </div>
                        <p class="text-center mt-2">25% Completado</p>
                    </div>

                    <div class="features-list mt-3">
                        <h4>Incluye:</h4>
                        <ul>
                            <?php foreach ($featuresList as $feat): ?>
                                <li><i class="fas fa-check text-primary"></i>
                                    <?php echo htmlspecialchars($feat); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="price-box">
                        <span class="price-label">Inversión:</span>
                        <h2>$
                            <?php echo number_format($course['price'], 2); ?> <small>MXN</small>
                        </h2>
                    </div>

                    <a href="checkout.php?id=<?php echo $course['id']; ?>"
                        class="btn btn-primary btn-block btn-lg checkout-btn">
                        Adquirir Curso Ahora <i class="fas fa-shopping-cart"></i>
                    </a>

                    <p class="secure-checkout"><i class="fas fa-shield-alt"></i> Pago 100% seguro garantizado</p>

                    <div class="features-list mt-4">
                        <h4>¿Qué vas a obtener?</h4>
                        <ul>
                            <?php foreach ($featuresList as $feat): ?>
                                <li><i class="fas fa-check"></i>
                                    <?php echo htmlspecialchars($feat); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <script src="js/script.js"></script>
</body>

</html>