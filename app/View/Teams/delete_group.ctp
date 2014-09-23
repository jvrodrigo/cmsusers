<div id="contentheader">
	<h1>Quitar grupos al usuario 
	<b><?php echo $this->Html->link($user['User']['username'],
						array('controller'=>'users','action'=>'view',$user['User']['id']),
						array('title'=>'Ver el usuario '.$user['User']['username']));
		?></b></h1>
	<div class="nav">
		<span><?php echo 'Estás en:';?></span><br>
		<?php echo $this->Html->link('Usuarios',
				array('controller'=>'users','action'=>'index'),
				array('title'=>'Listar usuarios'));
		?> --> Ver usuario 
		<?php echo $this->Html->link($user['User']['username'],
				array('controller'=>'users','action'=>'view',$user['User']['id']),
				array('title'=>'Ver el usuario '.$user['User']['username']));?>
		 --> Quitar grupos al usuario <?php echo '<b>'.$user['User']['username'].'</b>';?>
	</div>
</div>
<div id="contentcontent">
	<?php if($current_user['role']=='admin'):?>
	<table>
	<th>Nombre de usuario</th>
	<th>Email</th>
	<th>Nº de Grupos en que participa</th>
	<th>Grupos</th>
	<th>Acciones</th>
	<tr>
	<td><?php echo $this->Html->link($user['User']['username'],
				array('controller'=>'users','action'=>'view',$user['User']['id']),
				array('title'=>'Ver el usuario '.$user['User']['username'])); ?></td>
	<td><?php echo $user['User']['email']; ?></td>
	<td><?php echo count($user['Team']);?> grupo/s</td>
	<td><?php 
			if(!empty($groups)){
			foreach($groups as $group){ 
				echo $this->Html->link($group['Group']['name'],
					array('controller'=>'groups','action'=>'view',$group['Group']['id']),
					array('title'=>'Ver grupo '.$group['Group']['name']));
				echo '<br>';
			}
			}else{
				echo '<b>No participa en ningún grupo</b>';
			}
		?>
	</td>
	<td class="actions">
			<?php echo $this->Html->link('Ver',
						array('controller'=>'users','action'=>'view',$user['User']['id']),
						array('class'=>'actions','title'=>'Ver el usuario '.$user['User']['username']));?>
			<?php echo $this->Html->link('Editar',
						array('controller'=>'users','action'=>'edit',$user['User']['id']),
						array('class'=>'actions','title'=>'Editar el usuario '.$user['User']['username']),
						'...quieres editar el usuario '.$user['User']['username'].'?');?>
			<?php echo $this->Form->postLink('Eliminar',
						array('controller'=>'users','action'=>'delete',$user['User']['id']),
						array('class'=>'actions','title'=>'Eliminar el usuario '.$user['User']['username']),
						'...quieres eliminar el usuario '.$user['User']['username'].'?');?>
			<p class="actions">
			<?php echo $this->Html->link('Añadir Grupo/s',
						array('controller'=>'teams','action'=>'addGroup',$user['User']['id']),
						array('class'=>'actions','title'=>'Añadir uno o varios grupos al usuario '.$user['User']['username']),
						'...quieres añadir un grupo al usuario '.$user['User']['username'].'?');?>
			</p>
	</td>
	</tr>
	</table>
	<fieldset>
		<legend>Selecciona los grupos a quitar al usuario</legend>
	<?php if(count($groups)==0):?>
		<p>
		<?php 
		echo 'El usuario no tiene ningún grupo asignado, ';
		echo $this->Html->link('añada grupos',
				array('controller'=>'teams','action'=>'addGroup',$user['User']['id']),
				array('title'=>'Añadir uno o varios grupos al usuario '.$user['User']['username']));
		echo ' al usuario';
		?></p>
	<?php else:?>
		<?php echo $this->Form->create('Team');?>
		<?php echo $this->Form->input('user_id',array('type'=>'hidden','value'=>$user['User']['id']))?>
		<?php echo $this->Form->select('group_id',$groupslist,array('multiple'=>true,'size'=>'10','value'=>'name'));?>
		<?php echo $this->Form->end('Guardar');?>
	<?php endif;?>
	</fieldset>
	<?php endif;?>
</div>