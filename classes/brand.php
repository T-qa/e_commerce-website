<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Brand
{
    private $db;

    public function __construct()
    {
        $this->db = new DBConnect();
    }

    public function addBrand($name, $desc)
    {
        $conn = $this->db->connect();
        try {
            $stmt = $conn->prepare("INSERT INTO brand(name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $desc);
            $stmt->execute();

            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Brand Added Successfully';
            header("refresh:1.5;url=brand-view.php");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function updateBrand($id, $name, $desc)
    {
        $conn = $this->db->connect();
        
        try {
            $stmt = $conn->prepare("UPDATE brand SET name=?, description=? WHERE id=?");
            $stmt->bind_param("ssi", $name, $desc, $id);
            $stmt->execute();

            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Brand Updated Successfully';
            header("refresh:1.5;url=brand-view.php");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function removeBrand($id)
    {
        $conn = $this->db->connect();
    
        try {
            // Check if there are any products associated with this brand
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
            $stmt->execute();

            // Reset auto-increment value after successful deletion (if desired)
            //$conn->query("ALTER TABLE brand AUTO_INCREMENT = 1");
            header("refresh:0.5;url=brand-view.php");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function fetch()
    {
        $conn = $this->db->connect();
        $data = [];

        try {
            $stmt = $conn->prepare("SELECT * FROM brand");
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $stmt->close();
            $conn->close();
        }

        return $data;
    }
}