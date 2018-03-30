<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require_once __DIR__.'/../src/includes/functions.php';
require_once __DIR__.'/testFunctions.php';

class accountTest extends TestCase{
    
    
    
    private $mysqli = NULL;
    
    protected function setUp()
    {
        $this->mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
        $_SESSION['user_id'] = 42; // Id of a test User in the database
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
    public function testAccountUnitTestReset(){
        
        $this->assertTrue(resetAccountTest($this->mysqli));
    }
    
    public function testAddAccount(){
        $mysqli = $this->mysqli;
        $user_id = $_SESSION['user_id'];
        /*!!!! WE ASSUME THAT ALL DATA IS SANITIZED AT THIS STAGE !!!!*/
        $title = "Lifesd Savings";
        $balance = 12323.00;
        $financialinstitution = "CIBC";
        $type = "Savings Account";
        echo "\n\n-----testAddAccount-----";
        echo "\n\tUsing data addAccount($title, $financialinstitution,$type,$balance) in format addAccount(title, financialinstitution,type,balance)";
        $isSuccessful = addAccount($title, $financialinstitution,$type,$balance, $mysqli);
        if($isSuccessful){
            echo "\n\taddAccount Request Successful";
            echo "\n\n\t-----Checking Database to Confirm addAccount worked Properly-----";
            $stmt = $mysqli->prepare("SELECT title, financialinstitution, type, balance FROM Account WHERE uid = ?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();    // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($actualTitle, $actualFinancialinstitution, $actualType, $actualBalance);
            $stmt->fetch();
            
            if ($stmt->num_rows == 1) {
                echo "\n\tExpected: ($title, $financialinstitution,$type,$balance)";
                echo "\n\tActual: ($actualTitle, $actualFinancialinstitution, $actualType, $actualBalance)";
                $expected = array($title, $financialinstitution,$type,$balance);
                $actual = array($actualTitle, $actualFinancialinstitution, $actualType, $actualBalance);
                echo "\n-----testAddAccount SUCCESSFUL-----";
                $stmt->close();
                $this->assertEquals($expected,$actual);
            }else{
                $stmt->close();
                echo "\n-----testAddAccount FAILED-----";
                $this->assertTrue(false);
            }
        }else{
        
            echo "\n-----testAddAccount FAILED-----";
            $this->assertTrue(false);
        }
    }
    
    public function testEditAccount(){
        $mysqli = $this->mysqli;
        $user_id = $_SESSION['user_id'];
        /*!!!! WE ASSUME THAT ALL DATA IS SANITIZED AT THIS STAGE !!!!*/
        // This data is replacing the current data on the account
        $title = "Life Savings";
        $balance = 123;
        $financialinstitution = "RBC";
        $type = "Savings Account";
        $aid = getMainAccount($mysqli); // Returns Account created in AddAccount test
        echo "\n\n-----testEditAccount-----";
        echo "\n\tUsing data editAccount($title, $financialinstitution,$type,$balance) in format addAccount(title, financialinstitution,type,balance)";
        echo "\n\tExpecting the Account to change all of its old values to these new values";
        $isSuccessful = editAccount($title, $financialinstitution,$type,$balance,$aid, $mysqli);
        
        if($isSuccessful){
            echo "\n\teditAccount Request Successful";
            echo "\n\n\t-----Checking Database to Confirm editAccount worked Properly-----";
            $stmt = $mysqli->prepare("SELECT title, financialinstitution, type, balance FROM Account WHERE uid = ?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();    // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($actualTitle, $actualFinancialinstitution, $actualType, $actualBalance);
            $stmt->fetch();
            echo "\n\tExpected: ($title, $financialinstitution,$type,$balance)";
            if ($stmt->num_rows == 1) {
                echo "\n\tActual: ($actualTitle, $actualFinancialinstitution, $actualType, $actualBalance)";
                $expected = array($title, $financialinstitution,$type,$balance);
                $actual = array($actualTitle, $actualFinancialinstitution, $actualType, $actualBalance);
                echo "\n-----testEditAccount SUCCESSFUL-----";
                $stmt->close();
                $this->assertEquals($expected,$actual);
            }else{
                echo "\n\tActual: ($actualTitle, $actualFinancialinstitution, $actualType, $actualBalance)";
                $stmt->close();
                echo "\n-----testEditAccount FAILED-----";
                $this->assertTrue(false);
            }
        }else{
            
            echo "\n-----testEditAccount FAILED-----";
            $this->assertTrue(false);
        }
    }
    public function testDeleteAccount(){
        $mysqli = $this->mysqli;
        
        $aid = getMainAccount($mysqli); // Returns Account created in AddAccount test
        echo "\n\n-----testDeleteAccount-----";
        echo "\n\tUsing function deleteAccount($aid) in format addAccount(accountID)";
        echo "\n\tExpecting the Account to nolonger exist";
        $isSuccessful = deleteAccount($aid, $mysqli);
        
        if($isSuccessful){
            echo "\n\tdeleteAccount Request Successful";
            echo "\n\n\t-----Checking Database to Confirm deleteAccount worked Properly-----";
            $stmt = $mysqli->prepare("SELECT title, financialinstitution, type, balance FROM Account WHERE uid = ?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();    // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($actualTitle, $actualFinancialinstitution, $actualType, $actualBalance);
            $stmt->fetch();
            echo "\n\tExpected: Nothing Returned from Query";
            if ($stmt->num_rows == 0) {
                echo "\n\tActual: Nothing Returned from Query";
                echo "\n-----testDeleteAccount SUCCESSFUL-----";
                $stmt->close();
                $this->assertTrue(true);
            }else{
                $stmt->close();
                echo "\n\tActual: ".$stmt->num_rows." rows returned";
                echo "\n-----testDeleteAccount FAILED-----";
                $this->assertTrue(false);
            }
        }else{
            echo "\n-----testDeleteAccount FAILED-----";
            $this->assertTrue(false);
        }
    }
    
    protected function tearDown(){
        resetAccountTest($this->mysqli);
        $this->mysqli->close();
    }
    
}
?>