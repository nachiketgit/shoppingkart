<?php
/*
 * @Author Nachiket Kulkarni <kulkarninachiketv@gmail.com>
 * @Version 1.0
 * @Package Product
 */
require_once 'database.php';
class Product{  
    function __construct() {   
        // connecting to database  
        $db = new Database();         
    }  
	
    public function add_product($test = null){ 
     $post = (Array)json_decode(file_get_contents("php://input"));
     if(!empty($test))
        $post = $test;
        if(is_array($post)){
            if(empty($post['name'])){
                $result['code'] = '41';
                $result['message'] = 'Product name can not be empty.';
                return json_encode($result);
            }
            if(empty($post['description'])){
                $result['code'] = '42';
                $result['message'] = 'Description can not be not empty.';
                return json_encode($result);
            } 
            if(!empty($post['discount'])&&!is_float($post['discount'])&&!is_int($post['discount'])){
                $result['code'] = '43';
                $result['message'] = 'Descount must be numeric only.';
                return json_encode($result);
            }
            if(empty($post['category'])){
                $result['code'] = '44';
                $result['message'] = 'Category can not be empty.';
                return json_encode($result);
            } 
            if(!is_int($post['category'])){
                $result['code'] = '45';
                $result['message'] = 'Category must be integer only.';
                return json_encode($result);
            } 
            if(empty($post['price'])){
                $result['code'] = '46';
                $result['message'] = 'Price can not be empty.';
                return json_encode($result);
            } 
            if(!is_int($post['price'])){
                $result['code'] = '47';
                $result['message'] = 'Price must be integer only.';
                return json_encode($result);
            } 
            $discount = empty($this->clean_input($post['discount'])) ? 0 : $this->clean_input($post['discount']);
            $query = "insert into products(`categories_id`,`name`,`description`,`discount`) values(". 
                    $this->clean_input($post['category']) .",'". $this->clean_input($post['name']) ."','". 
                    $this->clean_input($post['description']) ."',". $discount . "," . $this->clean_input($post['price']) .")";
            if(empty($test))
                mysql_query($query);
            $result['code'] = '50';
            $result['message'] = 'Product saved successfully.';
        }else{
            $result['code'] = '48';
            $result['message'] = 'Insufficient parameters';
        }
            return json_encode($result);
    } 
    public function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = mysql_real_escape_string($data);
        return $data;
     }
    public function update_product($test = null){ 
     $post = (Array)json_decode(file_get_contents("php://input")); 
     if(!empty($test))
        $post = $test;
        if(is_array($post)){
            if(empty($post['name'])){
                $result['code'] = '51';
                $result['message'] = 'Product name can not be empty.';
                return json_encode($result);
            }
            if(empty($post['description'])){
                $result['code'] = '52';
                $result['message'] = 'Description can not be not empty.';
                return json_encode($result);
            } 
            if(!empty($post['discount'])&&!is_float($post['discount'])&&!is_int($post['discount'])){
                $result['code'] = '53';
                $result['message'] = 'Descount must be numeric only.';
                return json_encode($result);
            }
            if(empty($post['category'])){
                $result['code'] = '54';
                $result['message'] = 'Category can not be empty.';
                return json_encode($result);
            } 
            if(!is_int($post['category'])){
                $result['code'] = '55';
                $result['message'] = 'Category must be integer only.';
                return json_encode($result);
            }
            if(empty($post['price'])){
                $result['code'] = '56';
                $result['message'] = 'Price can not be empty.';
                return json_encode($result);
            } 
            if(!is_int($post['price'])){
                $result['code'] = '57';
                $result['message'] = 'Price must be integer only.';
                return json_encode($result);
            }
            if(is_numeric($post['id'])&& !empty($post['id'])){
                $query = 'select id from products where id = '. $post['id']; 
                $resultArray = mysql_query($query);
                $dataArray = mysql_fetch_assoc($resultArray);
                if(empty($dataArray['id'])){
                    $result['code'] = '58';
                    $result['message'] = 'Product does not exist.';
                    return json_encode($result);
                }
            }
            
            $discount = empty($this->clean_input($post['discount'])) ? 0 : $this->clean_input($post['discount']);
            $query = "update products set `categories_id` = ".$this->clean_input($post['category']) .
                    ",`name` = '".$this->clean_input($post['name']) ."',`description` = '" . $this->clean_input($post['description']) .
                    "',`discount` = ". $discount ." where id=".$this->clean_input($post['id']);
            if(empty($test))
                mysql_query($query);
            $result['code'] = '60';
            $result['message'] = 'Product saved successfully.';
        }else{
            $result['code'] = '59';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result);
    } 
    public function delete_product($test = null){ 
     $post = (Array)json_decode(file_get_contents("php://input"));
     if(!empty($test))
        $post = $test;
        if(is_array($post)){                     
            if(!is_numeric($post['id'])){
                $result['code'] = '61';
                $result['message'] = 'Invalid product id.';
                return json_encode($result);
            }
            if(is_numeric($post['id'])&& !empty($post['id'])){
                $query = 'select * from products where id = '. $post['id']; 
                $resultArray = mysql_query($query);
                $dataArray = mysql_fetch_assoc($resultArray);
                if(empty($dataArray['id'])){
                    $result['code'] = '62';
                    $result['message'] = 'Product does not exist.';
                    return json_encode($result);
                }
            }
            $query = "update products set `is_active` = 0 where id=" . $this->clean_input($post['id']);
            if(empty($test))
                mysql_query($query);
            $result['code'] = '70';
            $result['message'] = 'Product deleted successfully.';
        }else{
            $result['code'] = '63';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result);
    } 
    public function get_all_products(){ 
        $query = 'select * from products'; 
        $resultArray = mysql_query($query); 
        while($row = mysql_fetch_assoc($resultArray)) {
            $dataArray[] =  $row;           
        }
        $result['code'] = '80';
        $result['data'] = $dataArray;
        return json_encode($result);
    } 
} 
