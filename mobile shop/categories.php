<?php
session_start();
if (isset($_SESSION['admin'])||isset($_SESSION['user'])) {

include('init.php');
 if (isset($_GET['shopid'])&& is_numeric($_GET['shopid'])) {
           $shopid=$_GET['shopid'];
 }
$stmt=$con->prepare("SELECT * from  shop where ShopID=?");
$stmt->execute(array($shopid));
$shops=$stmt->fetch();
    
   echo "<h2 class='text-center'>" .$shops['ShopName']. "</h2>";


$do='';
if (isset($_GET['do'])) {
  $do=$_GET['do'];
}


switch ($do) {
	

  
   case 'Manage':

if (isset($_SESSION['admin'])) {
        
    if (isset($_GET['shopid'])&& is_numeric($_GET['shopid'])) {
           $shopid=$_GET['shopid'];

   ?>
   	
      
       <div class="container">
     
    
      


    

      
      <div class="table-responsive">
      <table class="main-table text-center table table-bordered">
          <tr>
              <td>الاسم</td>
              
              <td>تاريخ الاضافة</td>
              <td>التحكم</td>
          </tr> 
        
            <?php
               
                
                  $stmt4=$con->prepare("SELECT categories.*,shopcat.*,shop.* from categories

                 join shopcat on shopcat.shopcat_catid=categories.ID
                 join shop on shop.ShopID=shopcat.shopcat_shopid
                where ShopID=?");
                  $stmt4->execute(array($shopid));
                  $cats=$stmt4->fetchALL();
                   foreach ($cats as $cat) {
                     
                          echo "<tr>";
                  
                       echo "<td>".$cat['Name']."</td>";
                       echo "<td>" .$cat['catdate'] ."</td>";
                    
                     
                       
                       
                       echo "<td>

                      <a href='?do=Edit&catid=".$cat['ID']."' class='btn btn-primary'>تعديل</a>
                      <a href='?do=Delete&catid=".$cat['ID']."' class='btn btn-danger'>حذف</a>
                       </td>";
                  echo "</tr>";
                 
                   
                   }

                 
               
               
           
                ?>
      </table>
      </div>
  
   <a href='?do=Add&shopid=<?php echo $shopid; ?>' class="btn btn-primary"> اضافة تصنيف جديد</a>
   </div>

    


   <?php	
}
}else{echo "sorry". "you are not admin";


}

   break;
 

 







	case 'Add':?>
		
   <div class="container">
      <h2 class="text-center">اضافة التصنيفات</h2>
      <form class="form-horizontal" action="?do=Insert" method="POST">
         <div class="form-group">
              
               <div class="col-sm-10">
                  
                    <input type="text" name="name" class="form-control col-sm-10 form-control" id="inputEmail3" placeholder="الاسم المستخدم" autocomplete="off">
                 </div>
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم التصنيف</label>
        </div>   



        

     
        
         
    <div class="form-group">
         
        <div class="col-sm-10">
                 

             
                
              <?php

             // $stmt=$con->prepare("SELECT * FROM shop");
             // $stmt->execute();
             // $shops=$stmt->fetchALL();


                if (isset($_GET['shopid'])&& is_numeric($_GET['shopid'])) {
                	 $shopid=$_GET['shopid'];
                } ?>
             
               <input type='hidden' name="shop" value="<?php echo $shopid?>">

              
            

             

              
              
             
              

        </div>
         

          </div>
      
       
            <div class="form-group">
           
          <div class="col-sm-offset-2 col-sm-4">
             <button style="display: inline-block;width: 60%;" type="submit" class="btn btn-default btn btn-primary">اضافة تصنيف جديد</button>
         </div>
          
         </div>
 
     </form>
    
        </div>


		<?php break;
	
	   case 'Insert':
	   	

	   	 if ($_SERVER['REQUEST_METHOD']=='POST') {
		    

	   echo "<div class='container'>";
	     $name           =$_POST['name'];
       $shop           =$_POST['shop'];
       
   
   $formerrors=array();

    if(empty($name))   {$formerrors[]= "<div class='alert alert-danger'>يجب الا تترك اسم التصنيف فارغ</div>";}
    if(empty($name))  {$formerrors[]= "<div class='alert alert-danger'>يجب ان تختار المحل</div>";} 
     
      
      if(!empty($formerrors)){
        foreach ($formerrors as $error) {
          echo $error;
        header("refresh:3;url=?do=Add");
       exit();
      }}
 
        //$check=checkall('shopcat_shopid','shopcat',$shop);
        //$check2=checkall('Name','categories',$name);

      // if($check>0){echo $formerrors[]="<div class='alert alert-danger'>هذا المستخدم موجود بالفعل</div>";header("refresh:3;url=?do=Add"); exit();}
	
     



         $stmt=$con->prepare("INSERT INTO categories (Name,catdate)values(:zName,now())");
          $stmt->execute(array(

           'zName'=>$name ,
            
           
          ));
      

            
         $stmt1=$con->prepare("SELECT LAST_INSERT_ID() from categories");
         $stmt1->execute();
         $itmid=$stmt1->fetch();
       
         $stmt3=$con->prepare("SELECT ShopID from shop where ShopID=?");
         $stmt3->execute(array($shop));
         $shop=$stmt3->fetch();
           
          $stmt2=$con->prepare("INSERT INTO  shopcat (shopcat_shopid,shopcat_catid) values(:zshop,:zitem)");
        $stmt2->execute(array(
        'zshop'=>$shop['ShopID'],
        'zitem'=>$itmid['LAST_INSERT_ID()'],
      ));




          if ($stmt) {
              echo "<div class='container'>";
               echo "<div class='alert alert-success'>";
               echo $stmt->rowCount(). "سجيلت";
               
                echo "</div>";   
              echo"</div>";
             
         
          }else{echo"no row";}
            
          
      



       echo "</div>";

      
      }
      
		break;

   case 'Edit':?>
   	
      <?php 
             if (isset($_GET['catid'])&& is_numeric($_GET['catid'])) {
              	 $catid=$_GET['catid'];
             

              $stmt= $con->prepare("SELECT  * from categories where ID=?");
              $stmt->execute(array($catid));
              $cat=$stmt->fetch();
       

           ?>




              <div class="container">
     
      <form class="form-horizontal" action="?do=Update" method="POST">
         <div class="form-group">
              
               <div class="col-sm-10">
                  <input type="hidden" name="cat" value="<?php echo $cat['ID']?>">
                    <input type="text" name="name" class="form-control col-sm-10 form-control" id="inputEmail3" placeholder="الاسم المستخدم" autocomplete="off" value="<?php echo $cat['Name'] ?>">
                 </div>
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم التصنيف</label>
        </div>   



        

     
        
         
    <div class="form-group">
         
       
         
          </div>
      
       
            <div class="form-group">
           
          <div class="col-sm-offset-2 col-sm-4">
             <button style="display: inline-block;width: 60%;" type="submit" class="btn btn-default btn btn-primary">اضافة تصنيف جديد</button>
         </div>
          
         </div>
 
     </form>
    
        </div>





   <?php 
    }
   	break;
   
  case 'Update':
   
   if ($_SERVER['REQUEST_METHOD']=='POST'){
        $name=$_POST['name'];
        $catid1=$_POST['cat'];
 
   

         $stmt3=$con->prepare("UPDATE categories SET Name=? where ID=?");
         $stmt3->execute(array($name,$catid1));
      
      if ($stmt3) {
              echo "<div class='container'>";
               echo "<div class='alert alert-success'>";
               echo $stmt3->rowCount(). "حد ثت";

                echo "</div>";
               header("refresh:1;url=?do=Add");
              echo"</div>";
          }else{echo"no row";}
            
       
        }
   	break; 



    case 'Delete':
    	 
        echo "<div class='container'>";
     
     if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
       $catid=$_GET['catid'];

     $stmt1=$con->prepare("SELECT * FROM  categories WHERE ID=?");
      $stmt1->execute(array($catid));
   
   $count1=$stmt1->rowCount();
  
   }
        
        if ($count1>0) {
          $stmt=$con->prepare("DELETE FROM categories WHERE ID = :Zid");
          $stmt->bindparam(":Zid",$catid);
           $stmt->execute();
             echo"<div class='alert alert-success'>" .$stmt->rowCount()."حذف" ."</div>" ;
        
            header("refresh:1;url=?do=Manage");
        }

    	break;

      
}


}
?>
