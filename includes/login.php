<?php
require_once('./Utils/SQLUtil.php');
$sqlUtil = new MySQLUtil();
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['typeDniX'];
    $password = $_POST['typePasswordX'];

    $status = $sqlUtil->checkLogin($dni, $password);

    if($status){
        $_SESSION['dni'] = $dni;
        header('Location: ../dashboard.html');
        exit();
    }else{
        echo "<script>alert('Hubo un error al autenticarte, inténtalo de nuevo.')</script>";
        echo "<script>window.location.href = '../login.html';;</script>";
    }
}

?>