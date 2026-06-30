<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

require '../includes/conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre']   ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $distrito = trim($_POST['distrito'] ?? '');

    if ($nombre === '' || $apellido === '' || $distrito === '') {
        $error = 'Por favor completa todos los campos.';
    } else {
        $stmt = $conn->prepare('INSERT INTO usuarios (nombre, apellido, distrito) VALUES (?, ?, ?)');
        if ($stmt->execute([$nombre, $apellido, $distrito])) {
            header('Location: listado.php?exito=1');
            exit;
        } else {
            $error = 'Ocurrió un error al registrar.';
        }
    }
}

$distritos = ['Los Olivos', 'Comas', 'Independencia', 'San Martín de Porres', 'Puente Piedra', 'Carabayllo', 'Ancón', 'Santa Rosa'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Registro</title>
</head>

<body class="bg-blue-100 flex items-center justify-center min-h-screen">

    <div class="bg-gray-100 w-full max-w-3xl rounded-3xl p-12 shadow-lg">

        <h1 class="text-5xl font-bold text-center text-red-600 mb-12">
            Registro de Usuario
        </h1>

        <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-8">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-8">
                <label class="block text-2xl font-semibold text-gray-800 mb-4">Nombre</label>
                <input
                    type="text"
                    name="nombre"
                    value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                    placeholder="Miguel Angel"
                    required
                    class="w-full p-5 text-2xl border border-red-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-8">
                <label class="block text-2xl font-semibold text-gray-800 mb-4">Apellido</label>
                <input
                    type="text"
                    name="apellido"
                    value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>"
                    placeholder="Huerta Rojas"
                    required
                    class="w-full p-5 text-2xl border border-red-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-8">
                <label class="block text-2xl font-semibold text-gray-800 mb-4">Distrito</label>
                <select
                    name="distrito"
                    required
                    class="w-full p-5 text-2xl border border-red-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <?php foreach ($distritos as $d): ?>
                    <option value="<?= $d ?>" <?= ($_POST['distrito'] ?? '') === $d ? 'selected' : '' ?>>
                        <?= $d ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button
                type="submit"
                class="w-full bg-red-600 text-white text-2xl font-bold py-5 rounded-2xl hover:bg-red-700 transition duration-300">
                Registrar
            </button>

        </form>

        <a href="../dashboard/menu.php"
           class="mt-6 flex items-center justify-center w-full bg-gray-200 text-gray-700 text-xl font-semibold py-4 rounded-2xl hover:bg-gray-300 transition duration-300">
            ← Volver al Menú
        </a>

    </div>

</body>
</html>
