<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new DBConnect();
    }

    public function addProduct($name, $desc, $brand_id, $category_id, $price, $img)
    {
        $description = $this->db->connect()->real_escape_string($desc);
        $sql = "INSERT INTO product(name, description, brand_id, category_id, price, img) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("ssiiis", $name, $description, $brand_id, $category_id, $price, $img);

        if ($stmt->execute()) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Add Successfully';
            header("refresh:1.5;url=product-view.php");
        } else {
            die($stmt->error);
        }

        $stmt->close();
    }

    public function updateProduct($id, $name, $desc, $brand_id, $category_id, $price, $img)
    {
        $description = $this->db->connect()->real_escape_string($desc);
        $sql = "UPDATE product SET name=?, description=?, brand_id=?, category_id=?, price=?, img=? WHERE id=?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("ssiiisi", $name, $description, $brand_id, $category_id, $price, $img, $id);

        if ($stmt->execute()) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successful';
            header("refresh:1.5;url=product-view.php");
        } else {
            $_SESSION['status_code'] = 'error';
            $_SESSION['status'] = 'Something is wrong. Please try again.';
        }

        $stmt->close();
    }

    public function removeProduct($id)
    {
        $id = $this->db->connect()->real_escape_string($id);
        $sql = "DELETE FROM product WHERE id=?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("refresh:0.5;url=product-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }

        $stmt->close();
    }


    public function addProductDetails($product_id, $display, $resolution, $ram, $memory, $cpu, $gpu, $size, $weight)
    {
        $sql = "INSERT INTO product_details(product_id, display, resolution, RAM, memory, CPU, GPU, size, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("issssssss", $product_id, $display, $resolution, $ram, $memory, $cpu, $gpu, $size, $weight);

        if ($stmt->execute()) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Add Successfully';
            header("refresh:1.5;url=product-details-admin.php");
        } else {
            die($stmt->error);
        }

        $stmt->close();
    }

    public function updateProductDetails($product_id, $display, $resolution, $ram, $memory, $cpu, $gpu, $size, $weight)
    {
        $sql = "UPDATE product_details SET display=?, resolution=?, RAM=?, memory=?, CPU=?, GPU=?, size=?, weight=? WHERE product_id=?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("ssssssssi", $display, $resolution, $ram, $memory, $cpu, $gpu, $size, $weight, $product_id);

        if ($stmt->execute()) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successfully';
            header("refresh:1.5;url=product-details-admin.php");
        } else {
            die($stmt->error);
        }

        $stmt->close();
    }

    public function removeProductDetails($id)
    {
        $id = $this->db->connect()->real_escape_string($id);
        $sql = "DELETE FROM product_details WHERE product_id=?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("refresh:0.5;url=product-details-admin.php");
        } else {
            echo "<script>alert('Error')</script>";
        }

        $stmt->close();
    }
    
    public function fetch()
    {
        $data = null;
        $sql = "SELECT product.id, product.name, product.description, brand.name AS brand_name, category.name AS category_name, product.price, product.img FROM product INNER JOIN brand ON product.brand_id = brand.id INNER JOIN category ON product.category_id = category.id";
        $result = $this->db->connect()->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function fetchByID($id)
    {
        $id = $this->db->connect()->real_escape_string($id);
        $data = null;
        $sql = "SELECT product.id, product.name, product.description, brand.name 
        AS brand_name, category.name 
        AS category_name, product.price, product.img 
        FROM product INNER JOIN brand ON product.brand_id = brand.id 
        INNER JOIN category ON product.category_id = category.id 
        WHERE product.id=?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $stmt->close();
        return $data;
    }

    public function fetchRandom()
    {
        $data = null;
        $sql = "SELECT product.id, product.name, product.description, brand.name AS brand_name, category.name AS category_name, product.price, product.img FROM product INNER JOIN brand ON product.brand_id = brand.id INNER JOIN category ON product.category_id = category.id ORDER BY RAND()";
        $result = $this->db->connect()->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function fetchByCategory($category)
    {
        $data = null;
        $category_id = $this->db->connect()->real_escape_string($category);
        $sql = "SELECT product.id AS productID, product.name, product.description, brand.name AS brand_name, category.id, category.name AS category_name, product.price, product.img FROM product INNER JOIN brand ON product.brand_id = brand.id INNER JOIN category ON product.category_id = category.id WHERE product.category_id=? ORDER BY RAND() LIMIT 8";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            return 0;
        }

        $stmt->close();
        return $data;
    }

    public function fetchExcludedFromDetails()
    {
        $data = null;
        $sql = "SELECT product.id, product.name FROM product WHERE product.id NOT IN (SELECT product_id FROM product_details)";
        $result = $this->db->connect()->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function fetchProductDetails()
    {
        $data = null;
        $sql = "SELECT product.id, product.name, b.display, b.resolution, b.RAM, b.memory, b.CPU, b.GPU, b.size, b.weight FROM product INNER JOIN product_details AS b ON product.id = b.product_id";
        $result = $this->db->connect()->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function fetchProductDetailsByID($id)
    {
        $id = $this->db->connect()->real_escape_string($id);
        $data = [];
        $sql = "SELECT product.id, product.name, product.description, brand.name AS brand_name, category.name AS category_name, product.price, product.img, product_details.display, product_details.resolution, product_details.RAM, product_details.memory, product_details.CPU, product_details.GPU, product_details.size, product_details.weight 
                FROM product 
                INNER JOIN brand ON product.brand_id = brand.id 
                INNER JOIN category ON product.category_id = category.id 
                INNER JOIN product_details ON product.id = product_details.product_id 
                WHERE product.id=?";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
    
        $stmt->close();
        return $data;
    }
      
    
}