<?php


function getMonthlyIncome($mysqli, $aid, $month){
    // Get the total income over all accounts for a user in the last year
    $query = "SELECT SUM(amount) FROM AccountTransaction WHERE amount > 0 AND aid = ? AND MONTH(`date`) = ? LIMIT 1";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('ii', $aid, $month);
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
        $stmt->bind_result($totalIncome);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {
          if($totalIncome != null){
            return $totalIncome;
          }else{
            return null;
          }
        }
        $stmt->close();
      }else{
          return null;
      }
}

function getMonthlyExpenses($mysqli, $aid, $month){
    // Get the total expenses over all accounts for a user in the last year
    $query = "SELECT SUM(amount) FROM AccountTransaction WHERE amount < 0 AND aid = ? AND MONTH(`date`) = ? LIMIT 1";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('ii', $aid, $month);
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
        $stmt->bind_result($totalExpenses);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {
          if($totalExpenses != null){
            return $totalExpenses;
          }else{
            return null;
          }
        }
        $stmt->close();
      }else{
          return null;
      }
}

?>