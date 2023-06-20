<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

$data = $mysqlUtil->getAllData('Product');

if ($data) {
    echo "<option value=''></option>";
    foreach ($data as $row) {
        echo "<option value='{$row['idProduct']}'>{$row['idProduct']} - {$row['nameProduct']}</option>";
    }
}
?>