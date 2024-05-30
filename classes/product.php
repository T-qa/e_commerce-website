<?php
require_once(__DIR__ . "/../config/dbconfig.php");
class Product
{
    private $id;
    private $name;
    private $price;
    private $desc;
    private $category;
    private $brand;

    public function addProduct($name, $desc, $brand_id, $category_id, $price, $img)
    {
        $DB = new DBConnect();
        $description = str_replace("'", "\'", $desc);
        $sql = "INSERT INTO product(name, description, brand_id, category_id, price, img) VALUES ('$name','$description',$brand_id,$category_id,$price,'$img')";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Add Successfully';
            header("refresh:1.5;url=product-view.php");
        } else {
            die(mysqli_error($DB->connect()));
        }
    }

    public function addProductDetails($product_id, $display, $resolution, $ram, $memory, $cpu, $gpu, $size, $weight)
    {
        $DB = new DBConnect();
        $sql = "INSERT INTO product_details(product_id, display, resolution, RAM, memory, CPU, GPU, size, weight) VALUES ('$product_id','$display','$resolution','$ram','$memory','$cpu','$gpu','$size','$weight')";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Add Successfully';
            header("refresh:1.5;url=product-details-admin.php");
        } else {
            die(mysqli_error($DB->connect()));
        }
    }

    public function updateProductDetails($product_id, $display, $resolution, $ram, $memory, $cpu, $gpu, $size, $weight)
    {
        $DB = new DBConnect();
        $sql = "UPDATE product_details SET  display='$display', resolution='$resolution', RAM='$ram', memory='$memory', CPU ='$cpu', GPU='$gpu', size='$size', weight='$weight'WHERE product_id ='$product_id'";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            $_SESSION['status_code'] = 'success';
            $_SESSION['status'] = 'Update Successfully';
            header("refresh:1.5;url=product-details-admin.php");
        } else {
            die(mysqli_error($DB->connect()));
        }
    }
    public function updateProduct($id, $name, $desc, $brand_id, $category_id, $price, $img)
    {
        $DB = new DBConnect();
        $description = str_replace("'", "\'", $desc);
        try {
            $sql = "UPDATE product SET name='$name', description ='$description', brand_id = $brand_id, category_id = $category_id, price = $price, img = '$img' WHERE id ='$id'";
            $query = mysqli_query($DB->connect(), $sql);
            if ($query && $brand_id != '' && $category_id != '') {
                $_SESSION['status_code'] = 'success';
                $_SESSION['status'] = 'Update Successful';
                header("refresh:1.5;url=product-view.php");
            }
        } catch (Exception $ex) {
            $_SESSION['status_code'] = 'error';
            $_SESSION['status'] = 'Something is wrong. Please try again.';
        }
    }
    public function removeProduct($id)
    {
        $id = str_replace("'", "", $id);
        $DB = new DBConnect();
        $sql = "delete from product where id=$id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            header("refresh:0.5;url=product-view.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    }

    public function removeProductDetails($id)
    {
        $id = str_replace("'", "", str_replace("/", "", $id));
        $DB = new DBConnect();
        $sql = "delete from product_details where product_id=$id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            header("refresh:0.5;url=product-details-admin.php");
        } else {
            echo "<script>alert('Error')</script>";
        }
    }
    public function fetch()
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT product.id, product.name, product.description, brand.name AS brand_name, category.name AS category_name, product.price,product.img FROM product INNER JOIN brand ON product.brand_id = brand.id INNER JOIN category ON product.category_id = category.id";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function fetchByID($id)
    {
        $id = str_replace("'", "", str_replace("/", "", $id));
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT product.id, product.name, product.description, brand.name AS brand_name, 
        category.name AS category_name, product.price,product.img FROM product INNER JOIN brand ON product.brand_id = brand.id INNER JOIN category 
        ON product.category_id = category.id WHERE product.id = $id ";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function fetchRandom()
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT product.id, product.name, product.description, brand.name AS brand_name, category.name AS category_name, product.price,product.img FROM product INNER JOIN brand ON product.brand_id = brand.id INNER JOIN category ON product.category_id = category.id ORDER BY RAND()";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function fetchByCategory($category)
    {

        $DB = new DBConnect();
        $data = null;
        $category_id = mysqli_real_escape_string($DB->connect(), $category);
        $sql = "SELECT product.id AS productID, product.name, product.description, brand.name AS brand_name, category.id, category.name AS category_name, product.price,product.img FROM product INNER JOIN brand ON product.brand_id = brand.id INNER JOIN category ON product.category_id = category.id WHERE product.category_id = $category_id ORDER BY RAND() LIMIT 8";
        $result = mysqli_query($DB->connect(), $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        } else {
            return 0;
        }
    }
    public function fetchExcludedFromDetails()
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT product.id, product.name FROM product WHERE product.id NOT IN (SELECT product_id FROM product_details);";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function fetchProductDetails()
    {
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT product.id, product.name, b.display, b.resolution, b.RAM,b.memory,b.CPU,b.GPU,b.size,b.weight FROM product INNER JOIN product_details As b ON product.id = b.product_id;";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function fetchProductDetailsByID($id)
    {
        $id = str_replace("'", "", str_replace("/", "", $id));
        $DB = new DBConnect();
        $data = null;
        $sql = "SELECT product.id, product.name, b.display, b.resolution, b.RAM,b.memory,b.CPU,b.GPU,b.size,b.weight FROM product INNER JOIN product_details AS b ON product.id = b.product_id WHERE product.id =$id;";
        $result = mysqli_query($DB->connect(), $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}