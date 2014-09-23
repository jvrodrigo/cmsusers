<?php if(!empty($meeting)):?>
	<div id="contentheader">
		<h1>Ver reunión <b><?php echo htmlentities($meeting['Meeting']['title']);?>
		</b> del Grupo 
		<b><?php echo $this->Html->link($meeting['Group']['name'],
					array('controller'=>'groups','action'=>'view',$meeting['Group']['id']),
					array('title'=> 'Ver groupo '.$meeting['Group']['name']));?></b></h1>
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
			<b><?php echo htmlentities($meeting['Meeting']['title']);?></b>
			</span>
		</div>
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
			<?php if($current_user['id']==$meeting['Group']['user_id']):?>
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
			<p class="actions">
			<?php echo $this->Html->link('Añadir contenidos',
					array('controller'=>'contents','action'=>'add',$meeting['Meeting']['id']),
					array('class'=>'actions','title'=>'Añade contenidos a la reunión '.$meeting['Meeting']['title']),
					'...quieres añadir contenidos a la reunión '.$meeting['Meeting']['title'].'?');?>
			</p>
			<?php endif;?>
			</td>
			<tr>
				<th class="description_th" colspan="4" title="Pulse para expandir/contraer">
				<div class="arrow_description"><?php echo $this->Html->image('arrow-down.gif', array('alt' => 'expandir/contraer'));?></div>
				Descripción </th>
			</tr>
		</table>
		<div class="description_div">
			<p>
			<?php if($meeting['Meeting']['description']==NULL){
						echo 'No hay descripción';
					}else{
						echo nl2br(htmlentities($meeting['Meeting']['description']));
					} 
			?>
			</p>
		</div>
		<div class="info">
		<?php if(count($meeting['Content'])==0): ?>
			<div class="slider_1" title="Pulse para expandir/contraer"><h3>Contenidos de la reunión <b><?php echo htmlentities($meeting['Meeting']['title']);?></b>
				<div class="arrow_1"><?php echo $this->Html->image('arrow-up.gif', array('alt' => 'expandir/contraer'));?></div></h3>
			</div>
			<div class="down_1">
				<p class="p_slider"><?php echo 'No hay contenidos para esta reunión, quieres ';?>
				<?php echo $this->Html->link('añadir', array('controller'=>'contents','action'=>'add',$meeting['Meeting']['id']));?>
				<?php echo ' contenidos para esta reunión';?></p>
			</div>
		<?php else: ?>
		<div class="slider_1" title="Pulse para expandir/contraer">
			<div class="arrow_1"><?php echo $this->Html->image('arrow-up.gif', array('alt' => 'expandir/contraer'));?></div>
			<h3>Contenidos de la reunión <b><?php echo htmlentities($meeting['Meeting']['title']);?></b></h3>
		</div>
		<div class="down_1">
			<p class="p_slider">Listado de <b>contenidos</b></p>
		<table class="subtable">
			<tr>
				<th>Título del contenido</th>
				<th>Descripción</th>
				<th>Archivo</th>
				<th>Estado</th>
				<th>Acciones</th>
			</tr>
			<?php 
				if($current_user['id']==$meeting['Group']['user_id']){
					//echo $this->Form->create('Content',array('action'=>'delete'));
					//echo $this->Form->input('meeting_id',array('type'=>'hidden','value'=>$meeting['Meeting']['id']));
				}	
			?>
			<?php foreach ($meeting['Content'] as $content) :?>
			<tr>
				<td><?php
						/*if($current_user['id']==$meeting['Group']['user_id']){
							echo $this->Form->input('id.',
								array(
									'id'=>'ContentId_'.$content['id'],'value'=>$content['id'],
									'label'=>'','hiddenField' => false,'type'=>'checkbox','div'=>false
								));
						}*/
						echo $this->Html->link($content['title'],
							array('controller'=>'contents','action'=>'view',$content['id']),
							array('title'=>'Ver contenido '.$content['title']));?></td>
				<td><?php 
						if($content['description']==NULL){
							echo 'No hay descripción';	
						}else {
							echo $this->Formato->acortarString10($content['description']);
						}?>
				</td>
				<td><?php
				echo $this->Html->link($this->Formato->acortarString20($content['file']),
						array('controller' => 'contents', 'action' => 'download',$content['id'],$content['file']),
						array('title'=>'Descargar el archivo '.$content['file']));
				?></td>
				<td><?php echo ($content['status']=='public') ? 'Público' : 'Privado';?></td>
				<td class="actions">
					<?php echo $this->Html->link('Ver',
							array('controller'=>'contents','action'=>'view',$content['id']),
							array('class'=>'actions','title'=>'Ver el contenido '.$content['title']));?>
					<?php if($current_user['id']==$meeting['Group']['user_id']):?>
					<?php echo $this->Html->link('Editar',
							array('controller'=>'contents','action'=>'edit',$content['id']),
							array('class'=>'actions','title'=>'Editar el contenido '.$content['title']),
							'...quieres editar el contenido '.$content['title'].' de la reunión '.$meeting['Meeting']['title'].'?');?>
					<?php echo $this->Form->postLink('Eliminar',
							array('controller'=>'contents','action'=>'delete',$content['id']),
							array('class'=>'actions','title'=>'Eliminar el contenido '.$content['title']),
							'...quieres eliminar el contenido '.$content['title'].' de la reunión '.$meeting['Meeting']['title'].'?');
					?>
					<?php endif;?>
							
				</td>
			</tr>
			<?php endforeach;?>
			<?php if($current_user['id']==$meeting['Group']['user_id']):?>
			<!--<tr><td colspan="5">
			<?php
				//echo $this->Form->select('selector',array('run'=>'Eliminar selección'),array('title' => 'Acciones por lote','required'=>true)); 
				//echo $this->Form->end('Eliminar');?>
			</td></tr>-->
			<?php endif;?>
		</table>

		</div>
		</div>
		<?php endif;?>
	</div>
<?php else:?>
	<div id="contentheader">
		<h1>La reunión no existe</h1> 
	</div>
<?php endif;?>
