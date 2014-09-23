<div id="contentheader">
	<h1>Añadir Usuario</h1>
	<div class="nav">
		<span><?php echo 'Estás en:';?></span><br>
		<?php echo $this->Html->link('Usuarios',array('action'=>'index'));?> --> Añadir Usuario
	</div>
</div>
<div id="contentcontent">
	<?php if($current_user['role']=='admin'):?>
	<fieldset class="adduser">
		<legend>Rellena los siguientes campos: </legend>
		<?php echo $this->Form->create('User');?>
		<?php	echo $this->Form->input('username',array('label'=>'Nombre de Usuario','autofocus'));?>
		<?php echo $this->Form->input('password',array('label'=>'Contraseña'));?>
		<?php echo $this->Form->input('password_confirmation',array('type'=>'password','label'=>'Repite la contraseña'));?>
		<?php echo $this->Form->input('role', array('type'=>'hidden','label'=>'Rol','value' => 'member'));?>
		<?php echo $this->Form->input('email');?>
		<?php echo $this->Form->end('Guardar');?><br />
	</fieldset>	
	<?php endif;?>
</div>