<?php
//============uso de namespaces============
use classes\ctrl_sesion\Ctrl_Sesion;
//=========================================
include_once("../classes/ctrl_sesion.php");
//$session = new ctrl_sesion();
//$session->cerrar_session();
Ctrl_Sesion::cerrar_sesion();
