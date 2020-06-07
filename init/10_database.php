<?php
$dbname = 'footballclub';
$dns = 'mysql:dbname='.$dbname.';host=localhost';
$develop = 1;

if( $develop == 1){
    $dbuser = 'root';
    $dbpassword = '';
}

$options    = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$db = null;

try{
    $db = new PDO($dns, $dbuser, $dbpassword, $options);
}
catch(PDOException $e){
    $message = 'Database connection failed: ' . $e->getMessage();
    die($message);
}