<?php
include('class/product.php');
$category = new Product(); 
$result = $category->get_all_products();
echo $result;