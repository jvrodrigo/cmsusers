<?php
class FormatoHelper extends AppHelper{

function acortarFecha($fecha){
return substr($fecha,0,4).'-'.substr($fecha,5,2).'-'.substr($fecha,8,2);
}
function acortarFechaMeeting($fecha){
return substr($fecha,8,2).'-'.substr($fecha,5,2).'-'.substr($fecha,0,4).' '.substr($fecha,11,2).'hrs:'.substr($fecha,14,2).'min';
}
function modified($datecreated,$datemodified){
	$dcreated = strtotime($datecreated);
	$dmodified = strtotime($datemodified);

	if($dcreated==$dmodified){
		return 'Nunca';
	}else{
		return $this->acortarFecha($datemodified);
	}		
}
function acortarString10($str){
	if(strlen($str)>20){
		return nl2br(htmlentities(substr($str, 0, strpos($str, ' ', 10)).' ...'));
	} else {
		return nl2br(htmlentities($str));
	}
}
function acortarString20($str){
	if(strlen($str)>30){
		return nl2br(htmlentities(substr($str, 0, strpos($str, ' ', 20)).' ...'));
	} else {
		return nl2br(htmlentities($str));
	}
}
function acortarUsername($str){
	if(strlen($str)>14){
		return nl2br(htmlentities(substr($str,0,13))).'...';
	} else {
		return nl2br(htmlentities($str));
	}
}
function acortarEmail($str){
	if(strlen($str)>10){
		return nl2br(htmlentities(substr($str,0,7))).'...';
	} else {
		return nl2br(htmlentities($str));
	}
}
}