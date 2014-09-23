<?php if(!empty($public_contents)):?>
<div id="public_contents">
<h2>Contenidos públicos</h2>
<table>
	<tr>
	<th>Título del contenido</th>
	<th>Descripción</th>
	<th>Archivo</th>
	<th>Acciones</th>
	</tr>
	<?php foreach($public_contents as $content):?>
	<tr>
		<td><?php echo $this->Html->link($content['Content']['title'],
					array('controller'=>'contents','action'=>'publicView',$content['Content']['id']),
					array('title'=>'Ir al contenido '.$content['Content']['title']));?>
		</td>
		<td><?php 
			if($content['Content']['description']==NULL){
				echo 'No hay descripción';
			}else{
				echo $this->Formato->acortarString10($content['Content']['description']);
			}?></td>
		<td><?php
			echo $this->Html->link($this->Formato->acortarString20($content['Content']['file']),
					array('action' => 'publicDownload',$content['Content']['id'],$content['Content']['file']),
					array('title'=>'Descargar el archivo '.$content['Content']['file']));
			?></td>
		<td class="actions">
		
			<?php echo $this->Html->link('Ver el contenido',
					array('controller'=>'contents','action'=>'publicView',$content['Content']['id']),
					array('class'=>'actions','title'=>'Ir al contenido '.$content['Content']['title']));?>
			<p class="actions">
			<?php
			echo $this->Html->link('Descargar el archivo',
					array('action' => 'publicDownload',$content['Content']['id'],$content['Content']['file']),
					array('class'=>'actions','title'=>'Descargar el archivo '.$content['Content']['file']));
			?>
			</p>
		</td>
	</tr>
	<?php endforeach;?>
</table>
</div>
<?php else:?>
<div id="public_contents">
<h2>No hay contenidos públicos</h2>
<?php endif;?>
</div>