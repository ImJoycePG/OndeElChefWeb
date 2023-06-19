<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

$tableName = 'Employee';
$data = $mysqlUtil->getAllData($tableName);

if ($data) {
  foreach ($data as $supplier) {
    echo "<tr>";
    echo "<td>" . $supplier['dniEmployee'] . "</td>";
    echo "<td>" . $supplier['nameEmployee'] . "</td>";
    echo "<td>" . $supplier['surnameEmployee'] . "</td>";
    echo "<td>" . $supplier['ageEmployee'] . "</td>";
    echo "<td>" . $supplier['salaryEmployee'] . "</td>";
    echo "<td>" . $supplier['phoneEmployee'] . "</td>";
    echo "<td>" . $supplier['idRole'] . "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='2'>No se encontraron resultados.</td></tr>";
}
?>
