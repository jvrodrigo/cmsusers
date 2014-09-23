<?php if(!empty($content)):?>
	<div id="contentheader">
		<h1>Ver contenido <b><?php echo htmlentities($content['Content']['title']);?>
		</b> de la reunión 
		<b><?php echo $this->Html->link($content['Meeting']['title'],
					array('controller'=>'meetings','action'=>'view',$content['Meeting']['id']),
					array('title'=> 'Ver reunión '.$content['Meeting']['title']));?></b></h1>
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
			<b><?php echo htmlentities($content['Content']['title']);?></b>
			</span>
		</div>
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
				echo $this->Html->link($this->Formato->acortarString20($content['Content']['file']),
						array('action' => 'download',$content['Content']['id'],$content['Content']['file']),
						array('title'=>'Descargar el archivo '.$content['Content']['file']));
				?></td>
			<td><?php echo $this->Html->link($content['Meeting']['title'],
						array('controller'=>'meetings','action'=>'view',$content['Meeting']['id']),
						array('title'=>'Ver reunión '.$content['Meeting']['title']));?></td>
			<td><?php echo ($content['Content']['status']=='public') ? 'Público' : 'Privado';?></td>
			<td class="actions">
			<?php if($current_user['id']==$content['Meeting']['Group']['user_id']):?>
				<?php echo $this->Html->link('Editar',
						array('controller'=>'contents','action'=>'edit',$content['Content']['id']),
						array('class'=>'actions','title'=>'Editar el contenido '.$content['Content']['title']),
						'...quieres editar el contenido '.$content['Content']['title'].' de la reunión '.$content['Meeting']['title'].'?');?>
				<?php echo $this->Form->postLink('Eliminar',
						array('controller'=>'contents','action'=>'delete',$content['Content']['id']),
						array('class'=>'actions','title'=>'Eliminar el contenido '.$content['Content']['title']),
						'...quieres eliminar el contenido '.$content['Content']['title'].' de la reunión '.$content['Meeting']['title'].'?');?>
			<?php endif;?>
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
		<div class="description_div">
			<p>
			<?php if($content['Content']['description']==NULL){
						echo 'No hay descripción';
					}else{
						echo nl2br(htmlentities($content['Content']['description']));
					} 
			?>
			</p>
		</div>
	</div>
<?php else:?>
	<div id="contentheader">
		<h1>El contenido no existe</h1>
	</div>
<?php endif;?>
