<?php
//---------- USES DE LAS CLASES DE NAMESPACES ----
use \classes\conexion\Conexion;
use \classes\usuario\Usuario;
use classes\ctrl_sesion\Ctrl_Sesion;

//-----------------------------------------------
include_once("classes/conexion.php");
include_once("classes/usuario.php");
include_once("classes/ctrl_sesion.php");

Ctrl_Sesion::activar_sesion();

$cnx = new Conexion();
$usuario = new Usuario($cnx);

$id = 0;
$login = "";
$password = "";
$rol = "";

$error = "";

//=================verificnado metodo post
//funciones
function procesarIniciarSession()
{
  //se pone global para acceder a las variables globales desde una funcion
  global $usuario;
  global $login;
  global $password;
  global $rol;
  global $error;


  $login = $_POST["txtLogin"];
  $password = $_POST["txtPassword"];

  if ($usuario->loguear($login, $password) == true) {
    //guardar datos en la session
    $id = $usuario->getId();
    $nombre = $usuario->getNombre();
    $rol = $usuario->getRol();
    Ctrl_Sesion::iniciar_sesion($login, $id, $nombre, $rol);
    if ($rol === "cliente") {
      header("location:index.php?msg=logueado correctamente");
    } else {
      header("location:formsadm/index.php?msg=logueado correctamente");
    }
  } else {
    $error = "Error al iniciar revise sus datos de acceso";
  }
}
//si preciona en el boton iniciar seccion
if (isset($_POST["btnAceptar"])) {
  procesarIniciarSession();
}

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <?php include 'head.php'; ?>
</head>

<body>
  <!--::header part start::-->
  <?php include 'header.php'; ?>
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
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-6">
          <div class="login_part_text text-center">
            <div class="login_part_text_iner">
              <h2>New to our Shop?</h2>
              <p>
                There are advances being made in science and technology
                everyday, and a good example of this is the
              </p>
              <a href="register.php" class="btn_3">Create an Account</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="login_part_form">
            <div class="login_part_form_iner">
              <h3>
                Welcome Back ! <br />
                Please Sign in now
              </h3>
              <form class="row contact_form" action="login.php" method="post" novalidate="novalidate">
                <div class="col-md-12 form-group p_star">
                  <input type="text" class="form-control" id="txtLogin" name="txtLogin" value="<?php echo $login ?>" placeholder="email">
                </div>
                <div class="col-md-12 form-group p_star">
                  <input type="password" class="form-control" id="txtPassword" name="txtPassword" value="<?php echo $password ?>" placeholder="password">
                </div>
                <div class="col-md-12 form-group">
                  <div class="creat_account d-flex align-items-center">
                    <input type="checkbox" id="f-option" name="selector">
                    <label for="f-option">Remember me</label>
                  </div>
                  <button type="submit" class="btn_3" name="btnAceptar" value="Aceptar">
                    log in
                  </button>
                  <a class="lost_pass" href="">forget password?</a>
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