<?php

function lang($pharase)
{
 static $lang=array(


 	'message' =>'welcome' ,
 	'admin' =>'admimstration'


 );
 return $lang[$pharase];
}
?>