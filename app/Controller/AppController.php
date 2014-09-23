<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
Configure::write('Session.timeout', '15');// 15 minutos Sesion.timeout 
class AppController extends Controller {
	var $components = array(
	'Session',
	'Security',
	'Auth' => array(
	'loginRedirect' => array('controller' => 'pages', 'action' => 'index'),
	'logoutRedirect' => array('controller' => 'pages', 'action' => 'index'),
	'authError' => 'No estás autorizado para realizar esta acción',
	'authorize' => array('Controller') // Added this line
	));
	
function beforeFilter(){

	$this->Auth->fields = array('username'=>'username','password'=>'password');
	$this->Auth->allow('index','display','publicIndex','publicView','publicDownload');
	$this->set('logged_in',$this->Auth->loggedIn());
	$this->set('current_user', $this->Auth->user());
	$this->Security->csrfExpires = '15 min'; // CSRF protección
	//$this->Security->requireSecure('index');
}
public function isAuthorized($user) {
	// Admin can access every action
	if (isset($user['role']) && $user['role'] === 'admin') {
		return true;
	}
	// Default deny
	return false;
}
}
