<div id="contentheader">
<h1>Home</h1>
</div>
<div id="contentcontent">
<?php if(!$logged_in):?>
<div id="loginform">
	<fieldset>
		<?php
			echo $this->Form->create('User',array('action'=>'login'));
			echo $this->Form->input('username',array('label'=>'Usuario','autofocus'));
			echo $this->Form->input('password',array('label'=>'Contraseña'));
			echo $this->Form->end(__('Iniciar sesión'));
		?>
	</fieldset>
</div>
<?php endif;?>
	<?php 
		echo $this->requestAction(
				array(
					'controller' => 'contents',
					'action' => 'publicIndex'
				),
				array('return'));
	?>
</div>

