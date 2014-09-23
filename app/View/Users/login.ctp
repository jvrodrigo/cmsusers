<?php echo $this->Session->flash('auth'); ?>
<div id="contentheader">
<h1>Solo puedes ver los <?php echo $this->Html->link('contenidos públicos',array('controller'=>'pages','action'=>'index'));?>
 y descargar sus archivos</h1>
</div>
<div id="contentcontent">
<div id="loginform">
	<fieldset><legend>Entre aquí usando su nombre<br> de usuario y contraseña</legend>
		<?php
			echo $this->Form->create('User',array('action'=>'login'));
			echo $this->Form->input('username',array('label'=>'Usuario','autofocus'));
			echo $this->Form->input('password',array('label'=>'Contraseña'));
			echo $this->Form->end(__('Iniciar sesión'));
		?>
	</fieldset>
</div>
<h2>Quieres <?php echo $this->Html->link('ver los contenidos públicos',array('controller'=>'pages','action'=>'index'));?>?</h2>

</div>