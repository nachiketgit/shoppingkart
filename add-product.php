<?php
include('class/product.php');
$category = new Product(); 
$result = $category->add_product();
echo $result;