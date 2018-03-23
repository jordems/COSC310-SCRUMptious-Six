<?php
$host="localhost";
$username="root";
$password="";
$databasename="scomments";

$connect=mysql_connect($host,$username,$password);
$db=mysql_select_db($databasename);



if(isset($_POST['user_comm']) )
{
  $comment=$_POST['user_comm'];
  $name=$_POST['user_name'];
  $insert=mysql_query("insert into comments (name,comment,post_time) values('$name','$comment',CURRENT_TIMESTAMP)");
  
  //$id=mysql_insert_id($insert);

  $select=mysql_query("select name,comment,post_time from comments where name='$name' and comment='$comment'");
  
  if($row=mysql_fetch_array($select))
  {
	  $name=$row['name'];
	  $comment=$row['comment'];
      $time=$row['post_time'];
  ?>
<div class="comment_div"> 
 <p class="name"><strong>Posted By:</strong> <?php echo $name;?> <span style="float:right"><?php echo date("j/m/Y g:ia", strtotime($time)) ?></span></p>
 <p class="comments"><?php echo $comment;?></p>	
</div>
  <?php
  }
exit;
}

?>