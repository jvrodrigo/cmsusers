<?php if(!empty($meeting)):?>
	<div id="contentheader">
		<h1>Añadir contenidos para la reunión 
		<b><?php echo $this->Html->link($meeting['Meeting']['title'],
				array('controller'=>'meetings','action'=>'view',$meeting['Meeting']['id']),
				array('title'=>'Ver reunión '));
		echo '</b> del grupo <b>';
		echo $this->Html->link($meeting['Group']['name'],
				array('controller'=>'groups','action'=>'view',$meeting['Group']['id']));?></b></h1>
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
						array('title'=>'Ver mis grupos'));?> --> Ver grupo		
			<?php endif;?>
			<?php echo $this->Html->link($meeting['Group']['name'],
					array('controller'=>'groups','action'=>'view',$meeting['Group']['id']),
					array('title'=>'Ver grupo '.$meeting['Group']['name']));?> --> Ver reunión 
			<?php echo $this->Html->link($meeting['Meeting']['title'],
					array('controller'=>'meetings','action'=>'view',$meeting['Meeting']['id']),
					array('title'=>'Ver reunión '.$meeting['Meeting']['title']));?> --> Añade contenidos a la reunión
			<b><?php echo htmlentities($meeting['Meeting']['title']);?></b>
			</span>
		</div>
	</div>
	<div id="contentcontent">
		<?php if($meeting['Group']['user_id']==$current_user['id']):// Si el usuario es el responsable del grupo ?>
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
			<?php echo $this->Html->link('Ver',
					array('controller'=>'meetings','action'=>'view',$meeting['Meeting']['id']),
					array('class'=>'actions','title'=>'Ver la reunión '.$meeting['Meeting']['title']));?>
			<?php	echo $this->Html->link('Editar',
					array('controller'=>'meetings','action'=>'edit',$meeting['Meeting']['id']),
					array('class'=>'actions','title'=>'Editar la reunión '.$meeting['Meeting']['title']),
					'...quieres editar la reunión '.$meeting['Meeting']['title'].'?');
			?>
			<?php 
					echo $this->Form->postLink('Eliminar',
					array('controller'=>'meetings','action'=>'delete',$meeting['Meeting']['id']),
					array('class'=>'actions','title'=>'Eliminar la reunión '.$meeting['Meeting']['title']),
					'...quieres eliminar la reunión '.$meeting['Meeting']['title'].'?');
			?>
			</td>
			<tr>
				<th class="description_th" colspan="4" title="Pulse para expandir/contraer">
				<div class="arrow_description"><?php echo $this->Html->image('arrow-down.gif', array('alt' => 'expandir/contraer'));?></div>
				Descripción </th>
			</tr>
		</table>
		<div class="description_div"><p><?php echo nl2br(htmlentities($meeting['Meeting']['description'])); ?></p></div>
		<fieldset>
			<legend>Rellene los siguientes campos</legend>
			<?php echo $this->Form->create('Content',array('type'=>'file'));?>
			<?php	echo $this->Form->input('meeting_id',array('type'=>'hidden','value' => $meeting['Meeting']['id']));?>
			<?php	echo $this->Form->input('status',
					array('label'=>'Estado','options'=>array('public'=>'público','private'=>'privado')));?>
			<?php	echo $this->Form->input('title',array('label'=>'Título del contenido (requerido)','autofocus'));?>
			<?php	echo $this->Form->input('description',array('label'=>'Descripción del contenido'));?>
			<?php	echo $this->Form->input('file',array('type'=>'file','label'=>'Sube un archivo','required'=>'required','fileSize'=>'<1MB'));?>	
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
