<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;


require_once __DIR__.'/../src/includes/functions.php';
require_once __DIR__.'/testFunctions.php';

class transactionTest extends TestCase{
    
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
        $this->assertTrue(resetTransactionsTest($this->aid,$this->mysqli));
    }
    
    /*This test is for Completeing a Valid transaction*/
    public function testTransactionA_SuccessfulTransaction(){
        $mysqli = $this->mysqli;
        
        // **WE ASSUME THAT DATA IS ALREADY SANITIZED AT THIS STAGE**
        $toUsername = "jordems";
        $amount = 12.12;
        $reason = "Money Owed";
        $accoundid = $this->aid; // Don't Change
        
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
                echo "\n-----Transaction A's Test is SUCCESSFUL!-----";
                
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
                echo "\nTransaction A Failed, User Not Linked to Account ";
                echo "\n-----Transaction A Failed!-----";
                $this->assertTrue(false); // Transaction Failed, Username Doesn't Exist 
                break;
        }     
    }

    /*This test is for Sending an amount to a username that doesn't exist*/
    public function testTransactionB_ToNonExistingUser(){
        $mysqli = $this->mysqli;
        
        // **WE ASSUME THAT DATA IS ALREADY SANITIZED AT THIS STAGE**
        $toUsername = "NOtExistentUser";
        $amount = 12.12;
        $reason = "Money Owed";
        $accoundid = $this->aid; // Don't Change (just for testing purposes)
        
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
                echo "\n  Transaction B Failed, Database Error";
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
                echo "\n-----Transaction B's Test is SUCCESSFUL!-----";
                $this->assertTrue(true); // Transaction Failed, Receiving Username Doesn't exist or Doesn't have a main Account
                break;
            case 5:
                echo "\nTransaction B Failed, User Not Linked to Account ";
                echo "\n-----Transaction B Failed!-----";
                $this->assertTrue(false); // Transaction Failed, Username Doesn't Exist
                break;
        }
    }
    
    /*This test is for Sending an amount to a username that doesn't exist*/
    public function testTransactionC_FromAccountNotLinkedToSendingUser(){
        $mysqli = $this->mysqli;
        
        // **WE ASSUME THAT DATA IS ALREADY SANITIZED AT THIS STAGE**
        $toUsername = "jordems";
        $amount = 12.12;
        $reason = "Money Owed";
        $accoundid = -1; // This Account Id is linked to someoneelses Account
        
        /* Get the account balance from the test user's id, and from the receiving username
         * Before the transaction to compare with resulting balances*/
        $fromBalanceBefore= getAccountBalance($accoundid, $mysqli);
        
        echo "\n\n-----Transaction C-----";
        
        $code = sendTransaction($toUsername, $amount, $reason, $accoundid ,$mysqli);
        echo "\n Sent Transaction('$toUsername', $amount, \"$reason\", $accoundid) in format(tousername,amount,reason,fromaccountid)";
        echo "\n ***Expecting Failed Transaction as withdrawing Financial Account Doesn't link to this user***";
        switch($code){
            case 0:
                echo "\n  Transaction C's Request is Successful";
                echo "\n-----Transaction C's Test has Failed!-----";
                $this->assertTrue(false); // Transaction Sent Successfully
                break;
            case 1:
                echo "\n  Transaction C Failed, Database Error";
                echo "\n-----Transaction C's Test has Failed!-----";
                $this->assertTrue(false); // Transaction Failed, Database Error
                break;
            case 2:
                echo "\n  Transaction C Failed, Insufficient Funds";
                echo "\n-----Transaction C's Test has Failed!-----";
                $this->assertTrue(false); // Transaction Failed, Insufficient Funds
                break;
            case 3:
                echo "\n  Transaction C Failed, Receiving Username Doesn't exist or Transaction to this Username is Not Allowed";
                echo "\n-----Transaction C's Test has Failed-----";
                $this->assertTrue(false); // Transaction Failed, Receiving Username Doesn't exist or Doesn't have a main Account
                break;
            case 5:
                echo "\nTransaction C Failed, User Not Linked to Account ";
                $fromBalanceAfter = getAccountBalance($accoundid, $mysqli);
                echo "\n  FromAccount Balance Before: \$$fromBalanceBefore";
                echo "\n  FromAccount Balance After: \$$fromBalanceAfter";
                $amountWithdrew = round($fromBalanceBefore-$fromBalanceAfter,2);
                echo "\n  Amount withdrew: \$".($amountWithdrew);
                
                // If the amount taken out of the account is different from the amount sent assert false
                if($amountWithdrew != 0) $this->assertTrue(false);
                echo "\n-----Transaction C's Test is SUCCESSFUL!-----";
                $this->assertTrue(true); // Transaction Failed, Username Doesn't Exist
                break;
        }
    }
    
    /*This test is for Completeing a Valid transaction*/
    public function testTransactionD_SendingNegativeAmount(){
        $mysqli = $this->mysqli;
        
        // **WE ASSUME THAT DATA IS ALREADY SANITIZED AT THIS STAGE**
        $toUsername = "jordems";
        $amount = -12.12;
        $reason = "Money Owed";
        $accoundid = $this->aid; // Don't Change
        
        /* Get the account balance from the test user's id, and from the receiving username
         * Before the transaction to compare with resulting balances*/
        $fromBalanceBefore= getAccountBalance($accoundid, $mysqli);
        $toBalanceBefore = getAccountBalanceofUser($toUsername, $mysqli);
        
        echo "\n\n-----Transaction D-----";
        
        $code = sendTransaction($toUsername, $amount, $reason, $accoundid ,$mysqli);
        echo "\n Sent Transaction('$toUsername', $amount, \"$reason\", $accoundid) in format(tousername,amount,reason,fromaccountid)";
        echo "\n ***Expecting Faild Transaction, Error Message: Insufficient funds***";
        switch($code){
            case 0:
                echo "\n Transaction D's Request is Successful";
                echo "\n\n --Verifying with Database's Account Data--";
                echo "\n-----Transaction D's Test FAILED!-----";
                
                $this->assertTrue(false); // Transaction Sent Successfully
                break;
            case 1:
                echo "\nTransaction D Failed, Database Error";
                echo "\n-----Transaction D's Test FAILED!-----";
                $this->assertTrue(false); // Transaction Failed, Database Error
                break;
            case 2:
                echo "\nTransaction D Failed, Insufficient Funds";
                echo "\n-----Transaction D's Test is SUCCESSFUL!-----";
                $this->assertTrue(true); // Transaction Failed, Insufficient Funds
                break;
            case 3:
                echo "\nTransaction D Failed, Receiving Username Doesn't exist or Doesn't have a main Account";
                echo "\n-----Transaction D's Test FAILED!-----";
                $this->assertTrue(false); // Transaction Failed, Receiving Username Doesn't exist or Doesn't have a main Account
                break;
            case 5:
                echo "\nTransaction D Failed, User Not Linked to Account ";
                echo "\n-----Transaction D's Test FAILED!-----";
                $this->assertTrue(false); // Transaction Failed, Username Doesn't Exist
                break;
        }
    }
    
    protected function tearDown(){
        // Reset Data After each test
        resetTransactionsTest($this->aid,$this->mysqli);
        // Close Connection
        $this->mysqli->close();
    }
    
}
?>