<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard/menu.php');
    exit;
}

require 'includes/conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $pass   = $_POST['pass'] ?? '';

    if ($correo === '' || $pass === '') {
        $error = 'Por favor completa todos los campos.';
    } else {
        $stmt = $conn->prepare('SELECT id, nombre, pass FROM administradores WHERE correo = ?');
        $stmt->execute([$correo]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila && password_verify($pass, $fila['pass'])) {
            $_SESSION['admin_id']     = $fila['id'];
            $_SESSION['admin_nombre'] = $fila['nombre'];
            header('Location: dashboard/menu.php');
            exit;
        } else {
            $error = 'Correo o contraseña incorrectos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center min-h-screen">

    <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md">

        <h1 class="text-4xl font-bold text-center text-indigo-600 mb-8">
            Iniciar Sesión
        </h1>

        <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Correo Electrónico</label>
                <input
                    type="email"
                    name="correo"
                    value="<?= htmlspecialchars($_POST['correo'] ?? 'administrador@utp.edu.pe') ?>"
                    placeholder="correo@ejemplo.com"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Contraseña</label>
                <input
                    type="password"
                    name="pass"
                    value="Marco1415"
                    placeholder="********"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex justify-between items-center mb-6">
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2">
                    <span class="text-gray-600">Recordarme</span>
                </label>
                <a href="#" class="text-indigo-600 hover:underline">¿Olvidó su contraseña?</a>
            </div>

            <button
                type="submit"
                class="w-full bg-red-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-red-700 transition duration-300">
                Ingresar
            </button>

        </form>

        <p class="text-center text-gray-600 mt-6">
            ¿No tienes cuenta?
            <a href="usuarios/registro.php" class="text-indigo-600 font-semibold hover:underline">Regístrate</a>
        </p>

        <div class="mt-6 p-3 bg-gray-50 rounded-lg text-sm text-gray-500 text-center">
            <span class="font-semibold">Usuario:</span> administrador@utp.edu.pe &nbsp;|&nbsp;
            <span class="font-semibold">Contraseña:</span> Marco1415
        </div>

    </div>

</body>
</html>
