<?php
// app/Controller/MeetingsController.php
class MeetingsController extends AppController {
var $name = 'Meetings';
var $uses = array('Group','User','Meeting','Content');

public function view($id=null){
	$this->Meeting->recursive = 2; // Añado recursividad 2 para poder acceder a los Contenidos desde la reunión
	$this->set('meeting', $this->Meeting->findById($id));
}
function add($id = null){ // Entrada Group.id
	$this->Group->id = $id;
	if($this->Group->exists()){
		$this->set('group',$this->Group->findById($id));
	}
	if ($this->request->is('post')){
		$this->Meeting->create();	
		if ($this->Meeting->save($this->request->data)) {
			$this->Session->setFlash(__('La reunión <b>'.htmlentities($this->request->data['Meeting']['title']).'</b>, ha sido guardada'));
			$this->redirect(array('controller'=>'groups','action' => 'view',$this->request->data['Meeting']['group_id']));
		} else {
			$this->Session->setFlash(__('La reunión <b>'.htmlentities($this->request->data['Meeting']['title']).'</b> no ha sido guardada. Porfavor, intentelo de nuevo.'));
		}
	}
}
public function edit($id=null){
	$this->Meeting->id = $id;
	if (!$this->Meeting->exists()) {
		$this->Session->setFlash(__('La reunión no existe'));
	}
	if ($this->request->is('post') || $this->request->is('put')) {
		if ($this->Meeting->save($this->request->data)) {
			$this->Session->setFlash(__('La reunión <b>'.htmlentities($this->request->data['Meeting']['title']).'</b> ha sido modificada'));
			$this->redirect(array('action' => 'view',$id));
		} else {
			$this->Session->setFlash(__('La reunión no ha sido modificada. Porfavor, intentelo de nuevo.'));
		}
	}elseif($this->request->is('get')) {
		$meeting = $this->Meeting->findById($id);
		$this->set('meeting',$meeting);
		$this->request->data = $this->Meeting->read(null, $id);
	}
}
function delete($id = null) {
	if($this->request->is('post')){
		$this->Meeting->id = $id;
		if (!$this->Meeting->exists()) {
			throw new NotFoundException(__('La reunión no existe'));
		}
		$meeting = $this->Meeting->findById($id);
		foreach($meeting['Content'] as $content){ // Elimina las carpetas donde se almacenan los contenidos de la reunión
			$this->Content->eliminarDir(APP . 'Data' . DS . 'contents' .DS. $content['id']);
		}
		if ($this->Meeting->delete($id,true)) {
			$this->Session->setFlash(__('La reunión <b>'.htmlentities($meeting['Meeting']['title']).'</b> ha sido eliminada'));
			$this->redirect(array('controller'=>'groups','action' => 'view',$meeting['Meeting']['group_id']));
		}else{
			$this->Session->setFlash(__('La reunión no ha sido eliminada, por favor intentelo de nuevo'));
			$this->redirect(array('controller'=>'groups','action' => 'view',$meeting['Meeting']['group_id']));
		}
	}
}
function isAuthorized($user){
	/*if(parent::isAuthorized($user)){
		return true;
	}else{*/
	if(!empty($this->request->params['pass'][0])){
		if(in_array($this->action, array('view'))){  // Permite a los usuarios del grupo que puedan ver la reunión
			$this->Meeting->id = $this->request->params['pass'][0];
			if (!$this->Meeting->exists()) {
				throw new NotFoundException(__('La reunión no existe'));
			}
			if(parent::isAuthorized($user))return true; // Solo admin puede ver los las reuniones sin pertenecer al grupo
			$group_id = $this->Meeting->find('first',array( // Busca el Meeting.id y devuelve Meeting.group_id
				'fields'=> 'group_id',
				'conditions' => array(
					'Meeting.id' => $this->request->params['pass'][0])));
			$group_id = $group_id['Meeting']['group_id'];
			
			if($this->Group->isMember($group_id,$user['id'])){
				return true;
			}else{
				$this->Session->setFlash(__('No eres miembro de este Grupo'));
				return false;
			}
		}
		// Permite que los usuarios Responsables del grupo que puedan añadir y editar las reuniones
		if (in_array($this->action, array('edit','delete'))){
			$this->Meeting->id = $this->request->params['pass'][0];
			if (!$this->Meeting->exists()) {
				throw new NotFoundException(__('La reunión no existe'));
			}
			$group_id = $this->Meeting->find('first',array( // Busca el Meeting.id y devuelve Meeting.group_id
				'fields'=> 'group_id',
				'conditions' => array(
					'Meeting.id' => $this->request->params['pass'][0])));
			$group_id = $group_id['Meeting']['group_id'];
			$user_id = $this->Group->find('first',array( // Busca Group.id y devuelve Group.user_id
				'fields' => 'user_id',
				'conditions' => array(
					'Group.id' => $group_id				
				)));
			$user_id = $user_id['Group']['user_id'];
			if ($this->Meeting->isManager($user_id, $user['id'])) {
				return true;
			}else{
				$this->Session->setFlash(__('No eres el responsable de este Grupo'));
				return false;
			}
		}
		elseif(in_array($this->action, array('add'))) {
		$this->Group->id = $this->request->params['pass'][0];
			if (!$this->Group->exists()) {
				throw new NotFoundException(__('El grupo no existe'));
			}
			$user_id = $this->Group->find('first',array(
				'fields' => 'user_id',
				'conditions'=> array(
					'Group.id' => $this->request->params['pass'][0])));
			$user_id = $user_id['Group']['user_id'];
			if ($this->Meeting->isManager($user_id, $user['id'])) {
				return true;
			}else{
				$this->Session->setFlash(__('No eres el responsable de este Grupo'));
				return false;
			}
		}
	}
}
}