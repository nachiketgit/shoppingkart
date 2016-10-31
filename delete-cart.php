<?php
include('class/cart.php');
$cart = new Cart(); 
$result = $cart->delete_cart();
echo $result;