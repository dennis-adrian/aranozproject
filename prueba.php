<?php

use \classes\ctrl_session\Ctrl_Sesion;

include_once 'classes/ctrl_sesion.php';
Ctrl_Sesion::verificar_inicio_sesion();

$nombre_usuario = Ctrl_Sesion::get_nombre_usuario();
echo ($nombre_usuario);
