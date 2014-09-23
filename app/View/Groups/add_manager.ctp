<div id="contentheader">
	<h1>Asignar un responsable al grupo <b><?php echo htmlentities($group['Group']['name']); ?></b> </h1>
<?php if($current_user['role']=='admin'):?>
	<div class="nav">
		<span><?php echo 'Estás en:';?><br>
		<?php echo $this->Html->link('Grupos',
				array('action'=>'index'),
				array('title'=>'Ver todos los grupos'));?> --> Ver grupo 
		<b><?php echo $this->Html->link($group['Group']['name'],
				array('action'=>'view',$group['Group']['id']),
				array('title'=>'Ver grupo '.$group['Group']['name']));?></b> --> Asignar responsable al grupo
		<b><?php echo htmlentities($group['Group']['name']);?></b>		
		</span>
	</div>
<?php else:?>
	<div class="nav">
		<span><?php echo 'Estás en:';?><br>
		<?php echo $this->Html->link('Mis grupos',
				array('action'=>'index'),
				array('title'=>'Ver mis grupos'));?> --> Ver grupo 
		<b><?php echo $group['Group']['name'];?></b>
		</span>
	</div>
<?php endif;?>
</div>
<div id="contentcontent">
	<table>
	<tr>
		<th>Nombre del grupo</th>
		<th>Responsable</th>
		<th>Nº de Usuarios en el grupo</th>
		<th>Acciones</th>
	</tr>
	<tr>
		<td><b>
			<?php echo $this->Html->link($group['Group']['name'],
					array('action'=>'view',$group['Group']['id']),
					array('title'=>'Ver grupo '.$group['Group']['name'])); ?>
		</b></td>
		<td>
			<?php if($group['Group']['user_id']==NULL){
						echo '<b>No asignado</b>';
					}else{
						echo $this->Html->link($group['User']['username'],
								array('controller'=>'users','action'=>'view',$group['User']['id']),
								array('title'=>'Ver el usuario '.$group['User']['username']));
					}	
			?>			
		</td>
		<td><?php echo count($group['Team']); ?> usuario/s</td>
		<td class="actions">
		<?php echo $this->Html->link('Editar',
				array('action'=>'edit',$group['Group']['id']),
				array('class'=>'actions','title'=>'Editar el grupo '.$group['Group']['name']),
				'...quieres editar el grupo '.$group['Group']['name'].'?');?>
		<?php echo $this->Form->postLink('Eliminar',
				array('action'=>'delete',$group['Group']['id']),
				array('class'=>'actions','title'=>'Eliminar el grupo '.$group['Group']['name']),
				'...quieres eliminar el grupo '.$group['Group']['name'].'?');?>
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
		</td>
	</tr>
	
	<tr>
		<th class="description_th" colspan="4" title="Pulse para expandir/contraer">
			<div class="arrow_description"><?php echo $this->Html->image('arrow-down.gif', array('alt' => 'plegar'));?></div>
			Descripción </th>
	</tr>
	</table>
	<div class="description_div" ><p><?php echo nl2br(htmlentities($group['Group']['description'])); ?></p></div>
<?php if(!empty($group['Team'])):?>
	<fieldset>
		<legend>Selecciona un usuario</legend>
		<?php echo $this->Form->create('Group',array('action'=>'addManager'));?>
		<?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$group['Group']['id']));?>
		<?php echo $this->Form->input('name',array('type'=>'hidden','value'=>$group['Group']['name']));?>		
		<?php echo $this->Form->select('user_id',$users,array('required','size'=>'10'));?>
		<?php echo $this->Form->end('Guardar');?>
	</fieldset>
	<?php else:?>
	<fieldset><legend>No hay usuarios en el grupo <?php echo '<b>'.htmlentities($group['Group']['name']).'</b>';?></legend>
		<p><?php 
			echo 'No hay usuarios en el grupo, quieres ';
			echo $this->Html->link('añadir',
				array('controller'=>'teams','action'=>'addUser',$group['Group']['id']),
				array('title'=>'Añadir uno o varios usuarios al grupo '.$group['Group']['name']),
				'...quieres añadir uno o varios usuarios al grupo '.$group['Group']['name'].'?');
			echo ' uno o varios usuarios al grupo <b>'.htmlentities($group['Group']['name']).'</b>?';
			?>
		</p>
	
	
	</fieldset>

	
	<?php endif;?>
</div>