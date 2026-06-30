<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

require '../includes/conexion.php';

$total_usuarios = (int) $conn->query('SELECT COUNT(*) FROM usuarios')->fetchColumn();
$total_distritos = (int) $conn->query('SELECT COUNT(DISTINCT distrito) FROM usuarios')->fetchColumn();

$nombre = htmlspecialchars($_SESSION['admin_nombre']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        <aside class="w-64 bg-red-700 text-white">

            <div class="p-6 text-center border-b border-red-500">
                <h1 class="text-3xl font-bold">UTP</h1>
                <p class="text-sm mt-2">Sistema de Ventas</p>
            </div>

            <nav class="mt-6">

                <a href="../usuarios/listado.php" class="flex items-center px-6 py-4 hover:bg-red-800 transition">
                    ⚙️ <span class="ml-3">Lista de Usuarios</span>
                </a>

                <a href="../usuarios/registro.php" class="flex items-center px-6 py-4 hover:bg-red-800 transition">
                    🛠️ <span class="ml-3">Registro de Usuarios</span>
                </a>

                <a href="#" class="flex items-center px-6 py-4 hover:bg-red-800 transition">
                    📊 <span class="ml-3">Reportes</span>
                </a>

            </nav>

            <div class="mt-auto p-4 border-t border-red-500">
                <a href="../auth/cerrar_sesion.php"
                   class="flex items-center justify-center w-full bg-white text-red-700 font-bold py-3 rounded-xl hover:bg-red-100 transition duration-300">
                    🚪 <span class="ml-2">Cerrar Sesión</span>
                </a>
            </div>

        </aside>

        <div class="flex-1 flex flex-col">

            <header class="bg-white shadow-md p-5 flex justify-between items-center">

                <h2 class="text-2xl font-bold text-gray-700">Dashboard</h2>

                <div class="flex items-center">
                    <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full">
                    <span class="ml-3 font-semibold text-gray-700"><?= $nombre ?></span>
                </div>

            </header>

            <main class="p-8">

                <h3 class="text-3xl font-bold text-gray-700 mb-8">
                    Bienvenido al Sistema de Ventas
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h4 class="text-xl font-bold text-gray-700">Ventas del Día</h4>
                        <p class="text-4xl text-green-600 mt-4"><?= $total_usuarios ?></p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h4 class="text-xl font-bold text-gray-700">Productos</h4>
                        <p class="text-4xl text-blue-600 mt-4"><?= $total_distritos ?></p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h4 class="text-xl font-bold text-gray-700">Clientes</h4>
                        <p class="text-4xl text-red-600 mt-4"><?= $total_usuarios ?></p>
                    </div>

                </div>

            </main>

        </div>

    </div>

</body>
</html>
