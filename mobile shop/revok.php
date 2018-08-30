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
              <td>العدد</td>
              <td>التارخ الاضافة</td>
               <td>التحكم</td>
          </tr> 
        
            <?php
                  $stmt4=$con->prepare("SELECT * FROM revoked");
                  $stmt4->execute();
                  $revokes=$stmt4->fetchALL();
                   foreach ($revokes as $revoke) {
                     
                          echo "<tr>";
                  
                       echo "<td>".$revoke['revokName']."</td>";
                       echo "<td>" .$revoke['revokenum'] ."</td>";
                       echo "<td>" .$revoke['revokdate'] ."</td>";
                      
        
                       echo "<td>

                      <a href='?do=Edit&revokid=".$revoke['revokID']."' class='btn btn-primary'>تعديل</a>
                      <a href='?do=Delete&revokid=".$revoke['revokID']."' class='btn btn-danger'>حذف</a>
                       </td>";
                  echo "</tr>";
                 
                   
                   }
           
                ?>
      </table>
      </div>
    <a href="?do=Add" class="btn btn-primary">اضافة ناقص جديد</a>
   </div>

<?php break;

   case 'Add':?>
		
          <div class="container">
      <h2 class="text-center">اضافة النواقص</h2>
      <form class="form-horizontal" action="?do=Insert" method="POST">
         <div class="form-group">
              
               <div class="col-sm-10">
                  
                    <input type="text" name="name" class="form-control col-sm-10 form-control" id="inputEmail3" placeholder="الاسم الناقص" autocomplete="off">
                 </div>
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم</label>
        </div>   



        
        <div class="form-group">
             
               <div class="col-sm-10">
                    <input type="text" name="num" class="form-control col-sm-10" id="inputEmail3" placeholder = "الكمية الناقصة" autocomplete= "off" >
                 </div>
            <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الكمية الناقصة</label>
        </div>   


     
       
  
      
       
            <div class="form-group">
           
          <div class="col-sm-offset-2 col-sm-4">
             <button style="display: inline-block;width: 60%;" type="submit" class="btn btn-default btn btn-primary">اضافة  الناقص</button>
         </div>
          
         </div>
 
     </form>
    
        </div>

		<?php break;
	
 


    case 'Insert':
		

             
     if ($_SERVER['REQUEST_METHOD']=='POST') {
		    

	   echo "<div class='container'>";
	     $name          =$_POST['name'];
        $num            =$_POST['num'];
      
   
   $formerrors=array();

    if(empty($name))   {$formerrors[]= "<div class='alert alert-danger'>يجب ان تكتب اسم المستخدم</div>";}
    if(empty($num))  {$formerrors[]= "<div class='alert alert-danger'>يجب ان تكتب العدد</div>";} 
      
      
      if(!empty($formerrors)){
        foreach ($formerrors as $error) {
          echo $error;
        header("refresh:3;url=?do=Add");
       exit();
      }}
 

      $check=checkall('revokName','revoked',$num);

      if($check>0){echo $formerrors[]="<div class='alert alert-danger'>هذا المستخدم موجود بالفعل</div>";header("refresh:3;url=?do=Add"); exit();}
         
       else{

                     $stmt=$con->prepare("INSERT INTO revoked (revokName,revokenum,revokdate)values(:zrevokName,:zrevokenum,now())");
          $stmt->execute(array(

           'zrevokName'=>$name ,
            'zrevokenum'=>$num ,
            
           
          ));
      

          if ($stmt) {
              echo "<div class='container'>";
               echo "<div class='alert alert-success'>";
               echo $stmt->rowCount(). "تم التسجيل بنجاح";

                echo "</div>";

              echo"</div>";
          }else{echo"no row";}
            
          
       }



       echo "</div>";

      }

		break;



 case 'Edit':?>
      	
         <?php 
             

              
                
              

           if (isset($_GET['revokid'])&& is_numeric($_GET['revokid'])) {
              	 $revokid=$_GET['revokid'];
             



              $stmt= $con->prepare("SELECT * FROM revoked where revokID=?");
              $stmt->execute(array($revokid));
              $revok=$stmt->fetch();
        


           ?>


        <div class="container">
      <h2 class="text-center">اضافة مستخدمين</h2>
      <form class="form-horizontal" action="?do=Update" method="POST">
         <div class="form-group">
              
               <div class="col-sm-10">
                  <input type="hidden" name="revok" value="<?php echo  $revokid?>">
                    <input type="text" name="name" class="form-control col-sm-10 form-control" id="inputEmail3" placeholder="الاسم " autocomplete="off" value="<?php echo $revok['revokName'];?>">
                 </div>
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم</label>
        </div>   



        
        <div class="form-group">
             
               <div class="col-sm-10">
                    <input type="text" name="num" class="form-control col-sm-10" id="inputEmail3" placeholder = "الكمية الناقصة" autocomplete= "off" value="<?php echo $revok['revokenum'];?>">
                 </div>
            <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الكمية</label>
        </div>   


     
         
       
       
            <div class="form-group">
           
          <div class="col-sm-offset-2 col-sm-4">
             <button style="display: inline-block;width: 60%;" type="submit" class="btn btn-default btn btn-primary">البيانات تحديث</button>
         </div>
          
         </div>
 
     </form>
    
        </div>

		<?php 

    } 
     
		break;


case 'Update':
	
        $name           =$_POST['name'];
        $num            =$_POST['num'];
        $revok          =$_POST['revok'];
       
   

         $stmt=$con->prepare("UPDATE revoked SET revokName=?,revokenum=? where revokID=?");
         $stmt->execute(array($name,$num ,$revok));
      
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
     
     if (isset($_GET['revokid']) && is_numeric($_GET['revokid'])) {
       $revokid=$_GET['revokid'];

     $stmt=$con->prepare("SELECT * FROM  revoked WHERE revokID=?");
      $stmt->execute(array($revokid));
   
   $count=$stmt->rowCount();
  
   }
        
        if ($count>0) {
          $stmt=$con->prepare("DELETE FROM revoked WHERE revokID = :Zid");
          $stmt->bindparam(":Zid",$revokid);
           $stmt->execute();
             echo"<div class='alert alert-success'>" .$stmt->rowCount()."حذف" ."</div>" ;
        }

    	break;
}

include($tpl.'footer.php');
}
   