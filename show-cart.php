<?php
include('class/cart_product.php');
$item = new Cart_product(); 
$result = $item->show_cart();
echo $result;