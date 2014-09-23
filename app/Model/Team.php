<?php
// app/Model/Team.php
class Team extends AppModel{
	var $name = 'Team';
	var $belongsTo = array(
        'User' => array(
				'className' => 'User'
			),
			'Group' => array(
				'className' => 'Group'
			));
	var $validate = array(
		'group_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message'=> 'Porfavor, selecciona un grupo'
			)
	
		),
		'user_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message'=> 'Porfavor, selecciona un usuario'
			)
	
		));
}