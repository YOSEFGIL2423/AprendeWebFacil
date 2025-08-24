<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aprendewebfacil";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar formulario de contacto
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $mensaje_texto = $_POST['mensaje'];
    
    // Insertar en la base de datos
    $sql = "INSERT INTO contactos (nombre, email, telefono, mensaje, fecha_creacion)
            VALUES ('$nombre', '$email', '$telefono', '$mensaje_texto', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        $mensaje = "<div class='alert alert-success'>¡Mensaje enviado correctamente! Te contactaremos pronto.</div>";
        
        // Reiniciar valores del formulario
        $_POST = array();
    } else {
        $mensaje = "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Obtener contactos para mostrar (funcionalidad CRUD)
$contactos = array();
$sql = "SELECT * FROM contactos ORDER BY fecha_creacion DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $contactos[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - AprendeWebFacil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <i class="fas fa-code me-2"></i>AprendeWebFacil
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="que-es-web.html">¿Qué es una Web?</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tecnologias.html">Tecnologías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contacto.php">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-primary text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold">Contacto</h1>
                    <p class="lead">¿Tienes preguntas? ¡Nos encantaría ayudarte en tu camino de aprendizaje!</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <?php echo $mensaje; ?>
                    
                    <div class="card mb-5">
                        <div class="card-body">
                            <h2 class="card-title">Envíanos un mensaje</h2>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre completo</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono (opcional)</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" 
                                           value="<?php echo isset($_POST['telefono']) ? $_POST['telefono'] : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="mensaje" class="form-label">Mensaje</label>
                                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required><?php echo isset($_POST['mensaje']) ? $_POST['mensaje'] : ''; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                            </form>
                        </div>
                    </div>

                    <!-- CRUD Section for Admin (normally hidden) -->
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Mensajes recibidos</h2>
                            <p class="text-muted">Esta sección normalmente estaría oculta y sería accesible solo para administradores.</p>
                            
                            <?php if (count($contactos) > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Teléfono</th>
                                                <th>Mensaje</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($contactos as $contacto): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($contacto['nombre']); ?></td>
                                                    <td><?php echo htmlspecialchars($contacto['email']); ?></td>
                                                    <td><?php echo htmlspecialchars($contacto['telefono']); ?></td>
                                                    <td><?php echo htmlspecialchars(substr($contacto['mensaje'], 0, 50)) . '...'; ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($contacto['fecha_creacion'])); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-center">No hay mensajes aún.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>AprendeWebFacil</h5>
                    <p>Enseñamos desarrollo web desde cero con un enfoque práctico y accesible para todos.</p>
                </div>
                <div class="col-md-4">
                    <h5>Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.html" class="text-white">Inicio</a></li>
                        <li><a href="que-es-web.html" class="text-white">¿Qué es una Web?</a></li>
                        <li><a href="tecnologias.html" class="text-white">Tecnologías</a></li>
                        <li><a href="contacto.php" class="text-white">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <p><i class="fas fa-envelope me-2"></i> info@aprendewebfacil.com</p>
                    <div class="d-flex">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2023 AprendeWebFacil. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>