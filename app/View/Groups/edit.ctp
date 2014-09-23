<div id="contentheader">
<h1>Editar el Grupo <b><?php echo htmlentities($group['Group']['name']);?></b></h1>
	<div class="nav">
		<span><?php echo 'Estás en:';?></span><br>
		<?php echo $this->Html->link('Grupos',array('action'=>'index'));?> --> Editar grupo 
		<?php echo $this->Html->link($group['Group']['name'],array('action'=>'view',$group['Group']['id']));?></span>
	</div>
<div id="contentcontent">
		<table>
		<tr>
			<th>Nombre del grupo</th>
			<th>Responsable del grupo</th>
			<th>Nº de Usuarios en el grupo</th>
			<th>Acciones</th>
		</tr>
		<tr>
			<td>
				<?php echo $this->Html->link($group['Group']['name'],
						array('action'=>'view',$group['Group']['id']),
						array('title'=>'Ver el grupo '.$group['Group']['name'])); ?></td>
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
					array('action'=>'view',$group['Group']['id']),
					array('class'=>'actions','title'=>'Ver el grupo '.$group['Group']['name']));?>
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
			<th class="description_th" colspan="4">
			<div class="arrow_description"><?php echo $this->Html->image('arrow-down.gif', array('alt' => 'expandir/contraer'));?></div>
			Descripción </th>
		</tr>
		</table>
		<div class="description_div"><p><?php echo nl2br(htmlentities($group['Group']['description'])); ?></p></div>

	<?php if($current_user['role']=='admin'):?>
<fieldset>
	<legend>Rellena los siguientes campos: </legend>
<?php echo $this->Form->create('Group',array('action'=>'edit'));?>
<?php echo $this->Form->input('name',array('label'=>'Nombre del grupo',));?>
<?php echo $this->Form->input('description',array('label'=>'Descripción'));?>
<?php echo $this->Form->input('id',array('type'=>'hidden'));?>
<?php echo $this->Form->end('Guardar');?>
</fieldset>
<?php endif;?>
</div>