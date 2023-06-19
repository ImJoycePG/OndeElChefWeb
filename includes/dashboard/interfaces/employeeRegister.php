<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

session_start();
if (!isset($_SESSION['dni'])) {
    header('Location: ../../login.html');
    exit();
}

$dni = $_POST["dniEmployee"];
$nombre = $_POST["nameEmployee"];
$apellido = $_POST["surnameEmployee"];
$edad = $_POST["ageEmployee"];
$salario = $_POST["salaryEmployee"];
$telefono = $_POST["phoneEmployee"];
$idRole = $_POST["idRole"];


if(isset($_POST['action']) && $_POST['action'] === 'guardar') {
    if (!preg_match('/^\d{8}$/', $dni)) {
        echo '<script>alert("El DNI debe contener 8 números");</script>';
        echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
    }
    
    if (!preg_match('/^\d{9}$/', $telefono)) {
        echo '<script>alert("El teléfono debe contener 9 números");</script>';
        echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
    }

    $tableName = 'Employee';
    $columns = array('dniEmployee', 'nameEmployee', 'surnameEmployee', 'ageEmployee', 'salaryEmployee', 'phoneEmployee', 'idRole');
    $values = array($dni, $nombre, $apellido, $edad, $salario, $telefono, $idRole);

    $existingData = $mysqlUtil->findData($tableName, 'dniEmployee', $dni);
    if(count($existingData) > 0){
        echo '<script>alert("Ya existe este empleado en la base de datos.");</script>';
        echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
    }else{
        $mysqlUtil->insertData($tableName, $columns, $values);
        echo '<script>alert("Se ha ingresado correctamente a la base de datos.");</script>';
        echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
    }
} else if(isset($_POST['action']) && $_POST['action'] === 'buscar') {
    $tableName = 'Employee';
    $dni = $_POST['dniEmployee'];
    $existingData = $mysqlUtil->findData($tableName, 'dniEmployee', $dni);
    if(count($existingData) > 0){
        $data = $existingData[0];
        header('Location: ../../../dashboard/interfaces/empleado.html?dniEmployee=' . $data['dniEmployee'] . '&nameEmployee=' . $data['nameEmployee'] . '&surnameEmployee=' . $data['surnameEmployee'] . '&ageEmployee=' . $data['ageEmployee'] . '&salaryEmployee=' . $data['salaryEmployee'] . '&phoneEmployee=' . $data['phoneEmployee'] . '&idRole=' . $data['idRole']);
        exit();
    } else {
        echo '<script>alert("No se encontró ningún empleado con ese DNI.");</script>';
        echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
    }
} else if(isset($_POST['action']) && $_POST['action'] === 'actualizar') {
    if (!preg_match('/^\d{8}$/', $dni)) {
        echo '<script>alert("El DNI debe contener 8 números");</script>';
        echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
    }
    
    if (!preg_match('/^\d{9}$/', $telefono)) {
        echo '<script>alert("El teléfono debe contener 9 números");</script>';
        echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
    }

    $tableName = 'Employee';
    $columns = array('dniEmployee', 'nameEmployee', 'surnameEmployee', 'ageEmployee', 'salaryEmployee', 'phoneEmployee', 'idRole');
    $values = array($dni, $nombre, $apellido, $edad, $salario, $telefono, $idRole);
    $conditions = array('dniEmployee' => $dni);

    foreach ($values as $value) {
        if (empty($value)) {
            echo '<script>alert("Todos los campos son obligatorios");</script>';
            echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
        }
    }

    $mysqlUtil->updateData($tableName, array_combine($columns, $values), $conditions);
    
    echo '<script>alert("Se ha actualizado los datos en la base de datos.");</script>';
    echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
} else if(isset($_POST['action']) && $_POST['action'] === 'eliminar') {
    
    $idProduct = $_POST['dniEmployee'];
    $tableName = 'Employee';
    $existingData = $mysqlUtil->findData($tableName, 'dniEmployee', $idProduct);
    if (count($existingData) < 1) {
        echo '<script>alert("No existe ninguno con esa id.");</script>';
        echo '<script>window.location.href = " ../../../dashboard/interfaces/empleado.html";</script>';
    } else {
        if (!$mysqlUtil->deleteRow($tableName, 'dniEmployee', $idProduct)) {
            echo '<script>alert("Se ha eliminado correctamente.");</script>';
            echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
        }else{
            echo '<script>alert("No se pudo eliminar correctamente.");</script>';
            echo '<script>window.location.href = "../../../dashboard/interfaces/empleado.html";</script>';
        }
    }
}

?>