<?php
// app/Controller/TeamsController.php
class TeamsController extends AppController {
var $name = 'Teams';
var $uses = array('Team','User','Group');
public function addGroup($id=null) {//Entrada User.id
	$this->User->recursive = -1;
	$this->set('user',$this->User->findById($id));
	$this->Group->recursive = 	2;
	$this->set('groups',$this->Group->find('list'));
	$this->set('mygroups',$this->Team->findAllByUserId($id)); // todos los equipos que pertenece el usuario
	$groups = $this->Team->findAllByUserId($id);
	$mygroups = NULL; // Variable para almacenar Group.id de los grupos que pertenece el usuario
	$i = 0;
	foreach($groups as $group){	// Bucle para almacenar los Group.id que pertenece el usuario
		$mygroups[$i]=$group['Group']['id']; // Identificador de los grupos que pertenece el usuario
		$i++;
	}
	$unasiggn_groups = $this->Group->find('list',array(	      // Consulta para listar los grupos que el usuario no pertenece
		'fields' => array('Group.name'),
		'conditions' => array('NOT'=>	array('Group.id'=> $mygroups))));
	$this->set('unasiggn_groups',$unasiggn_groups); 
	
	// Si queremos asignar un team al usuario
	if($this->request->is('post')){
		$log = true; // Verifica que no hay fallos (bandera)
		$oklog = ''; // String para mostrar los grupos asignados
		// Guarda en la base de datos la relacion User.id=>Team.user_id, Group.id=>Team.group_id
		$request = $this->request->data['Team']['group_id'];
		//$teams = $this->Team;
		foreach ($request as $team){ // Bucle para recorrer el array Team.group_id[] multiple
			// Crea el objeto Team
			$this->Team->create();
			$this->request->data['Team']['group_id'] = $team; // Guarda el valor de group_id
			
			if($this->Team->save($this->data)){ // Guarda el objeto Team en la base de datos
				$garbage = $this->Group->findById($this->request->data['Team']['group_id']);
				$oklog = '</br><b>'.htmlentities($garbage['Group']['name']).'</b>'.$oklog;
			}
			else{
				$log = false;
			}
		}
		
		$user = $this->User->findById($this->request->data['Team']['user_id']);
		if($log == true){
			$this->Session->setFlash(__('Al usuario <b>'.$user['User']['username'].'</b>, se le ha añadido '.$oklog));
			$this->redirect(array('controller'=>'users','action' => 'view',$id),null,true);		
		}else{
			$this->Session->setFlash(__('Ha habido un error, al usuario <b>'.$user['User']['username'].'</b>se le ha asignado</br>'.htmlentities($oklog)));
		}

	}
}
public function addUser($id=null) { // Entrada Group.id
	$this->Group->recursive = 2;
	$this->set('group',$this->Group->findById($id)); // Busca el grupo
	$this->set('users',$this->User->find('list'));	// Lista todos los usuarios
	$this->set('myusers',$this->Team->findAllByGroupId($id)); // Envía los Usuarios que pertenecen al grupo para contarlos 
	$users = $this->Team->findAllByGroupId($id); // Usuarios que pertenecen al grupo
	$myusers = NULL; // Variable para almacenar User.id de los usuarios que pertenecen al grupo
	$i = 0;
	foreach($users as $user){ // Bucle para buscar los usuarios del grupo
		$myusers[$i]=$user['User']['id']; // Identificador de los usuarios del grupo
		$i++;
	}
	$unasiggn_users = $this->User->find('list',array(	      // Consulta para listar los grupos que el usuario no pertenece
		'fields' => array('User.username'),
		'conditions' => array('NOT'=>	array('User.id'=> $myusers,'User.role'=>'admin'))));
	$this->set('unasiggn_users',$unasiggn_users); 
	// Si queremos asignar usuarios al grupo
	if($this->request->is('post')){
		$log = true; // Verifica que no hay fallos (bandera)
		$oklog = ''; // String para mostrar los grupos asignados
		$request = $this->request->data['Team']['user_id'];
		foreach ($request as $team){ // Bucle para recorrer el array Team.user_id[] multiple
			// Crea el objeto Team
			$this->Team->create();
			$this->request->data['Team']['user_id'] = $team; // Guarda el valor de user_id
			
			if($this->Team->save($this->data)){ // Guarda el objeto Team en la base de datos
				$garbage = $this->User->findById($this->request->data['Team']['user_id']);
				$oklog = '</br><b>'.$garbage['User']['username'].'</b>'.$oklog;
			}
			else{
				$log = false;
			}
		}
		$group = $this->Group->findById($this->request->data['Team']['group_id']);
		if($log == true){
			
			$this->Session->setFlash(__('Al grupo <b>'.htmlentities($group['Group']['name']).'</b>, se le ha añadido el/los usuario/s'.$oklog));
			$this->redirect(array('controller'=>'groups','action' => 'view',$id),null,true);		
		}else{
			$this->Session->setFlash(__('Ha habido un error, al grupo <b>'.htmlentities($group['Group']['name']).'</b> se le ha asignado</br>'.$oklog));
		}
	}
}
public function deleteGroup($id=null){ // Entrada User.id
	if($this->request->is('post')){
		$log = null;
		foreach($this->request->data['Team']['group_id'] as $group_id){ // Elimina los registros donde Team.user_id y Team.group_id coinciden
			$this->Team->deleteAll(array(
				'Team.user_id'=>$this->request->data['Team']['user_id'],
				'Team.group_id'=>$group_id),false);
			$group = $this->Team->Group->findById($group_id);
			$log = $log .'<br>'.htmlentities($group['Group']['name']);
			if($group['Group']['user_id']==$this->request->data['Team']['user_id']){ // Si el usuario que se quita es el responsable del grupo
					$this->Team->Group->updateAll(array('Group.user_id' => NULL),array('Group.id' => $group_id));
			}
		}
		$this->Session->setFlash(__('Al usuario se le ha dado de baja de los grupos <b>'.$log.'</b>'));
		$this->redirect(array('controller'=>'users','action'=>'view',$this->request->data['Team']['user_id']));
	}else{ // Si el método es get mostramos los grupos donde el usuario participa
		$this->User->id = $id;
		if(!$this->User->exists()) { // Si el usuario no existe lanza una excepcion
			$this->Session->setFlash(__('El usuario no existe'));
			$this->redirect($this->referer());
		}
		$this->User->recursive=1;
		$this->set('user',$this->User->findById($id));
		//$this->set('groups',$this->Team->findAllByUserId($id));
		$teams = $this->Team->find('list',array( // Busca todos los equipos donde el usuario participa
										'conditions'=> array(
												'Team.user_id'=>$id
										),
										'fields' => array('Team.group_id')
									));
		$groupslist = $this->Team->Group->find('list',array( // Busca una lista de los grupos donde el usuario participa
			'conditions' => array(
					'Group.id' => $teams),
			'fields' => array('Group.name')
		));
		$this->set('groupslist',$groupslist); //Será utilizado para el método 'post' de este método
		$this->Team->Group->recursive=-1;
		$groups = $this->Team->Group->find('all',array(
			'conditions' => array(
					'Group.id' => $teams)					
		));
		$this->set('groups',$groups);	
	}
}
public function deleteUser($id) {// Entrada Group.id
	if($this->request->is('post')){
		$log = null;
		$query = null;
		$group = $this->Team->Group->findById($this->request->data['Team']['group_id']); // Busca el grupo
		foreach($this->request->data['Team']['user_id'] as $user_id){ //Bucle de los usuarios seleccionados
			$query = $this->Team->User->find('first',array(
												'fields'=>'User.username',
												'conditions'=>array(
													'User.id'=>$user_id)));//Busca el nombre de usuario para mostrarlo en el mensaje flash
			$log = $log.'<br>'.$query['User']['username'];
			$this->Team->deleteAll(array( // Elimina los registros donde Team.user_id y Team.group_id coinciden
				'Team.group_id'=>$this->request->data['Team']['group_id'],
				'Team.user_id'=>$user_id),false);
			if($user_id==$group['Group']['user_id']){ // Si el usuario que se quita es el responsable del grupo
					$this->Team->Group->updateAll(array('Group.user_id' => NULL),array('Group.id' => $this->request->data['Team']['group_id']));
			}
		}
		$this->Session->setFlash(__('Al grupo <b>'.htmlentities($group['Group']['name']).'</b>, se le ha dado de baja el/los usuario/s <b>'.$log.'</b>'));
		$this->redirect(array('controller'=>'groups','action'=>'view',$this->request->data['Team']['group_id']));
	}else{
		$this->Group->id = $id;
		if(!$this->Group->exists()) {
			$this->Session->setFlash(__('El grupo no existe'));
			$this->redirect($this->referer());
			}
		$this->Group->recursive=1;
		$this->set('group',$this->Group->findById($id));// Variable para mostrar en el view
		
		$teams = $this->Team->find('list',array( // Busca todos los usuarios que participan en el grupo
										'conditions'=> array(
												'Team.group_id'=>$id
										),
										'fields' => array('Team.user_id')
									));
		$userslist = $this->Team->User->find('list',array( // Busca una lista de los grupos donde el usuario participa
			'conditions' => array(
					'User.id' => $teams),
			'fields' => array('User.username')
		));
		$this->set('userslist',$userslist); //Será utilizado para el método 'post'
		$this->Team->User->recursive=-1;
		$users = $this->Team->User->find('all',array(
			'conditions' => array(
					'User.id' => $teams)
		));
		$this->set('users',$users);
		
	}
}
public function delete($user_id=null,$id = null){ // Entrada User.id, Team.id
	if($this->request->is('post')){
		// Busca en la base datos para mostrar por pantalla la acción
		$user = $this->User->findById($user_id);
		$team = $this->Team->findById($id);
		$group = $this->Group->findById($team['Team']['group_id']);

		if($this->Team->delete($id)){
			if($user['User']['id'] == $group['Group']['user_id']) { // Si el usuario resposable es eliminado del grupo
				$this->Group->updateAll(array('Group.user_id' => NULL),array('Group.id' => $team['Team']['group_id']));
			}
			$this->Session->setFlash(__('Al usuario <b>'.$user['User']['username'].'</b>, se le ha dado de baja del grupo </br><b>'.htmlentities($group['Group']['name']).'</b>'));
			$this->redirect($this->referer());
		}
	}	
}
}

