<?php
// app/Controller/UsersController.php
class UsersController extends AppController {
var $name = 'Users';
var $helpers = array('Html','Form','Time');
var $uses = array('User','Group','Team');

public function style($id=null,$style=null) { // Entrada User.id, style['default','orange','blue']
	$this->User->id = $id;
	if (!$this->User->exists()) {
			throw new NotFoundException(__('El usuario no existe'));
	}
	$_SESSION['style']=$style;// Variable $_SESSION['style'] para actualizar el estilo en el momento;
	$this->User->Profile->id = $id;
	$this->User->Profile->saveField('style',$style,true); // Actualiza la base de datos del User->Profile['style']
	$this->redirect($this->referer());
}
public function index(){
	$user = $this->Auth->user();
	if($user['role']=='admin'){// Si es admin lista todos los usuarios
		$this->User->recursive = 1;
		$this->set('users', $this->User->find('all',array(
			'fields' => array('id','username','role','created','modified','email'),
			'order'=>array('User.username'=>'ASC'
		))));	
	}elseif($user['role']=='member'){
		$this->User->recursive = 1;
		$this->set('user', $this->User->findById($user['id']));
	}else{
		$this->redirect(array('action' => 'login'),null,true);
	}
}
public function view($id=null){
	$this->User->recursive = 2; // Añado recursividad 2 para poder acceder a los Grupos desde el Usuario
	$this->set('user', $this->User->find('first',array(
		'fields' => array('id','username', 'role', 'modified','created','email'),
		'conditions' => array('User.id' => $id))));
}
public function edit($id=null){
	$this->User->id = $id;
	if (!$this->User->exists()) {
		throw new NotFoundException(__('El usuario no existe'));
	}
	if ($this->request->is('post') || $this->request->is('put')) {
		$olduserdata = $this->User->findById($id);
		
		if ($this->User->save($this->request->data)) {
			$this->Session->setFlash(__('El usuario <b>'.$olduserdata['User']['username'].'</b> ha sido modificado'));
			$this->redirect(array('action' => 'view',$id),null,true);
		} else {
			$this->Session->setFlash(__('El usuario no ha sido modificado. Porfavor, intentelo de nuevo.'));
		}
	} else {
		$this->User->recursive=2;
		$this->request->data = $this->User->read(null, $id);
		unset($this->request->data['User']['password']);
	}
	$this->User->recursive=2;
	$this->set('user',$this->User->findById($id));
}
function add(){  
	if ($this->request->is('post')){
		if(!empty($this->request->data)){
			$this->User->create();
			$this->User->Profile->create(); // Crea el perfil del usuario
			$user = $this->User->save($this->request->data);// If the user was saved, Now we add this information to the data
        	// and save the Profile.
        	   if (!empty($user)) {
            // The ID of the newly created user has been set as $this->User->id.
            $this->request->data['Profile']['user_id'] = $this->User->id;
            // Because our User hasOne Profile, we can access the Profile model through the User model:
            if($this->User->Profile->save($this->request->data)){
            	$this->Session->setFlash(__('El usuario <b>'.$this->request->data['User']['username'].'</b>, ha sido guardado'));
					$this->redirect(array('controller'=>'users','action' => 'index'));
            } else {
					$this->Session->setFlash(__('El usuario no ha sido guardado. Porfavor, intentelo de nuevo.'));
				}
         }
		}
	}
}

function delete($id = null) { // Entrada User.id
	if($id==1){ // No se puede eliminar el usuario 'admin'
			$this->Session->setFlash(__('El usuario <b>admin</b> no puede ser eliminado'));
			$this->redirect($this->referer());
	}
	if($this->request->is('post')){ // Para eliminar siempre metodo POST para proteccion CSRF
		if($id!=null){ // Si pasa parametros en la url
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('El usuario no existe'));
			}	
			$user = $this->User->findById($id);
			if ($this->User->delete($id)) {
				$this->Group->updateAll(array('Group.user_id' => NULL),array('Group.user_id' => $id)); // Actualiza la base de datos Group.user_id = NULL donde el usuario es responsable
				if(!($this->User->Team->deleteAll(array('Team.user_id'=>$id)))){ // Elimina el registro de los equipos que pertenece el usuario
					$this->Session->setFlash(__('Error al eliminar los grupos que el usuario <b>'.$user['User']['username'].'</b> pertenece'));	
				}else{  
					$this->Session->setFlash(__('El usuario <b>'.$user['User']['username'].'</b> ha sido eliminado'));
					$this->redirect(array('action' => 'index'));
				}	
			}else{
				$this->Session->setFlash(__('El usuario no ha sido dado de baja/eliminado'));
				$this->redirect(array('action' => 'index'));
			}
		}/*else{// Para eliminar multiples usuarios de una vez con checkboxes
			$flag = false;
			if(!empty($this->request->data['User']['id'])){ // Si se ha elegido algún checkbox para eliminar algún usuario
				foreach($this->request->data['User']['id'] as $user){ // Bucle para eliminar los usuarios seleccionados
					if($this->User->delete($user)){// Elimina el usuario de la base de datos de forma recursiva
						$this->Group->updateAll(array('Group.user_id' => NULL),array('Group.user_id' => $user)); // Actualiza la base de datos Group.user_id = NULL donde el usuario es responsable
						$this->User->Team->deleteAll(array('Team.user_id'=>$user)); // Elimina el registro de los equipos que pertenece el usuario
					}else{
						$flag=true;//Ha ocurrido un error				
					} 		
				}
			}else{ 
				$this->Session->setFlash(__('Elige algún <b>usuario</b> a eliminar'));
				$this->redirect($this->referer());
			}
			if($flag==false){
				$this->Session->setFlash(__('Se ha eliminado el/los usuarios'));
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('Ha ocurrido algún error, por favor intentelo de nuevo'));
				$this->redirect($this->referer());
			}
		}*/
	}
}
function beforeFilter() {
	parent::beforeFilter();
   $this->Auth->allow('logout'); // Letting users logout 
}
function isAuthorized($user) {
	// Check if user 'role' => 'admin'. All privileges
	if(parent::isAuthorized($user)){
		return true;
	}else{
		// Permite que los usuarios reqistrados puedan ver y editarse a si mismos
		if (in_array($this->action, array('view','edit','style'))) {
			$opt_id = $this->request->params['pass'][0];
			if ($this->User->isOwnedBy($opt_id, $user['id'])) {
				return true;
			}else{
				$this->Session->setFlash(__('No te pertenece este Usuario'));
				return false;
			}
		}
	}
}
public function login() {
	if ($this->request->is('post')) {
		if ($this->Auth->login()) {
			$this->User->id = $this->Auth->user('id'); // target correct record
			$this->User->saveField('last_login',date(DATE_ATOM)); // save login time
			$_SESSION['style'] = $this->Auth->user('Profile.style'); // Aplica el estilo
			$this->redirect($this->Auth->loginRedirect);
			
		} else {
			$this->Session->setFlash(__('Usuario o contraseña no válida, inténtelo de nuevo'));
		}
	}
}
function logout() {
    $this->redirect($this->Auth->logout());
}
}