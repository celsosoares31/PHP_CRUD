<?php
class Employee
{
    private $conn;
    private $db_table = 'Employee';
    public $id;
    public $name;
    public $email;
    public $age;
    public $designation;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get All employees from the database
    public function getAllEmployees()
    {
        $query = "SELECT id, name,email, age, designation, created_at FROM" . $this->db_table . "";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    // Create employee in the database
    public function createEmployee()
    {
        $query = "INSERT INTO" . $this->db_table . "
        SET 
        name = :name,
        email = :email,
        age = :age,
        designation = :designation,
        created_at = :created_at";
        $stmt = $this->conn->prepare($query);

        // Sinitizing the data before inserting to the bd       $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->designation = htmlspecialchars(strip_tags($this->designation));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':age', $this->age);
        $stmt->bindParam(':designation', $this->designation);
        $stmt->bindParam(':created_at', $this->created_at);

        if (!$stmt->execute()) {
            return false;
        }
        return true;
    }
    // Get single row from database
    public function getSingleEmployee()
    {
        $query = "SELECT id,name,email,age,designation,created_at FROM " . $this->db_table . "
         WHERE id=? LIMIT 0.1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $dataRow['name'];
        $this->email = $dataRow['email'];
        $this->age = $dataRow['age'];
        $this->designation = $dataRow['designation'];
        $this->created_at = $dataRow['created_at'];
    }
    // Update employee in the database
    public function updateEmployee()
    {
        $query = "UPDATE " . $this->db_table . "
        SET 
        name = :name,
        email = :email,
        age = :age,
        designation = :designation,
        created_at = :created_at
        WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        //Sanitize the content before inserting to the db

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->designation = htmlspecialchars(strip_tags($this->designation));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':age', $this->age);
        $stmt->bindParam(':designation', $this->designation);
        $stmt->bindParam(':created_at', $this->created_at);
        $stmt->bindParam(':id', $this->id);
        if (!$stmt->execute()) {
            return false;
        }
        return true;
    }
    // Delete employee from the database
    function deleteEmployee()
    {
        $sqlQuery = "DELETE FROM" . $this->db_table . "WHERE id=?";
        $stmt = $this->conn->prepare($sqlQuery);
        // Sinitize the id
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        if (!$stmt->execute()) {
            return false;
        }
        return true;
    }
}
