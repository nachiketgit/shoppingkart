<?php
include('class/cart.php');
$cart = new Cart(); 
$result = $cart->create_cart();
echo $result;