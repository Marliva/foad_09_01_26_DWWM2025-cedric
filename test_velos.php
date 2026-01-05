<?php
require_once 'config/db_connect.php';
require_once 'includes/functions_velos.php';

$velos = getAllVelos($pdo);

echo '<pre>';
print_r($velos);
