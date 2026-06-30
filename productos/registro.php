<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

require '../includes/conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = trim($_POST['precio'] ?? '');
    $stock  = trim($_POST['stock']  ?? '');

    if ($nombre === '' || $precio === '' || $stock === '') {
        $error = 'Por favor completa todos los campos.';
    } elseif (!is_numeric($precio) || $precio <= 0) {
        $error = 'El precio debe ser un número mayor a 0.';
    } elseif (!is_numeric($stock) || $stock < 0) {
        $error = 'El stock debe ser un número válido.';
    } else {
        $stmt = $conn->prepare('INSERT INTO producto (nombre, precio, stock) VALUES (?, ?, ?)');
        if ($stmt->execute([$nombre, $precio, $stock])) {
            header('Location: listado.php?exito=1');
            exit;
        } else {
            $error = 'Ocurrió un error al registrar.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Registro de Producto</title>
</head>
<body class="bg-blue-50 flex items-center justify-center min-h-screen">

    <div class="bg-white w-full max-w-2xl rounded-3xl p-10 shadow-lg">

        <h1 class="text-4xl font-bold text-center text-blue-600 mb-10">Registro de Producto</h1>

        <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-6">
                <label class="block text-xl font-semibold text-gray-800 mb-3">Nombre</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                    placeholder="Laptop HP" required
                    class="w-full p-4 text-xl border border-blue-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-xl font-semibold text-gray-800 mb-3">Precio (S/.)</label>
                <input type="number" name="precio" step="0.01" min="0.01" value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>"
                    placeholder="0.00" required
                    class="w-full p-4 text-xl border border-blue-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-8">
                <label class="block text-xl font-semibold text-gray-800 mb-3">Stock</label>
                <input type="number" name="stock" min="0" value="<?= htmlspecialchars($_POST['stock'] ?? '') ?>"
                    placeholder="0" required
                    class="w-full p-4 text-xl border border-blue-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white text-xl font-bold py-4 rounded-2xl hover:bg-blue-700 transition duration-300">
                Registrar Producto
            </button>

        </form>

        <a href="listado.php"
           class="mt-4 flex items-center justify-center w-full bg-gray-200 text-gray-700 text-lg font-semibold py-3 rounded-2xl hover:bg-gray-300 transition duration-300">
            ← Volver a Productos
        </a>

    </div>

</body>
</html>
