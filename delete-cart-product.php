<?php
include('class/cart_product.php');
$item = new Cart_product(); 
$result = $item->delete_cart_product();
echo $result;