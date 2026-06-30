<?php
$host   = $_ENV['PGHOST']     ?? 'localhost';
$puerto = $_ENV['PGPORT']     ?? 5432;
$dbname = $_ENV['PGDATABASE'] ?? 'bd_utp';
$user   = $_ENV['PGUSER']     ?? 'postgres';
$pass   = $_ENV['PGPASSWORD'] ?? '1234';

$dsn  = "pgsql:host=$host;port=$puerto;dbname=$dbname";
$conn = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
