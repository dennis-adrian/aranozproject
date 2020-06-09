<?php
//============uso de namespaces============
use classes\conexion\Conexion;
use classes\ctrl_session\Ctrl_Sesion;
use classes\usuario\Usuario;

//=========================================
include_once("classes/conexion.php");
include_once("classes/usuario.php");
include_once("classes/ctrl_sesion.php");
Ctrl_Sesion::activar_sesion();
$cnx = new Conexion();
$usuario = new Usuario($cnx);

$id = 0;
$nombre = "";
$email = "";
$direccion = "";
$login = "";
$password = "";
$telefono = "";

$op = 0;
$operacion = "";
$error = "";

//funciones
function procesarAdicionar()
{
    //se pone global para acceder a las variables globales desde una funcion
    global $usuario;

    global $nombre;
    global $email;
    global $direccion;
    global $login;
    global $password;
    global $telefono;
    global $error;

    $nombre = $_POST["txtNombre"];
    $email = $_POST["txtEmail"];
    $login = $_POST["txtLogin"];
    $password = $_POST["txtPassword"];
    $direccion = $_POST["txtDireccion"];
    $telefono = $_POST["txtTelefono"];

    $usuario->inicializar(0, 'cliente', $nombre, $email, $direccion, $login, $password, $telefono);
    if ($usuario->guardar())
        header("location:login.php?msg=cliente registrado correctamente!!! Puede iniciar sesión");
    else {
        $error = "Error al adicionar, revise los datos!!!";
    }
}
//=========
if (isset($_POST["btnAceptar"]))
    procesarAdicionar();
?>
<!doctype html>
<html lang="zxx">

<head>
    <?php include 'head.php'; ?>
</head>

<body>
    <!--::header part start::-->
    <?php include 'header.php' ?>
    <!-- Header part end-->


    <!-- breadcrumb start-->
    <section class="breadcrumb breadcrumb_bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb_iner">
                        <div class="breadcrumb_iner_item">
                            <h2>Tracking Order</h2>
                            <p>Home <span>-</span> Tracking Order</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb start-->

    <!--================login_part Area =================-->
    <section class="login_part padding_top">
        <div class="container">
            <div class="row text-align-center">
                <div class="col-lg-12 col-md-6">
                    <div class="login_part_form text-center">
                        <div class="login_part_form_iner">
                            <h3>First time ? <br>
                                Please Register</h3>
                            <form class="row contact_form" action="#" method="post" novalidate="novalidate">
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="" placeholder="name">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="txtEmail" name="txtEmail" value="" placeholder="email">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="txtLogin" name="txtLogin" value="" placeholder="username">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" value="" placeholder="password">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" value="" placeholder="address">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" value="" placeholder="phone number">
                                </div>
                                <div class="col-md-6 form-group">
                                    <a href="index.php" class="btn_3" name="txtCancelar">
                                        cancel
                                    </a>
                                </div>
                                <div class="col-md-6 form-group">
                                    <button type="submit" value="submit" class="btn_3" name="btnAceptar">
                                        register
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================login_part end =================-->

    <!--::footer_part start::-->
    <?php include_once 'footer.php'; ?>
    <!--::footer_part end::-->

    <?php include_once 'jsincludes.php'; ?>
</body>

</html>