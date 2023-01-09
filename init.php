<?php
define('ROOT',dirname(__FILE__));
//Carga la configuracion de la conexion a la base de datos
$config= require_once 'config/config.php';

// Se crea la conexion a la base datos
try{
$db=new PDO("mysql:host=".$config['host'].";dbname=".$config['db_name'],$config['user_name'],$config['password']);
// Se inicializa la aplicacion 
require_once 'app/App.php';
$app=new App($db);
$app->run();
}catch(PDOException $e){
    echo "Error de conexion ".$e->getMessage();
}