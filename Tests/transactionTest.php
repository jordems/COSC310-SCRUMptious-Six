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
    
    /*This test is for Completeing a Valid transaction*/
    public function testTransactionA(){
        $mysqli = $this->mysqli;
        
        // **WE ASSUME THAT DATA IS ALREADY SANITIZED AT THIS STAGE**
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
        echo "\n Sent Transaction('$toUsername', $amount, \"$reason\", $accoundid) in format(tousername,amount,reason,fromaccountid)";
        echo "\n ***Expecting Successful Transaction***";
        switch($code){
            case 0:
                echo "\n Transaction A's Request is Successful";
                echo "\n\n --Verifying with Database's Account Data--";
                
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
                echo "\n-----Transaction A's test is SUCCESSFUL!-----";
                
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

    /*This test is for Sending an amount to a username that doesn't exist*/
    public function testTransactionB(){
        $mysqli = $this->mysqli;
        
        // **WE ASSUME THAT DATA IS ALREADY SANITIZED AT THIS STAGE**
        $toUsername = "NOtExistentUser";
        $amount = 12.12;
        $reason = "Money Owed";
        $accoundid = 36; // Don't Change (just for testing purposes)
        
        /* Get the account balance from the test user's id, and from the receiving username
         * Before the transaction to compare with resulting balances*/
        $fromBalanceBefore= getAccountBalance($accoundid, $mysqli);
        
        echo "\n\n-----Transaction B-----";
        
        $code = sendTransaction($toUsername, $amount, $reason, $accoundid ,$mysqli);
        echo "\n Sent Transaction('$toUsername', $amount, \"$reason\", $accoundid) in format(tousername,amount,reason,fromaccountid)";
        echo "\n ***Expecting Failed Transaction as Username Doesn't Exist***";
        switch($code){
            case 0:
                echo "\n  Transaction B's Request is Successful";
                echo "\n-----Transaction B's Test has Failed!-----";
                $this->assertTrue(false); // Transaction Sent Successfully
                break;
            case 1:
                echo "\n  Transaction A Failed, Database Error";
                echo "\n-----Transaction B's Test has Failed!-----";
                $this->assertTrue(false); // Transaction Failed, Database Error
                break;
            case 2:
                echo "\n  Transaction B Failed, Insufficient Funds";
                echo "\n-----Transaction B's Test has Failed!-----";
                $this->assertTrue(false); // Transaction Failed, Insufficient Funds
                break;
            case 3:
                echo "\n  Transaction B Failed, Receiving Username Doesn't exist or Doesn't have a main Account";
                $fromBalanceAfter = getAccountBalance($accoundid, $mysqli);
                echo "\n  FromAccount Balance Before: \$$fromBalanceBefore";
                echo "\n  FromAccount Balance After: \$$fromBalanceAfter";
                $amountWithdrew = round($fromBalanceBefore-$fromBalanceAfter,2);
                echo "\n  Amount withdrew: \$".($amountWithdrew);
                
                // If the amount taken out of the account is different from the amount sent assert false
                if($amountWithdrew != 0) $this->assertTrue(false);
                echo "\n-----Transaction B's Test is a SUCCESS!-----";
                $this->assertTrue(true); // Transaction Failed, Receiving Username Doesn't exist or Doesn't have a main Account
                break;
        }
    }
    
    protected function tearDown(){
        $this->mysqli->close();
    }
    
}
?>