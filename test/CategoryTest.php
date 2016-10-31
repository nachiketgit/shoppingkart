<?php
/*
 * @Author Nachiket Kulkarni <kulkarninachiketv@gmail.com>
 * @Version 1.0
 * @Package CategoryTests
 */ 
require '../class/category.php';
class CategoryTests extends PHPUnit_Framework_TestCase{  	
    private $category;
    protected $id;
 
    protected function setUp()
    {
        $this->category = new Category();
    } 
    /**
    * @dataProvider addCategoryProvider
    */
    public function testAddCategory($arrayData)
    {
        $result = $this->category->add_category($arrayData); 
        $this->assertEquals('{"code":"10","message":"Category saved successfully."}', $result);
    }
    /**
    * @dataProvider updateCategoryProvider
    */
    public function testUpdateCategory($arrayData)
    {
        $result = $this->category->update_category($arrayData);        
        $this->assertEquals('{"code":"20","message":"Category saved successfully."}', $result);
    }
    /**
    * @dataProvider deleteCategoryProvider
    */
    public function testDeleteCategory($arrayData)
    {
        $result = $this->category->delete_category($arrayData);
        $this->assertEquals('{"code":"30","message":"Category deleted successfully."}', $result);
    }
    public function addCategoryProvider() {
        return array(
            array(array('name'=>'','tax'=>10)),
            array(array('name'=>'Kidsware','tax'=>'ff')),
            array(array('name'=>'Electronic','tax'=>10)), //Correct dataset
        );
    }
    public function updateCategoryProvider() {
        return array(
            array(array('id'=> 1,'name'=>'','tax'=>10)),
            array(array('id'=> 1,'name'=>'Kidsware','tax'=>'ff')),
            array(array('id'=> 10,'name'=>'Kidsware','tax'=>10)),
            array(array('id'=> 1,'name'=>'Electronics','tax'=>10)), //Correct dataset
        );
    }
    public function deleteCategoryProvider() {
        return array(
            array(array('id'=>'jj')),
            array(array('id'=>1)) //Correct dataset
        );
    }
} 
