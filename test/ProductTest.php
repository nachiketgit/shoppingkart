<?php 
/*
 * @Author Nachiket Kulkarni <kulkarninachiketv@gmail.com>
 * @Version 1.0
 * @Package ProductTests
 */ 
require '../class/product.php';
class ProductTests extends PHPUnit_Framework_TestCase{ 
	
    private $product; 
    protected function setUp()
    {
        $this->product = new Product();
    } 
    /**
    * @dataProvider addProductProvider
    */
    public function testAddProduct($dataArray)
    {
        $result = $this->product->add_product($dataArray);
        $this->assertEquals('{"code":"50","message":"Product saved successfully."}', $result);
    }
    /**
    * @dataProvider updateProductProvider
    */
    public function testUpdateProduct($dataArray)
    {
        $result = $this->product->update_product($dataArray);
        $this->assertEquals('{"code":"60","message":"Product saved successfully."}', $result);
    }
    /**
    * @dataProvider deleteProductProvider
    */
    public function testDeleteProduct($dataArray)
    {
        $result = $this->product->delete_product($dataArray);
        $this->assertEquals('{"code":"70","message":"Product deleted successfully."}', $result);
    }
    public function addProductProvider() {
        return array(
            array(array('category'=>1,'name'=>'LG TV','description'=>'Latest hd tv','discount'=>5,'price'=>'ff')),
            array(array('category'=>'ff','name'=>'LG TV','description'=>'Latest hd tv','discount'=>5,'price'=>10000)),
            array(array('category'=>1,'name'=>'','description'=>'Latest hd tv','discount'=>5,'price'=>10000)),
            array(array('category'=>1,'name'=>'LG TV','description'=>'','discount'=>5,'price'=>10000)),
            array(array('category'=>1,'name'=>'LG TV','description'=>'Latest hd tv','discount'=>'dd','price'=>10000)),
            array(array('category'=>1,'name'=>'LG TV','description'=>'Latest hd tv','discount'=>5,'price'=>10000)) //Correct dataset
        );
    }
    public function updateProductProvider() {
        return array(
            array(array('id'=> 1,'category'=>1,'name'=>'LG TV','description'=>'Latest hd tv','discount'=>5,'price'=>'ff')),
            array(array('id'=> 1,'category'=>'dd','name'=>'LG TV','description'=>'Latest hd tv','discount'=>5,'price'=>10000)),
            array(array('id'=> 1,'category'=>1,'name'=>'','description'=>'Latest hd tv','discount'=>5,'price'=>10000)),
            array(array('id'=> 1,'category'=>1,'name'=>'LG TV','description'=>'','discount'=>5,'price'=>10000)),
            array(array('id'=> 1,'category'=>1,'name'=>'LG TV','description'=>'Latest hd tv','discount'=>'dd','price'=>10000)),
            array(array('id'=> 10,'category'=>1,'name'=>'LG TV','description'=>'Latest hd tv','discount'=>5,'price'=>10000)),
            array(array('id'=> 1,'category'=>1,'name'=>'LG TV','description'=>'Latest hd tv','discount'=>5,'price'=>10000)) //Correct dataset
        );
    }
    public function deleteProductProvider() {
        return array(
            array(array('id'=>'jj')),
            array(array('id'=>1)) //Correct dataset
        );
    }
} 
