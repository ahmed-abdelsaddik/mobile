<?php
session_start();
 
 
     if (isset($_POST['update'])) 
    {
      include("../connect.php");
	  $username=$_POST['username'];
	  $password=$_POST['password'];
	  $phone=$_POST['phone'];
	  $address=$_POST['address'];
	  $tall=$_POST['tall'];
	  $weight=$_POST['weight'];
	  $speed=$_POST['speed'];
    $userid=$_POST['userid'];
      $stmt=$con->prepare("UPDATE user_info  SET username=?,     
           
       phone=? WHERE userid=?"); 
            
     $stmt->execute(array($username,$phone,$userid));
      header("location:create.php");

       $stmt=$con->prepare("UPDATE members  SET tall=?,     
           
       weight=?,speed=? WHERE memberid=?"); 
            
     $stmt->execute(array($tall,$weight,$speed,$userid));
      header("location:create.php");
    }
