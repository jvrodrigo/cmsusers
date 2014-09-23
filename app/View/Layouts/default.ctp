<?php
	$myappDescription = __d('cake_dev', 'Gestor de usuarios y contenidos');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $myappDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		if(!empty($_SESSION['style'])){
			if($_SESSION['style']=='blue'){
				echo $this->Html->css('cake.generic.blue');
			}elseif($_SESSION['style']=='orange'){
				echo $this->Html->css('cake.generic.orange');		
			}elseif($_SESSION['style']=='grey'){
				echo $this->Html->css('cake.generic.grey');
			}
			else{
				echo $this->Html->css('cake.generic');			
			}
		}else{
			echo $this->Html->css('cake.generic');
		}
		echo $this->Html->script(array('jquery.min.js','jquery_practica_tw.js'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
	<div id="header">
		<h1 class="header">
			<?php echo $this->Html->link($myappDescription, '/',array('title'=>'Ir a home -> Ver los contenidos públicos')); ?>
		</h1>
		<?php if($logged_in):?>
		<div class="style">
			<?php 
				echo '<a href="/tw_practica/users/style/'.$current_user['id'].'/blue" title="Tema azul"><div class="blue"></div></a>';
			?>			
			<?php 
				echo '<a href="/tw_practica/users/style/'.$current_user['id'].'/orange" title="Tema naranja"><div class="orange"></div></a>';
			?>
			<?php 
				echo '<a href="/tw_practica/users/style/'.$current_user['id'].'/grey" title="Tema gris"><div class="grey"></div></a>';
			?>
			<?php 
				echo '<a href="/tw_practica/users/style/'.$current_user['id'].'/default" title="Tema azul oscuro"><div class="default"></div></a>';
			?>
		</div>	
		<?php endif;?>
	</div>
	<?php if($current_user['role']=='admin'):?>
	<div id="menu">
	<ul>
		<li class="logged">
			<?php echo 'Bienvenido: <br/><b>';
					echo $this->Html->link($this->Formato->acortarUsername($current_user['username']),
							array('controller'=>'users','action'=>'view',$current_user['id']),
							array('title'=>'Ver usuario '.$current_user['username']));
					echo '</b>';?></li>
		<li>
		<?php echo $this->Html->link('Home',
				array('controller'=>'pages','action'=>'index'),
				array('class'=>'menu','title'=>'Ir a home -> Ver los contenidos públicos')); 
		?>
		</li>
		<li>
		<?php echo $this->Html->link('Listar usuarios',
				array('controller'=>'users','action'=>'index'),
				array('class'=>'menu','title'=>'Ver todos los usuarios')); 
		?>
		</li>
		<li>
		<?php echo $this->Html->link('Crear usuario',
				array('controller'=>'users','action'=>'add'),
				array('class'=>'menu','title'=>'Crear un usuario nuevo')); 
		?>
		</li>
		<li>
		<?php echo $this->Html->link('Listar grupos',
				array('controller'=>'groups','action'=>'index'),
				array('class'=>'menu','title'=>'Ver todos los grupos'));
		?>
		</li>
		<li>
		<?php echo $this->Html->link('Crear grupo',
				array('controller'=>'groups','action'=>'add'),
				array('class'=>'menu','title'=>'Crear un grupo nuevo')); 
		?>
		</li>
		<li>
		<?php echo $this->Html->link('Cerrar sesión', 
				array('controller'=>'users','action'=>'logout'),
				array('class'=>'menu','title'=>'Cerrar sesión'));?>
		</li>
	</ul>
	</div>
	<?php elseif($current_user['role']=='member'): ?>	
	<div id="menu">
	<li class="logged">
		<?php echo 'Bienvenido: </br><b>'.$this->Html->link($this->Formato->acortarUsername($current_user['username']),
			array('controller'=>'users','action'=>'view',$current_user['id'])).'</b>';?></li>
	<ul>
		<li>
		<?php echo $this->Html->link('Home',
				array('controller'=>'pages','action'=>'index'),
				array('class'=>'menu','title'=>'Ir a home -> Ver los contenidos públicos')); 
		?>
		</li>
		<li>
		<?php echo $this->Html->link('Mi zona privada',
				array('controller'=>'users','action'=>'index'),
				array('class'=>'menu','title'=>'Ir a mi zona privada'));?>
		</li>
		<li>
		<?php echo $this->Html->link('Mis grupos',
				array('controller'=>'groups','action'=>'index'),
				array('class'=>'menu','title'=>'Ir a mis grupos'));
		?>
		</li>
		<li>
		<?php echo $this->Html->link('Cerrar sesión', 
				array('controller'=>'users','action'=>'logout'),
				array('class'=>'menu','title'=>'Cerrar sesión'));?>
		</li>
	</ul>
	</div>
	<?php endif;?>
	<div id="content">
			<?php echo $this->Session->flash('auth'); ?>
			<?php echo $this->Session->flash(); ?>
			
			<?php echo $this->fetch('content'); ?>
	</div>
		<div id="footer">
			<?php /*echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $myappDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);*/
			?>
		</div>
	</div>
	<?php /*echo $this->element('sql_dump');*/ ?>
</body>
</html>
