<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

$tableName = 'Category';
$data = $mysqlUtil->getAllData($tableName);

if ($data) {
  foreach ($data as $supplier) {
    echo "<tr>";
    echo "<td>" . $supplier['idCategory'] . "</td>";
    echo "<td>" . $supplier['nameCategory'] . "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='2'>No se encontraron resultados.</td></tr>";
}
?>
