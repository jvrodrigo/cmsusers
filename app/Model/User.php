<?php
// app/Model/User.php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel{
	var $name = 'User';
	var $displayField = 'username';

	var $hasMany = array(
		'Team' => array(
			'className' => 'Team',
			'dependent' => 'true'
		));
	var $hasOne = array(
        'Profile' => array(
				'className' => 'Profile',
				'dependent' => true
	));
	var $validate = array(
	'username' => array(
		'required' => array(
			'rule' => 'alphaNumeric',
			'required' => true,
			'message'=>'No puedes utilizar símbolos'
		),
		'unique' => array(
			'rule' => 'isUnique',
			'message' => 'El nombre de usuario ya existe'
		)
	),
	'password' => array(
		'required'=>array(
		'rule' => 'notEmpty',
		'message'=>'Necesitas una contraseña'
		),
		'Match passwords' => array(
			'rule'=> 'matchPasswords',
			'message' => 'Las contraseñas no coinciden'
		)
	),
	/*'role' => array(
		'valid' => array(
			'rule' => array('inList',array('admin', 'manager','member')),
			'message' => 'Por favor introduce un rol valido',
			'allowEmpty' => false
			)
	),*/
	'password_confirmation'=>array(
			'required' => array(
				'rule' => 'notEmpty',
				'message'=> 'Porfavor confirma tu contraseña'
			)
	),
	'email' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message'=> 'Porfavor, introduce un correo electrónico válido'
			)
	));
public function matchPasswords($data){
	if($data['password']== $this->data['User']['password_confirmation']){
		return true;
	}
	$this->invalidate('password_confirmation','Las contraseñas no coinciden');
	return false;
}
public function beforeSave($options = array()) {
    if (isset($this->data['User']['password'])) {
        $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
    }
    return true;
}
public function isOwnedBy($opt_id, $user) {
    return $this->field('id', array('id' => $opt_id, 'id' => $user)) === $opt_id;
}
}