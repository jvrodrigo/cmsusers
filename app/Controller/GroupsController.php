<?php
// app/Controller/GroupsController.php
class GroupsController extends AppController {
var $name = 'Groups';
var $uses = array('Group','Team','User');
public function index() {
	$user = $this->Auth->user();
	// Si es admin lista todos los grupos
	if($user['role']=='admin'){
		$this->set('groups', $this->Group->find('all',array('order'=>array('group.name'=>'ASC'))));
	}
	// Si es member lista los grupos a los que pertenece Team.group_id
	elseif($user['role'] == 'member') {
		$this->Team->recursive = 2;
		$groups = $this->Team->find('all',array(
			'conditions' => array(
				'Team.user_id' => $user['id']
			)));
		$this->set('groups',$groups);
	}else{
		$this->redirect(array('controller'=>'users','action' => 'login'),null,true);
	}
	
}
public function view($id=null){
	$this->Group->recursive = 2; // Añado recursividad 2 para poder acceder a los Usuarios y a los contenidos desde el Grupo
	$this->set('group', $this->Group->findById($id));
	$this->Group->Meeting->recursive = 1;
	$meetings = $this->Group->Meeting->find('all',array(
			'conditions'=> array(
				'Meeting.group_id' => $id
				),
			'order'=> array(
				'Meeting.date DESC')));
	$this->set('meetings',$meetings);
}
function add(){  
	if ($this->request->is('post')){
		$this->Group->create();	
		if ($this->Group->save($this->request->data)) {
			$this->Session->setFlash(__('El grupo <b>'.htmlentities($this->request->data['Group']['name']).'</b>, ha sido guardado'));
			$this->redirect(array('controller'=>'groups','action' => 'index'));
		} else {
			$this->Session->setFlash(__('El grupo <b>'.htmlentities($this->request->data['Group']['name']).'</b> no ha sido guardado. Porfavor, intentelo de nuevo.'));
		}
	}
}
public function edit($id=null){
	$this->Group->id = $id;
	if (!$this->Group->exists()) {
		throw new NotFoundException(__('El grupo no existe'));
	}
	if ($this->request->is('post') || $this->request->is('put')) {
		$oldname = $this->Group->findById($id);
		if ($this->Group->save($this->request->data)) {
			$this->Session->setFlash(__('El grupo <b>'.htmlentities($oldname['Group']['name']).'</b> ha sido modificado'));
			$this->redirect(array('action' => 'view',$id),null,true);
		} else {
			$this->Session->setFlash(__('El grupo no ha sido modificado. Porfavor, intentelo de nuevo.'));
		}
	} else {
		$this->request->data = $this->Group->read(null, $id);
	}
	$this->set('group',$this->Group->findById($id));
}
function delete($id = null) {
	if($this->request->is('post')){ // Si el método es post. Se selecciona los checkbox para eliminar los grupos
		if($id!=null){
			$this->Group->id = $id;
			if (!$this->Group->exists()) {
				throw new NotFoundException(__('El grupo no existe'));
			}
			$group = $this->Group->findById($id);
			$this->Group->Meeting->Content->recursive = -1;
			foreach($group['Meeting'] as $meeting){
				$content_path = $this->Group->Meeting->Content->findAllByMeetingId($meeting['id']);
				foreach($content_path as $path){ // Elimina todos los contenidos(APP/Data/contents/path/file) del disco
					$this->Group->Meeting->Content->eliminarDir(APP. 'Data'.DS.'contents'.DS.$path['Content']['id']);
				}
			}
			if ($this->Group->delete($id,true)) {		// Elimina en cascada el Grupo, Team, Meeting y Content que pertenece al grupo
				$this->Session->setFlash(__('El grupo <b>'.htmlentities($group['Group']['name']).'</b> ha sido eliminado'));
				$this->redirect(array('action' => 'index'));		
			}else{
				$this->Session->setFlash(__('El grupo no ha sido eliminado, por favor intentelo de nuevo'));
				$this->redirect(array('action' => 'index'));
			}
		}/*else{// Para eliminar multiples grupos de una vez con checkboxes
			if(empty($this->request->data['Group']['id'])){
				$this->Session->setFlash(__('Selecciona los <b>grupos</b> a eliminar'));
				$this->redirect($this->referer());
			}
			$flag = false; // Var para encontrar algún error
			$logErr = null;// Var para mostrar los errores
			$logOk = null;
			foreach($this->request->data['Group']['id'] as $group_id){ // Por cada casilla seleccionada
				$group = $this->Group->findById($group_id);
				$this->Group->Meeting->Content->recursive = -1;
				foreach($group['Meeting'] as $meeting){// Por cada reunión que tiene el grupo
					$content_path = $this->Group->Meeting->Content->findAllByMeetingId($meeting['id']);// Busca todos los contenidos de la reunión
					foreach($content_path as $path){ // Elimina todos los contenidos(APP/Data/contents/path/file) del disco
						$this->Group->Meeting->Content->eliminarDir(APP. 'Data'.DS.'contents'.DS.$path['Content']['id']);
					}
				}
				if ($this->Group->delete($group_id,true)){ // Elimina en cascada el Grupo, Team, Meeting y Content que pertenece al grupo
					$logOk = $logOk.'<br>'.htmlentities($group['Group']['name']);
				}else{// Si hay algún error -> flag = true
					$flag=true;
					$logErr = $logErr.'<br>'.$group['Group']['name'];
				}
			}
			if($flag==false){ // Si no ha ocurrido ningún error
				$this->Session->setFlash(__('Se han eliminado el/los grupo/s <b>'.$logOk.'</b>'));
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('Ha ocurrido un error, no se han eliminado los grupos <b>'.htmlentities($logErr).'</b>'));
				$this->redirect($this->referer());
			}
		}*/
	}
}
function addManager($group_id=null,$user_id=null) {
	
	if($this->request->is('post')){// Si el metodo es post
		if($group_id!=null && $user_id!=null){ //Si pasamos parametros metodo -> postLink
			// Permite al admin asignar directamente desde Groups view el usuario responsable
			$isBelongs = $this->Team->find('list',array(
				'conditions'=> array(
				'user_id' => $user_id,
				'group_id'=> $group_id
			)));
			if(empty($isBelongs)){
				$this->Session->setFlash(__('Este usuario no pertenece a este grupo'));
				$this->redirect($this->referer());
			}else{
				if($this->Group->updateAll(array('Group.user_id' => $user_id),array('Group.id' => $group_id))){ // Actualiza la base de datos con el id del usuario responsable
					$group = $this->Group->findById($group_id);
					$user = $this->User->findById($user_id);
					$this->Session->setFlash(__('Al grupo <b>'.htmlentities($group['Group']['name']).'</b> se le ha asignado como responsable el usuario <b>'.$user['User']['username'].'</b>'));
					$this->redirect($this->referer());
				}
			}
		}else{ // Seleccion por formulario
			if($this->Group->updateAll(array('Group.user_id' => $this->request->data['Group']['user_id']),array('Group.id' => $this->request->data['Group']['id']))){ // Actualiza la base de datos con el id del usuario responsable)
				$user = $this->User->findById($this->request->data['Group']['user_id']);
				$this->Session->setFlash(__('Al grupo <b>'.htmlentities($this->request->data['Group']['name']).'</b> se le ha asignado como responsable el usuario <b>'.$user['User']['username'].'</b>'));
				$this->redirect(array('action'=>'view',$this->request->data['Group']['id']));
			}else{
				$this->Session->setFlash(__('Ha ocurrido un problema, por favor intentelo de nuevo'));
				$this->redirect(array('action'=>'view',$this->request->data['Group']['id']));
			}				
		}	
	}else{// Metodo get para mostrar los usuarios que pertenecen al grupo
		$this->Group->id = $group_id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('El grupo no existe'));
		}
		// Si el usuario es null pasa a todos los usuarios del grupo a la variable 'users' para elegir el responsable con el método post
		$this->set('group',$this->Group->findById($group_id));
		$team = $this->Team->find('list',
			array(	      // Consulta para listar user_id de los usuarios que pertenecen al grupo
				'fields' => array('Team.user_id'),
				'conditions' => array('Team.group_id'=> $group_id)
			));
		$users = $this->User->find('list',// Consulta para listar User.username de los usuarios que pertenecen al grupo
			array(
				'fields' => array('User.username'),
				'conditions' => array('User.id' => $team)
			));
		$this->set('users',$users);
	}
}
function deleteManager($group_id=null){
	if($this->request->is('post')){
		$group = $this->Group->findById($group_id);
		if($this->Group->updateAll(array('Group.user_id' => NULL),array('Group.id' => $group_id))){ // Actualiza la base de datos con el id del usuario responsable		
			$this->Session->setFlash(__('Al grupo <b>'.htmlentities($group['Group']['name']).'</b> se le ha desasignado como responsable el usuario <b>'.$group['User']['username'].'</b>'));
			$this->redirect($this->referer());
		}
	}
}
function isAuthorized($user){
	if(parent::isAuthorized($user)){
		return true;
	}else{
		// Permite que los usuarios miembros del grupo puedan ver el grupo
		if (in_array($this->action, array('view'))){
			$opt_id = $this->request->params['pass'][0];
			if ($this->Group->isMember($opt_id, $user['id'])) {
				return true;
			}else{
				$this->Session->setFlash(__('No eres miembro de este Grupo'));
				return false;
			}
		}
	}
}
}