<?php
 session_start();
 include "connect.php";
if($_SERVER['REQUEST_METHOD']="POST"){
    
 $username=$_POST['username'];
 $password=$_POST['password'];
  

   }
 
  echo $username ;
$stmt=$con->prepare("SELECT * FROM user_info  WHERE username=?  AND  password=? AND GroupID=1");
$stmt->execute(array($username,$password));
$row=$stmt->fetch();
$count=$stmt->rowCount();


if ($count>0) {
     $_SESSION['admin']=$username;
     $_SESSION['id']=$row['userid'];
    

     header("location:views/create.php");
   
    exit();
     } 



  $stmt2=$con->prepare("SELECT * FROM user_info  WHERE username=?  AND  password=? AND GroupID=0");
$stmt2->execute(array($username,$password));
$row2=$stmt2->fetch();
$count2=$stmt2->rowCount();

 

  if ($count2>0) {
    $_SESSION['user']=$username;
    $_SESSION['id']=$row2['UserID'];

     header("location:main.php");
   
    exit();
     }else{header("location:main.php");}

