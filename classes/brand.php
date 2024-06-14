<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Brand
{
    private $name;
    private $description;

    public function addBrand($name, $desc)
    {
        $DB = new DBConnect();
        $conn = $DB->connect();
        
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO brand(name, description) VALUES (?, ?)");
        // Bind the parameters to the SQL query
        $stmt->bind_param("ss", $name, $desc);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Add Successfully';
            header("refresh:1.5;url=brand-view.php");
        } else {
            die($stmt->error);
        }
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    public function updateBrand($id, $name, $desc)
    {
        $DB = new DBConnect();
        $conn = $DB->connect();
        
        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE brand SET name=?, description=? WHERE id=?");
        // Bind the parameters to the SQL query
        $stmt->bind_param("ssi", $name, $desc, $id);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successfully';
            header("refresh:1.5;url=brand-view.php");
        } else {
            die($stmt->error);
        }
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    public function removeBrand($id)
    {
        $DB = new DBConnect();
        $conn = $DB->connect();
        
        // Prepare the SQL statement
        $stmt = $conn->prepare("DELETE FROM brand WHERE id=?");
        // Bind the parameter to the SQL query
        $stmt->bind_param("i", $id);

        // Execute the prepared statement
        if ($stmt->execute()) {
            header("refresh:0.5;url=brand-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    public function fetch()
    {
        $DB = new DBConnect();
        $conn = $DB->connect();
        $data = null;
        
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM brand");

        // Execute the prepared statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();
        
        return $data;
    }
}