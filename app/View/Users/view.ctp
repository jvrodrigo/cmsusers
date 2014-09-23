<?php if(!empty($user)):?>  
<div id="contentheader">
<h1>Ver usuario <b><?php echo $user['User']['username']; ?></b> </h1>
	<?php if($current_user['role']=='admin'):?>
		<div class="nav">
			<span><?php echo 'Estás en:';?><br>
			<?php echo $this->Html->link('Usuarios',array('action'=>'index'),array('title'=>'Ver usuarios'));?> --> Ver usuario 
			<b><?php echo $user['User']['username'];?></b></span>
		</div>
	<?php else:?>
		<div class="nav">
			<span><?php echo 'Estás en:';?><br>
			<?php echo $this->Html->link('Mi zona privada',array('action'=>'index'),array('title'=>'Ir a mi zona privada'));?> --> Ver usuario 
			<b><?php echo $user['User']['username'];?></b></span>
		</div>
	<?php endif;?>
</div>
<div id="contentcontent">
<table>
	<th>Nombre de usuario</th>
	<th>Email</th>
	<th>Último acceso</th>
	<th>Nº de Grupos</th>
	<th>Responsable de los grupos</th>
	<th>Acciones</th>
	<tr>
	<td><b><?php echo $user['User']['username']; ?></b></td>
	<td><?php echo $user['User']['email']; ?></td>
	<td><?php echo $this->Formato->modified($user['User']['created'],$user['User']['modified']); ?></td>
	<td><?php echo count($user['Team']); ?> grupo/s</td>
	<td>
	<?php 
		$i = 0; 
		foreach($user['Team'] as $group){
			if($user['User']['id']==$group['Group']['user_id']){
				echo $this->Html->link($group['Group']['name'],
						array('controller'=>'groups','action'=>'view',$group['Group']['id']),
						array('title'=>'Ver el grupo '.$group['Group']['name']));
				echo '<br>';
				$i++;			
			}
		}
		if($i==0)  echo '<b>No es responsable de ningún grupo</b>'; 	
	?></td>
	<td class="actions">
		<?php echo $this->Html->link('Editar',
				array('action'=>'edit',$user['User']['id']),
				array('class'=>'actions','title'=>'Editar el usuario '.$user['User']['username']),
				'...quieres editar el usuario '.$user['User']['username'].'?');?>
		<?php if($current_user['role']=='admin'):?>
		<?php echo $this->Form->postLink('Eliminar',
				array('action'=>'delete',$user['User']['id']),
				array('type'=>'post','class'=>'actions','title'=>'Eliminar el usuario '.$user['User']['username']),
				'...quieres eliminar el usuario '.$user['User']['username'].'?');?>
		<p class="actions">
		<?php echo $this->Html->link('Añadir Grupo/s',
				array('controller'=>'teams','action'=>'addGroup',$user['User']['id']),
				array('type'=>'post','class'=>'actions','title'=>'Añadir a un grupo el usuario '.$user['User']['username']),
				'...quieres añadir uno o varios grupos al usuario '.$user['User']['username'].'?');?>
		<?php echo $this->Html->link('Quitar Grupo/s',
				array('controller'=>'teams','action'=>'deleteGroup',$user['User']['id']),
				array('class'=>'actions','title'=>'Quitar uno o varios grupos al usuario '.$user['User']['username']),
				'...quieres quitar uno o varios grupos al usuario '.$user['User']['username'].'?');?>
		</p>
		<?php endif;?>
	</td>
	</tr>
</table>
<div class="info">
<div class="slider_1" title="Pulse para expandir/contraer"><h3>Grupos donde participa el usuario <b><?php echo $user['User']['username']?></b>
<div class="arrow_1"><?php echo $this->Html->image('arrow-up.gif', array('alt' => 'expandir/contraer'));?></div></h3>
</div>
	<div class="down_1">
	<p class="p_slider">Listado de <b>Grupos</b></p>
		<table class="subtable">
		<?php if(count($user['Team']) == 0): ?>
			<p class="p_slider"><?php echo 'El usuario <b>'.$user['User']['username'].'</b> no tiene ningun grupo de trabajo asignado ';
					echo '¿Quieres '; 
					echo $this->Html->link('asignarle',
						array(
						'controller'=>'teams','action'=>'addGroup',
						$user['User']['id']),array('type'=>'post'),'...quieres añadir un grupo al usuario '.$user['User']['username'].'?');
					echo ' alguno?';?></p>
		<?php else:?>
			<th>Nombre del grupo</th>
			<th>Descripción</th>
			<th>Responsable</th>
			<th>Acciones</th>
				<?php 			
				foreach($user['Team'] as $group):?>
					<tr>
					<td>
					<p>
						<?php
							echo $this->Html->link($group['Group']['name'],
							array('controller'=>'groups','action'=>'view',$group['Group']['id']),
							array('title'=>'Ver el grupo '.$group['Group']['name']));	
						?>
					</p>
					</td>
					<td>
					<p>
						<?php
							echo $this->Formato->acortarString10($group['Group']['description']);
						?>					
					</p>
					</td>
					<td>
					<?php
						if($current_user['role']=='admin'){
							if ($group['Group']['user_id']==NULL){
								echo 'No asignado';
							}elseif($user['User']['id']==$group['Group']['user_id']) {
								echo '<b>'.$user['User']['username'].'</b>';
							}
							else{
								echo $this->Html->link('Ver usuario',
										array('action'=>'view',$group['Group']['user_id']),
										array('title'=>'Ver usuario responsable'));
							}
						}else{
							if ($group['Group']['user_id']==NULL){
								echo 'No asignado';
							}elseif($group['Group']['user_id']==$current_user['id']){
								echo '<b>Eres el responsable</b>';
							}else{
								echo 'No eres el responsable';						
							}
						}
					?>
					
					</td>
					<td class="actions">
					<?php
							echo $this->Html->link('Ver',
							array('controller'=>'groups','action'=>'view',$group['Group']['id']),
							array('class'=>'actions','title'=>'Ver el grupo '.$group['Group']['name']));	
					?>
					<?php if($current_user['role']=='admin'):?>
					<?php echo $this->Form->postLink('Quitar grupo',
							array('controller'=>'teams','action'=>'delete',$user['User']['id'],$group['id']),
							array('class'=>'actions','title'=>'Dar de baja al usuario '.$user['User']['username'].' del grupo '.$group['Group']['name']),
								'...quieres dar de baja al usuario '.$user['User']['username'].' del grupo '.$group['Group']['name'].'?');
					?>
					<?php 
						if($user['User']['id']==$group['Group']['user_id']){
							echo $this->Html->link('Quitar responsable',
							array('controller'=>'groups','action'=>'deleteManager',$group['Group']['id']),
							array('class'=>'actions','title'=>'Desasignar como responsable del grupo '.$group['Group']['name'].' al usuario '.$user['User']['username']),
							'...quieres desasignar a '.$user['User']['username'].' como responsable del grupo '.$group['Group']['name'].'?');					
						}else{
							echo $this->Html->link('Ser responsable',
							array('controller'=>'groups','action'=>'addManager',$group['Group']['id'],$user['User']['id']),
							array('class'=>'actions','title'=>'Asignar como responsable del grupo '.$group['Group']['name'].' al usuario '.$user['User']['username']),
							'...quieres asignar a '.$user['User']['username'].' como responsable del grupo '.$group['Group']['name'].'?');
						}
					?>
					<?php endif;?>
					<?php if($current_user['id']==$group['Group']['user_id']):?>
					<p class="actions">
					<?php echo $this->Html->link('Crear reunión',
							array('controller'=>'meetings','action'=>'add',$group['Group']['id']),
							array('class'=>'actions','title'=>'Crear nueva reunión para el grupo '.$group['Group']['name']),
							'...quieres crear una reunión para el grupo '.$group['Group']['name'].'?');
					?>
					</p>
					<?php endif;?>
					</td>
				</tr>
				<?php endforeach;?>
		<?php endif;?>
		</table>
	</div>
</div>
</div>
<?php else: ?>
<div id="contentheader">
	<h1>El Usuario no existe</h1>
</div>
<?php endif;?>