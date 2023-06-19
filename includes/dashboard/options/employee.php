<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

$data = $mysqlUtil->getAllData('Employee');

if ($data) {
    echo "<option value=''></option>";
    foreach ($data as $row) {
        echo "<option value='{$row['dniEmployee']}'>{$row['dniEmployee']} - {$row['nameEmployee']}</option>";
    }
}
?>