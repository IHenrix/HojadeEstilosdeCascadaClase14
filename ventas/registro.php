<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

require '../includes/conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id  = (int) ($_POST['cliente_id']  ?? 0);
    $producto_id = (int) ($_POST['producto_id'] ?? 0);
    $cantidad    = (int) ($_POST['cantidad']    ?? 0);

    if ($cliente_id === 0) {
        $error = 'Debes seleccionar un cliente.';
    } elseif ($producto_id === 0) {
        $error = 'Debes seleccionar un producto.';
    } elseif ($cantidad <= 0) {
        $error = 'La cantidad debe ser mayor a 0.';
    } else {
        $stmt = $conn->prepare('SELECT precio FROM producto WHERE id = ?');
        $stmt->execute([$producto_id]);
        $precio = $stmt->fetchColumn();

        if (!$precio) {
            $error = 'El producto seleccionado no existe.';
        } else {
            $total = $precio * $cantidad;
            $stmt  = $conn->prepare('INSERT INTO venta (cliente_id, producto_id, cantidad, total) VALUES (?, ?, ?, ?)');
            if ($stmt->execute([$cliente_id, $producto_id, $cantidad, $total])) {
                header('Location: listado.php?exito=1');
                exit;
            } else {
                $error = 'Ocurrió un error al registrar la venta.';
            }
        }
    }
}

$clientes  = $conn->query('SELECT id, nombre, apellido FROM cliente ORDER BY nombre')->fetchAll(PDO::FETCH_ASSOC);
$productos = $conn->query('SELECT id, nombre, precio FROM producto ORDER BY nombre')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Registro de Venta</title>
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">

    <div class="bg-white w-full max-w-2xl rounded-3xl p-10 shadow-lg">

        <h1 class="text-4xl font-bold text-center text-green-600 mb-10">
            Registro de Venta
        </h1>

        <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-6">
                <label class="block text-xl font-semibold text-gray-800 mb-3">Cliente</label>
                <select name="cliente_id" required
                    class="w-full p-4 text-xl border border-green-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Selecciona un cliente --</option>
                    <?php foreach ($clientes as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre'] . ' ' . $c['apellido']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-xl font-semibold text-gray-800 mb-3">Producto</label>
                <select name="producto_id" required
                    class="w-full p-4 text-xl border border-green-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Selecciona un producto --</option>
                    <?php foreach ($productos as $p): ?>
                    <option value="<?= $p['id'] ?>">
                        <?= htmlspecialchars($p['nombre']) ?> — S/. <?= number_format($p['precio'], 2) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-8">
                <label class="block text-xl font-semibold text-gray-800 mb-3">Cantidad</label>
                <input type="number" name="cantidad" min="1" value="1" required
                    class="w-full p-4 text-xl border border-green-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white text-xl font-bold py-4 rounded-2xl hover:bg-green-700 transition duration-300">
                Registrar Venta
            </button>

        </form>

        <a href="listado.php"
           class="mt-4 flex items-center justify-center w-full bg-gray-200 text-gray-700 text-lg font-semibold py-3 rounded-2xl hover:bg-gray-300 transition duration-300">
            ← Ver Ventas
        </a>

        <a href="../dashboard/menu.php"
           class="mt-3 flex items-center justify-center w-full bg-gray-100 text-gray-500 text-lg font-semibold py-3 rounded-2xl hover:bg-gray-200 transition duration-300">
            ← Volver al Menú
        </a>

    </div>

</body>
</html>
