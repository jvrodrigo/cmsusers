<?php if($current_user['role']=='admin'):?>
	<div id="contentheader">
	<h1>Listar Usuarios</h1>
		<div class="nav">
			<span><?php echo 'Estás en:';?><br>
			<?php echo $this->Html->link('Usuarios',array('action'=>'index'),array('title'=>'Ver todos los usuarios'));?></span>
		</div>
		<!--<div id="search">
			<input class="search" type="text" id="texto" size="30"/>	
		</div>-->
	</div>
	<div id="contentcontent">
	<?php
			//echo $this->Form->create('User',array('action'=>'delete'));
			//echo $this->fetch('buffer');
		?>
		<table>
		<tr>
			<th>Nombre de usuario</th>
			<th>Email</th>
			<th>Último acceso</th>
			<th>Nº de Grupos que participa</th>
			<th>Acciones</th>
		</tr>
		<?php
			
			foreach($users as $user):
		?>
		<tr>
			<td><?php
					/*if($user['User']['role']!='admin'){// Multiple checkbox
						echo $this->Form->create('User',array('action'=>'delete'));
						echo $this->Form->input('id.',
							array(
								'id'=>'UserId_'.$user['User']['id'],'value'=>$user['User']['id'],
								'label'=>'','type'=>'checkbox','multiple'=>'checkbox','checked'=>false,'div'=>false
							));
					}*/
					echo $this->Html->link($user['User']['username'],
					array('action'=>'view', $user['User']['id']),
					array('title'=> 'Ver usuario '.$user['User']['username']));?></td>
			<td><?php echo $user['User']['email'];?></td>			
			</td>
			<td><?php echo $this->Formato->modified($user['User']['created'],$user['User']['modified']);?></td>
			<td><?php echo $this->Html->link(count($user['Team']).' grupo/s',
						array('action'=>'view',$user['User']['id'])); ?></td>
			<td class="actions">
				<?php echo $this->Html->link('Ver',
						array('action'=>'view',$user['User']['id']),
						array('class'=>'actions','title'=>'Ver el usuario '.$user['User']['username']));?>
				<?php echo $this->Html->link('Editar',
						array('action'=>'edit',$user['User']['id']),
						array('class'=>'actions','title'=>'Editar el usuario '.$user['User']['username']),
						'...quieres editar el usuario '.$user['User']['username'].'?');?>
						
				<?php 
						//echo $this->Form->end();
				echo $this->Form->postLink('Eliminar',
						array('action'=>'delete',$user['User']['id']),
						array('class'=>'actions','title'=>'Eliminar el usuario '.$user['User']['username']),
						'...quieres eliminar el usuario '.$user['User']['username'].'?');
						echo $this->Form->submit('',array('type'=>'hidden'));
						?>
				<p class="actions">
				<?php echo $this->Html->link('Añadir Grupo/s',
						array('controller'=>'teams','action'=>'addGroup',$user['User']['id']),
						array('class'=>'actions','title'=>'Añadir uno o varios grupos al usuario '.$user['User']['username']),
						'...quieres añadir un grupo al usuario '.$user['User']['username'].'?');?>
				<?php echo $this->Html->link('Quitar Grupo/s',
						array('controller'=>'teams','action'=>'deleteGroup',$user['User']['id']),
						array('class'=>'actions','title'=>'Quitar uno o varios grupos al usuario '.$user['User']['username']),
						'...quieres quitar uno o varios grupos al usuario '.$user['User']['username'].'?');?>
				</p>
			</td>
		</tr>
		<?php endforeach;?>
		<!--<tr><td colspan="5">
		<?php
			//echo $this->Form->select('selector',array('run'=>'Eliminar selección'),array('title' => 'Acciones por lote','required'=>true));
			//echo $this->Form->end('Eliminar',array('title' => 'Acciones por lote')); 
		?></td></tr>-->
		</table>
	</div>
<?php elseif($current_user['role']=='member'): ?>
	<div id="contentheader">
	<h1>Mi Zona Privada</h1>
	<div class="nav">
		<span><?php echo 'Estás en:';?></span><br>
		<?php echo $this->Html->link('Mi zona privada',
				array('action'=>'index'),
				array('title'=>'Ir a mi zona privada'));?>
	</div>
	</div>
	<div id="contentcontent">
		<table>
		<tr>
			<th>Nombre de usuario</th>
			<th>Email</th>
			<th>Tus grupos</th>
			<th>Último acceso</th>
			<th>Acciones</th>	
		</tr>
			<td><?php echo $this->Html->link($user['User']['username'],
							array('action'=>'view',$user['User']['id']),
							array('title'=>'Ver usuario '.$user['User']['username']));?></td>
			<td><?php echo $user['User']['email'];?></td>
			<td>
				<?php $i=count($user['Team']);
						echo $this->Html->link($i.' grupo/s',
							array('controller'=>'groups','action'=>'index'),
							array('title'=>'Ir a mis grupos'));
				?>
			</td>
			<td><?php echo $this->Formato->modified($user['User']['created'],$user['User']['modified'])?></td>
			<td class="actions">
			<?php echo $this->Html->link('Ver',
						array('action'=>'view',	$user['User']['id']),
						array('class'=>'actions','title'=>'Ver el usuario '.$user['User']['username']));?>
			<?php echo $this->Html->link('Editar',
						array('action'=>'edit',$user['User']['id']),
						array('class'=>'actions','title'=>'Cambiar contraseña o mail del usuario '.$user['User']['username']),'...quieres editar el usuario '.$user['User']['username'].'?');?>
			</td>
		</table>
	</div>
<?php endif;?>
	