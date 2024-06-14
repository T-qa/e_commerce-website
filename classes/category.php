<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Category
{
    public function addCategory($name, $desc)
    {
        $DB = new DBConnect();
        $conn = $DB->connect();

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO category (name, description) VALUES (?, ?)");
        // Bind the parameters to the SQL query       
        $stmt->bind_param("ss", $name, $desc);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Add Successfully';
            header("refresh:1.5;url=category-view.php");
        } else {
            die("Error: " . $stmt->error);
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    public function updateCategory($id, $name, $desc)
    {
        $DB = new DBConnect();
        $conn = $DB->connect();

        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE category SET name=?, description=? WHERE id=?");
        // Bind the parameters to the SQL query
        $stmt->bind_param("ssi", $name, $desc, $id);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successfully';
            header("refresh:1.5;url=category-view.php");
        } else {
            die("Error: " . $stmt->error);
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    public function removeCategory($id)
    {
        $DB = new DBConnect();
        $conn = $DB->connect();
    
        // Check if there are any products associated with this category (optional, based on your needs)
        $stmt_check = $conn->prepare("SELECT COUNT(*) AS total FROM product WHERE category_id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        $row = $result->fetch_assoc();
        $total_products = $row['total'];
    
        if ($total_products > 0) {
            echo "<script>alert('Cannot delete category. There are still products associated with it.')</script>";
            return;
        }
    
        // Proceed with category deletion
        $stmt = $conn->prepare("DELETE FROM category WHERE id=?");
        $stmt->bind_param("i", $id);
    
        if ($stmt->execute()) {
            // Reset auto-increment value after successful deletion
            $conn->query("ALTER TABLE category AUTO_INCREMENT = 1");
            header("refresh:0.5;url=category-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    
        // Close statements and connection
        $stmt->close();
        $conn->close();
    }

    public function fetch()
    {
        $DB = new DBConnect();
        $conn = $DB->connect();
        $data = array();

        $stmt = $conn->prepare("SELECT * FROM category");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $data;
    }

    public function fetchByID($id)
    {
        $DB = new DBConnect();
        $conn = $DB->connect();
        $data = array();

        $stmt = $conn->prepare("SELECT * FROM category WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $data;
    }
}