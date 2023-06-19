<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

$data = $mysqlUtil->getAllData('Category');

if ($data) {
    echo "<option value=''></option>";
    foreach ($data as $row) {
        echo "<option value='{$row['idCategory']}'>{$row['idCategory']} - {$row['nameCategory']}</option>";
    }
}
?>