<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

$tableName = 'Product';
$data = $mysqlUtil->getAllData($tableName);

if ($data) {
  foreach ($data as $supplier) {
    echo "<tr>";
    echo "<td>" . $supplier['idProduct'] . "</td>";
    echo "<td>" . $supplier['nameProduct'] . "</td>";
    echo "<td>" . $supplier['costProduct'] . "</td>";
    echo "<td>" . $supplier['stockProduct'] . "</td>";
    echo "<td>" . $supplier['idCategory'] . "</td>";
    echo "<td>" . $supplier['dueDate'] . "</td>";
    echo "<td>" . $supplier['joinDate'] . "</td>";
    echo "<td>" . $supplier['rucSupplier'] . "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='2'>No se encontraron resultados.</td></tr>";
}
?>
