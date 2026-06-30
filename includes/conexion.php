<?php
$host   = $_ENV['PGHOST']     ?? $_SERVER['PGHOST']     ?? 'localhost';
$puerto = $_ENV['PGPORT']     ?? $_SERVER['PGPORT']     ?? 5432;
$dbname = $_ENV['PGDATABASE'] ?? $_SERVER['PGDATABASE'] ?? 'railway';
$user   = $_ENV['PGUSER']     ?? $_SERVER['PGUSER']     ?? 'postgres';
$pass   = $_ENV['PGPASSWORD'] ?? $_SERVER['PGPASSWORD'] ?? '';

$dsn  = "pgsql:host=$host;port=$puerto;dbname=$dbname";
$conn = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
