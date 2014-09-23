<?php
// app/Model/Content.php
class Content extends AppModel{
	var $name = 'Content';
	var $belongsTo = array(
        'Meeting' => array(
				'className' => 'Meeting'
			));
	public $validate = array(
		'title' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'flashMessage'=> 'Porfavor introduzca un título para el nuevo contenido'
		))/*,
		'file' => array(
			'rule' => array('fileSize', '<=', '8MB'),
			'message'=> 'El archivo tiene que ser menor de 8MB'		
		)*/);
// Función recursiva para borrar una carpeta y sus archivos
public function eliminarDir($carpeta){
	foreach(glob($carpeta . "/*") as $archivos_carpeta){
		if (is_dir($archivos_carpeta)){
			$this->eliminarDir($archivos_carpeta);
		}
		else{
			unlink($archivos_carpeta);
		}
	}
	rmdir($carpeta);
}
}