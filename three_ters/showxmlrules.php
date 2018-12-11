<?php
$x=simplexml_load_file("xml/m.xml");

include("xmlru.php");


$sportf=$x->fit[0]->sport; 
$tallf=$x->fit[0]->tall;
$weightf=$x->fit[0]->weight;
$speedf=$x->fit[0]->speed;

    echo"<table border='2px'>";
   	echo "<tr>";
   	echo"<td>tall</td>";
   	echo"<td>weight</td>";
   	echo"<td>speed</td>";
   	echo"<td>sport</td>";
    echo"<td>control</td>";
    
     
   echo "</tr>"; 

       echo "<tr>";
     	
     	echo "<td>".$tallf."</td>";
     	echo "<td>".$weightf."</td>";
        echo "<td>".$speedf."</td>";
     	echo "<td>".$sportf."</td>";
     	echo "<td>"."<button type='button'><a href='editxml.php'>edit</a></button>"."</td>";
     	
     	echo "</tr>";
     	echo "</table>";


     	echo"<a  href='views/create.php'>back</a>";
