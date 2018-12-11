<?php


if(isset($_POST['submit'])){


$x=simplexml_load_file("xml/m.xml");

include("xmlru.php");
if (in_array($_POST['tall'],$tallf) and in_array($_POST['weight'],$weightf) and in_array($_POST['speed'],$speedf)) 
{
	echo "<h1 style='color:green;text-align:center'>".$sportf."</h1>";
}else {echo "<h1 style='color:red;text-align:center'>"."no sport"."</h1>";}


}

// if($_POST['tall']==$tallmf and $_POST['weight']==$weightmf and $_POST['speed']==$speedmf){
//      echo "<div>".$sportmf."</div>";
//     }        

//     elseif($_POST['tall']==$tallf and $_POST['weight']==$weightf and $_POST['speed']==$speedf){
//      echo "<div>".$sportf."</div>";
//     }   

//     elseif($_POST['tall']==$tallnof and $_POST['weight']==$weightnof and $_POST['speed']==$speednof){
//      echo "<div>".$sportnof."</div>";
//     } else{echo "no sport ";}
// }
?>

<form action="" method="POST">
 	<input type="text" name="tall" placeholder="tall">
 	<div style="height: 10px"> </div>
 	<input type="text" name="weight" placeholder="weight">
 	<div style="height: 10px"></div>
 	<input type="speed" name="speed" placeholder="speed">
 	<div style="height: 10px"> </div>
 	<input type="submit" name="submit" value="save"> 
 </form>
 