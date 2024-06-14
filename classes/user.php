<?php
require_once(__DIR__ . "/../config/dbconfig.php");

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new DBConnect();
    }

    public function removeUser($id)
    {
        $conn = $this->db->connect();

        // Start transaction
        $conn->begin_transaction();

        try {
            // Delete the user
            $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // Check if there are any remaining users
            $result = $conn->query("SELECT COUNT(*) as count FROM user");
            $row = $result->fetch_assoc();
            $count = $row['count'];

            // Reset AUTO_INCREMENT based on current count of users
            if ($count > 0) {
                // Get the current maximum user_id
                $result = $conn->query("SELECT MAX(user_id) AS max_id FROM user");
                $row = $result->fetch_assoc();
                $max_id = $row['max_id'];

                // Set AUTO_INCREMENT to the next available value
                $new_auto_increment = $max_id + 1;
                $conn->query("ALTER TABLE user AUTO_INCREMENT = $new_auto_increment");
            } else {
                // If no users are left, reset AUTO_INCREMENT to 1
                $conn->query("ALTER TABLE user AUTO_INCREMENT = 1");
            }

            // Commit transaction
            $conn->commit();

            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'User deleted successfully';
            header("refresh:1.5;url=user-view.php");
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            echo "<script>alert('Error deleting user: " . $e->getMessage() . "');</script>";
        }

        $stmt->close();
        $conn->close();
    }

    public function checkExistEmail($email)
    {
        $conn = $this->db->connect();

        try {
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            
            return $stmt->num_rows > 0;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function checkLogin($username, $password)
    {
        $conn = $this->db->connect();

        try {
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    return true;
                }
            }
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function checkUsername($username)
    {
        $conn = $this->db->connect();

        try {
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            return $stmt->num_rows > 0;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function registerUser($username, $email, $password)
    {
        $conn = $this->db->connect();

        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            $stmt->execute();

            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'User registered successfully';
        } catch (Exception $e) {
            $_SESSION['status'] = 'Registration unsuccessful: ' . $e->getMessage();
            $_SESSION['status_code'] = 'error';
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function updateProfile($fname, $lname, $email, $phone, $username)
    {
        $conn = $this->db->connect();

        try {
            $stmt = $conn->prepare("UPDATE user SET firstName = ?, lastName = ?, email = ?, phone = ? WHERE username = ?");
            $stmt->bind_param("sssss", $fname, $lname, $email, $phone, $username);
            $stmt->execute();

            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Profile updated successfully';
        } catch (Exception $e) {
            $_SESSION['status'] = 'Update unsuccessful: ' . $e->getMessage();
            $_SESSION['status_code'] = 'error';
        } finally {
            $stmt->close();
            $conn->close();
        }

        header("refresh:1.5;url=profile-view.php");
    }

    public function changePassword($current_pass, $new_password, $conf_new_pwd, $username)
    {
        $conn = $this->db->connect();

        try {
            $stmt = $conn->prepare("SELECT password FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($current_pass, $user['password'])) {
                    if ($new_password == $conf_new_pwd) {
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE username = ?");
                        $stmt->bind_param("ss", $hashed_password, $username);
                        $stmt->execute();

                        $_SESSION['status_code'] = 'success';
                        $_SESSION['status'] = 'Password changed successfully';
                        header("refresh:1.5;url=profile-view.php");
                    } else {
                        $_SESSION['status_code'] = 'error';
                        $_SESSION['status'] = 'The new password does not match confirmation';
                        header("refresh:1.5;url=profile.php");
                    }
                } else {
                    $_SESSION['status_code'] = 'error';
                    $_SESSION['status'] = 'Current password is incorrect';
                    header("refresh:1.5;url=profile-view.php");
                }
            } else {
                $_SESSION['status_code'] = 'error';
                $_SESSION['status'] = 'User not found';
                header("refresh:1.5;url=profile-view.php");
            }
        } catch (Exception $e) {
            $_SESSION['status'] = 'Error changing password: ' . $e->getMessage();
            $_SESSION['status_code'] = 'error';
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    public function fetchAllUsers()
    {
        $conn = $this->db->connect();
        $data = [];

        try {
            $stmt = $conn->prepare("SELECT * FROM user");
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
       
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

    public function fetchByUsername($username)
    {
        $conn = $this->db->connect();
        $data = [];

        try {
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
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
