<?php if(!empty($content)):?>
	<div id="contentheader">
		<h1>Ver contenido público <b><?php echo htmlentities($content['Content']['title']);?></b></h1>
		<div class="nav">
			<span><?php echo 'Estás en:';?><br>
			<?php echo $this->Html->link('Contenidos públicos',
					array('controller'=>'','action'=>'index'),
					array('title'=>'Ir a contenidos públicos'));?> --> Ver contenido público 
			<b><?php echo htmlentities($content['Content']['title']);?></b></span>
		</div>
	</div>
	<div id="contentcontent">
		<table>
		<tr>
			<th>Título del contenido</th>
			<th>Archivo</th>
			<th>Estado</th>
			<th>Acciones</th>
		</tr>
		<tr>
			<td><b><?php echo htmlentities($content['Content']['title']);?></b></td>
			<td><?php
				echo $this->Html->link($this->Formato->acortarString20($content['Content']['file']),
						array('action' => 'publicDownload',$content['Content']['id'],$content['Content']['file']),
						array('title'=>'Descargar el archivo '.$content['Content']['file']));
				?></td>
			<td><?php echo ($content['Content']['status']=='public') ? 'Público' : 'Privado';?></td>
			<td class="actions">
			<?php if($logged_in):?>
				<?php echo $this->Html->link('Editar',
						array('controller'=>'contents','action'=>'edit',$content['Content']['id']),
						array('class'=>'actions','title'=>'Editar el contenido '.$content['Content']['title']),
						'...quieres editar el contenido '.$content['Content']['title'].'?');
				?>
				<?php echo $this->Form->postLink('Eliminar',
						array('controller'=>'contents','action'=>'delete',$content['Content']['id']),
						array('class'=>'actions','title'=>'Eliminar el contenido '.$content['Content']['title']),
						'...quieres eliminar el contenido '.$content['Content']['title'].'?');
				?>
			<?php endif;?>
				<p class="actions">
				<?php echo $this->Html->link('Descargar el archivo',
						array('action' => 'publicDownload',$content['Content']['id'],$content['Content']['file']),
						array('class'=>'actions','title'=>'Descargar el archivo '.$content['Content']['file']));
				?>
				</p>
				</td>
			</td>		
		</tr>
				<tr>
			<th class="description_th" colspan="5" title="Pulse para expandir/contraer">
				<div class="arrow_description"><?php echo $this->Html->image('arrow-down.gif', array('alt' => 'expandir/contraer'));?></div>
				Descripción </th>
		</tr>
		</table>
		<div class="description_div" style="display:block;">		
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
