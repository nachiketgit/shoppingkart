<?php
include('class/cart_product.php');
$item = new Cart_product(); 
$result = $item->get_cart_total();
echo $result;