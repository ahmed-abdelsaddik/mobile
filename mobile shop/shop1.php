
<?php 


session_start();

$pagetitle='shops';



if (isset($_SESSION['admin'])||isset($_SESSION['user'])) {
	
  
   include('init.php');

  if (isset($_GET['shopid'])&& is_numeric($_GET['shopid'])) {
           $shopid=$_GET['shopid'];
 }
$stmt=$con->prepare("SELECT * from  shop where ShopID=?");
$stmt->execute(array($shopid));
$shops=$stmt->fetch();
    
   echo "<h2 class='text-center'>" .$shops['ShopName']. "</h2>";

    



		
$pricetotal=0;
$devicstotal=0;
$gain=0;
$do='';
if (isset($_GET['do'])) {
	$do=$_GET['do'];
}

switch ($do) {
	
		   
          case 'Add':
                
                if (isset($_GET['shopid'])&& is_numeric($_GET['shopid'])) {
                    $shopid=$_GET['shopid'];


          ?>
            
    <div class="container">
      <form class="form-horizontal" action="?do=Insert" method="POST">
         <div class="form-group">
              
               <div class="col-sm-10">
                   <input type="hidden" name="deviseid"/>
                   <input type="hidden" name="shopid" value="<?php echo  $shopid;?>" />
                    <input type="text" name="name" class="form-control col-sm-10 form-control" id="inputEmail3" placeholder="الاسم" autocomplete="off"  required="required">
                 </div>
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم</label>
        </div>   



        
        <div class="form-group">
             
               <div class="col-sm-10">
                    <input type="text" name="num" class="form-control col-sm-10" id="inputEmail3" placeholder = "العدد" autocomplete= "off"  required="required" >
                 </div>
            <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">العدد</label>
        </div>   


     
         <div class="form-group">
              
               <div class="col-sm-10">
                    <input type="text" name="Price" class="form-control col-sm-10" id="inputEmail3" placeholder = "السعر" autocomplete= "off"  required="required">
                 </div>
       
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">السع</label>
        </div>   

         
    <div class="form-group">
         
        <div class="col-sm-10">
                 

              <select name="Category" class="form-control" required="required">
                
               <?php
                $stmt=$con->prepare("SELECT categories.*,shopcat.*,shop.* from categories

                 join shopcat on shopcat.shopcat_catid=categories.ID
                 join shop on shop.ShopID=shopcat.shopcat_shopid
                where ShopID=?");
                $stmt->execute(array($shopid));
                $cats=$stmt->fetchALL();
                foreach ($cats as $cat) {
                  echo "<option value='".$cat['ID']."'>" . $cat['Name'] ."</option>";
                }
              ?>
              </select>
              

        </div>
          <label style="width: 6%;"  for="inputPassword3"  class="col-sm-2 control-label">التصنيف</label>

          </div>
      
       
            <div class="form-group">
           
          <div class="col-sm-offset-2 col-sm-4">
             <button style="display: inline-block;width: 60%;" type="submit" class="btn btn-default btn btn-primary">اضافة جهاز جديد</button>
         </div>
          
         </div>
 
     </form>
    
        </div>

	<?php

}
  	break;
	
	case 'Insert':
		
     if ($_SERVER['REQUEST_METHOD']=='POST') {
		    echo "<div class='container'>";
	      $name      =$_POST['name'];
        $num       =$_POST['num'];
        $price     =$_POST['Price'];
        $Category  =$_POST['Category'];
        $shop      =$_POST['shopid'];
   
  

   $formerrors=array();

    if(empty($name))   {$formerrors[]= "<div class='alert alert-danger'>يجب ان تكتب اسم الجهاز</div>";}
    if(empty($num)|| $num<=0)  {$formerrors[]= "<div class='alert alert-danger'>لايقل العدد عن صفر ولا يترك فارغا</div>";} 
    if(empty($price)||$price<=0) {$formerrors[]= "<div class='alert alert-danger'>لايقل السعر عن صفر ولا يترك فارغا</div>";} 
      if(empty($Category))   {$formerrors[]= "<div class='alert alert-danger'>يجب الا تترك التصنيف فارغ</div>";}
      
      if(!empty($formerrors)){
        foreach ($formerrors as $error) {
          echo $error;
        header("refresh:3;url=?do=Add&shopid=$shop");
      }}
        $check=checkall2('ItemName','itemcatid','items',$name,$Category);
     
      
   if (empty($formerrors)) {
               
       if($check>0){echo $formerrors[]="<div class='alert alert-danger'>هذا الاسم هو موجود بالفعل </div>";

        header("refresh:3;url=?do=Add&shopid=$shop");
     }
         
      else{
         $stmt=$con->prepare("INSERT INTO items (ItemName,ItemNumber,Itemprice,ItemTotalprice,itemcatid,itemdate)values(:zname,:znum,:zprice,:ztotprice,:zcat,now())");
          $stmt->execute(array(

           ':zname'=>$name ,
            ':znum'=>$num ,
            ':zprice'=>$price ,
            ':ztotprice'=>$num *$price ,
            ':zcat'=>$Category ,
           
          ));
      

          if ($stmt) {
              echo "<div class='container'>";
               echo "<div class='alert alert-success'>";
               echo $stmt->rowCount(). "تم تسجيل العنصر بنجاح";
                header("refresh:1;url=?do=Manage&shopid=$shop");
                echo "</div>";

              echo"</div>";
          }else{
            echo"no row";
          }
       
       
         $stmt1=$con->prepare("SELECT LAST_INSERT_ID() from items");
         $stmt1->execute();
         $itmid=$stmt1->fetch();
       
        // if (isset($_GET['shopid'])&& is_numeric($_GET['shopid'])) {
        //            $shopid=$_GET['shopid'];
        //          }
        //      echo $shopid;

        $stmt3=$con->prepare("SELECT ShopID from shop where ShopID=?");
         $stmt3->execute(array($shop));
         $shop=$stmt3->fetch();
    
    
       $stmt2=$con->prepare("INSERT INTO  shopitem (shopitem_shopid,shopitem_itemid) values(:zshop,:zitem)");
      $stmt2->execute(array(
        'zshop'=>$shop['ShopID'],
        'zitem'=>$itmid['LAST_INSERT_ID()'],
      ));

      
     }




  }

}

   echo "</div>";
		break;


   


    case 'Edit':
    	
    
    if (isset($_GET['shopid']) && is_numeric($_GET['shopid'])) {
       $shopid=$_GET['shopid'];}

    if (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) {
       $itemid=$_GET['itemid'];

      $stmt=$con->prepare("SELECT * FROM  items WHERE ItemID=?");
      $stmt->execute(array($itemid));
     $items=$stmt->fetch();


        ?>




          <div class="container">
      <form class="form-horizontal" action="?do=Update" method="POST">
         <div class="form-group">
              
               <div class="col-sm-10">
                   <input type="hidden" name="itemid" value="<?php echo $itemid ?>">
                     <input type="hidden" name="shop" value="<?php echo $shopid ?>">
                    <input type="text" name="name" class="form-control col-sm-10 form-control" id="inputEmail3" placeholder="الاسم" autocomplete="off" required='required' value="<?php echo $items['ItemName'] ?>">
                 </div>
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم</label>
        </div>   



        
        <div class="form-group">
             
               <div class="col-sm-10">
                    <input type="text" name="num" class="form-control col-sm-10" id="inputEmail3" placeholder = "العدد" autocomplete= "off" required='required' value="<?php echo $items['ItemNumber'] ?>">
                 </div>
            <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">العدد</label>
        </div>   


     
         <div class="form-group">
              
               <div class="col-sm-10">
                    <input type="text" name="Price" class="form-control col-sm-10" id="inputEmail3" placeholder = "السعر" autocomplete= "off" required='required' value="<?php echo $items['Itemprice'] ?>">
                 </div>
       
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">السع</label>
        </div>   

         
    <div class="form-group">
         
        <div class="col-sm-10">
                 

              <select name="Category" class="form-control" required="required">
                
               <?php
                $stmt=$con->prepare("SELECT * from categories");
                $stmt->execute();
                $cats=$stmt->fetchALL();
                foreach ($cats as $cat) {
                 echo "<option value='".$cat['ID']."'" ;
                     if ($items['itemcatid']==$cat['ID']) {
                      echo "selected";
                     }
                       
              
                  echo ">". $cat['Name'] ."</option>";
                }
              
              ?>
              </select>
              

        </div>
          <label style="width: 6%;"  for="inputPassword3"  class="col-sm-2 control-label">التصنيف</label>

          </div>
      
       
            <div class="form-group">
           
          <div class="col-sm-offset-2 col-sm-4">
             <button style="display: inline-block;width: 60%;" type="submit" class="btn btn-default btn btn-primary">اضافة جهاز جديد</button>
         </div>
          
         </div>
 
     </form>
    
        </div>




    	 <?php 
}
       break;


    case 'Update':
  if ($_SERVER['REQUEST_METHOD']=='POST') {
    
       echo "<div class='container'>";	
        $name     =$_POST['name'];
        $num      =$_POST['num'];
        $price     =$_POST['Price'];
        $Category  =$_POST['Category'];
    	  $item     =$_POST['itemid'];
        $shop    =  $_POST['shop'];
     

          $formerrors=array();

    if(empty($name))   {$formerrors[]= "<div class='alert alert-danger'>يجب ان تكتب اسم الجهاز</div>";}
    if(empty($num)|| $num<=0)  {$formerrors[]= "<div class='alert alert-danger'>لايقل العدد عن صفر ولا يترك فارغا</div>";} 
    if(empty($price)||$price<=0) {$formerrors[]= "<div class='alert alert-danger'>لايقل السعر عن صفر ولا يترك فارغا</div>";} 
      if(empty($Category))   {$formerrors[]= "<div class='alert alert-danger'>يجب الا تترك التصنيف فارغ</div>";}
      
      if(!empty($formerrors)){
        foreach ($formerrors as $error) {
          echo $error;
        header("refresh:3;url=?do=Edit&itemid=$item");
      }}
       // $check=checkall2('ItemID','itemcatid','items',$item,$Category);

   

     if (empty($formerrors)) {
     
      //if($check>0){echo $formerrors[]="<div class='alert alert-danger'>هذا الاسم هو موجود بالفعل </div>";
         // header("refresh:3;url=?do=Edit&itemid=$item");
    


    //else{
      $stmt=$con->prepare("UPDATE items  SET ItemName=?,     
           
       ItemNumber=?,Itemprice=?,ItemTotalprice=?,itemcatid=? WHERE ItemID=?"); 

                   

     $stmt->execute(array($name,$num,$price,($price*$num),$Category,$item)); 
                    
                     
                      
   echo "<div class='alert alert-success'>".$stmt->rowCount()."تم تحديث البيانات بنجاح"."</div>";
            
       header("refresh:3;url=?do=Manageitem&catid=$Category&shopid=$shop");

     // }
    }
  }
    echo "</div>";

    	break;


  case 'Delete':
  	
  	 echo "<div class='container'>";
      

     if (isset($_GET['shopid']) && is_numeric($_GET['shopid'])) {
       $shopid=$_GET['shopid'];
     }
    
    if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
       $catid=$_GET['catid'];
     }
    
     if (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) {
       $itemid=$_GET['itemid'];
            
  
     $stmt=$con->prepare("SELECT * FROM  items WHERE ItemID=?");
      $stmt->execute(array($itemid));
   
   $count=$stmt->rowCount();
  
   
        
        if ($count>0) {
          $stmt=$con->prepare("DELETE FROM items WHERE ItemID = :Zid");
          $stmt->bindparam(":Zid",$itemid);
           $stmt->execute();
             echo"<div class='alert alert-success'>" .$stmt->rowCount()."تم الحذف بالنجاح" ."</div>" ;
      
        // header("refresh:3;url=?do=Manageitem&catid=$catid &shopid=$shopid");
        }

         
}
              break;
  



case 'sell':



          
      if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
        $catid=$_GET['catid'];
   
        $stmt2=$con->prepare("SELECT * from categories where ID=?");
        $stmt2->execute(array($catid));
        $catname=$stmt2->fetch();
        echo "<h2 class='text-center'>". $catname['Name']  ."</h2>";
    
    $stmt=$con->prepare("SELECT * from items WHERE itemcatid=?");
   $stmt->execute(array($catid));
   $itemsells=$stmt->fetchALL();
  
   $count=$stmt->rowCount();
  
     
    

   }



if (isset($_GET['shopid']) && is_numeric($_GET['shopid'])) {
        $shopid=$_GET['shopid'];
          
}
            ?>
	
	
    

        <div class="container">
      <form class="form-horizontal" action="?do=Insertbuy" method="POST">
         <div class="form-group">
              
               <div class="col-sm-10">
                  <select name="name" class="form-control">
                <?php

                  foreach ($itemsells as $itemsell) {
                   echo "<option value='".$itemsell['ItemID']."'>". $itemsell['ItemName'] ."</option>";
                  }
                 

                ?>     
               

                  </select>
           </div>
           <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">الاسم</label>
        </div>   



        
        <div class="form-group">
             
               <div class="col-sm-10">
                  <input type="hidden" name="category" value="<?php echo $catid?>">
                   <input type="hidden" name="shop" value="<?php echo $shopid?>">
                    <input type="text" name="num" class="form-control col-sm-10" id="inputEmail3" placeholder = "العدد" autocomplete= "off">
                 </div>
            <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">العدد</label>
        </div>   


     
         <div class="form-group">
              
               <div class="col-sm-10">
                    <input type="text" name="Price" class="form-control col-sm-10" id="inputEmail3" placeholder = "السعر" autocomplete= "off" >
                 </div>
            <label style="width: 6%;" for="inputEmail3" class="col-sm-2 control-label">السعر</label>
               </div>
               <div class="form-group">
           
          <div class="col-sm-offset-2 col-sm-4">
             <button style="display: inline-block;width: 60%;" type="submit" class="btn btn-default btn btn-primary">بيع</button>
         </div>
          
         </div>

	<?php break;



         case 'Insertbuy':
  
         	
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        echo "<div class='container'>";
        $name      =$_POST['name'];
        $num       =$_POST['num'];
        $price     =$_POST['Price'];
        $category  =$_POST['category'];
        $shop      =$_POST['shop'];
   
          $stmt0=$con->prepare("SELECT * FROM items where ItemID=?");
           $stmt0->execute(array($name));
           $itemname1=$stmt0->fetch();
            


   $formerrors=array();

    if(empty($name))   {$formerrors[]= "<div class='alert alert-danger'>يجب ان تختار اسم الجهاز</div>";}
    if(empty($num)|| $num<=0 || $num>$itemname1['ItemNumber'])  {$formerrors[]= "<div class='alert alert-danger'>لايقل العدد عن صفر ولا يترك فارغا و لاا يجب ان يكون العددالمباع اكثر الموجود   </div>";} 
    if(empty($price)||$price<=0) {$formerrors[]= "<div class='alert alert-danger'>لايقل السعر عن صفر ولا يترك فارغا</div>";} 
      
      
      if(!empty($formerrors)){
        foreach ($formerrors as $error) {
          echo $error;
        header("refresh:3;url=?do=Add");
      }}
 

        $check2 =checkall2('sell_itemid','sell_shopid','sells',$name,$shop);

      
          if (empty($formerrors)) {
            if ($check2==0) {
              
            
            
       
           $stmt7=$con->prepare("SELECT * FROM items where ItemID=?");
           $stmt7->execute(array($name));
           $itemname=$stmt7->fetch();
      
         $stmt=$con->prepare("INSERT INTO sells (SellName,sellNum,sellprice,selltotalprice,sell_itemid,sell_catid,sell_shopid,sell_gain,selldate)values(:zname,:znum,:zprice,:ztotprice,:zsellitemid,:zcat,:zshop,:zgain,now())");
          $stmt->execute(array(

           'zname'=>$itemname['ItemName'],
            'znum'=> $num,
            'zprice'=>$price ,
            'ztotprice'=>$num *$price ,
             'zsellitemid'=>$name, 
             'zcat'=>$category ,
              'zshop'=>$shop,
              'zgain'=>($price-$itemname['Itemprice'])*$num,
               
          ));
      

          if ($stmt) {
              echo "<div class='container'>";
               echo "<div class='alert alert-success'>";
               echo $stmt->rowCount(). "تم البيع بنجاح";

                echo "</div>";
              
              echo"</div>";
             header("refresh:1;url=?do=Manage&shopid=$shop");
          }else{
            echo"no row";
          }
       
             }else{
     
     
      
           $stmt7=$con->prepare("SELECT * FROM items where ItemID=?");
           $stmt7->execute(array($name));
           $itemname=$stmt7->fetch();

     
        $stmt5=$con->prepare("SELECT * from sells where sell_itemid=?");
        $stmt5->execute(array($name));
        $all2=$stmt5->fetch();
         
         $stmt6=$con->prepare("UPDATE sells SET sellNum=?,sellprice=?,selltotalprice=?,sell_gain=? where sell_itemid=?");
          $stmt6->execute(array($all2['sellNum']+$num,$all2['sellprice']+$price,$all2['selltotalprice']+($num*$price),$all2['sell_gain']+($price-$itemname['Itemprice']),
          $name
       
        ));

              
             

                 if ($stmt6) {
              echo "<div class='container'>";
               echo "<div class='alert alert-success'>";
               echo $stmt6->rowCount(). "تم البيع بنجاح";

                echo "</div>";
              
              echo"</div>";
              header("refresh:.5;url=?do=Manage&shopid=$shop");
             
           
           }
      
         $stmt8=$con->prepare("SELECT * from items where ItemID=?");
         $stmt8->execute(array($name));
         $all3=$stmt8->fetch();
        
         $stmt3=$con->prepare("UPDATE items SET ItemNumber=?,ItemTotalprice=? WHERE ItemID=?");
       $stmt3->execute(array($all3['ItemNumber']-$num,$all3['Itemprice']*($all3['ItemNumber']-$num),$name));
     
           
       }

  }

}

   echo "</div>";
         	  
         	 
         	break;



   case 'Manage':

        if (isset($_GET['shopid'])&& is_numeric($_GET['shopid'])) {
           $shopid=$_GET['shopid'];


       ?>
    

         
     <div class="container">
      <h1 style="text-align: center;">التصنيفات</h1>
      <div class="table-responsive">
      <table class="main-table text-center table table-bordered">
          <tr>
          	  <td>الاسم</td>
              <td>التحكم</td>
          </tr>	
         



            <?php
               	  
               $stmt=$con->prepare("SELECT categories.*,shopcat.*,shop.* from categories

                 join shopcat on shopcat.shopcat_catid=categories.ID
                 join shop on shop.ShopID=shopcat.shopcat_shopid
                 
                where ShopID=?");
                 
                $stmt->execute(array($shopid));
                $cats=$stmt->fetchALL();
                   
                   foreach ($cats as $cat) {
                   
                   
               	  echo "<tr>";
                   echo "<td>";
                   echo $cat['Name'];
                   echo "</td>";
                       echo "<td>

                      <a href='?do=Manageitem&shopid=".$cat['ShopID']."&catid=".$cat['ID']."' class='btn btn-primary'>عرض الاجهازة</a>
                    
                      
                         <a href='?do=Managesells&shopid=".$cat['ShopID']."&catid=".$cat['ID']."' class='btn btn-primary'>عرض المبيعات</a>
                      
                       <a href='?do=sell&shopid=".$cat['ShopID']."&catid=".$cat['ID']." ' class='btn btn-primary'>بيع</a>
                       </td>";
               	 

                    }
               	  echo "</tr>";
           
                ?>
      </table>
      </div>
  
 
<!-- <a href='?do=Add&shopid=<?php echo $shopid;?>' class="btn btn-primary"> اضافة نوع جديد</a> -->
<a href='categories.php?do=Add&shopid=<?php echo $shopid;?>' class="btn btn-primary"> اضافة  تصنيف جديد</a>
   <?php if (isset($_SESSION['admin'])) { ?>
<a href='categories.php?do=Manage&shopid=<?php echo $shopid;?>' class="btn btn-primary"> التحكم في التصنيفات</a>
<?php }?>
</div>


  <?php 	

}
  break;

  
case 'Manageitem':?>
	    




         <div class="container">
      <h1 style="text-align: center;">
      	 <?php
       if (isset($_GET['shopid']) && is_numeric($_GET['shopid'])) {
        $shopid=$_GET['shopid'];
   
      if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
        $catid=$_GET['catid'];
   
      
         

  $stmt=$con->prepare("SELECT * FROM categories WHERE ID=?");
   $stmt->execute(array($catid));
   $row=$stmt->fetch();
    echo"<h2 class='text-center'>" .$row['Name']."</h2>";
   $count=$stmt->rowCount();
    
     


   }}


         ?>

    
      
   <input type="hidden" name="cat" value="<?php echo $catid?>">
     <p id="p"></p>
 
   
      </h1>
      <div class="table-responsive">
      <table class="main-table text-center table table-bordered" id="tbl">
          <tr id="t">
          	  <td>الاسم</td>
              <td>العدد</td>
             
              <td>السعر الكلي</td>
              
              <td>تاريخ الاضافة</td>
              <td>التحكم</td>
          </tr>	
          
           
            <?php
               	  

                  
                $serch=$_REQUEST['N'];
        
              
                
               
                $stmt4=$con->prepare("SELECT * FROM items where ItemName=? and itemcatid=?");
                  $stmt4->execute(array($serch,$catid));
                $items=$stmt4->fetchALL();
                 

                 
                  $stmt4=$con->prepare("SELECT * FROM items where itemcatid=?");
                  $stmt4->execute(array($catid));
                  $items=$stmt4->fetchALL();
                  
                   foreach ($items as $item) {
                     
                          echo "<tr>";
                  
                       echo "<td>".$item['ItemName']."</td>";
                       echo "<td>" .$item['ItemNumber'] ."</td>";
                       
                        echo "<td>".$item['ItemTotalprice']."</td>";
                        
                        echo "<td>" .$item['itemdate'] ."</td>";
                        echo "<td>

                      <a href='?do=Edit&itemid=".$item['ItemID']."&shopid=$shopid' class='btn btn-primary'>تعديل</a>
                      <a href='?do=Delete&itemid=".$item['ItemID']."&shopid=$shopid' class='btn btn-danger'>حذف</a>
                       </td>";
                  echo "</tr>";
                 
                  $devicstotal+=$item['ItemNumber'] ;
                   $pricetotal+=$item['ItemTotalprice'] ;
                   }

                 
               
               
           
                ?>
      </table>
      </div>




<a href='?do=Add&shopid=<?php echo $shopid;?>' class="btn btn-primary"> اضافة نوع جديد</a>

</div>


 



         <div class="container">
      <h1 style="text-align: center;">الاجمالي</h1>
      <div class="table-responsive">
      <table class="main-table text-center table table-bordered">
          <tr>
          	  <td>اجمالي عدد الاجهزه المباعه</td>
              <td>اجمالي المبلغ المباع به</td>
          </tr>	

           <?php


            
           
                        

                      
                          echo "<tr>";
                  
                       echo "<td>".$devicstotal."</td>";
                       echo "<td>" .$pricetotal ."</td>"; 
                    
                    echo "</tr>";

          
       ?>
<table>



	<?php break;


case 'Managesells':
	
  if (isset($_SESSION['admin'])) {
    
  
     if (isset($_GET['shopid']) && is_numeric($_GET['shopid'])) {
        $shopid=$_GET['shopid'];

    if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
        $catid=$_GET['catid'];
   

    $stmt=$con->prepare("SELECT * FROM categories WHERE ID=?");
   $stmt->execute(array($catid));
   $row=$stmt->fetch();
    echo"<h2 class='text-center'>" .$row['Name']."</h2>";
   $count=$stmt->rowCount();
    
     }

     
       $stmt1=$con->prepare("SELECT * from sells where sell_catid=? and sell_shopid=?");
       $stmt1->execute(array($catid,$shopid));
       $fetchsells=$stmt1->fetchALL();

    }
     ?>

         <div class="container">
      <h1 style="text-align: center;">المبيعات</h1>
      <div class="table-responsive">
      <table class="main-table text-center table table-bordered">
          <tr>
          	  <td>الاسم</td>
              <td>العدد المباع</td>
              <td>السعر المباع به</td>
             <td>المكسب</td>
              <td>تاريخ البيع</td>
             
             <td>التحكم</td>
          </tr>	
        
            <?php

            foreach ($fetchsells as $fetchsell) {
             
            
               	  echo "<tr>";
                      echo "<td>".$fetchsell['sellName']."</td>";
                      echo "<td>".$fetchsell['sellNum']."</td>";
                      echo "<td>".$fetchsell['selltotalprice']."</td>";
                      echo "<td>".$fetchsell['sell_gain']."</td>";
                      echo "<td>".$fetchsell['selldate']."</td>";
                      // echo "<td>".$fetchsell['fail']."</td>";
                       echo "<td>
                       <a href='?do=restsells&itemid=".$fetchsell['sell_itemid']."&shopid=$shopid' class='btn btn-primary'>تصفير</a>   </td>";
               	
                  echo "</tr>";
               
                 
               $pricetotal+=$fetchsell['selltotalprice'];
               $devicstotal+=$fetchsell['sellNum'];
               $gain+= $fetchsell['sell_gain'];
               }
           
                ?>
              
      </table>
      </div>



     <div class="container">
      <h1 style="text-align: center;">الاجمالي</h1>
      <div class="table-responsive">
      <table class="main-table text-center table table-bordered">
          <tr>
          	  <td>اجمالي عدد الاجهزه المباعه</td>
              <td>اجمالي المبلغ المباع به</td>
              <td>اجمالي الربح</td>
          </tr>	


           <tr>
          	  <td><?php echo $devicstotal;?></td>
              <td><?php echo $pricetotal;?></td>
              <td><?php echo $gain;?></td>
          </tr>	
    
<table>






<?php	

}else{echo "sorry your not admin";}

break;

case 'restsells':
  if (isset($_GET['shopid']) && is_numeric($_GET['shopid'])) {
        $shopid=$_GET['shopid'];
}
    if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
        $catid=$_GET['catid'];}
   
    if (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) {
        $itemid=$_GET['itemid'];}
   

           $stmt6=$con->prepare("UPDATE sells SET sellNum=?,sellprice=?,selltotalprice=?,sell_gain=?,selldate=? where sell_itemid=?");
          $stmt6->execute(array(0,0,0,0,0,$itemid));
          
        if ($stmt6) {
              echo"<div class='alert alert-success'>" ."تم عمل ريست بنجاح"."</div>";

            }
  break;



}



include($tpl.'footer.php');

}else{echo "you not regist";}




?>
