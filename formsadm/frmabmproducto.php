<?php
include_once("../classes/conexion.php");
include_once("../classes/producto.php");
require_once("../classes/ctrl_sesion.php");

use \classes\producto\Producto;
use \classes\ctrl_sesion\Ctrl_Sesion;
use \classes\conexion\Conexion;

Ctrl_Sesion::verificar_inicio_sesion();
$nombre_usuario = Ctrl_Sesion::get_nombre_usuario();


$cnx = new Conexion();
$producto = new Producto($cnx);

$id = 0;
$codigo = "";
$nombre = "";
$precio = 0;
$descripcion = "";
$stock = "";
$estado = "";
$imagen = "";
$categoria_id = 0;
$op = 0;
$operacion = "";
$error = "";

if (isset($_GET["id"])) {
    $op = $_GET["op"];
    $id = $_GET["id"];
    if ($producto->buscarPorId($id)) {
        $codigo = $producto->getCodigo();
        $nombre = $producto->getNombre();
        $precio = $producto->getPrecio();
        $descripcion = $producto->getDescripcion();
        $stock = $producto->getStock();
        $estado = $producto->getEstado();
        $imagen = $producto->getImagen();
        $categoria_id = $producto->getCategoria_id();
    } else
        header("location:frmproducto.php?msg=No existe el producto");
    switch ($op) {
        case 2:
            $operacion = "Modificar";
            break;
        case 3:
            $operacion = "Eliminar";
            break;
        default:
            header("location:frmproducto.php?msg=Operacion no permitida");
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
    global $cnx;
    global $producto;

    global $codigo;
    global $nombre;
    global $precio;
    global $descripcion;
    global $stock;
    global $estado;
    global $imagen;
    global $categoria_id;
    global $error;

    $codigo = $_POST["txtCodigo"];
    $nombre = $_POST["txtNombre"];
    $precio = $_POST["txtPrecio"];
    $descripcion = $_POST["txtDescripcion"];
    $stock = $_POST["txtStock"];
    $estado = $_POST["txtEstado"];
    $imagen = $_POST["txtImagen"];
    $categoria_id = $_POST["txtCategoria"];
    $producto->inicializar(0, $codigo, $nombre, $precio, $descripcion, $stock, $estado, $imagen, $categoria_id);
    if ($producto->guardar())
        header("location:frmproducto.php?msg=guardad correctamente!!!");
    else
        $error = "Error al adicionar, revise los datos!!!";
}
//Funciones
function procesarModificar()
{ //dentro de la funcion no puedo accedr a las variables globales 
    //si quiero acceder tengo que explicitar con la palabra global
    global $cnx;
    global $producto;

    global $codigo;
    global $nombre;
    global $precio;
    global $descripcion;
    global $stock;
    global $estado;
    global $imagen;
    global $categoria_id;
    global $error;

    $id = $_POST["txtId"];
    $codigo = $_POST["txtCodigo"];
    $nombre = $_POST["txtNombre"];
    $precio = $_POST["txtPrecio"];
    $descripcion = $_POST["txtDescripcion"];
    $stock = $_POST["txtStock"];
    $estado = $_POST["txtEstado"];
    $imagen = $_POST["txtImagen"];
    $categoria_id = $_POST["txtCategoria"];
    $producto->inicializar($id, $codigo, $nombre, $precio, $descripcion, $stock, $estado, $imagen, $categoria_id);
    if ($producto->modificar())
        header("location:frmproducto.php?msg=modificado correctamente!!!");
    else
        $error = "Error al modificar revise los datos !!!";
}
function procesarEliminar()
{ //dentro de la funcio no puedo accedr a las variables globales 
    //si quiero acceder tengo que explicitar con la palabra global
    global $cnx;
    global $producto;

    global $codigo;
    global $nombre;
    global $precio;
    global $descripcion;
    global $stock;
    global $estado;
    global $imagen;
    global $categoria_id;
    global $error;

    $id = $_POST["txtId"];
    $codigo = $_POST["txtCodigo"];
    $nombre = $_POST["txtNombre"];
    $precio = $_POST["txtPrecio"];
    $descripcion = $_POST["txtDescripcion"];
    $stock = $_POST["txtStock"];
    $estado = $_POST["txtEstado"];
    $imagen = $_POST["txtImagen"];
    $categoria_id = $_POST["txtCategoria"];
    $producto->inicializar($id, $codigo, $nombre, $precio, $descripcion, $stock, $estado, $imagen, $categoria_id);
    if ($producto->eliminar())
        header("location:frmproducto.php?msg=eliminado correctamente!!!");
    else
        $error = "Error al eliminar revise los datos !!!";
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
    <title>Registro de productos</title>
</head>

<body>
    <?php include("incluir_menu_formularios.php"); ?>
    <div style="margin: 30px;">
        <h1>Registro de Productos</h1>
        <h2>Operacion: <?php echo $operacion ?></h2>
        <div id="form-container" style="margin: 60px">
            <form name="form1" action="frmabmproducto.php" method="POST">
                <div class="form-group">
                    <input type="hidden" class="form-control" id="txtOperacion" name="txtOperacion" value="<?php echo $op ?>">
                </div>
                <div class="form-group">
                    <label for="txtId">Id del Producto</label>
                    <input type="text" class="form-control" id="txtId" name="txtId" value="<?php echo $id ?>">
                </div>
                <div class="form-group">
                    <label for="txtCodigo">Codigo del Producto</label>
                    <input type="text" class="form-control" id="txtId" name="txtCodigo" value="<?php echo $codigo ?>">
                </div>
                <div class="form-group">
                    <label for="txtNombre">Nombre del Producto</label>
                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $nombre ?>">
                </div>
                <div class="form-group">
                    <label for="txtPrecio">Precio del Producto</label>
                    <input type="number" class="form-control" step="0.01" id="txtPrecio" name="txtPrecio" value="<?php echo $precio ?>">
                </div>
                <div class="form-group">
                    <label for="txtDescripcion">Descripcion del Producto</label>
                    <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" value="<?php echo $descripcion ?>">
                </div>
                <div class="form-group">
                    <label for="txtStock">Stock</label>
                    <input type="number" class="form-control" id="txtStock" name="txtStock" value="<?php echo $stock ?>">
                </div>
                <div class="form-group">
                    <label for="txtEstado">Estado del Producto</label>
                    <input type="text" class="form-control" id="txtEstado" name="txtEstado" value="<?php echo $estado ?>">
                </div>
                <div class="form-group">
                    <label for="txImagen">Link de la Imagen</label>
                    <input type="text" class="form-control" id="txtImagen" name="txtImagen" value="<?php echo $imagen ?>">
                </div>
                <div class="form-group">
                    <label for="txtCategoria">Categoria del Producto</label>
                    <input type="text" class="form-control" id="txtCategoria" name="txtCategoria" value="<?php echo $categoria_id ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="btnAceptar" value="Acptar">Aceptar</button>
                <button type="submit" class="btn btn-primary" name="btnCancelar" value="Cancelar">Cancelar</button>
            </form>
            <h2><?php echo $error; ?></h2>
        </div>
    </div>
    <?php include("incluir_estilos_pie.php"); ?>
</body>

</html>