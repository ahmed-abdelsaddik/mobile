<?php
include("../connect.php");
  $userid=$_GET['userid'];
   $stmt=$con->prepare("SELECT user_info.*, members.* FROM user_info
    join members on members.memberid=user_info.userid");
   $stmt->execute();
   $users=$stmt->fetchAll();
   $count=$stmt->rowCount();
  
   
        
        if ($count>0) 
        {
           $stmt=$con->prepare("DELETE FROM user_info WHERE userid = :Zid");
           $stmt->bindparam(":Zid",$userid);
           $stmt->execute();


            $stmt2=$con->prepare("DELETE FROM members WHERE memberid = :Zid");
           $stmt2->bindparam(":Zid",$userid);
           $stmt2->execute();
          } 