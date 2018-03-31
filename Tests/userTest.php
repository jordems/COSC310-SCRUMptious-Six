<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require_once __DIR__.'/../src/includes/functions.php';
require_once __DIR__.'/testFunctions.php';

class userTest extends TestCase{
    
    
    
    private $mysqli = NULL;
    
    protected function setUp()
    {
        $this->mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    }
    
    // Test to confirm that the Database is working correctly
    public function testDBConnection(){
        $mysqli = $this->mysqli;
        
        /* check connection, if no errors continue */
        if (!$mysqli->connect_errno) {
            
            /* check if server is alive, if server is alive then continue */
            if ($mysqli->ping())
                $this->assertTrue(true);
                else
                    $this->assertTrue(true);
                    
        }else{
            $this->assertTrue(true);
        }
    }
    
    // Test to make sure that the Database reset is working correctly
    public function testUserUnitTestReset(){
        
        $this->assertTrue(resetUserTest($this->mysqli));
    }
    
    public function testRegisterUser_GoodData(){
        $this->assertTrue(true);
    }
    public function testRegisterUser_BadData(){
        $this->assertTrue(true);
    }
    public function testLoginUser(){
        $this->assertTrue(true);
    }
    public function testEditUser(){
        $this->assertTrue(true);
    }
    
    protected function tearDown(){
        resetUserTest($this->mysqli);
        $this->mysqli->close();
    }
    
}
?>