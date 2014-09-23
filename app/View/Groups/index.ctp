<div id="contentheader">
	<?php if($current_user['role']=='admin'):?>
		<h1>Listar grupos</h1>
		<div class="nav">
			<span><?php echo 'Estás en:';?></span><br>
			<?php echo $this->Html->link('Grupos',array('action'=>'index'),array('title'=>'Ver todos los grupos'));?>
		</div>
	<?php else:?>
		<h1>Mis grupos</h1>
		<div class="nav">
			<span><?php echo 'Estás en:';?></span><br>
			<?php echo $this->Html->link('Mis grupos',array('action'=>'index'),array('title'=>'Ver mis grupos'));?>
		</div>
	<?php endif;?>
</div>
<div id="contentcontent">
	<?php if($current_user['role']=='admin'):?>
		<?php if(empty($groups)): ?>
			<fieldset>
				<legend>No existen grupos en la base de datos</legend>
				<p>¿Desea <b><?php echo $this->Html->link('añadir',array('action'=>'add'))?></b> grupos en la base de datos?</p>		
			</fieldset>
		<?php else:?>
		<table>
		<tr>
			<th>Nombre del grupo</th>
			<!--<th>Descripción</th>-->
			<th>Responsable</th>
			<th>Modificado</th>
			<th>Nº de Usuarios en el grupo</th>
			<th>Acciones</th>
		</tr>
		
		<?php
			//echo $this->Form->create('Group',array('action'=>'delete'));
			foreach($groups as $group):
		?>
		<tr>
			<td><div><?php 
					/*echo $this->Form->input('id.',
						array(
							'id'=>'GroupId_'.$group['Group']['id'],'value'=>$group['Group']['id'],
							'label'=>'','hiddenField' => false,'type'=>'checkbox','div'=>false
						));*/
					echo $this->Html->link($group['Group']['name'],
							array('action'=>'view',$group['Group']['id']),
							array('title'=>'Ver el grupo '.$group['Group']['name']));?></div></td>
			<!--<td><?php echo $this->Formato->acortarString10($group['Group']['description']);?></td>-->
			<td>
			<?php
				if($group['Group']['user_id']==NULL){
					echo $this->Html->link('No asignado',
							array('action'=>'addManager',$group['Group']['id']),
							array('title'=>'Asignar un responsable al grupo '.$group['Group']['name']));
				}else{ 
					echo $this->Html->link($group['User']['username'],array('controller'=>'users','action'=>'view',$group['Group']['user_id']),
							array('title'=>'Ver el usuario '.$group['User']['username']));
				}
			?>
				
			</td>
			<td><?php echo $this->Formato->modified($group['Group']['created'],$group['Group']['modified']);?></td>
			<td><?php echo count($group['Team']); ?> usuario/s</td>
			<td class="actions">
			<?php echo $this->Html->link('Ver',
					array('action'=>'view',$group['Group']['id']),
					array('class'=>'actions','title'=>'Ver el grupo '.$group['Group']['name']));?>
			<?php echo $this->Html->link('Editar',
					array('action'=>'edit',$group['Group']['id']),
					array('class'=>'actions','title'=>'Editar el grupo '.$group['Group']['name']),
					'...quieres editar el grupo '.$group['Group']['name'].'?');?>
			<?php echo $this->Form->postLink('Eliminar',
					array('action'=>'delete',$group['Group']['id']),
					array('class'=>'actions','title'=>'Eliminar el grupo '.$group['Group']['name']),
					'...quieres eliminar el grupo '.$group['Group']['name'].'?');?>
			<?php if($group['Group']['user_id']==$current_user['id']):?>
			<?php echo $this->Html->link('Crear Reunión',
					array('controller'=>'meetings','action'=>'add',$group['Group']['id']),
					array('class'=>'actions','title'=>'Crear nueva reunión para el grupo '.$group['Group']['name']));?>
			<?php endif;?>
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
		<?php endforeach;?>
		<!--<tr><td colspan="6">
		<?php
			//echo $this->Form->select('selector',array('run'=>'Eliminar selección'),array('default' => 'Acciones por lote','required'=>true)); 
			//echo $this->Form->end('Eliminar');
		?></td></tr>-->
		</table>
		<?php endif;?>
	<?php elseif($current_user['role']=='member'):?>
		<?php if(empty($groups)): ?>
			<fieldset>
				<legend>No tienes ningún grupo asignado</legend>			
			</fieldset>
		<?php else:?>
		<table>
		<tr>
			<th>Nombre del grupo</th>
			<th>Descripcion</th>
			<th>Rol</th>
			<th>Nº de Usuarios en el grupo</th>
			<th>Acciones</th>
		</tr>
		<?php
			foreach($groups as $group):
		?>
		<tr>
			<td><?php echo $this->Html->link($group['Group']['name'],
						array('action'=>'view',$group['Group']['id']),
						array('title'=>'Ver grupo '.$group['Group']['name']));?></td>
			<td><?php echo $this->Formato->acortarString10($group['Group']['description']);?></td>
			<td><?php echo ($group['Group']['user_id']==$current_user['id']) ? '<b>Responsable</b>': 'Miembro';?></td>
			<td><?php echo count($group['Group']['Team']); ?> usuario/s</td>
			<td class="actions"><?php echo $this->Html->link('Ver',
					array('action'=>'view',$group['Group']['id']),
					array('class'=>'actions','title'=>'Ver el grupo '.$group['Group']['name']));?>
			<?php if($current_user['id']==$group['Group']['user_id']): ?>
			<?php echo $this->Html->link('Crear Reunión',
						array('controller'=>'meetings','action'=>'add',$group['Group']['id']),
						array('class'=>'actions','title'=>'Crear nueva reunión para el grupo '.$group['Group']['name']));?>
			<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
		</table>
		<?php endif;?>
	<?php endif;?>
</div>