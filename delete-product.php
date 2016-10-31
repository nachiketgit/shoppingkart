<?php
include('class/product.php');
$category = new Product(); 
$result = $category->delete_product();
echo $result;