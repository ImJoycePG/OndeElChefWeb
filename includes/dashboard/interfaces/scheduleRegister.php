<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

session_start();
if (!isset($_SESSION['dni'])) {
    header('Location: ../../login.html');
    exit();
}

if (isset($_POST['action']) && $_POST['action'] === 'eliminar') {
    $ruc = $_POST['idSchedules'];
    $tableName = 'Schedules';
    $existingData = $mysqlUtil->findData($tableName, 'idSchedules', $ruc);
    if (count($existingData) < 1) {
        echo '<script>alert("No existe ninguno con esa id.");</script>';
        echo '<script>window.location.href = " ../../../dashboard/interfaces/horario.html";</script>';
    } else {

        if ($mysqlUtil->deleteRow($tableName, 'idCategory', $ruc)) {
            echo '<script>alert("Se eliminó correctamente de la base de datos.");</script>';
            echo '<script>window.location.href = " ../../../dashboard/interfaces/horario.html";</script>';
        } else {
            echo '<script>alert("No se eliminó correctamente de la base de datos.");</script>';
            echo '<script>window.location.href = " ../../../dashboard/interfaces/horario.html";</script>';
        }
    }
} else if (isset($_POST['action']) && $_POST['action'] === 'guardar') {
    $ruc = $_POST['idSchedules'];
    $dniEmployee = $_POST['dniEmployee'];
    $startHour = $_POST['startHour'];
    $endHour = $_POST['endHour'];

    $tableName = 'Schedules';
    $columns = ['idSchedules', 'dniEmployee', 'startHour', 'endHour'];
    $values = [$ruc, $dniEmployee, $startHour, $endHour];

    $existingData = $mysqlUtil->findData($tableName, 'idSchedules', $ruc);
    if (count($existingData) > 0) {
        echo '<script>alert("Ya existe esta categoría en la base de datos.");</script>';
        echo '<script>window.location.href = " ../../../dashboard/interfaces/horario.html";</script>';
    } else {

        $mysqlUtil->insertData($tableName, $columns, $values);
        echo '<script>alert("Se ha ingresado correctamente una nueva categoría.");</script>';
        echo '<script>window.location.href = " ../../../dashboard/interfaces/horario.html";</script>';
    }
}
