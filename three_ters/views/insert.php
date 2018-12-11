  <?php
 session_start();
 if (isset($_SESSION['admin'])) {
  if($_SERVER['REQUEST_METHOD']="POST")
  {
  	 
    include("../connect.php");
	  $username=$_POST['username'];
	  $password=$_POST['password'];
	  $phone=$_POST['phone'];
	  $address=$_POST['address'];
	  $tall=$_POST['tall'];
	  $weight=$_POST['weight'];
	  $speed=$_POST['speed'];
         
         $stmt=$con->prepare("INSERT INTO user_info (username,password,phone,address)values(:zname,:znum,:zprice,:ztotprice)");
          $stmt->execute(array(

           ':zname'=>$username ,
            ':znum'=>$password ,
            ':zprice'=>$phone ,
            ':ztotprice'=>$address,
          ));
             
             $stmt2=$con->prepare("SELECT LAST_INSERT_ID() from user_info");
             $stmt2->execute();
             $u=$stmt2->fetch();
             
              

      
         $stmt1=$con->prepare("INSERT INTO members(tall,weight,speed,memberid)values(:zname,:znum,:zprice,:zmm)");
          $stmt1->execute(array(

            ':zname'=>$tall ,
            ':znum'=>$weight ,
            ':zprice'=>$speed ,
            ':zmm'=>$u['LAST_INSERT_ID()'],
           
          ));


    //header("location:create.php");
  }
}