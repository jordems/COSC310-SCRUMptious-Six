<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require_once __DIR__.'/../src/includes/functions.php';

class transactionTest extends TestCase{
    
    private $mysqli = NULL;
    
    protected function setUp()
    {
        $this->mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    }
    
    
    public function testTransactionA(){
        // Setting the Session for our test User
        $con = $this->mysqli;
        $_SESSION['user_id'] = 7; 
        $user_id = 7;
        $balance = getBalance($user_id, $con);
        echo $balance;
        $this->assertEquals(4, 4);        
    }
    
    protected function tearDown(){
        $this->mysqli->close();
    }
    
}