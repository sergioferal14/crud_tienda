<?php
if(!isset($_POST['id'])){
    header("Location:index.php");
    die();
}
session_start();
require dirname(__DIR__,2)."/vendor/autoload.php";
use Src\Categorias;



(new Categorias)->delete($_POST['id']);
$_SESSION['mensaje']="Categoria borrada correctamente";
header("Location:index.php");