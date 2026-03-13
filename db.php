<?php
// db.php - SQLite Database Connection and Setup

$db_file = __DIR__ . '/db/academy.sqlite';
$needs_setup = !file_exists($db_file);

try {
    $pdo = new PDO("sqlite:" . $db_file);
    // Enable exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($needs_setup) {
        setupDatabase($pdo);
    }
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

function setupDatabase($pdo)
{
    // 1. Create Users Table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // 2. Create Courses Table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS courses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            short_description TEXT NOT NULL,
            full_description TEXT NOT NULL,
            price REAL NOT NULL,
            image_url TEXT NOT NULL,
            video_url TEXT,
            features TEXT,
            instructor TEXT DEFAULT 'Carolina Navarrete'
        )
    ");

    // 3. Create Purchases Table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS purchases (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            course_id INTEGER NOT NULL,
            purchase_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            amount REAL NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (course_id) REFERENCES courses(id),
            UNIQUE(user_id, course_id)
        )
    ");

    // 4. Seed Courses Data
    seedCourses($pdo);
}

function seedCourses($pdo)
{
    $courses = [
        [
            'title' => 'Finanzas Sanas para Pymes',
            'slug' => 'finanzas-sanas-pymes',
            'short_description' => 'Aprende a estructurar las finanzas de tu pequeña o mediana empresa para garantizar rentabilidad y crecimiento sostenido.',
            'full_description' => '<p>Este curso está diseñado para emprendedores y dueños de negocio que buscan tomar el control de sus números. A lo largo de 5 módulos, aprenderás a leer estados financieros financieros, proyectar flujos de efectivo, y tomar decisiones basadas en datos.</p><ul><li>Módulo 1: Conceptos básicos de contabilidad.</li><li>Módulo 2: Interpretación de Balances y Estados de Resultados.</li><li>Módulo 3: Flujo de Caja y Presupuestación.</li><li>Módulo 4: Estrategias de optimización fiscal.</li><li>Módulo 5: Indicadores clave de rendimiento (KPIs).</li></ul>',
            'price' => 1499.00,
            'image_url' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder video
            'features' => '5 módulos en video|Plantillas de Excel descargables|Certificado de finalización|Acceso de por vida'
        ],
        [
            'title' => 'Sustentabilidad Corporativa 101',
            'slug' => 'sustentabilidad-corporativa',
            'short_description' => 'Integra prácticas sustentables en tu modelo de negocio para impacto ambiental y reducción de costos operativos.',
            'full_description' => '<p>La sustentabilidad ya no es una opción, es una necesidad estratégica. Descubre cómo transformar las operaciones de tu empresa para ser más amigables con el medio ambiente mientras mejoras tus márgenes de ganancia a través de la eficiencia.</p><ul><li>Módulo 1: Introducción a la Economía Circular.</li><li>Módulo 2: Auditorías Energéticas y de Recursos.</li><li>Módulo 3: Cadenas de Suministro Responsables.</li><li>Módulo 4: Certificaciones y Cumplimiento Normativo.</li><li>Módulo 5: Marketing Sustentable ("Green" vs Greenwashing).</li></ul>',
            'price' => 1850.00,
            'image_url' => 'https://images.unsplash.com/photo-1497435334941-8c899ee9e8e9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'features' => '5 módulos en video|Guía de auditoría ambiental|Certificado de finalización|Acceso de por vida'
        ],
        [
            'title' => 'Retiro Digno: Planificación IMSS',
            'slug' => 'retiro-digno-imss',
            'short_description' => 'Estrategias definitivas para maximizar tu pensión del IMSS y asegurar un retiro cómodo y sin preocupaciones.',
            'full_description' => '<p>No dejes tu futuro al azar. En este curso especializado, desglosamos las leyes del IMSS (Ley 73 y 97) de forma sencilla y te damos las herramientas para proyectar y maximizar tu pensión a través de estrategias legales como la Modalidad 40.</p><ul><li>Módulo 1: Entendiendo tu régimen (Ley 73 vs 97).</li><li>Módulo 2: Cálculo de semanas cotizadas y salario promedio.</li><li>Módulo 3: Modalidad 40: ¿Conviene y cómo aplicarla?</li><li>Módulo 4: Conservación de derechos y estrategias de reingreso.</li><li>Módulo 5: Trámites y resolución de problemas comunes.</li></ul>',
            'price' => 999.00,
            'image_url' => 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'features' => 'Catálogo de leyes simplificado|Calculadora de simulación de pensión|Resolución de dudas frecuentes'
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO courses (title, slug, short_description, full_description, price, image_url, video_url, features) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($courses as $c) {
        $stmt->execute([
            $c['title'],
            $c['slug'],
            $c['short_description'],
            $c['full_description'],
            $c['price'],
            $c['image_url'],
            $c['video_url'],
            $c['features']
        ]);
    }
}
?>