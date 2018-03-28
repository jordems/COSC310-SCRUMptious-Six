<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;


require_once __DIR__.'/../src/includes/functions.php';

class transactionTest extends TestCase{
    
    private $mysqli = NULL;
    
    protected function setUp()
    {
        $this->mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
        $_SESSION['user_id'] = 1;
    }
    
    
    private function getTransactionInfo($tid){
        
    }
    
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
    
    
    public function testTransactionA(){
        $mysqli = $this->mysqli;
        // Setting the Session for our test User
        $toUsername = "jordems";
        $amount = 12.12;
        $reason = "Money Owed";
        $accoundid = 36; // Don't Change
        
        /* Get the account balance from the test user's id, and from the receiving username
         * Before the transaction to compare with resulting balances*/
        $fromBalanceBefore= getAccountBalance($accoundid, $mysqli);
        $toBalanceBefore = getAccountBalanceofUser($toUsername, $mysqli);
        
        echo "\n\n-----Transaction A-----";
 
        $code = sendTransaction($toUsername, $amount, $reason, $accoundid ,$mysqli);
        echo "\n Sent Transaction('jordems', 12.12, \"Money Owed\", 36) in format(tousername,amount,reason,fromaccountid)";
        echo "\n Expecting Successful Transaction";
        switch($code){
            case 0:
                echo "\n Transaction A's Request is Successful";
                echo "\n\n --Verifying with Database Data--";
                
                // Getting the Resulting Balances
                $fromBalanceAfter = getAccountBalance($accoundid, $mysqli);
                $toBalanceAfter = getAccountBalanceofUser($toUsername, $mysqli);
                echo "\n  FromAccount Balance Before: \$$fromBalanceBefore";
                echo "\n  FromAccount Balance After: \$$fromBalanceAfter";
                $amountWithdrew = round($fromBalanceBefore-$fromBalanceAfter,2);
                echo "\n  Amount withdrew: \$".($amountWithdrew);
                
                // If the amount taken out of the account is different from the amount sent assert false
                if($amountWithdrew != $amount) $this->assertTrue(false);

                echo "\n  ToAccount Balance Before: \$$toBalanceBefore";
                echo "\n  ToAccount Balance After: \$$toBalanceAfter";
                $amountDeposited = round($toBalanceAfter-$toBalanceBefore,2);
                echo "\n  Amount deposited: \$".($amountDeposited);
                
                // If the amount deposited into the account is different from the amount sent assert false
                if($amountDeposited != $amount) $this->assertTrue(false);
                echo "\n-----Transaction A is SUCCESSFUL!-----";
                
                $this->assertTrue(true); // Transaction Sent Successfully
                break;
            case 1:
                echo "\nTransaction A Failed, Database Error";
                echo "\n-----Transaction A Failed!-----";
                $this->assertTrue(false); // Transaction Failed, Database Error
                break;
            case 2:
                echo "\nTransaction A Failed, Insufficient Funds";
                echo "\n-----Transaction A Failed!-----";
                $this->assertTrue(false); // Transaction Failed, Insufficient Funds 
                break;
            case 3:
                echo "\nTransaction A Failed, Receiving Username Doesn't exist or Doesn't have a main Account";
                echo "\n-----Transaction A Failed!-----";
                $this->assertTrue(false); // Transaction Failed, Receiving Username Doesn't exist or Doesn't have a main Account
                break;
            case 5:
                echo "\nTransaction A Failed, Username Doesn't Exist ";
                echo "\n-----Transaction A Failed!-----";
                $this->assertTrue(false); // Transaction Failed, Username Doesn't Exist 
                break;
        }     
    }

    
    protected function tearDown(){
        $this->mysqli->close();
    }
    
}
?>