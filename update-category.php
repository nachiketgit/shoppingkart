<?php
include('class/category.php');
$category = new Category(); 
$result = $category->update_category();
echo $result;