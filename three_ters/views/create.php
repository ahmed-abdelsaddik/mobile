
<style>
  table
  {
    background: #ccc;
    color: red;
    border:1px solid blue;
    text-align: center;
  }

table td
{
  border: 1px solid blue;
  margin: 0;
}

table td button

{
   background: green;
   
}

</style>



<?php
 session_start();
if (isset($_SESSION['admin'])) {


 include("../connect.php");
 $x=simplexml_load_file("../xml/m.xml");
 include("../xmlru.php");
  

   $stmt=$con->prepare("SELECT user_info.*, members.* FROM user_info
    join members on members.memberid=user_info.userid");
   $stmt->execute();
   $users=$stmt->fetchAll();
   
   

    echo"<table>";
   	echo "<tr>";
    echo"<td>name</td>";
   	echo"<td>address</td>";
   	echo"<td>phone</td>";
   	echo"<td>tall</td>";
   	echo"<td>weight</td>";
   	echo"<td>speed</td>";
   	 echo"<td>sport</td>";
    echo"<td>control</td>";
    
     
   echo "</tr>"; 
   

     foreach ($users as $user) 
     {
       echo "<tr>";
     	echo "<td>".$user['username']."</td>";
     	echo "<td>".$user['address']."</td>";
     	echo "<td>".$user['phone']."</td>";
      echo "<td>".$user['tall']."</td>";
     	echo "<td>".$user['weight']."</td>";
     	echo "<td>".$user['speed']."</td>";
      
if (in_array($user['tall'],$tallarr)
      
   and  
  in_array($user['weight'],$weightarr) 
  and in_array($user['speed'],$speed)
)

      {
         
        echo "<td>".$sportf."</td>";
      }else{echo "<td>nosport avilable</td>";}

      

      // elseif($user['tall']==$tallnof and $user['weight']==$weightnof and $user['speed']==$speednof){echo "<td>".$sportnof."</td>";}
      // elseif($user['tall']==$tallmf and $user['weight']==$weightmf and $user['speed']==$speedmf){
          
      //     echo "<td>".$sportmf."</td>";
      // }else{echo "<td>nosport avilable</td>";}


       echo "<td>";
           echo "<button><a href='edit.php?userid=".$user['userid']."'>edit</a></button>";
           echo "<span>||</span>";
           echo "<span>||</span>";
           echo "<button><a href='delete.php?userid=".$user['userid']."'>delete</a></button>";
          
           echo "</td>";
     
     echo "</tr>";
     }

    


   echo"</table>";
 
 ?>
 <div><a href="add.php">add member</a></div>
 <div><a href="../xml/uixml.php">add rules</a></div>
 <div><a href="../maininterface.php">main page</a></div>

 <?php }else{header("location:../main.php");}


// foreach($xml->children() as $books) { 
//     echo $books->title['lang'];
//     echo "<br>"; 
// } 
?> 
