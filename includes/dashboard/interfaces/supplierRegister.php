<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

session_start();
if (!isset($_SESSION['dni'])) {
    header('Location: ../../login.html');
    exit();
}

if (isset($_POST['action']) && $_POST['action'] === 'eliminar') {
    $ruc = $_POST['rucSupplier'];
    $tableName = 'Supplier';
    $existingData = $mysqlUtil->findData($tableName, 'idCategory', $ruc);
    if (count($existingData) < 1) {
        echo '<script>alert("No existe ninguno con esa id.");</script>';
        echo '<script>window.location.href = " ../../../dashboard/interfaces/proveedor.html";</script>';
    } else {
        if ($mysqlUtil->deleteRow($tableName, 'rucSupplier', $ruc)) {
            echo '<script>alert("Se eliminó correctamente de la base de datos.");</script>';
            echo '<script>window.location.href = " ../../../dashboard/interfaces/proveedor.html";</script>';
        } else {
            echo '<script>alert("No se eliminó correctamente de la base de datos.");</script>';
            echo '<script>window.location.href = " ../../../dashboard/interfaces/proveedor.html";</script>';
        }
    }
} else if (isset($_POST['action']) && $_POST['action'] === 'guardar') {
    $ruc = $_POST['rucSupplier'];
    $nombre = $_POST['nameSupplier'];

    $tableName = 'Supplier';
    $columns = ['rucSupplier', 'nameSupplier'];
    $values = [$ruc, $nombre];

    $existingData = $mysqlUtil->findData($tableName, 'rucSupplier', $ruc);
    if (count($existingData) > 0) {
        echo '<script>alert("Ya existe este proveedor en la base de datos.");</script>';
        echo '<script>window.location.href = " ../../../dashboard/interfaces/proveedor.html";</script>';
    } else {
        $mysqlUtil->insertData($tableName, $columns, $values);
        echo '<script>alert("Se ha ingresado correctamente un nuevo proveedor.");</script>';
        echo '<script>window.location.href = " ../../../dashboard/interfaces/proveedor.html";</script>';
    }
}
