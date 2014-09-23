<div id="contentheader">
<h1>Editar el usuario <b><?php echo $user['User']['username'];?></b></h1>
	<?php if($current_user['role']=='admin'):?>
		<div class="nav">
			<span><?php echo 'Estás en:';?><br>
			<?php echo $this->Html->link('Usuarios',array('action'=>'index'),array('title'=>'Ver usuarios'));?> --> Ver usuario 
			<?php echo $this->Html->link($user['User']['username'],
				array('action'=>'view',$user['User']['id']),
				array('title'=>'Ver usuario '.$user['User']['username']));?> --> Editar el usuario 
				<b><?php echo $user['User']['username'];?></b></span>
		</div>
	<?php else:?>
		<div class="nav">
			<span><?php echo 'Estás en:';?><br>
			<?php echo $this->Html->link('Mi zona privada',array('action'=>'index'),array('title'=>'Ir a mi zona privada'));?> --> Ver usuario 
			<?php echo $this->Html->link($user['User']['username'],
				array('action'=>'view',$user['User']['id']),
				array('title'=>'Ver usuario '.$user['User']['username']));?> --> Editar el usuario
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
		<?php echo $this->Html->link('Ver',
				array('action'=>'view',$user['User']['id']),
				array('class'=>'actions','title'=>'Ver el usuario '.$user['User']['username']));?>
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
	<?php if($current_user['role']=='admin'):?>
<fieldset>
	<legend>Rellena los siguientes campos: </legend>
<?php echo $this->Form->create('User',array('action'=>'edit'));?>
<?php echo $this->Form->input('username',array('label'=>'Nombre de usuario',));?>
<?php echo $this->Form->input('password',array('label'=>'Contraseña'));?>
<?php echo $this->Form->input('role',array('type'=>'hidden'));?>
<?php echo $this->Form->input('password_confirmation',array('type'=>'password','label'=>'Repite la contraseña'));?>
<?php echo $this->Form->input('email');?>
<?php echo $this->Form->input('id',array('type'=>'hidden'));?>
<?php echo $this->Form->end('Guardar');?>
</fieldset>
<?php elseif($current_user['role']=='member'):?>

<fieldset>
	<legend>Rellena los siguientes campos: </legend>
<?php echo $this->Form->create('User',array('action'=>'edit'));?>
<?php echo $this->Form->input('username',array('type'=>'hidden',));?>
<?php echo $this->Form->input('password',array('label'=>'Contraseña'));?>
<?php echo $this->Form->input('password_confirmation',array('type'=>'password','label'=>'Repite la contraseña'));?>
<?php echo $this->Form->input('email');?>
<?php echo $this->Form->input('role',array('type'=>'hidden'));?>
<?php echo $this->Form->input('id',array('type'=>'hidden'));?>
<?php echo $this->Form->end('Guardar');?>
</fieldset>
<?php endif;?>
</div>