<?php
/*
 * @Author Nachiket Kulkarni <kulkarninachiketv@gmail.com>
 * @Version 1.0
 * @Package Cart
 */
require_once 'database.php';

class Cart {

    function __construct() {
        // connecting to database  
        $db = new Database();
    }
    public function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = mysql_real_escape_string($data);
        return $data;
     }
    public function create_cart($test = null) {
        $post = (Array) json_decode(file_get_contents("php://input"));
        if(!empty($test))
            $post = $test;
        if (is_array($post)) {
            if (empty($post['name'])) {
                $result['code'] = '81';
                $result['message'] = 'Cart name can not be empty.';
                return json_encode($result);
            }
            $query = "insert into carts(`name`) values('" . $this->clean_input($post['name']) . "')";
            if(empty($test))
                mysql_query($query);
            $result['code'] = '90';
            $result['message'] = 'Cart created successfully.';
        } else {
            $result['code'] = '82';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result); 
    }
    public function delete_cart($test = null) {
       $post = (Array)json_decode(file_get_contents("php://input")); 
       if(!empty($test))
            $post = $test;
        if(is_array($post)){                     
            if(!is_int($post['id'])){
                $result['code'] = '91';
                $result['message'] = 'Invalid cart id.';
                return json_encode($result);
            }
            if(is_numeric($post['id'])&& !empty($post['id'])){
                $query = 'select id from carts where id = '. $post['id']; 
                $resultArray = mysql_query($query);
                $dataArray = mysql_fetch_assoc($resultArray);
                if(empty($dataArray['id'])){
                    $result['code'] = '92';
                    $result['message'] = 'Cart does not exist.';
                    return json_encode($result);
                }
            }
            $query = "delete from cart_products where carts_id=".$this->clean_input($post['id']);
            if(empty($test))
                mysql_query($query);
            $query = "delete from carts where id=".$this->clean_input($post['id']);
            if(empty($test))
                mysql_query($query);
            $result['code'] = '100';
            $result['message'] = 'Cart deleted successfully.';
        }else{
            $result['code'] = '93';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result);
    }

}

