<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require_once __DIR__.'/../src/includes/functions.php';

class accountTest extends TestCase{
    
    private $mysqli = NULL;
    
    protected function setUp()
    {
        $this->mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    }
    
    
    public function testAddAccount(){
        // Query that the sending user has enough money and their account is not frozen
        
        $this->assertEquals(4, 4);
    }
    
    protected function tearDown(){
        $this->mysqli->close();
    }
    
}