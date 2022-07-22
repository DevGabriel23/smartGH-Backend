<?php

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pdo = null;
$host = $_ENV['HOST'];
$user = $_ENV['USER'];
$pass = $_ENV['PASSWORD'];
$db = $_ENV['DATABASE'];

function conection(){
    try {
        $GLOBALS['pdo'] = new PDO("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db']."",$GLOBALS['user'],$GLOBALS['pass']);
        $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print "Error: No se pudo conectar con la base de datos: ".$db."<br/>";
        print "\nError: ".$e."<br/>";
        die();
    }
}

function disconection(){
    $GLOBALS['pdo'] = null;
}

function get($query){
    try {
        conection();
        $statement = $GLOBALS['pdo']->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();
        disconection();
        return $statement;
    } catch (Exception $e) {
        die("Error: ".$e);
    }
}

function post($query, $queryAutoIncrement){
    try {
        conection();
        $statement = $GLOBALS['pdo']->prepare($query);
        $statement->execute();
        $idAutoIncrement = get($queryAutoIncrement)->fetch(PDO::FETCH_ASSOC);
        $result = array_merge($idAutoIncrement, $_POST);
        $statement->closeCursor();
        disconection();
        return $statement;
    } catch (Exception $e) {
        die("Error: ".$e);
    }
}

?>