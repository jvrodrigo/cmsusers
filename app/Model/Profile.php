<?php
// app/Model/Profile.php
class Profile extends AppModel{
	var $name = 'Profile';
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		));
}