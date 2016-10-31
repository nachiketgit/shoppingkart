<?php
include('class/category.php');
$category = new Category(); 
$result = $category->delete_category();
echo $result;