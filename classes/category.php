<?php
require_once(__DIR__ . "/../config/dbconfig.php");

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = new DBConnect();
    }

    public function addCategory($name, $desc)
    {
        $conn = $this->db->connect();

        try {
            $stmt = $conn->prepare("INSERT INTO category (name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $desc);
            $stmt->execute();

            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Category Added Successfully';
            header("refresh:1.5;url=category-view.php");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function updateCategory($id, $name, $desc)
    {
        $conn = $this->db->connect();

        try {
            $stmt = $conn->prepare("UPDATE category SET name=?, description=? WHERE id=?");
            $stmt->bind_param("ssi", $name, $desc, $id);
            $stmt->execute();

            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Category Updated Successfully';
            header("refresh:1.5;url=category-view.php");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function removeCategory($id)
    {
        $conn = $this->db->connect();

        try {
            // Check if there are any products associated with this category
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
            $stmt->execute();

            // Reset auto-increment value after successful deletion (if needed)
            //$conn->query("ALTER TABLE category AUTO_INCREMENT = 1");

            header("refresh:0.5;url=category-view.php");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function fetchAll()
    {
        $conn = $this->db->connect();
        $data = [];

        try {
            $stmt = $conn->prepare("SELECT * FROM category");
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

    public function fetchById($id)
    {
        $conn = $this->db->connect();
        $data = [];

        try {
            $stmt = $conn->prepare("SELECT * FROM category WHERE id = ?");
            $stmt->bind_param("i", $id);
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
?>
