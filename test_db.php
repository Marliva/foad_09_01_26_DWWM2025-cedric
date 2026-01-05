<?php
require_once 'config/db_connect.php';

$stmt = $pdo->query("SELECT * FROM velos");
$velos = $stmt->fetchAll();

echo '<pre>';
print_r($velos);
