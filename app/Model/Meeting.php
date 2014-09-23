<?php
// app/Model/Meeting.php
class Meeting extends AppModel{
	var $name = 'Meeting';
	//var $uses = array('Meeting','Group');
	var $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'dependent' => true
			));
	var $hasMany = array(
		'Content' => array(
			'className' => 'Content',
			'dependent' => true				
		));
	var $validate = array(
		'date' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message'=> 'Porfavor, selecciona una fecha valida'
			)
	
		),
		'title' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message'=> 'Porfavor, introduzca el título de la reunión'
			)
	
		));

public function isManager($opt_id, $user) {
	if($opt_id == $user) return true;
	return false;	
}
}