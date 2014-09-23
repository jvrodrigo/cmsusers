<?php 
// app/Model/Group.php
class Group extends AppModel{
	var $name = 'Group';
	var $hasMany = array(
		'Team' => array(
			'className' => 'Team',
			'dependent' => true
		),
		'Meeting' => array(
			'className' => 'Meeting',
			'dependent' => true
		));
	var $belongsTo = array(
		'User'=> array(
			'classname' => 'User'		
	));
	var $validate = array(
	'name' => array(
		'required' => array(
				'rule' => 'notEmpty',
				'message'=> 'Porfavor, introduce un nombre para el grupo'
		),
		'unique' => array(
			'rule' => 'isUnique',
			'message' => 'El nombre del grupo ya existe, elija otro nombre'
		)
	),
	'description'=> array(
		'required' => array(
			'rule' => 'notEmpty',
			'message'=> 'Porfavor, introduce una breve descripción'
		)
	));
	public function isMember($opt_id, $user) { // Entrada Group.id, User.id 
		$this->Team->recursive = 2; // Recursividad para buscar dentro de Group.id->Team.group_id si User.id($user) se encuentra
		$teams = $this->Team->findByGroupId($opt_id);
		$flag = false;// Bandera para indicar se se ha encontrado User.id -> Team.user_id -> Team.group_id -> Group.id 
		if(!empty($teams)){ 
			foreach($teams['Group']['Team'] as $team){
					if($team['user_id'] == $user){
						$flag = true;	// Encontrado			
					}
			}
		}
		return $flag;
}
}
	