<?php if($current_user['id']==$meeting['Group']['user_id']):?>
	<div id="contentheader">
		<h1>Editar la reunión 
		<?php echo $this->Html->link($meeting['Meeting']['title'],
				array('controller'=>'meetings','action'=>'view',$meeting['Meeting']['id']));?>
		 del grupo 
		<?php echo $this->Html->link($meeting['Group']['name'],
				array('controller'=>'groups','action'=>'view',$meeting['Group']['id']));?></b></h1>
		
		<div class="nav">
			<span>
			<?php echo 'Estás en: ';?><br>
			<?php if($current_user['role']=='admin'):?>
			<?php echo $this->Html->link('Grupos',
					array('controller'=>'groups','action'=>'index'),
					array('title'=>'Ver todos los grupos'));?> --> Ver grupo
			<?php else: ?>
			<?php echo $this->Html->link('Mis grupos',
					array('controller'=>'groups','action'=>'index'),
					array('title'=>'Ver mis grupos'));?> --> Ver grupo
			
			<?php endif;?> 
			<?php echo $this->Html->link($meeting['Group']['name'],
					array('controller'=>'groups','action'=>'view',$meeting['Group']['id']),
					array('title'=>'Ver grupo '.$meeting['Group']['name']));?> --> Ver reunión 
			<?php echo $this->Html->link($meeting['Meeting']['title'],
					array('action'=>'view',$meeting['Meeting']['id']),
					array('title'=>'Ver reunión '.$meeting['Meeting']['title']));?> --> Editar reunión
			<b><?php echo htmlentities($meeting['Meeting']['title']);?></b>
			</span>
		</div>
	<div id="contentcontent">
			<table>
			<tr>
			<th>Nombre de la reunión</th>
			<th>Fecha</th>
			<th>Grupo</th>
			<th>Acciones</th>
			</tr>
			<td><b><?php echo htmlentities($meeting['Meeting']['title']);?></b></td>
			<td><b><?php echo $this->Formato->acortarFechaMeeting($meeting['Meeting']['date']);?></b></td>
			<td><?php echo $this->Html->link($meeting['Group']['name'],
					array('controller'=>'groups','action'=>'view',$meeting['Group']['id']),
					array('title'=>'Ver grupo '.$meeting['Group']['name']));?></td>
			<td class="actions">			
			<?php	echo $this->Html->link('Ver',
					array('controller'=>'meetings','action'=>'view',$meeting['Meeting']['id']),
					array('class'=>'actions','title'=>'Ver la reunión '.$meeting['Meeting']['title']));
			?>
			<?php 
					echo $this->Form->postLink('Eliminar',
					array('controller'=>'meetings','action'=>'delete',$meeting['Meeting']['id']),
					array('class'=>'actions','title'=>'Eliminar la reunión '.$meeting['Meeting']['title']),
					'...quieres eliminar la reunión '.$meeting['Meeting']['title'].'?');
			?>
			<p class="actions">
			<?php echo $this->Html->link('Añadir contenidos',
					array('controller'=>'contents','action'=>'add',$meeting['Meeting']['id']),
					array('class'=>'actions','title'=>'Añade contenidos a la reunión '.$meeting['Meeting']['title']),
					'...quieres añadir contenidos a la reunión '.$meeting['Meeting']['title'].'?');?>
			</p>
			</td>
			<tr>
				<th class="description_th" colspan="4">
				<div class="arrow_description"><?php echo $this->Html->image('arrow-down.gif', array('alt' => 'expandir/contraer'));?></div>
				Descripción </th>
			</tr>
		</table>
		<div class="description_div"><p><?php echo nl2br(htmlentities($meeting['Meeting']['description'])); ?></p></div>
	<fieldset>
		<legend>Rellena los siguientes campos: </legend>
			<?php echo $this->Form->create('Meeting',array('action'=>'edit'));?>
			<?php echo $this->Form->input('date',array('type'=>'datetime','label'=>'Fecha de la reunión'));?>
			<?php echo $this->Form->input('title',array('label'=>'Título de la reunión',));?>
			<?php echo $this->Form->input('description',array('label'=>'Descripción'));?>
			<?php echo $this->Form->input('id',array('type'=>'hidden'));?>
			<?php echo $this->Form->input('group_id',array('type'=>'hidden'));?>			
		<?php echo $this->Form->end('Guardar');?>
	</fieldset>
	</div>
<?php endif;?>
