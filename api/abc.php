<?php

class employees {

public name;
public designation;
public email;
public dob;
public age;
public conn;

public function __construct($db) {
$this->conn = $db;
}

public function getEmployees() {

   $sql = "SELECT * FROM Employees";
   $statement = $this->conn->prepare($sql);


}

}

?>