<?php

function gettitle(){

	 global $pagetitle;
	if (isset($pagetitle)) {
		echo $pagetitle;
	}else{echo "default";}
}



function checkall($slect,$from,$value)
{
 
	 global $con;
$satment=$con->prepare("SELECT $slect FROM $from WHERE $slect=?");
$satment->execute(array($value));
$count=$satment->rowCount();
return  $count;
}


function checkall2($slect,$shop,$from,$value1,$value2)
{
 
	 global $con;
$satment=$con->prepare("SELECT $slect,$shop FROM $from WHERE $slect=? and $shop=?");
$satment->execute(array($value1,$value2));
$count=$satment->rowCount();
return  $count;
}