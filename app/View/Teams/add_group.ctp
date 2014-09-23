<div id="contentheader">
	<h1>Añadir grupos al usuario 
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
		 --> Añadir grupos
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
	<td><?php echo count($mygroups);?> grupo/s</td>
	<td><?php 
			if(!empty($mygroups)){
			foreach($mygroups as $mygroup){ 
				echo $this->Html->link($mygroup['Group']['name'],
					array('controller'=>'groups','action'=>'view',$mygroup['Group']['id']),
					array('title'=>'Ver grupo '.$mygroup['Group']['name']));
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
			<?php echo $this->Html->link('Quitar Grupo/s',
						array('controller'=>'teams','action'=>'deleteGroup',$user['User']['id']),
						array('class'=>'actions','title'=>'Quitar uno o varios grupos al usuario '.$user['User']['username']),
						'...quieres quitar uno o varios grupos al usuario '.$user['User']['username'].'?');?>
			</p>
	</td>
	</tr>
	</table>
	<fieldset>
		<legend>Selecciona los <b>grupos</b> a asignar al usuario</legend>
	<?php if(count($groups)==0):?>
		<p>
		<?php 
		echo 'No hay <b>grupos</b> en la base de datos, por favor ';
		echo $this->Html->link('añada grupos',array('controller'=>'groups','action'=>'add'));
		echo ' en la base de datos';
		?></p>
	<?php else:?>
		<?php if(!empty($unasiggn_groups)):?>
		<?php echo $this->Form->create('Team');?>
		<?php echo $this->Form->input('user_id',array('type'=>'hidden','value'=>$user['User']['id']))?>
		<?php echo $this->Form->select('group_id',$unasiggn_groups,array('multiple'=>true,'size'=>'10'));
		?>
		<?php echo $this->Form->end('Guardar');?>
		<?php else:?>
		<p>El usuario <b><?php echo $user['User']['username'];?></b> tiene todos los <b>grupos</b> que existen asignados</p>
		<?php endif;?>
	<?php endif;?>
	</fieldset>
	<?php endif;?>
</div>