<?php if(!empty($group)): ?>
	<div id="contentheader">
		<h1>Ver grupo<b> <?php echo htmlentities($group['Group']['name']); ?></b> </h1>

	<?php if($current_user['role']=='admin'):?>
		<div class="nav">
			<span><?php echo 'Estás en:';?><br>
			<?php echo $this->Html->link('Grupos',
					array('action'=>'index'),
					array('title'=>'Ver todos los grupos'));?> --> Ver grupo 
			<b><?php echo htmlentities($group['Group']['name']);?></b>
			</span>
		</div>
	<?php else:?>
		<div class="nav">
			<span><?php echo 'Estás en:';?><br>
			<?php echo $this->Html->link('Mis grupos',
					array('action'=>'index'),
					array('title'=>'Ver mis grupos'));?> --> Ver grupo 
			<b><?php echo htmlentities($group['Group']['name']);?></b>
			</span>
		</div>
	
	<?php endif;?>
	</div>
	<div id="contentcontent">
		<table>
		<tr>
			<th>Nombre del grupo</th>
			<th>Responsable del grupo</th>
			<th>Nº de Usuarios en el grupo</th>
			<th>Acciones</th>
		</tr>
		<tr>
			<td><b><?php echo htmlentities($group['Group']['name']); ?></b></td>
			<td>
				<?php
					if($group['Group']['user_id']==NULL){
						echo $this->Html->link('No asignado',
							array('action'=>'addManager',$group['Group']['id'],null),
							array('title'=>'Asignar un responsable al grupo '.$group['Group']['name']));			
					} else{
					echo $this->Html->link($group['User']['username'],
						array('controller'=>'users','action'=>'view',$group['User']['id']),
						array('title'=>'Ver el usuario '.$group['User']['username']));
					}	
				?>
			</td>
			<td><?php echo count($group['Team']); ?> usuario/s</td>
			<td class="actions">
			<?php if($current_user['role']=='admin'):?>
			<?php echo $this->Html->link('Editar',
					array('action'=>'edit',$group['Group']['id']),
					array('class'=>'actions','title'=>'Editar el grupo '.$group['Group']['name']),
					'...quieres editar el grupo '.$group['Group']['name'].'?');?>
			<?php echo $this->Form->postLink('Eliminar',
					array('action'=>'delete',$group['Group']['id']),
					array('class'=>'actions','title'=>'Eliminar el grupo '.$group['Group']['name']),
					'...quieres eliminar el grupo '.$group['Group']['name'].'?');?>
			<?php endif;?>
			<?php if($group['Group']['user_id']==$current_user['id']):?>
			<?php echo $this->Html->link('Crear Reunión',
					array('controller'=>'meetings','action'=>'add',$group['Group']['id']),
					array('class'=>'actions','title'=>'Crear nueva reunión para el grupo '.$group['Group']['name']));?>
			<?php endif;?>
			<?php if($current_user['role']=='admin'):?>
			<p class="actions">
			<?php echo $this->Html->link('Añadir Usuario/s',
					array('controller'=>'teams','action'=>'addUser',$group['Group']['id']),
					array('class'=>'actions','title'=>'Añadir uno o varios usuarios al grupo '.$group['Group']['name']),
					'...quieres añadir uno o varios usuarios al grupo '.$group['Group']['name'].'?');?>
			<?php echo $this->Html->link('Quitar Usuario/s',
					array('controller'=>'teams','action'=>'deleteUser',$group['Group']['id']),
					array('class'=>'actions','title'=>'Quitar uno o varios usuarios del grupo '.$group['Group']['name']),
					'...quieres quitar uno o varios usuarios del grupo '.$group['Group']['name'].'?');?>
			</p>
			<?php endif;?>
			</td>
		</tr>
		<tr>
		<th class="description_th" colspan="4" title="Pulse para expandir/contraer">
			<div class="arrow_description"><?php echo $this->Html->image('arrow-down.gif', array('alt' => 'plegar'));?></div>
			Descripción </th>
		</tr>
		</table>
		<div class="description_div" ><p><?php echo nl2br(htmlentities($group['Group']['description'])); ?></p></div>
		
	<div class="info">
		<div class="slider_1" title="Pulse para expandir/contraer">
			<div class="arrow_1"><?php echo $this->Html->image('arrow-up.gif', array('alt' => 'plegar'));?></div>
			<h3>Reuniones del grupo <b><?php echo htmlentities($group['Group']['name']); ?></b></h3>
		</div>
		<div class="down_1">
				<?php if($group['Group']['user_id']==$current_user['id']):?>
					<p class="p_slider">
					Usuario <b><?php echo $current_user['username'];?></b> <u>eres el responsable</u> del grupo <b><?php echo htmlentities($group['Group']['name']); ?></b>
					</p>
					<p class="p_slider"><?php echo $this->Html->link('Crear Reunión',
						array('controller'=>'meetings','action'=>'add',$group['Group']['id']),
						array('class'=>'actions','title'=>'Crear nueva reunión para el grupo '.$group['Group']['name']));?>
					</p>
				<?php else:?>
					<p class="p_slider">Usuario <b><?php echo $current_user['username'];?></b> <u>no eres el responsable</u> del grupo <b><?php echo htmlentities($group['Group']['name']); ?></b></p>
				<?php endif;?>
				<?php if(count($group['Meeting'])!=0):	?>
				<table>
					<?php foreach($meetings as $meeting):?>
						<tr class="meeting">
							<td class="meetingDate">
							<?php echo $this->Html->link($this->Formato->acortarFechaMeeting($meeting['Meeting']['date']),
									array('controller'=>'meetings','action'=>'view',$meeting['Meeting']['id']),
									array('title'=>'Ver la reunión '.$meeting['Meeting']['title']));?>							
							</td>
							<td><?php echo $this->Html->link($meeting['Meeting']['title'],
									array('controller'=>'meetings','action'=>'view',$meeting['Meeting']['id']),
									array('title'=>'Ver la reunión '.$meeting['Meeting']['title']));?></td>
							<!--<td>
							<?php echo 'Archivo';/*if($meeting['Meeting']['description']==NULL){
										echo 'No hay descripción';
									}else{
										echo $this->Formato->acortarString10($meeting['Meeting']['description']);
									};*/?>
							</td>-->
							<td class="actions">
							<?php
								echo $this->Html->link('Ver',
									array('controller'=>'meetings','action'=>'view',$meeting['Meeting']['id']),
									array('class'=>'actions','title'=>'Ver la reunión '.$meeting['Meeting']['title']));?>
							<?php if($current_user['id']==$group['Group']['user_id']):?>
							<?php 
								echo $this->Html->link('Editar',
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
							<?php 
								echo $this->Html->link('Añadir contenidos',
									array('controller'=>'contents','action'=>'add',$meeting['Meeting']['id']),
									array('class'=>'actions','title'=>'Añadir contenidos a la reunión '.$meeting['Meeting']['title']),
									'...quieres añadir contenidos a la reunión '.$meeting['Meeting']['title'].'?');
							?>
							<!--<?php 
								echo $this->Html->link('Eliminar contenidos',
									array('controller'=>'contents','action'=>'delete',$meeting['Meeting']['id'],$meeting['Meeting']['id']),
									array('class'=>'actions','title'=>'Eliminar contenidos a la reunión '.$meeting['Meeting']['title']),
									'...quieres eliminar contenidos a la reunión '.$meeting['Meeting']['title'].'?');
							?>-->
							</p>
							<?php endif;?>
							</td>						
							<?php 
									if(count($meeting['Content'])==0){
										echo '<tr class="content">';
										echo '<td class="content" colspan="4">No hay contenidos en esta reunión</td>';
										echo '</tr>';
									}else{
										foreach($meeting['Content'] as $content){
											echo '<tr class="content">';
											echo '<td class="content" colspan="1"><p>';
											echo $this->Html->link($content['title'],
												array('controller'=>'contents','action'=>'view',$content['id']),
												array('title'=>'Ver contenido '.$content['title']));
											echo '</p></td>';
											echo '<td class="content"><p>';
											echo $this->Html->link($this->Formato->acortarString20($content['file']),
												array('controller'=>'contents','action'=>'download',$content['id'],$content['file']),
												array('title'=>'Descargar el archivo '.$content['file']));
											echo '</p></td>';
											echo '<td class="content"><p>';
											echo ($content['status']=='public') ? 'Público':'Privado';
											echo '</p></td>';
											echo '</tr>';
										}
									};?>
				<?php endforeach;?>
				</table>
				<?php else: ?>
				<p class="p_slider">No hay reuniones</p>
				<?php endif;?>
		</div>
	</div>
	<div class="info">
		<div class="slider_2" title="Pulse para expandir/contraer">
		<div class="arrow_2"><?php echo $this->Html->image('arrow-up.gif', array('alt' => 'plegar'));?></div>
		<h3>Usuarios que pertenecen al grupo <b><?php echo htmlentities($group['Group']['name']);?></b></h3>
			
		</div>
		<div class="down_2">
		<?php if(count($group['Team']) == 0): ?>
		<p class="p_slider">
			<?php echo 'El grupo <b>';
					echo htmlentities($group['Group']['name']);
					echo '</b> no tiene ningún usuario ';
					echo '¿Quieres '; 
					echo $this->Html->link('añadir',	array(
						'controller'=>'teams','action'=>'addUser',
						$group['Group']['id']),array('title'=>'Añadir uno o varios usuarios al grupo ' .$group['Group']['name']),
						'...quieres añadir uno o varios usuarios al grupo '.$group['Group']['name'].'?');
					echo ' uno o varios usuarios al grupo?';?>
		</p>
		<?php else:?>
			<div>
			<?php if($group['Group']['user_id'] == NULL):?>
				<p class="p_slider">El grupo <b><?php echo htmlentities($group['Group']['name']);?></b> no tiene ningún responsable</p>
				<p class="p_slider">¿Desea 
				<?php echo $this->Html->link('asignar un responsable',
								array('action'=>'addManager',$group['Group']['id']),
								array('title'=>'Asignar un responsable al grupo '.$group['Group']['name']));?> al grupo <b>
				<?php echo htmlentities($group['Group']['name']);?>
				</b></p>
			<?php else:?>
				<p class="p_slider">El responsable del grupo <b><?php echo htmlentities($group['Group']['name']);?></b> es el usuario <b>
				<?php 
					echo $this->Html->link($group['User']['username'],
						array('controller'=>'users','action'=>'view',$group['User']['id']),
						array('title'=>'Ver el usuario '.$group['User']['username']));	
				?>
				</b></p>
			<?php endif;?>
			</div>
			<table class="subtable">
				<tr>
					<th>Nombre de usuario</th>
					<th>Rol</th>
					<?php if($current_user['role']=='admin'):?> 
					<th>Email</th>
					<th>Acciones</th>
					<?php endif;?>
				</tr>
				<?php foreach($group['Team'] as $user):?>
					<tr>
					<td>
					<p>
						<?php 
							echo $this->Html->link($user['User']['username'],
								array('controller'=>'users','action'=>'view',$user['User']['id']),
								array('title'=>'Ver el usuario '.$user['User']['username']));	
						?>
					</p>
					</td>
					<td>
						<?php echo ($group['Group']['user_id']==$user['User']['id']) ? '<b>Responsable</b>': 'Miembro';?>
					</td>
					<?php if($current_user['role']=='admin'):?>
					<td>
					<p>
						<?php
							echo $this->Formato->acortarEmail($user['User']['email']);
						?>					
					</p>
					</td>
					<td class="actions">
					<?php echo $this->Form->postLink('Quitar usuario',
							array('controller'=>'teams','action'=>'delete',$user['User']['id'],$user['id']),
							array('class'=>'actions','title'=>'Dar de baja al usuario '.$user['User']['username'].' del grupo '.$group['Group']['name']),
							'...quieres dar de baja al usuario '.$user['User']['username'].' del grupo '.$group['Group']['name'].'?');
					?>
					<?php 
						if($user['User']['id']==$group['User']['id']){
							echo $this->Form->postLink('Quitar responsable',
							array('action'=>'deleteManager',$group['Group']['id']),
							array('class'=>'actions','title'=>'Desasignar como responsable del grupo '.$group['Group']['name'].' al usuario '.$user['User']['username']),
							'...quieres desasignar a '.$user['User']['username'].' como responsable del grupo '.$group['Group']['name'].'?');					
						}else{
							echo $this->Form->postLink('Ser responsable',
							array('action'=>'addManager',$group['Group']['id'],$user['User']['id']),
							array('class'=>'actions','title'=>'Asignar como responsable del grupo '.$group['Group']['name'].' al usuario '.$user['User']['username']),
							'...quieres asignar a '.$user['User']['username'].' como responsable del grupo '.$group['Group']['name'].'?');
						}
					?>
					</td>
					<?php endif;?>
					</tr>
				<?php endforeach;?>
			</table>
		<?php endif;?>
		</div>
	</div>
</div>
<?php else:?>
	<div id="contentheader">
		<h1>El grupo no existe</h1>
	</div>
<?php endif;?>