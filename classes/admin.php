<?php
require_once(__DIR__ . "/../config/dbconfig.php");

class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = new DBConnect();
    }

    public function registerAdmin($username, $password)
    {
        $sql = "INSERT INTO admin(username, password) VALUES (?, ?)";
        $conn = $this->db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Registered Successfully';
        } else {
            $_SESSION['status_code'] = 'error';
            $_SESSION['status'] = 'Registration Unsuccessful';
        }
    }

    public function checkUsername($username)
    {
        $sql = "SELECT * FROM admin WHERE username = ?";
        $conn = $this->db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0;
    }

    public function addAdmin($username, $password, $confirmPassword)
    {
        if ($password !== $confirmPassword) {
            $_SESSION['status_code'] = 'error';
            $_SESSION['status'] = 'Confirmed Password does not match';
            return;
        }

        $sql = "INSERT INTO admin(username, password) VALUES (?, ?)";
        $conn = $this->db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Admin Added Successfully';
            header("refresh:1.5;url=admin-view.php");
        } else {
            die(mysqli_error($conn));
        }
    }

    public function checkLogin($username, $password)
    {
        $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
        $conn = $this->db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0;
    }

    public function updateAdmin($id, $username, $password)
    {
        $sql = "UPDATE admin SET username = ?, password = ? WHERE admin_id = ?";
        $conn = $this->db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $password, $id);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Admin Updated Successfully';
            header("refresh:1.5;url=admin-view.php");
        } else {
            die(mysqli_error($conn));
        }
    }

    public function removeAdmin($id)
    {
        $sql = "DELETE FROM admin WHERE admin_id = ?";
        $conn = $this->db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            header("refresh:0.5;url=admin-view.php");
        } else {
            echo "<script>alert('Error deleting admin');</script>";
        }
    }

    public function fetchByUsername($username)
    {
        $sql = "SELECT * FROM admin WHERE username = ?";
        $conn = $this->db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function fetchAllAdmins()
    {
        $sql = "SELECT * FROM admin";
        $conn = $this->db->connect();
        $result = $conn->query($sql);

        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
?>
