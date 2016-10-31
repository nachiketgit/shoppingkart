<?php
include('class/category.php');
$category = new Category(); 
$result = $category->get_all_categories();
echo $result;