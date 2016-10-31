<?php
/*
 * @Author Nachiket Kulkarni <kulkarninachiketv@gmail.com>
 * @Version 1.0
 * @Package CartProductTests
 */ 
require '../class/cart_product.php';
class CartProductTests extends PHPUnit_Framework_TestCase{  	
    private $cart; 
 
    protected function setUp()
    {
        $this->cart = new Cart_product();
    } 
    /**
    * @dataProvider createAddCartProductProvider
    */
    public function testAddCartProduct($arrayData)
    {
        $result = $this->cart->add_cart_product($arrayData);        
        $this->assertEquals('{"code":"110","message":"Product saved successfully."}', $result);
    }
    /**
    * @dataProvider deleteCartProductProvider
    */
    public function testDeleteCartProduct($arrayData)
    {
        $result = $this->cart->delete_cart_product($arrayData);
        $this->assertEquals('{"code":"120","message":"Product deleted successfully."}', $result);
    }
    public function createAddCartProductProvider() {
        return array(
            array(array('cart'=>'','product'=>1)),
            array(array('cart'=>1,'product'=>'')),
            array(array('cart'=>1,'product'=>1)) //Correct dataset
        );
    }
    public function deleteCartProductProvider() {
        return array(
            array(array('id'=> 'gg')),
            array(array('id'=> 1))//Correct dataset
        );
    } 
} 
