<?php
    class MySQLUtil {
        private $config;
        private $connection = null;

        public function __construct() {
            $this->config = json_decode(file_get_contents(__DIR__ . '/../config.json'), true);
        }
        
        public function getConnection() {
            if(!$this->connection){
                $this->connectDatabase();
            }

            return $this->connection;
        }

        private function connectDatabase(){
            $host = $this->config['host'];
            $database = $this->config['database'];
            $username = $this->config['username'];
            $password = $this->config['passsword'];
            $this->connection = mysqli_connect($host, $username, $password, $database);
        }

        private function createTables() {
            try {
                $conn = $this->getConnection();
                $stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS Employee (
                    dniEmployee varchar(8) not null primary key,
                    nameEmployee varchar(32) not null,
                    surnameEmployee varchar(32) not null,
                    ageEmployee int not null,
                    salaryEmployee decimal not null,
                    phoneEmployee int
                )");
                $stmt->execute();
        
                $stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS LoginData (
                    dniEmployee varchar(8) not null primary key,
                    password varchar(32) not null,
                    foreign key(dniEmployee) references Employee(dniEmployee)
                )");
                $stmt->execute();
        
                $stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS Schedules (
                    idSchedules varchar(12) not null primary key,
                    dniEmployee varchar(8) not null,
                    foreign key(dniEmployee) references Employee(dniEmployee)
                )");
                $stmt->execute();
        
                $stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS RoleType (
                    idRole varchar(12) not null primary key,
                    nameRole varchar(32) not null
                )");
                $stmt->execute();
        
                $stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS Boss (
                    idGerente varchar(12) not null primary key,
                    idRole varchar(12) not null,
                    dniEmployee varchar(8) not null,
                    foreign key(dniEmployee) references Employee(dniEmployee),
                    foreign key(idRole) references RoleType(idRole)
                )");
                $stmt->execute();
        
                $stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS Supplier (
                    rucSupplier varchar(11) not null primary key,
                    nameSupplier varchar(200) not null
                )");
                $stmt->execute();
        
                $stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS Product (
                    idProduct varchar(12) not null primary key,
                    nameProduct varchar(32) not null,
                    costProduct decimal not null,
                    stockProduct int not null,
                    idLote int not null,
                    dueDate date not null,
                    joinDate date not null,
                    rucSupplier varchar(11) not null,
                    foreign key(rucSupplier) references Supplier(rucSupplier)
                )");
                $stmt->execute();
        
                $stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS Cliente (
                    dniClient varchar(8) not null primary key,
                    nameClient varchar(32) not null,
                    surnameClient varchar(32) not null
                )");
                $stmt->execute();
        
        
            } catch (PDOException $ex) {
                echo "<script>alert('Ocurrio un error');</script>";
            }
        }
        
        public function insertData($tableName, $columns, $values){
            $columnsStr = implode(' , ', $columns);
            $placeholders = implode(' , ', array_fill(0, count($values), '?'));
        
            $query = "INSERT INTO " . $tableName . " (" . $columnsStr . ") VALUES (" . $placeholders . ")";
            $stmt = $this->getConnection()->prepare($query);
            $stmt->bind_param(str_repeat('s', count($values)), ...$values);
            $stmt->execute();
        
            $stmt->close();
        }

        public function findData($tableName, $column, $value){
            $query = "SELECT * FROM " . $tableName . " WHERE " . $column . " = ?";
            $stmt = $this->getConnection()->prepare($query);
            $stmt->bind_param("s", $value);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        
            $stmt->close();
        
            return $data;
        }

        public function deleteRow($tableName, $columnName, $columnValue){
            try {
                $query = "DELETE FROM " . $tableName . " WHERE " . $columnName . "=?";
                $stmt = $this->getConnection()->prepare($query);
                $stmt->bind_param("s", $columnValue);
                $stmt->execute();
                $stmt->close();
                return true;
            } catch (mysqli_sql_exception $e) {
                echo '<script>alert("No se pudo eliminar debido a restricciones.");</script>';
                return false;
            }
        }
        

        public function updateData($tableName, $columnValues, $conditions){
            $columnCount = count($columnValues);
            $conditionCount = count($conditions);
            $params = array_merge(array_values($columnValues), array_values($conditions));
            $i = 0;

            $query = "UPDATE " . $tableName . " SET ";

            foreach($columnValues as $key => $value){
                $query .= $key . " = ?";
                $i++;

                if($i < $columnCount){
                    $query .= ", ";
                }
            }

            if($conditionCount > 0){
                $query .= " WHERE ";

                $j = 0;
                foreach($conditions as $key => $value){
                    $query .= $key . " = ?";
                    $j++;

                    if($j < $conditionCount) {
                        $query .= " AND ";
                    }
                }
            }

            $stmt = $this->getConnection()->prepare($query);

            $types = str_repeat("s", count($params));
            foreach($params as $key => $value){
                if(is_int($value)){
                    $types[$key] = "i";
                }elseif(is_float($value)){
                    $types[$key] = "d";
                }
            }

            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $stmt->close();

        }


        public function getAllData($tableName) {
            $query = "SELECT * FROM " . $tableName;
            $result = $this->getConnection()->query($query);
        
            if ($result->num_rows > 0) {
                $data = array();
        
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
        
                return $data;
            } else {
                return false;
            }
        }
         
        public function checkLogin($dni, $password) {
            $query = "SELECT dniEmployee, passEmployee FROM LoginData WHERE dniEmployee = ? AND passEmployee = ?";
            try {
                $conn = $this->getConnection();
                $statement = $conn->prepare($query);
                $statement->bind_param('ss', $dni, $password);
                $statement->execute();
                $result = $statement->get_result();
                $resultSet = $result->fetch_assoc();
                if ($resultSet) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo "<script>alert('Hubo un error al hacer la consulta.');</script>";
            }
        }
        
    }
?>