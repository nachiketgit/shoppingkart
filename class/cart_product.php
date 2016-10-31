<?php
/*
 * @Author Nachiket Kulkarni <kulkarninachiketv@gmail.com>
 * @Version 1.0
 * @Package Cart_product
 */
require_once 'database.php';
class Cart_product{  
    function __construct() {   
        // connecting to database  
        $db = new Database();         
    }  
	
    public function add_cart_product($test = null){ 
    $post = (Array)json_decode(file_get_contents("php://input")); 
    if(!empty($test))
            $post = $test; 
        if(is_array($post)){
            if(empty($post['cart'])){
                $result['code'] = '101';
                $result['message'] = 'Cart id can not be empty.';
                return json_encode($result);
            } 
            if(!is_int($post['cart'])){
                $result['code'] = '102';
                $result['message'] = 'Cart id must be integer only.';
                return json_encode($result);
            }
            if(empty($post['product'])) {
                $result['code'] = '103';
                $result['message'] = 'Product id should not be not empty.';
                return json_encode($result);
            }
            if(!is_int($post['product'])) {
                $result['code'] = '104';
                $result['message'] = 'Product id should be numeric only.';
                return json_encode($result);
            }
            $query = 'select id from products where is_active = 1 and id = ' . $post['product'];
            $resultArray = mysql_query($query);
            $productArray = mysql_fetch_assoc($resultArray);
            if(empty($productArray['id'])){
                $result['code'] = '105';
                $result['message'] = 'Product does not exist.';
                return json_encode($result);
            }
            $query = 'select id from categories where is_active = 1 and id = ' . $productArray['categories_id'];
            $resultArray = mysql_query($query);
            $categoryArray = mysql_fetch_assoc($resultArray);
            if(empty($categoryArray['id'])){
                $result['code'] = '106';
                $result['message'] = 'Category does not exist.';
                return json_encode($result);
            }
            $discount = ($productArray['price'] * $productArray['discount'])/100; 
            $price = $productArray['price'] - $discount;
            $tax = ($price * $categoryArray['tax'])/100;
            $query = "insert into cart_products(`carts_id`,`products_id`,`discount`,`tax`,`price`) values(". 
                    $this->clean_input($post['cart']) .",". $this->clean_input($post['product']) .",". 
                    $discount .",". $tax .",". $price .")";
            if(empty($test))
                mysql_query($query);
            $result['code'] = '110';
            $result['message'] = 'Product saved successfully.';
        }else{
            $result['code'] = '107';
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
    public function delete_cart_product($test = null){ 
    $post = (Array)json_decode(file_get_contents("php://input")); 
    if(!empty($test))
            $post = $test;
        if(is_array($post)){                     
            if(!is_int($post['id'])){
                $result['code'] = '111';
                $result['message'] = 'Invalid product id.';
                return json_encode($result);
            }
            if(is_numeric($post['id'])&& !empty($post['id'])){
                $query = 'select id from cart_products where id = '. $post['id']; 
                $resultArray = mysql_query($query);
                $dataArray = mysql_fetch_assoc($resultArray);
                if(empty($dataArray['id'])){
                    $result['code'] = '112';
                    $result['message'] = 'Product does not exist.';
                    return json_encode($result);
                }
            }
            $query = "delete from cart_products where id=".$this->clean_input($post['id']);
            if(empty($test))
                mysql_query($query);
            $result['code'] = '120';
            $result['message'] = 'Product deleted successfully.';
        }else{
            $result['code'] = '113';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result);
    } 
    public function show_cart(){ 
    $post = (Array)json_decode(file_get_contents("php://input")); 
        if(is_array($post)){                     
            if(!is_int($post['id'])){
                $result['code'] = '121';
                $result['message'] = 'Invalid cart id.';
                return json_encode($result);
            }
            if(!empty($post['id'])){
                $query = 'select id from carts where id = '. $post['id']; 
                $resultArray = mysql_query($query);
                $cartArray = mysql_fetch_assoc($resultArray);
                if(empty($cartArray['id'])){
                    $result['code'] = '122';
                    $result['message'] = 'Cart does not exist.';
                    return json_encode($result);
                }
            }
            $total_discount = 0;
            $total_tax = 0;
            $total_price = 0; 
            $query = "select cp.discount,cp.tax,cp.price,products.name,carts.name as cartname
                from cart_products as cp " . 
                     " inner join products on cp.products_id = products.id ".
                     " inner join carts on cp.carts_id = carts.id where products.is_active = 1 and cp.carts_id = ".$this->clean_input($post['id']); 
            $resultArray = mysql_query($query);
            while($row = mysql_fetch_assoc($resultArray)) { 
                $row['price_with_tax'] = $row['price'] + $row['tax'];
                $dataArray['products'][] =  $row;
                $total_discount = $total_discount + $row['discount'];
                $total_tax = $total_tax + $row['tax'];
                $total_price = $total_price + $row['price'];
                $cartname = $row['cartname'];
            } 
            $dataArray['cart_name'] =  $cartname;
            $dataArray['grand_total'] =  $total_discount + $total_tax + $total_price;
            $dataArray['total_discount'] =  $total_discount;
            $dataArray['total_tax'] =  $total_tax;
            $dataArray['total_price_with_discount'] =  $total_price;
            $dataArray['total_price'] =  $total_price + $total_discount;
            $dataArray['total_price_with_tax'] =  $total_price + $total_tax;
            
            $result['code'] = '130';
            $result['data'] = $dataArray;
        }else{
            $result['code'] = '123';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result);
    } 
    public function get_cart_total(){ 
    $post = (Array)json_decode(file_get_contents("php://input")); 
        if(is_array($post)){                     
            if(!is_int($post['id'])){
                $result['code'] = '131';
                $result['message'] = 'Invalid cart id.';
                return json_encode($result);
            }
            if(!empty($post['id'])){
                $query = 'select id from carts where id = '. $post['id']; 
                $resultArray = mysql_query($query);
                $cartArray = mysql_fetch_assoc($resultArray);
                if(empty($cartArray['id'])){
                    $result['code'] = '132';
                    $result['message'] = 'Cart does not exist.';
                    return json_encode($result);
                }
            } 
            $query = "select sum(cp.discount + cp.tax + cp.price) as total from cart_products as cp where cp.carts_id = ".$this->clean_input($post['id']); 
            $resultArray = mysql_query($query);
            while ($row = mysql_fetch_assoc($resultArray)) {
                $dataArray['total'] = $row['total'];
            }
            $result['code'] = '140';
            $result['data'] = $dataArray;
        }else{
            $result['code'] = '133';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result);
    } 
    public function get_total_discount(){ 
    $post = (Array)json_decode(file_get_contents("php://input")); 
        if(is_array($post)){                     
            if(!is_int($post['id'])){
                $result['code'] = '141';
                $result['message'] = 'Invalid cart id.';
                return json_encode($result);
            }
            if(!empty($post['id'])){
                $query = 'select id from carts where id = '. $post['id']; 
                $resultArray = mysql_query($query);
                $cartArray = mysql_fetch_assoc($resultArray);
                if(empty($cartArray['id'])){
                    $result['code'] = '142';
                    $result['message'] = 'Cart does not exist.';
                    return json_encode($result);
                }
            } 
            $query = "select sum(cp.discount) as total from cart_products as cp where cp.carts_id = ".$this->clean_input($post['id']); 
            $resultArray = mysql_query($query);
            while ($row = mysql_fetch_assoc($resultArray)) {
                $dataArray['total'] = round($row['total'],2);
            }
            $result['code'] = '150';
            $result['data'] = $dataArray;
        }else{
            $result['code'] = '143';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result);
    } 
    public function get_total_tax(){ 
    $post = (Array)json_decode(file_get_contents("php://input")); 
        if(is_array($post)){                     
            if(!is_int($post['id'])){
                $result['code'] = '151';
                $result['message'] = 'Invalid cart id.';
                return json_encode($result);
            }
            if(!empty($post['id'])){
                $query = 'select id from carts where id = '. $post['id']; 
                $resultArray = mysql_query($query);
                $cartArray = mysql_fetch_assoc($resultArray);
                if(empty($cartArray['id'])){
                    $result['code'] = '152';
                    $result['message'] = 'Cart does not exist.';
                    return json_encode($result);
                }
            } 
            $query = "select sum(cp.tax) as total from cart_products as cp where cp.carts_id = ".$this->clean_input($post['id']); 
            $resultArray = mysql_query($query);
            while ($row = mysql_fetch_assoc($resultArray)) {
                $dataArray['total'] = round($row['total'],2);
            }
            $result['code'] = '160';
            $result['data'] = $dataArray;
        }else{
            $result['code'] = '153';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result);
    } 
} 
