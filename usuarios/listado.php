<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

require '../includes/conexion.php';

if (isset($_GET['eliminar'])) {
    $id = (int) $_GET['eliminar'];
    $stmt = $conn->prepare('DELETE FROM usuarios WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: listado.php?exito=eliminado');
    exit;
}

$por_pagina    = 5;
$pagina        = max(1, (int) ($_GET['pagina'] ?? 1));
$offset        = ($pagina - 1) * $por_pagina;
$total         = (int) $conn->query('SELECT COUNT(*) FROM usuarios')->fetchColumn();
$total_paginas = (int) ceil($total / $por_pagina);

$stmt = $conn->prepare('SELECT id, nombre, apellido, distrito FROM usuarios ORDER BY id DESC LIMIT ? OFFSET ?');
$stmt->execute([$por_pagina, $offset]);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$exito = $_GET['exito'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla con Paginación</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-6">

        <div class="flex items-center justify-between mb-6">
            <a href="../dashboard/menu.php"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition font-semibold">
                ← Volver al Menú
            </a>
            <h1 class="text-3xl font-bold text-indigo-600">
                Lista de Usuarios
            </h1>
            <a href="../usuarios/registro.php"
               class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                + Registrar
            </a>
        </div>

        <?php if ($exito === '1'): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            Usuario registrado correctamente.
        </div>
        <?php elseif ($exito === 'editado'): ?>
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg mb-4">
            Usuario actualizado correctamente.
        </div>
        <?php elseif ($exito === 'eliminado'): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            Usuario eliminado.
        </div>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th class="p-3 text-left">N°</th>
                        <th class="p-3 text-left">Nombre</th>
                        <th class="p-3 text-left">Apellido</th>
                        <th class="p-3 text-left">Distrito</th>
                        <th class="p-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-400">No hay usuarios registrados.</td>
                    </tr>
                    <?php endif; ?>

                    <?php $contador = $offset + 1; foreach ($usuarios as $u): ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3"><?= $contador++ ?></td>
                        <td class="p-3"><?= htmlspecialchars($u['nombre']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($u['apellido']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($u['distrito']) ?></td>
                        <td class="p-3 text-center">
                            <a href="editar.php?id=<?= $u['id'] ?>"
                               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 inline-block">
                                Editar
                            </a>
                            <a href="listado.php?eliminar=<?= $u['id'] ?>"
                               onclick="return confirm('¿Eliminar este usuario?')"
                               class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-2 inline-block">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center mt-8 space-x-2">

            <a href="?pagina=<?= max(1, $pagina - 1) ?>"
               class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 <?= $pagina === 1 ? 'opacity-50 pointer-events-none' : '' ?>">
                Anterior
            </a>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="?pagina=<?= $i ?>"
               class="px-4 py-2 rounded <?= $i === $pagina ? 'bg-indigo-600 text-white' : 'bg-gray-200 hover:bg-gray-300' ?>">
                <?= $i ?>
            </a>
            <?php endfor; ?>

            <a href="?pagina=<?= min($total_paginas, $pagina + 1) ?>"
               class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 <?= $pagina === $total_paginas ? 'opacity-50 pointer-events-none' : '' ?>">
                Siguiente
            </a>

        </div>

    </div>

</body>
</html>
