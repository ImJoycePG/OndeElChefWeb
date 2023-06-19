<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

session_start();
if (!isset($_SESSION['dni'])) {
    header('Location: ../../login.html');
    exit();
}

$idProduct = $_POST['idProduct'];
$nameProduct = $_POST['nameProduct'];
$costProduct = $_POST['costProduct'];
$stockProduct = $_POST['stockProduct'];
$idCategory = $_POST['idCategory'];
$dueDate = $_POST['dueDate'];
$joinDate = $_POST['joinDate'];
$rucProveedor = $_POST['rucProveedor'];

if(isset($_POST['action']) && $_POST['action'] === 'guardar') {
    $tableName = 'Product';
    $columns = array('idProduct', 'nameProduct', 'costProduct', 'stockProduct', 'idCategory', 'dueDate', 'joinDate', 'rucSupplier');
    $values = array($idProduct, $nameProduct, $costProduct, $stockProduct, $idCategory, $dueDate, $joinDate, $rucProveedor);

    $existingData = $mysqlUtil->findData($tableName, 'idProduct', $idProduct);
    if(count($existingData) > 0){
        echo '<script>alert("Ya existe este producto en la base de datos.");</script>';
        echo '<script>window.location.href = "../../../dashboard/interfaces/producto.html";</script>';
    }else{
        $mysqlUtil->insertData($tableName, $columns, $values);
        echo '<script>alert("Se ingresó correctamente a la base de datos");</script>';
        echo '<script>window.location.href = "../../../dashboard/interfaces/producto.html";</script>';
    }
} else if(isset($_POST['action']) && $_POST['action'] === 'buscar') {
    $tableName = 'Product';
    $idProduct = $_POST['idProduct'];
    $existingData = $mysqlUtil->findData($tableName, 'idProduct', $idProduct);
    if(count($existingData) > 0){
        $data = $existingData[0];
        header('Location: ../../../dashboard/interfaces/producto.html?idProduct=' . $data['idProduct'] . '&nameProduct=' . $data['nameProduct'] . '&costProduct=' . $data['costProduct'] . '&stockProduct=' . $data['stockProduct'] . '&idCategory=' . $data['idCategory'] . '&dueDate=' . $data['dueDate'] . '&joinDate=' . $data['joinDate'] . '&rucSupplier=' . $data['rucSupplier']);
        exit();
    } else {
        echo '<script>alert("No se encontró ningún producto con ese ID.");</script>';
        echo '<script>window.location.href = "../../../dashboard/interfaces/producto.html";</script>';
    }
} else if(isset($_POST['action']) && $_POST['action'] === 'actualizar') {
    $tableName = 'Product';
    $columns = array('nameProduct', 'costProduct', 'stockProduct', 'idCategory', 'dueDate', 'joinDate', 'rucSupplier');
    $values = array($nameProduct, $costProduct, $stockProduct, $idCategory, $dueDate, $joinDate, $rucProveedor);
    $conditions = array('idProduct' => $idProduct);

    foreach ($values as $value) {
        if (empty($value)) {
            echo '<script>alert("Todos los campos son obligatorios");</script>';
            echo '<script>window.location.href = "../../../dashboard/interfaces/producto.html";</script>';
        }
    }

    $mysqlUtil->updateData($tableName, array_combine($columns, $values), $conditions);
    
    header('Location: ../../../dashboard/interfaces/producto.html');
    exit();
} else if(isset($_POST['action']) && $_POST['action'] === 'eliminar') {
    
    $idProduct = $_POST['idProduct'];
    $tableName = 'Product';
    $existingData = $mysqlUtil->findData($tableName, 'idProduct', $idProduct);
    if (count($existingData) < 1) {
        echo '<script>alert("No existe ninguno con esa id.");</script>';
        echo '<script>window.location.href = " ../../../dashboard/interfaces/producto.html";</script>';
    } else {
        if ($mysqlUtil->deleteRow($tableName, 'idProduct', $idProduct)) {
            header('Location: ../../../dashboard/interfaces/producto.html');
            exit();
        }else{
            echo '<script>window.location.href = "../../../dashboard/interfaces/producto.html";</script>';
            exit();
        }
    }
}


?>