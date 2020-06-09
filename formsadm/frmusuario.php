<?php
include_once("../classes/conexion.php");
include_once("../classes/usuario.php");
require_once("../classes/ctrl_sesion.php");

use classes\ctrl_sesion\Ctrl_Sesion;
use classes\conexion\Conexion;
use classes\usuario\Usuario;

Ctrl_Sesion::verificar_inicio_sesion();
$nombre_usuario = Ctrl_Sesion::get_nombre_usuario();

$cnx = new Conexion();
$usuario = new Usuario($cnx);

$criterio = "";

if (isset($_POST["btnBuscar"])) {
    $criterio = $_POST["txtCriterio"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("incluir_estilos_encabezado.php"); ?>
    <title>Gestion de Usuarios</title>
</head>

<body>
    <?php include("incluir_menu_formularios.php"); ?>
    <div style="margin: 30px;">
        <h1>Usuario</h1>
        <div id="form-container" style="margin: 60px">
            <form name="form1" action="frmusuario.php" method="POST">
                <div class="form-group">
                    <label for="productName">Nombre del Usuario</label>
                    <input type="text" class="form-control" id="txtCriterio" name="txtCriterio" value="<?php echo $criterio; ?>">
                </div>
                <button type="submit" class="btn btn-primary" value="Buscar" name="btnBuscar">Enviar</button>
                <hr>
                <?php
                if (isset($_POST["btnBuscar"])) {
                    $usuario->buscarabm($criterio, "frmabmusuario.php");
                }
                ?>
            </form>
            <a href="frmabmusuario.php?op=1">Adicionar</a>
            <h2>
                <?php
                if (isset($_GET["msg"]))
                    echo $_GET["msg"];
                ?>
            </h2>
        </div>
    </div>
    <?php include("incluir_estilos_pie.php"); ?>

</body>

</html>