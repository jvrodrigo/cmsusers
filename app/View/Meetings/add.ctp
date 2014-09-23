<?php if(!empty($group)):?>
	<div id="contentheader">
		<h1>Crear Reunión para el Grupo <b><?php echo htmlentities($group['Group']['name']);?></b></h1>
	</div>
	<div class="nav">
		<span>
		<?php echo 'Estás en: ';?><br>
		<?php if($current_user['role']=='admin'):?>
		<?php echo $this->Html->link('Grupos',
				array('controller'=>'groups','action'=>'index'),
				array('title'=>'Ver todos los grupos'));?> --> Ver grupo
		<?php else:?>
		<?php echo $this->Html->link('Mis grupos',
				array('controller'=>'groups','action'=>'index'),
				array('title'=>'Ver todos los grupos'));?> --> Ver grupo

		<?php endif;?>  
		<?php echo $this->Html->link($group['Group']['name'],
				array('controller'=>'groups','action'=>'view',$group['Group']['id']),
				array('title'=>'Ver grupo '.$group['Group']['name']));?> --> Añadir reunión al grupo 
		<b><?php echo htmlentities($group['Group']['name']);?></b>
		</span>
	</div>
	<div id="contentcontent">
		<?php if($group['Group']['user_id']==$current_user['id']):// Si el usuario es el responsable del grupo ?>
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
				<?php
					if($group['Group']['user_id']==NULL){
						echo $this->Html->link('No asignado',
							array('action'=>'addManager',$group['Group']['id'],null),
							array('title'=>'Asignar un responsable al grupo '.$group['Group']['name']));			
					} else{
					echo $this->Html->link($group['User']['username'],
						array('controller'=>'users','action'=>'view',$group['User']['id']),
						array('title'=>'Ver el usuario '.$group['User']['username']));
					}	
				?>
	</td>
	<td><?php echo count($group['Team']); ?> usuario/s</td>
	<td class="actions">
		<?php echo $this->Html->link('Ver',
				array('controller'=>'groups','action'=>'view',$group['Group']['id']),
				array('class'=>'actions','title'=>'Ver el grupo '.$group['Group']['name']));?>
		<?php if($current_user['role']=='admin'):?>
		<?php echo $this->Html->link('Editar',
				array('controller'=>'groups','action'=>'edit',$group['Group']['id']),
				array('class'=>'actions','title'=>'Editar el grupo '.$group['Group']['name']),'...quieres editar el grupo '.$group['Group']['name'].'?');?>
		<?php echo $this->Form->postLink('Eliminar',
				array('controller'=>'groups','action'=>'delete',$group['Group']['id']),
				array('class'=>'actions','title'=>'Eliminar el grupo '.$group['Group']['name']),'...quieres eliminar el grupo '.$group['Group']['name'].'?');?>
		<p class="actions">
		<?php echo $this->Html->link('Añadir Usuario/s',
				array('controller'=>'teams','action'=>'addUser',$group['Group']['id']),
				array('class'=>'actions','title'=>'Añadir uno o varios usuarios al grupo '.$group['Group']['name']),
				'...quieres añadir uno o varios usuarios al grupo '.$group['Group']['name'].'?');?>
		<?php echo $this->Html->link('Quitar Usuario/s',
				array('controller'=>'teams','action'=>'deleteUser',$group['Group']['id']),
				array('class'=>'actions','title'=>'Quitar uno o varios usuarios del grupo '.$group['Group']['name']),
				'...quieres quitar uno o varios usuarios del grupo '.$group['Group']['name'].'?');?>
				
		</p>
		<?php endif;?>
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
			<legend>Introduce los datos de la reunión</legend>
			<?php echo $this->Form->create('Meeting');?>
			<?php	echo $this->Form->input('group_id',array('type'=>'hidden','value' => $group['Group']['id']));?>
			<?php echo $this->Form->input('date',array('type'=>'datetime','label'=>'Fecha de la reunión'));?>
			<?php	echo $this->Form->input('title',array('label'=>'Título de la reunión','autofocus'));?>
			<?php	echo $this->Form->input('description',array('label'=>'Descripción de la reunión'));?>
		<?php echo $this->Form->end('Guardar');?>
		</fieldset>
		<?php else:?>
		<?php echo '<p>No eres el usuario <b>responsable</b> de este grupo</p>';?>
		<?php endif;?>
	</div>
<?php else:?>
	<div id="contentheader">
		<h1>El grupo no existe</h1>
	</div>
<?php endif;?>
