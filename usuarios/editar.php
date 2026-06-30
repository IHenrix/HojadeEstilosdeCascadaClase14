<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

require '../includes/conexion.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id === 0) {
    header('Location: listado.php');
    exit;
}

$stmt = $conn->prepare('SELECT id, nombre, apellido, distrito FROM usuarios WHERE id = ?');
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header('Location: listado.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre']   ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $distrito = trim($_POST['distrito'] ?? '');

    if ($nombre === '' || $apellido === '' || $distrito === '') {
        $error   = 'Por favor completa todos los campos.';
        $usuario = ['nombre' => $nombre, 'apellido' => $apellido, 'distrito' => $distrito];
    } else {
        $stmt = $conn->prepare('UPDATE usuarios SET nombre = ?, apellido = ?, distrito = ? WHERE id = ?');
        if ($stmt->execute([$nombre, $apellido, $distrito, $id])) {
            header('Location: listado.php?exito=editado');
            exit;
        } else {
            $error = 'Error al actualizar el registro.';
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
    <title>Editar Usuario</title>
</head>

<body class="bg-yellow-50 flex items-center justify-center min-h-screen">

    <div class="bg-gray-100 w-full max-w-3xl rounded-3xl p-12 shadow-lg">

        <h1 class="text-5xl font-bold text-center text-yellow-600 mb-12">
            Editar Usuario
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
                    value="<?= htmlspecialchars($usuario['nombre']) ?>"
                    required
                    class="w-full p-5 text-2xl border border-red-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-8">
                <label class="block text-2xl font-semibold text-gray-800 mb-4">Apellido</label>
                <input
                    type="text"
                    name="apellido"
                    value="<?= htmlspecialchars($usuario['apellido']) ?>"
                    required
                    class="w-full p-5 text-2xl border border-red-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-10">
                <label class="block text-2xl font-semibold text-gray-800 mb-4">Distrito</label>
                <select
                    name="distrito"
                    required
                    class="w-full p-5 text-2xl border border-red-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <?php foreach ($distritos as $d): ?>
                    <option value="<?= $d ?>" <?= $usuario['distrito'] === $d ? 'selected' : '' ?>>
                        <?= $d ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button
                type="submit"
                class="w-full bg-yellow-500 text-white text-2xl font-bold py-5 rounded-2xl hover:bg-yellow-600 transition duration-300">
                Guardar Cambios
            </button>

        </form>

        <a href="listado.php"
           class="mt-6 flex items-center justify-center w-full bg-gray-200 text-gray-700 text-xl font-semibold py-4 rounded-2xl hover:bg-gray-300 transition duration-300">
            ✕ Cancelar
        </a>

    </div>

</body>
</html>
