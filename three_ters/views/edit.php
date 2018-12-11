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
     
      $stmt=$con->prepare("UPDATE user_info  SET username=?,     
           
       phone=? WHERE userid=?"); 
            
     $stmt->execute(array($username,$phone,$userid));
      header("location:create.php");
    }








 include("../connect.php");
if (isset($_SESSION['admin'])) {
     if (isset($_GET['userid'])&& is_numeric($_GET['userid'])) {
           $userid=$_GET['userid'];
            $stmt=$con->prepare("SELECT user_info.*, members.* FROM user_info
           join members on members.memberid=user_info.userid where userid=?");
         $stmt->execute(array($userid));
         $users=$stmt->fetch();
   
	?>
	
   
 <form action="update.php" method="POST">
 	<input type="hidden" name="userid" value="<?php echo $userid ?>">
 	<input type="text" name="username" value="<?php echo $users['username']?>">
 	<input type="text" name="phone" value="<?php echo $users['phone']?>">
 	<input type="text" name="tall" placeholder="tall" value="<?php echo $users['tall']?>">
 	<input type="text" name="weight" placeholder="weight" value="<?php echo $users['weight']?>">
 	<input type="text" name="speed" placeholder="speed" value="<?php echo $users['speed']?>">

 	<input type="submit" name="update" value="save"> 
 </form>

<?php
}

}else{echo "no";}

