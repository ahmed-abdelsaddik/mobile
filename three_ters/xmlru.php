<?php





// $tallarr=[];
// $weightarr=[];
// $speedarr=[];
// $sportf=[];

// $tallf=explode('-',$x->fit[0]->tall);
// $tallf=range($tallf[0], $tallf[1]);


// $weightf=explode('-',$x->fit[0]->weight);
// $weightf=range($weightf[0], $weightf[1]);


// $speedf=explode('-',$x->fit[0]->speed);
// $speedf=range($speedf[0], $speedf[1]);

// $sportf=$x->fit[0]->sport; 


foreach ($x->children() as $child) {
	
	
    
	$tallf=explode('-',$child->tall);
	$tallf=range($tallf[0], $tallf[1]);
    
	$tallarr[]=$tallf;

	$weightf=explode('-',$child->weight);
    $weightf=range($weightf[0], $weightf[1]);
    
    $weightarr[]=$weightf;
    
    $speedf=explode('-',$child->speed);
    $speedf=range($speedf[0], $speedf[1]);
    $speedarr[]=$speedf; 
   
    $sportf=$child->sport;

	
}

$tallarr;
$weightarr;
$speedarr;
$sportf;







?>