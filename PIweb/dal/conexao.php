<?php


$host = 'localhost';
$db = 'bluehorizon';
$user = 'root';
$pass = 'aluno'; // ou 'root' no MAMP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
$pdo=null;
try {
    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {
    echo "<p>Erro ao conectar ao banco de dados: " . $e->getMessage() . "</p>";
}

var_dump($pdo);