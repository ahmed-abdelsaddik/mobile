<?php

session_start();
if (isset($_SESSION['admin'])) {
  

include('init.php');

$do='';
if (isset($_GET['do'])) {
  $do=$_GET['do'];
}


switch ($do) {
	
case 'Manage':?>
 
       <div class="container">
     
         
    
      


    

      
      <div class="table-responsive">
      <table class="main-table text-center table table-bordered">
          <tr>
              <td>الاسم</td>
              <td>الاسم بالكامل</td>
              <td>النوع</td>
              <td>تاريخ الاضافة</td>
              <td>التحكم</td>
          </tr> 
        
            <?php
                  $stmt4=$con->prepare("SELECT * FROM users");
                  $stmt4->execute();
                  $users=$stmt4->fetchALL();
                   foreach ($users as $user) {
                     
                          echo "<tr>";
                  
                       echo "<td>".$user['UserName']."</td>";
                       echo "<td>" .$user['FullName'] ."</td>";
                    
                      echo "<td>"; 
                      if ($user['GroupID']==1) {echo "صاحب عمل";
                       
                      }elseif ($user['GroupID']==0) {
                       echo "مستخدم عادي";
                      }

                      echo "</td>";
                       
                       echo "<td>" .$user['userdate'] ."</td>";
                       echo "<td>

                      <a href='?do=Edit&userid=".$user['UserID']."' class='btn btn-primary'>تعديل</a>
                      <a href='?do=Delete&userid=".$user['UserID']."' class='btn btn-danger'>حذف</a>
                       </td>";
                  echo "</tr>";
                 
                   
                   }

                
               
           
                ?>
      </table>
      </div>
    <a href="?do=Add" class="btn btn-primary">اضافة مستخدم جديد</a>
   </div>


   <?php 
 //}

   break;










  case 'Add':?>
		
          <div class="container">
      <h2 class="text-center">اضافة مستخدمين</h2>
      <form class="form-horizontal" action="?do=Insert" method="POST">
         <div class="form-group">
              
               <div class="col-sm-10">
                  
                    <input type="text" name="username" class="form-control col-sm-10 form-control" id="inputEmail3" placeholder="الاسم المستخدم" autocomplete="off">
                 </div>
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم المستخدم</label>
        </div>   



        
        <div class="form-group">
             
               <div class="col-sm-10">
                    <input type="text" name="fullnum" class="form-control col-sm-10" id="inputEmail3" placeholder = "الا سم بلكامل" autocomplete= "off" >
                 </div>
            <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم بلكامل</label>
        </div>   


     
         <div class="form-group">
              
               <div class="col-sm-10">
                    <input type="password" name="password" class="form-control col-sm-10" id="inputEmail3" placeholder = "الرقم السري" autocomplete= "off">
                 </div>
       
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الرقم السري</label>
        </div>   

         
    <div class="form-group">
         
        <div class="col-sm-10">
                 

              <select name="admin" class="form-control" >
                
               
                <option value=0> مستخدم عادي</option>;
                <option value=1> صاحب عمل</option>;
                           
              </select>
              

        </div>
          <label style="width: 6%;"  for="inputPassword3"  class="col-sm-2 control-label">نوع المستخدم</label>

          </div>
      
       
            <div class="form-group">
           
          <div class="col-sm-offset-2 col-sm-4">
             <button style="display: inline-block;width: 60%;" type="submit" class="btn btn-default btn btn-primary">اضافة مستخدم جديد</button>
         </div>
          
         </div>
 
     </form>
    
        </div>

		<?php break;
	
	case 'Insert':
		

             
     if ($_SERVER['REQUEST_METHOD']=='POST') {
		    

	   echo "<div class='container'>";
	     $username          =$_POST['username'];
        $fullnum           =$_POST['fullnum'];
        $password         =$_POST['password'];
        $admin           =$_POST['admin'];

   
   $formerrors=array();

    if(empty($username))   {$formerrors[]= "<div class='alert alert-danger'>يجب ان تكتب اسم المستخدم</div>";}
    if(empty($fullnum))  {$formerrors[]= "<div class='alert alert-danger'>يجب ان تكتب الاسم الكامل</div>";} 
      if(empty($password))   {$formerrors[]= "<div class='alert alert-danger'>يجب ان تكتب البسورد</div>";}
      
      if(!empty($formerrors)){
        foreach ($formerrors as $error) {
          echo $error;
        header("refresh:3;url=?do=Add");
       exit();
      }}
 

      $check=checkall('username','users',$username);

      if($check>0){echo $formerrors[]="<div class='alert alert-danger'>هذا المستخدم موجود بالفعل</div>";header("refresh:3;url=?do=Add"); exit();}
         
       else{

                     $stmt=$con->prepare("INSERT INTO users (UserName,FullName,Password,GroupID,userdate)values(:zUserName,:zFullName,:zPassword,:zGroupID,now())");
          $stmt->execute(array(

           'zUserName'=>$username ,
            'zFullName'=>$fullnum ,
            'zPassword'=>$password ,
            'zGroupID'=>$admin ,
           
          ));
      

          if ($stmt) {
              echo "<div class='container'>";
               echo "<div class='alert alert-success'>";
               echo $stmt->rowCount(). "سجيلت";

                echo "</div>";

              echo"</div>";
          }else{echo"no row";}
            
          
       }

}

       echo "</div>";

      

		break;
		

      case 'Edit':?>
      	
         <?php 
             

              if (isset($_SESSION['id'])) {
                
              
              if (isset($_GET['userid'])&& is_numeric($_GET['userid'])) {
              	 $userid=$_GET['userid'];
             

              $stmt= $con->prepare("SELECT * FROM users where UserID=?");
              $stmt->execute(array($userid));
              $users=$stmt->fetch();
        


           ?>


        <div class="container">
      <h2 class="text-center">اضافة مستخدمين</h2>
      <form class="form-horizontal" action="?do=Update" method="POST">
         <div class="form-group">
              
               <div class="col-sm-10">
                  <input type="hidden" name="userid" value="<?php echo $userid?>">
                    <input type="text" name="username" class="form-control col-sm-10 form-control" id="inputEmail3" placeholder="الاسم المستخدم" autocomplete="off" value="<?php echo $users['UserName'];?>">
                 </div>
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم المستخدم</label>
        </div>   



        
        <div class="form-group">
             
               <div class="col-sm-10">
                    <input type="text" name="fullnum" class="form-control col-sm-10" id="inputEmail3" placeholder = "الا سم بلكامل" autocomplete= "off" value="<?php echo $users['FullName'];?>">
                 </div>
            <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم بلكامل</label>
        </div>   


     
         <div class="form-group">
              
               <div class="col-sm-10">
                    <input type="password" name="password" class="form-control col-sm-10" id="inputEmail3" placeholder = "الرقم السري" autocomplete= "off">
                 </div>
       
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الرقم السري</label>
        </div>   

         
    <div class="form-group">
         
        <div class="col-sm-10">
                 

              <select name="admin" class="form-control">
                
               
                <option value="0" <?php if($users['GroupID']==0){echo "select";}?>> مستخدم عادي</option>
                <option value="1" <?php if($users['GroupID']==1){ echo "select";}?>> صاحب عمل</option>
                           
              </select>
              

        </div>
          <label style="width: 6%;"  for="inputPassword3"  class="col-sm-2 control-label">نوع المستخدم</label>

          </div>
      
       
            <div class="form-group">
           
          <div class="col-sm-offset-2 col-sm-4">
             <button style="display: inline-block;width: 60%;" type="submit" class="btn btn-default btn btn-primary">تحديث</button>
         </div>
          
         </div>
 
     </form>
    
        </div>

		<?php 

    } 
     }
		break;
	

case 'Update':
	
        $username       =$_POST['username'];
        $fullnum        =$_POST['fullnum'];
        $password       =$_POST['password'];
        $admin          =$_POST['admin'];
        $userid         =$_POST['userid'];
   

         $stmt=$con->prepare("UPDATE users SET UserName=?,FullName=?,Password=?,GroupID=? where UserID=?");
         $stmt->execute(array($username ,$fullnum ,$password,$admin,$userid));
      
      if ($stmt) {
              echo "<div class='container'>";
               echo "<div class='alert alert-success'>";
               echo $stmt->rowCount(). "حد ثت";

                echo "</div>";

              echo"</div>";
          }else{echo"no row";}
            
	break;

    case 'Delete':
    	 
        echo "<div class='container'>";
     
     if (isset($_GET['userid']) && is_numeric($_GET['userid'])) {
       $userid=$_GET['userid'];

     $stmt=$con->prepare("SELECT * FROM  users WHERE UserID=?");
      $stmt->execute(array($userid));
   
   $count=$stmt->rowCount();
  
   }
        
        if ($count>0) {
          $stmt=$con->prepare("DELETE FROM users WHERE UserID = :Zid");
          $stmt->bindparam(":Zid",$userid);
           $stmt->execute();
             echo"<div class='alert alert-success'>" .$stmt->rowCount()."حذف" ."</div>" ;
        }

    	break;



}

include($tpl.'footer.php');
}