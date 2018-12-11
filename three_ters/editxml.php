<?php
$x=simplexml_load_file("xml/m.xml");

include("xmlru.php");

$sportf=$x->fit[0]->sport; 
$tallf=$x->fit[0]->tall;

echo $tallf[8];
$weightf=$x->fit[0]->weight;



$speedf=$x->fit[0]->speed;
?>
<form action="xml/test.php" method="POST">
 	<input type="text" name="tall" placeholder="tall" value="<?php echo $tallf ?>"><br>
 	<p></p>
 	<input type="text" name="weight" placeholder="weight" value="<?php echo $weightf ?>"><br>
 	<p></p>
 	<input type="speed" name="speed" placeholder="speed" value="<?php echo $speedf ?>"><br>
 	<p></p>
 	<input type="text" name="sport" placeholder="sport" value="<?php echo $sportf ?>"><br>	 
 	<p></p>
 		<input type="submit" name="submit" value="save"> 
 </form>
<a  href='views/create.php'>back</a>