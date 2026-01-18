<?php
// config.php
$DB_HOST = '***************';     
$DB_NAME = '**********'; 
$DB_USER = '********';       
$DB_PASS = '******';         
try {
  $pdo = new PDO(
    "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
    $DB_USER,
    $DB_PASS,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_PERSISTENT => false
    ]
  );
} catch (PDOException $e) {
  http_response_code(500);
  exit('Error de conexión DB: ' . $e->getMessage());
}
