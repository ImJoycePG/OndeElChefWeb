<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

$data = $mysqlUtil->getAllData('Supplier');

if ($data) {
    echo "<option value=''></option>";
    foreach ($data as $row) {
        echo "<option value='{$row['rucSupplier']}'>{$row['rucSupplier']} - {$row['nameSupplier']}</option>";
    }
}
?>