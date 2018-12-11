<?php
$x=simplexml_load_file("xml/m.xml");


for ($i=0; $i < 3; $i++) 
{ 
	
	 
	
	if($i==0)
	{
      $tall.$i=explode('-',$x->fit[$i]->tall);
      $tallf.$i=range($tallf.$i[0], $tallf.$i[1]);
	  
	}
	
	if($i==1)
	{
      $tall.$i=explode('-',$x->fit[$i]->tall);
      $tallf.$i=range($tallf.$i[0], $tallf.$i[1]);
	  
	}

	
	if($i==2)
	{
      $tall.$i=explode('-',$x->fit[$i]->tall);
      $tallf.$i=range($tallf.$i[0], $tallf.$i[1]);
	  
	}
    
	
}



foreach($x->children() as $books) { 
    echo $books->tall;
    echo "<br>"; 
} 