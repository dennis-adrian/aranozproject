<?php
//============uso de namespaces============
use classes\ctrl_session\Ctrl_Sesion;
//=========================================
include_once("../classes/ctrl_sesion.php");
//$session = new Ctrl_Session();
//$session->cerrar_session();
Ctrl_Sesion::cerrar_sesion();
