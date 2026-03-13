<?php
require_once 'db.php';
require_once 'auth.php';

// Must be logged in to checkout
requireLogin();

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

// If already purchased, send back to detail
if (userHasPurchasedCourse($pdo, $user['id'], $course['id'])) {
    header("Location: curso_detalle.php?id=" . $course['id']);
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mock Payment Processing
    $card = $_POST['card_number'] ?? '';

    if (strlen($card) < 16) {
        $error = "Número de tarjeta inválido para la simulación.";
    } else {
        // "Charge" card and grant access
        $stmt = $pdo->prepare("INSERT INTO purchases (user_id, course_id, amount) VALUES (?, ?, ?)");
        if ($stmt->execute([$user['id'], $course['id'], $course['price']])) {
            // Purchase successful!
            header("Location: curso_detalle.php?id=" . $course['id'] . "&success=1");
            exit;
        } else {
            $error = "Hubo un error al procesar tu compra.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Academia Carolina Navarrete</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/cursos.css">
</head>

<body class="bg-light">

    <div class="checkout-wrapper reveal active">
        <div class="checkout-header text-center">
            <a href="cursos.php" class="logo"><img src="images/Logo_amarillo.png" alt="Logo" style="height: 40px;">
                Carolina Navarrete</a>
            <h2>Completar Compra</h2>
        </div>

        <?php if ($error): ?>
            <div class="auth-error text-center"><i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="checkout-grid">
            <!-- Order Summary -->
            <div class="order-summary card">
                <h3>Resumen del Pedido</h3>
                <div class="summary-item">
                    <img src="<?php echo htmlspecialchars($course['image_url']); ?>" alt="Course Thumbnail"
                        class="summary-img">
                    <div class="summary-details">
                        <h4>
                            <?php echo htmlspecialchars($course['title']); ?>
                        </h4>
                        <p>1x Curso Online Completo</p>
                    </div>
                </div>
                <hr>
                <div class="summary-totals">
                    <div class="total-row"><span>Subtotal:</span> <span>$
                            <?php echo number_format($course['price'], 2); ?>
                        </span></div>
                    <div class="total-row"><span>IVA (16% incl):</span> <span>$0.00</span></div>
                    <div class="total-row grand-total"><span>Total (MXN):</span> <span>$
                            <?php echo number_format($course['price'], 2); ?>
                        </span></div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="payment-form card">
                <h3>Detalles de Pago <i class="fas fa-lock float-right text-muted"></i></h3>
                <p class="text-muted text-sm mb-3">Simulador integrado. (Ingresa cualquier número de 16 dígitos para
                    probar).</p>

                <form method="POST">
                    <div class="form-group">
                        <label>Nombre en la tarjeta</label>
                        <input type="text" class="form-control" name="card_name"
                            value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Número de Tarjeta</label>
                        <div class="input-icon">
                            <i class="fab fa-cc-visa"></i>
                            <input type="text" class="form-control" name="card_number" placeholder="4111 1111 1111 1111"
                                required maxlength="19">
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label>Vencimiento (MM/AA)</label>
                            <input type="text" class="form-control" placeholder="12/28" required>
                        </div>
                        <div class="form-group">
                            <label>CVC</label>
                            <input type="text" class="form-control" placeholder="123" required maxlength="4">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg mt-3">
                        Pagar $
                        <?php echo number_format($course['price'], 2); ?> <i class="fas fa-lock"></i>
                    </button>

                    <div class="text-center mt-3 d-flex justify-content-center gap-2 cards-accepted">
                        <i class="fab fa-cc-visa fa-2x text-muted"></i>
                        <i class="fab fa-cc-mastercard fa-2x text-muted"></i>
                        <i class="fab fa-cc-amex fa-2x text-muted"></i>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="curso_detalle.php?id=<?php echo $course['id']; ?>" class="text-muted"><i
                    class="fas fa-arrow-left"></i> Volver al curso</a>
        </div>
    </div>

</body>

</html>