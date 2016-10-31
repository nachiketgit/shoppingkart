<?php
/*
 * @Author Nachiket Kulkarni <kulkarninachiketv@gmail.com>
 * @Version 1.0
 * @Package CartTests
 */ 
require '../class/cart.php';
class CartTests extends PHPUnit_Framework_TestCase{  	
    private $cart; 
 
    protected function setUp()
    {
        $this->cart = new Cart();
    } 
    /**
    * @dataProvider createCartProvider
    */
    public function testCreateCart($arrayData)
    {
        $result = $this->cart->create_cart($arrayData);        
        $this->assertEquals('{"code":"90","message":"Cart created successfully."}', $result);
    }
    /**
    * @dataProvider deleteCartProvider
    */
    public function testDeleteCart($arrayData)
    {
        $result = $this->cart->delete_cart($arrayData);
        $this->assertEquals('{"code":"100","message":"Cart deleted successfully."}', $result);
    }
    public function createCartProvider() {
        return array(
            array(array('name'=>'')),
            array(array('name'=>'Nachiket')) //Correct dataset
        );
    }
    public function deleteCartProvider() {
        return array(
            array(array('id'=> 'gg')),
            array(array('id'=> 1))//Correct dataset
        );
    } 
} 
