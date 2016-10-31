<?php
include('class/category.php');
$category = new Category(); 
$result = $category->add_category();
echo $result;