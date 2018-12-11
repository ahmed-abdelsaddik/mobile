<?php
  session_start();

if (isset($_SESSION['admin'])) {
?>

 <form action="insert.php" method="POST">
 	<input type="text" name="username" placeholder="username">
 	<div style="height: 10px"></div>
 	<input type="password" name="password" placeholder="password">
 	<div style="height: 10px"></div>
 	<input type="text" name="phone" placeholder="phone">
 	<div style="height: 10px"></div>
 	<input type="text" name="address" placeholder="address">
 	<div style="height: 10px"></div>
 	<input type="text" name="tall" placeholder="tall">
 	<div style="height: 10px"></div>
 	<input type="text" name="weight" placeholder="weight">
 	<div style="height: 10px"></div>
 	<input type="speed" name="speed" placeholder="speed">
 	<div style="height: 10px"></div>
 	<input type="submit" name="submit" value="save"> 
 </form>

<?php }?>