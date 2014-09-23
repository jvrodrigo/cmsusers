<?php if($current_user['role']=='admin'):?>
<div id="contentheader">
	<h1>Quitar usuarios al Grupo <b><?php echo htmlentities($group['Group']['name']); ?></b> </h1>
	<div class="nav">
		<span><?php echo 'Estás en:';?><br>
		<?php echo $this->Html->link('Grupos',
				array('controller'=>'groups','action'=>'index'),
				array('title'=>'Ver todos los grupos'));?> --> Ver grupo 
		<b><?php echo $this->Html->link($group['Group']['name'],
				array('controller'=>'groups','action'=>'view',$group['Group']['id']),
				array('title'=>'Ver grupo '.$group['Group']['name']));?></b> --> Quitar usuarios al grupo 
		<b><?php echo htmlentities($group['Group']['name']);?></b>
		</span>
	</div>
</div>
<div id="contentcontent">
	<table>
	<th>Nombre de grupo</th>
	<th>Responsable del grupo</th>
	<th>Nº de Usuarios en el grupo</th>
	<th>Acciones</th>
	<tr>
	<td><?php echo $this->Html->link($group['Group']['name'],
				array('controller'=>'groups','action'=>'view',$group['Group']['id']),
				array('title'=>'Ver el grupo '.$group['Group']['name']));?></td>
	<td>
		<?php	if($group['Group']['user_id']==NULL){
					echo $this->Html->link('No asignado',
						array('controller'=>'groups','action'=>'addManager',$group['Group']['id'],null),
						array('title'=>'Asignar un responsable al grupo '.$group['Group']['name']));			
				} else{
					echo $this->Html->link($group['User']['username'],
						array('controller'=>'users','action'=>'view',$group['User']['id']),
						array('title'=>'Ver el usuario '.$group['User']['username']));
				}	
		?>
	</td>
	<td><?php echo count($users); ?> usuario/s</td>
	<td class="actions">
		<?php echo $this->Html->link('Ver',
				array('controller'=>'groups','action'=>'view',$group['Group']['id']),
				array('class'=>'actions','title'=>'Ver el grupo '.$group['Group']['name']));?>
		<?php echo $this->Html->link('Editar',
				array('controller'=>'groups','action'=>'edit',$group['Group']['id']),
				array('class'=>'actions','title'=>'Editar el grupo '.$group['Group']['name']),
				'...quieres editar el grupo '.$group['Group']['name'].'?');?>
		<?php echo $this->Form->postLink('Eliminar',
				array('controller'=>'groups','action'=>'delete',$group['Group']['id']),
				array('class'=>'actions','title'=>'Eliminar el grupo '.$group['Group']['name']),
				'...quieres eliminar el grupo '.$group['Group']['name'].'?');?>
		<p class="actions">
		<?php echo $this->Html->link('Añadir Usuario/s',
				array('controller'=>'teams','action'=>'addUser',$group['Group']['id']),
				array('class'=>'actions','title'=>'Añadir uno o varios usuarios al grupo '.$group['Group']['name']),
				'...quieres añadir uno o varios usuarios al grupo '.$group['Group']['name'].'?');?>
		</p>
	</td>
	</tr>
	<tr>
	<th class="description_th" colspan="4" title="Pulse para expandir/contraer">
		<div class="arrow_description"><?php echo $this->Html->image('arrow-down.gif', array('alt' => 'plegar'));?></div>
		Descripción: </th>
	</tr>
	</table>
	<div class="description_div"><p><?php echo nl2br(htmlentities($group['Group']['description'])); ?></p></div>

	<fieldset>
		<legend>Selecciona los usuarios a quitar al grupo <b><?php echo htmlentities($group['Group']['name']); ?></b></legend>
	<?php if(count($users)==0):?>
		<p><?php echo 'El grupo no tiene ningún usuario participando ';
					echo $this->Html->link('añada usuarios',
						array('controller'=>'teams','action'=>'addUser',$group['Group']['id']),
						array('title'=>'Añadir uno o varios usuarios al grupo '.$group['Group']['name']));
					echo ' al grupo <b>'.htmlentities($group['Group']['name']).'</b>';
			?>
	<?php else:?>
			<?php echo $this->Form->create('Team');?>
			<?php echo $this->Form->select('user_id',$userslist,array('multiple' => true,'size'=>'10'))?>
			<?php echo $this->Form->input('group_id',array('type'=>'hidden','value'=>$group['Group']['id']));?>
			<?php echo $this->Form->end('Guardar');?>
	<?php endif;?>
	</fieldset>
</div>
<?php endif;?>
