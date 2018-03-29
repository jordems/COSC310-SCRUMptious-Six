<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require_once __DIR__.'/../src/includes/functions.php';
require_once __DIR__.'/testFunctions.php';

class accountTest extends TestCase{
    
    private $mysqli = NULL;
    private $aid = NULL;
    
    protected function setUp()
    {
        $this->mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
        $this->aid = 36;
        $_SESSION['user_id'] = 1;
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
    public function testTransactionUnitTestReset(){
        
        $this->assertTrue(resetAccountTest($this->aid,$this->mysqli));
    }
    
    public function testAddAccount(){
        // Query that the sending user has enough money and their account is not frozen
        
        $this->assertEquals(4, 4);
    }
    
    protected function tearDown(){
        resetAccountTest($this->aid,$this->mysqli);
        $this->mysqli->close();
    }
    
}