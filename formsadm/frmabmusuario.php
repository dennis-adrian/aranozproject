<?php
include_once("../classes/conexion.php");
include_once("../classes/usuario.php");
require_once("../classes/ctrl_sesion.php");
//---------- USES DE LAS CLASES DE NAMESPACES ----
use \classes\ctrl_sesion\Ctrl_Sesion;
use \classes\conexion\Conexion;
use \classes\usuario\Usuario;
//-----------------------------------------------
Ctrl_Sesion::verificar_inicio_sesion();
$nombre_usuario = Ctrl_Sesion::get_nombre_usuario();

$cnx = new Conexion();
$usuario = new Usuario($cnx);

$id = 0;
$rol = "";
$nombre = "";
$email = "";
$direccion = "";
$login = "";
$password = "";
$telefono = "";

$op = 0;
$operacion = "";
$error = "";

if (isset($_GET["id"])) {
    $op = $_GET["op"];
    $id = $_GET["id"];
    if ($usuario->buscarPorId($id)) {
        $rol = $usuario->getRol();
        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail();
        $direccion = $usuario->getDireccion();
        $login = $usuario->getLogin();
        $password = $usuario->getPassword();
        $telefono = $usuario->getTelefono();
    } else
        header("location:frmusuario.php?msg=No existe el usuario");
    switch ($op) {
        case 2:
            $operacion = "Modificar";
            break;
        case 3:
            $operacion = "Eliminar";
            break;
        default:
            header("location:frmusuario.php?msg=Operacion no permitida");
            break;
    }
} else {
    if (isset($_GET["op"]) && $_GET["op"] == 1) {
        $op = 1;
        $operacion = "Adicionar";
    }
}
//=================verificnado metodo post
//funciones
function procesarAdicionar()
{
    //se pone global para acceder a las variables globales desde una funcion
    global $usuario;

    global $rol;
    global $nombre;
    global $email;
    global $direccion;
    global $login;
    global $password;
    global $telefono;
    global $error;

    $rol = $_POST["txtRol"];
    $nombre = $_POST["txtNombre"];
    $email = $_POST["txtEmail"];
    $direccion = $_POST["txtDireccion"];
    $login = $_POST["txtLogin"];
    $password = $_POST["txtPassword"];
    $telefono = $_POST["txtTelefono"];

    $usuario->inicializar(0, $rol, $nombre, $email, $direccion, $login, $password, $telefono);
    if ($usuario->guardar())
        header("location:frmusuario.php?msg=guardado correctamente!!!");
    else {
        $error = "Error al adicionar, revise los datos!!!";
    }
}
//Funciones
function procesarModificar()
{ //dentro de la funcion no puedo accedr a las variables globales 
    //si quiero acceder tengo que explicitar con la palabra global
    global $usuario;
    global $id;
    global $rol;
    global $nombre;
    global $email;
    global $direccion;
    global $login;
    global $password;
    global $telefono;
    global $error;
    $id = $_POST["txtId"];
    $rol = $_POST["txtRol"];
    $nombre = $_POST["txtNombre"];
    $email = $_POST["txtEmail"];
    $direccion = $_POST["txtDireccion"];
    $login = $_POST["txtLogin"];
    $password = $_POST["txtPassword"];
    $telefono = $_POST["txtTelefono"];
    $usuario->inicializar($id, $rol, $nombre, $email, $direccion, $login, $password, $telefono);
    if ($usuario->modificar())
        header("location:frmusuario.php?msg=modificado correctamente!!!");
    else {
        $error = "Error al modificar revise los datos !!!";
    }
}
function procesarEliminar()
{ //dentro de la funcio no puedo accedr a las variables globales 
    //si quiero acceder tengo que explicitar con la palabra global
    global $cnx;
    global $usuario;
    global $id;
    global $rol;
    global $nombre;
    global $email;
    global $direccion;
    global $login;
    global $password;
    global $telefono;
    global $error;
    $id = $_POST["txtId"];
    $rol = $_POST["txtRol"];
    $nombre = $_POST["txtNombre"];
    $email = $_POST["txtEmail"];
    $direccion = $_POST["txtDireccion"];
    $login = $_POST["txtLogin"];
    $password = $_POST["txtPassword"];
    $telefono = $_POST["txtTelefono"];
    $usuario->inicializar($id, $rol, $nombre, $email, $direccion, $login, $password, $telefono);
    if ($usuario->eliminar())
        header("location:frmusuario.php?msg=eliminado correctamente!!!");
    else {
        $error = "Error al eliminar revise los datos !!!";
    }
}
//=========
if (isset($_POST["btnAceptar"])) {
    $op = $_POST["txtOperacion"];
    switch ($op) {
        case 1:
            procesarAdicionar();
            break;
        case 2:
            procesarModificar();
            break;
        case 3:
            procesarEliminar();
            break;
        default:
            echo "no hay operacion";
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("incluir_estilos_encabezado.php"); ?>
    <title>Registro de Usuario</title>
</head>

<body>
    <?php include("incluir_menu_formularios.php"); ?>
    <div style="margin: 30px;">
        <h1>Registro de Usuarios</h1>
        <h2>Operacion: <?php echo $operacion ?></h2>
        <div id="form-container" style="margin: 60px">
            <form name="form1" action="frmabmusuario.php" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" id="txtOperacion" name="txtOperacion" value="<?php echo $op ?>">
                </div>
                <div class="form-group">
                    <input type="radio" name="txtRol" id="txtRol" class="form-input" value="admin" />
                    <label for="admin">admin</label><br>
                    <input type="radio" name="txtRol" id="txtRol" class="form-input" value="cliente" />
                    <label for="cliente">cliente</label><br>
                </div>

                <div class="form-group">
                    <label for="txtId">Nombre</label>
                    <input type="text" class="form-control" id="txtId" name="txtId" value="<?php echo $id ?>">
                </div>
                <div class="form-group">
                    <label for="txtNombre">Nombre</label>
                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $nombre ?>">
                </div>
                <div class=" form-group">
                    <label for="txtEmail">Email</label>
                    <input type="text" class="form-control" id="txtEmail" name="txtEmail" value="<?php echo $email ?>">
                </div>
                <div class="form-group">
                    <label for="txtDireccion">Dirección</label>
                    <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" value="<?php echo $direccion ?>">
                </div>
                <div class="form-group">
                    <label for="txtLogin">Login </label>
                    <input type="text" class="form-control" id="txtLogin" name="txtLogin" value="<?php echo $login ?>">
                </div>
                <div class="form-group">
                    <label for="txtPassword">Password del Usuario</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" value="<?php echo $password ?>">
                </div>
                <div class="form-group">
                    <label for="txtTelefono">Teléfono</label>
                    <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" value="<?php echo $telefono ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="btnAceptar" value="Aceptar">Aceptar</button>
                <button type="submit" class="btn btn-primary" name="btnCancelar" value="Cancelar">Cancelar</button>

            </form>
            <h2><?php echo $error; ?></h2>
        </div>

    </div>
    <?php include("incluir_estilos_pie.php"); ?>
</body>

</html>