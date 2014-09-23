<div id="contentheader">
	<h1>Añadir Grupo</h1>
</div>
	<div class="nav">
		<span><?php echo 'Estás en:';?></span><br>
		<?php echo $this->Html->link('Grupos',array('action'=>'index'));?> --> Añadir grupo 
	</div>
<div id="contentcontent">
	<?php if($current_user['role']=='admin'):?>
	<fieldset>
		<legend>Rellena los siguientes campos:</legend>
		<?php echo $this->Form->create('Group');?>
		<?php	echo $this->Form->input('name',array('label'=>'Nombre del Grupo','autofocus'));?>
		<?php	echo $this->Form->input('description',array('label'=>'Descripción'));?>	
	<?php echo $this->Form->end('Guardar');?>
	</fieldset>
	<?php endif;?>
</div>