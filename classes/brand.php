<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Brand
{
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
            die("Error: " . $stmt->error);
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
            die("Error: " . $stmt->error);
        }
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    public function removeBrand($id)
    {
        $DB = new DBConnect();
        $conn = $DB->connect();
    
        // Check if there are any products associated with this brand (optional, based on your needs)
        $stmt_check = $conn->prepare("SELECT COUNT(*) AS total FROM product WHERE brand_id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        $row = $result->fetch_assoc();
        $total_products = $row['total'];

        if ($total_products > 0) {
            echo "<script>alert('Cannot delete brand. There are still products associated with it.')</script>";
            return;
        }

        // Proceed with brand deletion
        $stmt = $conn->prepare("DELETE FROM brand WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Reset auto-increment value after successful deletion
            $conn->query("ALTER TABLE brand AUTO_INCREMENT = 1");
            header("refresh:0.5;url=brand-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
        
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