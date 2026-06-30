<?php
$host   = getenv('PGHOST')     ?: 'localhost';
$puerto = getenv('PGPORT')     ?: 5432;
$dbname = getenv('PGDATABASE') ?: 'railway';
$user   = getenv('PGUSER')     ?: 'postgres';
$pass   = getenv('PGPASSWORD') ?: '1234';

$dsn  = "pgsql:host=$host;port=$puerto;dbname=$dbname";
$conn = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
