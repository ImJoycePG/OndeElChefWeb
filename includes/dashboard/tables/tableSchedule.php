<?php
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();

$tableName = 'Schedules';
$data = $mysqlUtil->getAllData($tableName);

if ($data) {
  foreach ($data as $supplier) {
    echo "<tr>";
    echo "<td>" . $supplier['idSchedules'] . "</td>";
    echo "<td>" . $supplier['dniEmployee'] . "</td>";
    echo "<td>" . $supplier['startHour'] . "</td>";
    echo "<td>" . $supplier['endHour'] . "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='2'>No se encontraron resultados.</td></tr>";
}
?>
