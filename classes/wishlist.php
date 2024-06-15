<?php
require_once(__DIR__ . "/../config/dbconfig.php");

class Wishlist
{
    private $db;

    public function __construct()
    {
        $this->db = new DBConnect();
    }

    public function checkAdded($id, $username)
    {
        $id = $this->sanitizeInput($id);
        $sql = "SELECT * FROM wishlist WHERE username = ? AND product_id = ?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("si", $username, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }

    public function remove($id, $username)
    {
        $sql = "DELETE FROM wishlist WHERE username = ? AND product_id = ?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("si", $username, $id);
        
        if ($stmt->execute()) {
            // Optional: Handle success
        } else {
            die("Error: " . $stmt->error);
        }
    }

    public function add($id, $username)
    {
        if ($_SESSION['username'] == '') {
            header("Location: ../login.php");
            exit(); // Stop execution after redirect
        }

        $wishlist = new Wishlist();
        $checker = new Wishlist();
        if (!$checker->checkAdded($id, $username)) {
            $sql = "INSERT INTO wishlist (username, product_id) VALUES (?, ?)";
            $stmt = $this->db->connect()->prepare($sql);
            $stmt->bind_param("si", $username, $id);
            
            if ($stmt->execute()) {
                // Optional: Handle success
            } else {
                die("Error: " . $stmt->error);
            }
        } else {
            $wishlist->remove($id, $username);
        }
    }

    public function fetch($username)
    {
        $sql = "SELECT w.username, w.product_id, p.name AS product_name, p.price, p.img 
                FROM wishlist w
                INNER JOIN product p ON p.id = w.product_id
                WHERE w.username = ?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return []; // Return an empty array if no results found
        }
    }

    public function wishlistItemsCount($username)
    {
        $sql = "SELECT COUNT(*) as items FROM wishlist WHERE username = ?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return $data['items'];
        } else {
            return 0;
        }
    }

    private function sanitizeInput($input)
    {
        // Example of basic input sanitization
        $input = str_replace("'", "", $input);
        $input = str_replace("/", "", $input);
        return $input;
    }
}
?>
