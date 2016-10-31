<?php
/*
 * @Author Nachiket Kulkarni <kulkarninachiketv@gmail.com>
 * @Version 1.0
 * @Package Category
 */
require_once 'database.php';

class Category {

    function __construct() {
        // connecting to database  
        $db = new Database();
    }

    public function add_category($test = null) {
        $post = (Array) json_decode(file_get_contents("php://input"));
        if(!empty($test))
            $post = $test;
        if (is_array($post)) {
            if (empty($post['name'])) {
                $result['code'] = '1';
                $result['message'] = 'Name can not be empty.';
                return json_encode($result);
            }
            if (empty($post['tax'])) {
                $result['code'] = '2';
                $result['message'] = 'Tax should not be not empty.';
                return json_encode($result);
            }
            if (!is_float($post['tax']) && !is_int($post['tax'])) {
                $result['code'] = '3';
                $result['message'] = 'Tax should be numeric only.';
                return json_encode($result);
            }
            $query = "insert into categories(`name`,`tax`) values('" . $this->clean_input($post['name']) . "' ," . $this->clean_input($post['tax']) . ")";
            if(empty($test))
                mysql_query($query);
            $result['code'] = '10';
            $result['message'] = 'Category saved successfully.';
        } else {
            $result['code'] = '4';
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

    public function update_category($test = null) {
        $post = (Array) json_decode(file_get_contents("php://input"));
        if(!empty($test))
            $post = $test;
        if (is_array($post)) {
            if (empty($post['name'])) {
                $result['code'] = '11';
                $result['message'] = 'Name can not be empty.';
                return json_encode($result);
            }
            if (empty($post['tax'])) {
                $result['code'] = '12';
                $result['message'] = 'Tax should not be not empty.';
                return json_encode($result);
            }
            if (!is_float($post['tax']) && !is_int($post['tax'])) {
                $result['code'] = '13';
                $result['message'] = 'Tax should be numeric only.';
                return json_encode($result);
            }
            if (!is_int($post['id'])) {
                $result['code'] = '14';
                $result['message'] = 'Invalid category id.';
                return json_encode($result);
            }
            if (is_int($post['id']) && !empty($post['id'])) {
                $query = 'select * from categories where id = ' . $post['id'];
                $resultArray = mysql_query($query);
                $dataArray = mysql_fetch_assoc($resultArray);
                if (empty($dataArray['id'])) {
                    $result['code'] = '15';
                    $result['message'] = 'Category does not exist.';
                    return json_encode($result);
                }
            }
            $query = "update categories set`name` = '" . $this->clean_input($post['name']) . "',`tax` = " . $this->clean_input($post['tax']) . " where id=" . $this->clean_input($post['id']);
            if(empty($test))
                mysql_query($query);
            $result['code'] = '20';
            $result['message'] = 'Category saved successfully.';
        } else {
            $result['code'] = '16';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result);
    }

    public function delete_category($test =  null) {
        $post = (Array) json_decode(file_get_contents("php://input"));
        if(!empty($test))
            $post = $test;
        if (is_array($post)) {
            if (!is_int($post['id'])) {
                $result['code'] = '21';
                $result['message'] = 'Invalid category id.';
                return json_encode($result);
            }
            if (is_int($post['id']) && !empty($post['id'])) {
                $query = 'select * from categories where id = ' . $post['id'];
                $resultArray = mysql_query($query);
                $dataArray = mysql_fetch_assoc($resultArray);
                if (empty($dataArray['id'])) {
                    $result['code'] = '22';
                    $result['message'] = 'Category does not exist.';
                    return json_encode($result);
                }
            }
            $query = "update categories set `is_active` = 0 where id=" . $this->clean_input($post['id']);
            if(empty($test))
                mysql_query($query);
            $result['code'] = '30';
            $result['message'] = 'Category deleted successfully.';
        } else {
            $result['code'] = '23';
            $result['message'] = 'Insufficient parameters';
        }
        return json_encode($result);
    }

    public function get_all_categories() {
        $query = 'select * from categories where is_active = 1';
        $resultArray = mysql_query($query);
        while ($row = mysql_fetch_assoc($resultArray)) {
            $dataArray[] = $row;
        }
        $result['code'] = '40';
        $result['data'] = $dataArray;
        return json_encode($result);
    }

}

