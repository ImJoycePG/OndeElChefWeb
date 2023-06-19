<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

$data = $mysqlUtil->getAllData('RoleType');

if ($data) {
    echo "<option value=''></option>";
    foreach ($data as $row) {
        echo "<option value='{$row['idRole']}'>{$row['idRole']} - {$row['nameRole']}</option>";
    }
}
?>