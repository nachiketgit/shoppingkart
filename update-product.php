<?php
include('class/product.php');
$category = new Product(); 
$result = $category->update_product();
echo $result;