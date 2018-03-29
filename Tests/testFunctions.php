<?php
function resetTransactionsTest($aid,$mysqli){
    $isBalanceReset = setBalance($aid,$mysqli, 5000);
    $isTransactionsRemoved = removeTransactions($aid,$mysqli);
    return ($isBalanceReset && $isTransactionsRemoved);
}

function setBalance($aid,$mysqli, $balance){
    $UPDATE_stmt = $mysqli->prepare("UPDATE Account SET balance = ? WHERE aid = ?");
    $UPDATE_stmt->bind_param('di', $balance,$aid);
    // Execute the prepared statement.
    if($UPDATE_stmt->execute()){
        $UPDATE_stmt->close();
        return true;
    }
    $UPDATE_stmt->close();
    return false;
}
function removeTransactions($aid,$mysqli){
    $DELETE_stmt = $mysqli->prepare("DELETE FROM Transaction WHERE toid = ? OR fromid = ?");
    $DELETE_stmt->bind_param('ii', $aid,$aid);
    // Execute the prepared statement.
    if($DELETE_stmt->execute()){
        $DELETE_stmt->close();
        return true;
    }
    $DELETE_stmt->close();
    return false;
}


function resetAccountTest($aid,$mysqli){
    // TODO:
    return true;
}

?>