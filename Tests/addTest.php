<?php
use PHPUnit\Framework\TestCase;

// Running phpunit in XAMPP --> phpunit C:\xampp\htdocs\COSC310-SCRUMptious-Six\Tests

require __DIR__.'/../add.php';
/*
 * class have to end with "Test.php"
 * functions have to start with "test"
 * Create document explaining testing 
 * */
 
class addTest extends TestCase{
    public function testAdd(){
        $expected=3;
        $actual=add(1,2);
        $this->assertEquals($expected,$actual);
    }
}