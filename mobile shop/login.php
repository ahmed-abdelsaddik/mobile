
<?php
session_start();
$nonavbar='';
$pagetitle='login';
// if (isset($_SESSION['login'])) {
//     header("location:dashbord.php");
//     exit();
// }else{
//     header('location:index.php');
//     exite();
// }

include('init.php');

if($_SERVER['REQUEST_METHOD']="POST"){

    

    $username=$_POST['Username'];
    $password=$_POST['Password'];

  
 
   
   } 

// check if user exit in database
 
$stmt=$con->prepare("SELECT UserID,UserName,Password FROM users  WHERE UserName=?  AND  Password=? AND GroupID=1");
$stmt->execute(array($username,$password));
$row=$stmt->fetch();
$count=$stmt->rowCount();

 
$stmt2=$con->prepare("SELECT UserID,UserName,Password FROM users  WHERE UserName=?  AND  Password=? AND GroupID=0");
$stmt2->execute(array($username,$password));
$row2=$stmt2->fetch();
$count2=$stmt2->rowCount();

 
if ($count>0) {
    $_SESSION['admin']=$username;
     $_SESSION['id']=$row['UserID'];
   
   
     header("location:shop1.php?do=Manage&shopid=1");
   
    exit();
     }

  if ($count2>0) {
    $_SESSION['user']=$username;
    $_SESSION['id']=$row2['UserID'];

     header("location:shop1.php?do=Manage&shopid=1");
   
    exit();
     }

 ?>

<!-- 
// this login form -->
<div class="parent" style="margin:100px auto;">
<div class="container">
    <h2 class="text-center" style="margin-bottom: -80px;">تسجيل الدخول</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>"  method='POST' style="width: 40%; margin: 100px auto;">
   <div class="form-group">
             
               <div class="col-sm-10">
                     
                    <input  style="width: 100%;" type="text" name="Username" class="form-control col-sm-10" id="inputEmail3" placeholder = "الاسم" autocomplete= "off" required='required'>
                 </div>
           
        </div>   


     <div class="form-group">
              
               <div class="col-sm-10">
                    <input style="width: 100%; margin-top: 10px;"  type="password" name="Password" class="form-control col-sm-10" id="inputEmail3" placeholder = "كلمة المرور" autocomplete= "off" required='required'>
                 </div>
           
        </div>   

 
 <div class="form-group">
           
          <div class="col-sm-offset-2 col-sm-4">
             <input style="margin-top: 10px;" class="btn btn-primary" type="submit" value="دخول">
         </div>
          
         </div>


</form>
   </div>



</div>





<?php  


include($tpl."footer.php")

  ?>  