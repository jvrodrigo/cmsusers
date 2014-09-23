<?php
// app/Controller/ContentsController.php
class ContentsController extends AppController {
var $name = 'Contents';
var $uses = array('Group','User','Meeting','Content');

public function publicIndex() {
	$this->Content->recursive = -1;
	$public_contents = $this->Content->find('all',
		array(
			'conditions'=> array('Content.status' => 'public')
		));
	$this->set('public_contents', $public_contents);
}
public function publicView($id=null){
	$this->Content->recursive=-1;
	$content = $this->Content->find('first',
			array(
				'conditions' => array(
					'Content.id' => $id
			)));
	if($content!=null){
		if($content['Content']['status']=='public'){// Si el contenido es publico
			$this->set('content',$content);
		}
		else { 
			$this->redirect(array('action' => 'view',$id)); // Si el contenido no es publico, pero el usuario pertenece al grupo
		}
	}else{
		$this->Session->setFlash(__('El contenido <b>no existe</b>'));
		$this->redirect($this->referer());
	}
}
public function publicDownload($id=null){
	$this->Content->recursive=-1;
	$content = $this->Content->find('first',
			array(
				'conditions' => array(
					'Content.id' => $id
			)));
	if($content!=null){
		if($content['Content']['status']=='public'){// Si el contenido es publico
			$this->download($id,$content['Content']['file']);
		}
		else {
			$this->redirect(array('action' => 'view',$id)); // Si el contenido no es publico, pero el usuario pertenece al grupo
		}
	}else{
		$this->Session->setFlash(__('El contenido <b>no existe</b>'));
		$this->redirect($this->referer());
	}
}
public function view($id=null){
	$this->Content->recursive = 2; // Añado recursividad 2 para poder acceder a los Usuarios desde el Grupo
	$this->set('content', $this->Content->findById($id));
}
public function download($id,$filename) {
	$this->viewClass = 'Media';
	$name = pathinfo($filename, PATHINFO_FILENAME);
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$mime = array(
		'avi' => 'video/avi',
		'bmp' => 'image/bmp',
		'css' => 'text/css',
		'doc' => 'application/msword',
		'docx' => 'application/msword',
		'gif' => 'image/gif',
		'html' => 'text/html',
		'jpeg' => 'image/jpeg',
		'jpg' => 'image/jpg',
		'mov' => 'video/quicktime',
		'mp3' => 'audio/mpeg',
		'mpeg' => 'video/mpeg',
		'odg'=> 'application/vnd.oasis.opendocument.graphics',
		'odp'=>'application/vnd.oasis.opendocument.presentation',
		'odt'=>'application/vnd.oasis.opendocument.text',
		'pdf' => 'application/pdf',
		'pps'=>'application/vnd.ms-powerpoint',
		'ppt'=>'application/vnd.ms-powerpoint',
		'png'=>'image/png',
		'rar' => 'application/zip',
		'sql' => 'application/text',
		'txt' => 'text/plain',
		'wav'=>'audio/x-wav',
		'zip' => 'application/zip'
	);
	$params = array(
		'id' => $id .DS. $filename,
		'name' => $name,
		'mimeType' => $mime,
		'download' => true,
		'extension' => $ext,
 		'path' => APP. 'Data' .DS. 'contents' . DS 
    );
	$this->set($params);
}
public function add($id = null){ // Entrada Meeting.id
	$this->Meeting->id = $id;
	if(!$this->Meeting->exists()){
		throw new NotFoundException(__('La reunión no existe'));
	}
	if ($this->request->is('post')){
		if(!empty($this->request->data['Content']['file']['tmp_name']) && is_uploaded_file($this->request->data['Content']['file']['tmp_name'])){
					$this->Content->create(); // Creo un objeto Content
		$this->Content->save(); // Lo guardo en la base de datos para obtener el id
		$content_id = $this->Content->find('first',array( // Busca el último Content.id
				'fields' => 'Content.id',
				'limit'=>'1',				
				'order' => array('Content.id'=>'desc')));
		$content_id = $content_id['Content']['id']; // Guarda el valor del ID
		if($content_id==NULL){$content_id=0;}
		if(!is_dir(APP. 'Data')){ // Si no existen la carpetas 'app/Data/contents/' se crearán aquí
			mkdir(APP. 'Data',0755);
			if(!is_dir(APP. 'Data' .DS. 'contents' )){
				mkdir(APP. 'Data'.DS.'contents',0755);
			}
		}
		if(!is_dir(APP. 'Data' .DS. 'contents' )){
				mkdir(APP. 'Data'.DS.'contents',0755);
		}
		if(!is_dir(APP. 'Data' .DS. 'contents' . DS . $content_id)){
			$newPath = APP. 'Data' .DS. 'contents' . DS . $content_id;
			mkdir($newPath,0755);
		}
		$newPath = APP. 'Data' .DS. 'contents' . DS . $content_id;
			move_uploaded_file($this->data['Content']['file']['tmp_name'], $newPath . DS . $this->request->data['Content']['file']['name']);
			$this->request->data['Content']['file'] = $this->request->data['Content']['file']['name'];
			$this->request->data['Content']['url'] = $content_id . '/' . $this->request->data['Content']['file'];
				//debug($this->request->data);
			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(__('El contenido <b>'.htmlentities($this->request->data['Content']['title']).'</b>, ha sido guardado'));
				$this->redirect(array('controller'=>'meetings','action' => 'view',$id));	
			}else {
				$this->Session->setFlash(__('El contenido <b>'.htmlentities($this->request->data['Content']['title']).'</b> no ha sido guardado. Porfavor, intentelo de nuevo.'));
			}	
								
		}			
			
		} 
	$this->set('meeting',$this->Meeting->findById($id));
}
public function edit($id=null){
	$this->Content->id = $id;

	if ($id==null) {
		throw new NotFoundException(__('El contenido no existe'));
		//$this->Session->setFlash(__('El contenido no existe'));
	}
	if ($this->request->is('post') || $this->request->is('put')) {
		if(!is_dir(APP. 'Data')){ // Si no existen la carpetas 'app/Data/contents/' se crearán aquí
			mkdir(APP. 'Data',0755);
			if(!is_dir(APP. 'Data' .DS. 'contents' )){
				mkdir(APP. 'Data'.DS.'contents',0755);
			}
		}
		if(!is_dir(APP. 'Data' .DS. 'contents' )){
				mkdir(APP. 'Data'.DS.'contents',0755);
		}
		$newPath = APP. 'Data' .DS. 'contents' . DS . $id;
		if(!is_dir(APP. 'Data' .DS. 'contents' . DS . $id)){	
			mkdir($newPath,0755);
		}
		// Si hay un archivo seleccionado en el Input file
		if(!empty($this->request->data['Content']['file']['tmp_name']) && is_uploaded_file($this->request->data['Content']['file']['tmp_name'])){
			unlink($newPath . DS . $this->request->data['Content']['filename']); // Elimina el archivo anterior
			move_uploaded_file($this->data['Content']['file']['tmp_name'], $newPath . DS . $this->request->data['Content']['file']['name']);
			$this->request->data['Content']['file'] = $this->request->data['Content']['file']['name'];
			$this->request->data['Content']['url'] = $id . '/' . $this->request->data['Content']['file'];
			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(__('El contenido <b>'.htmlentities($this->request->data['Content']['title']).'</b>, ha sido modificado'));
				$this->redirect(array('action' => 'view',$this->request->data['Content']['id']));	
			} else {
				$this->Session->setFlash(__('El contenido no ha sido modificado. Porfavor, intentelo de nuevo.'));
			}
		}else{ // Si no hay ningún archivo en el Input file
			$this->request->data['Content']['file'] = $this->request->data['Content']['filename'];
			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(__('El contenido <b>'.htmlentities($this->request->data['Content']['title']).'</b>, ha sido modificado'));
				$this->redirect(array('action' => 'view',$this->request->data['Content']['id']));
			} else {
				$this->Session->setFlash(__('El contenido no ha sido modificado. Porfavor, intentelo de nuevo.'));
			}
		}
	}elseif($this->request->is('get') && $id!=null) {
		$this->Content->recursive = 2; // Recursividad para poder acceder al Group.id desde Content.id
		$content = $this->Content->findById($id);
		$this->set('content',$content);
		$this->request->data = $this->Content->read(null, $id);
	}
}
function delete($id = null) {
	if($this->request->is('post')){ // Si se elimina en bloque los contenidos
		if($id!=null){
			$this->Content->id=$id;
			if (!$this->Content->exists()) {
				throw new NotFoundException(__('El contenido no existe'));
			}
			$content = $this->Content->findById($id);
			if ($this->Content->delete($id)) {
				$this->Content->eliminarDir(APP.'Data'.DS.'contents'.DS.$id);// Elimina la carpeta del servidor
				$this->Session->setFlash(__('El contenido <b>'.htmlentities($content['Content']['title']).'</b> ha sido eliminado'));
				$this->redirect(array('controller'=>'meetings','action' => 'view',$content['Content']['meeting_id']));
			}else{
				$this->Session->setFlash(__('El contenido no ha sido eliminado, por favor intentelo de nuevo'));
				$this->redirect(array('action' => 'index','controller'=>'groups'));
			}
		}/*else{// Eliminado multiple por checkboxes
			$log =null; // Variable para reqistrar los posibles errores
			$flag = false;
	
			if(empty($this->request->data['Content']['id'])){
				$this->Session->setFlash(__('Selecciona los contenidos a eliminar'));
				$this->redirect($this->referer());
			}
			foreach($this->request->data['Content']['id'] as $id){
				if ($this->Content->delete($id)) {
					$this->Content->eliminarDir(APP.'Data'.DS.'contents'.DS.$id);
				}else{
					$log = $log.'<br>'.'Error al eliminar el contenido con id -> '.$id;
					$flag = true;			
				}
			}
			if($flag==false){
				$this->Session->setFlash(__('El contenido ha sido eliminado'));
				$this->redirect($this->referer());	
			}
			else{
				$this->Session->setFlash(__(htmlentities($log)));
				$this->redirect($this->referer());
			}
		}*/
	}
}

function isAuthorized($user){
	/*if(parent::isAuthorized($user)){
		return true;
	}else{*/

		// Permite que los usuarios Responsables del grupo que puedan añadir y editar los contenidos de las reuniones
		if(!empty($this->request->params['pass'][0])){

			if(in_array($this->action, array('view','download'))){//Permite a los usuarios registrados que puedan ver la reunión y descargar el archivo
				if(parent::isAuthorized($user) && $this->action=='view') return true; // Solo admin puede ver los las reuniones sin pertenecer al grupo
				$this->Content->id = $this->request->params['pass'][0];
				if (!$this->Content->exists()) {
					throw new NotFoundException(__('El contenido no existe'));
				}
				$meeting_id = $this->Content->find('first',array( //Busca Content.id y devuelve Content.meeting_id
					'fields'=> 'meeting_id',
					'conditions' => array(
						'Content.id' => $this->request->params['pass'][0])));
				$meeting_id = $meeting_id['Content']['meeting_id'];
				$group_id = $this->Meeting->find('first',array( // Busca el Meeting.id y devuelve Meeting.group_id
					'fields'=> 'group_id',
					'conditions' => array(
						'Meeting.id' => $meeting_id)));
				$group_id = $group_id['Meeting']['group_id'];
				if ($this->Group->isMember($group_id, $user['id'])) { //Si es miembro del grupo
					return true;
				}elseif(parent::isAuthorized($user) && $this->action=='download'){ // Solo admin puede descargar los contenidos públicos sin pertenecer al grupo
					$content_status = $this->Content->findById($this->request->params['pass'][0]);
					if($content_status['Content']['status']=='public') {
						return true;
					}else{
						return false;
					} 
				}else{
					$this->Session->setFlash(__('No eres miembro de este Grupo'));
					return false;
				}
			}
			elseif (in_array($this->action, array('edit','delete'))){
				 
				$this->Content->id = $this->request->params['pass'][0];
				if (!$this->Content->exists()) {
					throw new NotFoundException(__('El contenido no existe'));
				}
				$meeting_id = $this->Content->find('first',array( //Busca Content.id y devuelve Content.meeting_id
					'fields'=> 'meeting_id',
					'conditions' => array(
						'Content.id' => $this->request->params['pass'][0])));
				$meeting_id = $meeting_id['Content']['meeting_id'];
				$group_id = $this->Meeting->find('first',array( // Busca el Meeting.id y devuelve Meeting.group_id
					'fields'=> 'group_id',
					'conditions' => array(
						'Meeting.id' => $meeting_id)));
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
				$this->Meeting->id = $this->request->params['pass'][0];
				if (!$this->Meeting->exists()) {
					throw new NotFoundException(__('La reunión no existe'));
				}
				$group_id = $this->Meeting->find('first',array(
					'fields' => 'group_id',
					'conditions'=> array(
						'Meeting.id' => $this->request->params['pass'][0])));
				$group_id = $group_id['Meeting']['group_id'];
				$user_id = $this->Group->find('first',array(
					'fields' => 'user_id',
					'conditions'=> array(
						'Group.id' => $group_id)));
				$user_id = $user_id['Group']['user_id'];
				if ($this->Meeting->isManager($user_id, $user['id'])) {
					return true;
				}else{
					$this->Session->setFlash(__('No eres el responsable de este Grupo'));
					return false;
				}
			}
		}else{
			if(in_array($this->action, array('delete'))){
				if($this->request->is('post')) { // Si el método es post
					$group_id = $this->Meeting->find('first',array( // Busca el Meeting.id y devuelve Meeting.group_id
						'fields'=> 'group_id',
						'conditions' => array(
							'Meeting.id' => $this->request->data['Content']['meeting_id'])));
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
				}else{
					return true;
				}			
			}	
		}
	}
}