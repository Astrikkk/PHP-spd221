<?php
include $_SERVER['DOCUMENT_ROOT'].'/options.php';
try {
    $dbh = new PDO(DB_DRIVER.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
    echo $e->getMessage();
}