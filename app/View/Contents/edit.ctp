
<div id="contentheader">
	<h1>Editar el contenido <b><?php echo htmlentities($content['Content']['title']);?></b>
 	de la reunión <b><?php echo $this->Html->link($content['Meeting']['title'],
 		array('controller'=>'meetings','action'=>'view',$content['Meeting']['id']));?></b></h1>
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
			<?php echo $this->Html->link($content['Meeting']['Group']['name'],
					array('controller'=>'groups','action'=>'view',$content['Meeting']['Group']['id']),
					array('title'=>'Ver grupo '.$content['Meeting']['Group']['name']));?> --> Ver reunión 
			<?php echo $this->Html->link($content['Meeting']['title'],
					array('controller'=>'meetings','action'=>'view',$content['Meeting']['id']),
					array('title'=>'Ver reunión '.$content['Meeting']['title']));?> --> Ver contenidos 
			<?php echo $this->Html->link($content['Content']['title'],
					array('action'=>'view',$content['Content']['id']),
					array('title'=>'Ver contenido '.$content['Content']['title']));?> --> Editar el contenido 
			<b><?php echo htmlentities($content['Content']['title']);?></b>
			</span>
		</div>
<div id="contentcontent">
		<table>
		<tr>
			<th>Título del contenido</th>
			<th>Archivo</th>
			<th>Reunión</th>
			<th>Estado</th>
			<th>Acciones</th>
		</tr>
		<tr>
			<td><b><?php echo htmlentities($content['Content']['title']);?></b></td>
			<td><?php
				echo $this->Html->link($content['Content']['file'],
						array('action' => 'download',$content['Content']['id'],$content['Content']['file']),
						array('title'=>'Descargar el archivo '.$content['Content']['file']));
				?>
			</td>
			<td><?php echo $this->Html->link($content['Meeting']['title'],
						array('controller'=>'meetings','action'=>'view',$content['Meeting']['id']),
						array('title'=>'Ver reunión '.$content['Meeting']['title']));?>
			</td>
			<td><?php echo ($content['Content']['status']=='public') ? 'Público' : 'Privado';?></td>		
			<td class="actions">
				<?php echo $this->Html->link('Ver',
						array('controller'=>'contents','action'=>'view',$content['Content']['id']),
						array('class'=>'actions','title'=>'Ver el contenido '.$content['Content']['title']));?>
				<?php echo $this->Form->postLink('Eliminar',
						array('controller'=>'contents','action'=>'delete',$content['Content']['id']),
						array('class'=>'actions','title'=>'Eliminar el contenido '.$content['Content']['title']),
						'...quieres eliminar el contenido '.$content['Content']['title'].' de la reunión '.$content['Meeting']['title'].'?');?>
				<p class="actions">
				<?php
					echo $this->Html->link('Descargar el archivo',
						array('action' => 'download',$content['Content']['id'],$content['Content']['file']),
						array('class'=>'actions','title'=>'Descargar el archivo '.$content['Content']['file']));
				?>
				</p>
			</td>
		</tr>
		<tr>
		<th class="description_th" colspan="5" title="Pulse para expandir/contraer">
				<div class="arrow_description"><?php echo $this->Html->image('arrow-down.gif', array('alt' => 'expandir/contraer'));?></div>
				Descripción </th>
		</tr>
		</table>
		<div class="description_div"><p><?php echo nl2br(htmlentities($content['Content']['description'])); ?></p></div>
<fieldset>
	<legend>Rellena los siguientes campos: </legend>
		<?php echo $this->Form->create('Content',array('type'=>'file','action'=>'edit'));?>
		<?php	echo $this->Form->input('status',
					array('label'=>'Estado','options'=>array('public'=>'público','private'=>'privado')));?>
		<?php echo $this->Form->input('title',array('label'=>'Título del contenido',));?>
		<?php echo $this->Form->input('description',array('label'=>'Descripción del contenido'));?>
		<?php echo $this->Form->input('file',array('type'=>'file','label'=>'Elige un archivo'));?>
		<?php echo $this->Form->input('meeting_id',array('type'=>'hidden','value'=>$content['Content']['meeting_id']));?>
		<?php echo $this->Form->input('filename',array('type'=>'hidden','value'=>$content['Content']['file']));?>
		<?php echo $this->Form->input('id',array('type'=>'hidden', 'value'=>$content['Content']['id']));?>
		<?php echo $this->Form->end('Guardar');?>
</fieldset>

</div>