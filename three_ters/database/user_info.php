<?php

include "connect.php";
if($_SERVER['REQUEST_METHOD']="POST"){
    $username=$_POST['username'];
    $password=$_POST['password'];
   } 

   
$stmt=$con->prepare("SELECT * FROM user_info  WHERE username=?  AND  password=? AND GroupID=1");
$stmt->execute(array($username,$password));
$row=$stmt->fetch();
$count=$stmt->rowCount();

 
$stmt2=$con->prepare("SELECT UserID,UserName,Password FROM users  WHERE UserName=?  AND  Password=? AND GroupID=0");
$stmt2->execute(array($username,$password));
$row2=$stmt2->fetch();
$count2=$stmt2->rowCount();

 
if ($count>0) {
    $_SESSION['admin']=$username;
    $_SESSION['id']=$row['userid'];
   
   
     header("location:shop1.php?do=Manage&shopid=1");
   
    exit();
     }

  if ($count2>0) {
    $_SESSION['user']=$username;
    $_SESSION['id']=$row2['userid'];

     header("location:shop1.php?do=Manage&shopid=1");
   
    exit();
     }else{header(header("location:main.php")}

