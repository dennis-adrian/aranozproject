<?php

namespace classes\producto;

class Producto
{
    private $id;
    private $codigo;
    private $nombre;
    private $precio;
    private $descripcion;
    private $stock;
    private $estado;
    private $imagen;
    private $categoria_id;

    //atributo para la conexion
    private $cnx;

    //método constructor
    function inicializar($id, $codigo, $nombre, $precio, $descripcion, $stock, $estado, $imagen, $categoria_id)
    {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->stock = $stock;
        $this->estado = $estado;
        $this->imagen = $imagen;
        $this->categoria_id = $categoria_id;
    }
    function __construct($cnx)
    {
        $this->id = 0;
        $this->codigo = "";
        $this->nombre = "";
        $this->precio = 0;
        $this->descripcion = "";
        $this->stock = 0;
        $this->estado = 0;
        $this->imagen = "";
        $this->categoria_id = 0;
        $this->cnx = $cnx;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getCodigo()
    {
        return $this->codigo;
    }
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function getStock()
    {
        return $this->stock;
    }
    public function setStock($stock)
    {
        $this->stock = $stock;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
    public function getCategoria_id()
    {
        return $this->categoria_id;
    }
    public function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $categoria_id;
    }

    function mostrar_producto_categoria($criterionombre, $paginadestino)
    {
        $sql = "SELECT * FROM producto WHERE nombre LIKE '%$criterionombre%' ";
        $resultado = $this->cnx->execute($sql);
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            while ($registro = $this->cnx->next($resultado)) {
                $id = $registro["id"];
                $nombre = $registro["nombre"];
                $precio = $registro["precio"];
                $imagen = $registro["imagen"];
                echo "
                    <div class='col-lg-4 col-sm-6'>
                        <div class='single_product_item'>
                            <a href='$paginadestino?productid=$id'><img src='$imagen' alt='''></a> 
                            <div class='single_product_text'>
                                <h4>$nombre</h4>
                                <h3>$ $precio</h3>
                                <a href='$paginadestino?productid=$id' class='add_cart'>+ add to cart<i class='ti-heart'></i></a>
                            </div>
                        </div>
                    </div>
                ";
            }
        } else {
            return false;
        }
    }
    function mostrar_producto_detalle($id)
    {
        $sql = "SELECT * FROM producto WHERE id = $id";
        $resultado = $this->cnx->execute($sql);
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            $registro = $this->cnx->next($resultado);
            $this->id = $id;
            $this->nombre = $registro["nombre"];
            $this->precio = $registro["precio"];
            $this->categoria_id = $registro["categoria_id"];
            $this->estado = $registro["estado"];
            $this->descripcion = $registro["descripcion"];
            $this->imagen = $registro["imagen"];
            return true;
        } else {
            return false;
        }
    }
    function guardar()
    {
        $codigo = $this->codigo;
        $nombre = $this->nombre;
        $precio = $this->precio;
        $descripcion = $this->descripcion;
        $stock = $this->stock;
        $estado = $this->estado;
        $imagen = $this->imagen;
        $categoria_id = $this->categoria_id;
        $sql = "insert into producto values(null, '$codigo', '$nombre',$precio,$descripcion, $stock, $estado, $imagen,$categoria_id)";
        $resultado = $this->cnx->execute($sql);
        //para evitar errores en la consulta
        //me aseguro que el resultado no sea nulo
        //y que la stock de filas afectadas sea mayor a cero
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function modificar()
    {
        $n = $this->nombre;
        $p = $this->precio;
        $c = $this->stock;
        $id = $this->id;
        $sql = "update productos set nombre ='$n', precio = $p, stock = $c where id=$id";
        $resultado = $this->cnx->execute($sql);
        //para evitar errores en la consulta
        //me aseguro que el resultado no sea nulo
        //y que la stock de filas afectadas sea mayour a cero
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function eliminar()
    {
        $id = $this->id;
        $sql = "delete from productos where id=$id";
        $resultado = $this->cnx->execute($sql);
        //para evitar errores en la consulta
        //me aseguro que el resultado no sea nulo
        //y que la stock de filas afectadas sea mayour a cero
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function buscar($criterionombre)
    {
        //$id = $this->id;
        $sql = "select * from productos where nombre like '%$criterionombre%' ";
        $resultado = $this->cnx->execute($sql);
        //para evitar errores en la consulta
        //me aseguro que el resultado no sea nulo
        //y que la stock de filas afectadas sea mayour a cero
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            return $resultado;
        } else {
            return false;
        }
    }
    function buscarPorId($id)
    {
        //$id = $this->id;
        $sql = "select * from productos where id = $id ";
        $resultado = $this->cnx->execute($sql);
        //para evitar errores en la consulta
        //me aseguro que el resultado no sea nulo
        //y que la stock de filas afectadas sea mayour a cero
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            //cada vez que se hace una consulta el apuntador apunta a un registro nulo
            //se debe apuntar al siguiente registro para obtener el primer registro de una consulta
            $registro = $this->cnx->next($resultado);
            $this->id = $id;
            $this->nombre = $registro["nombre"];
            $this->precio = $registro["precio"];
            $this->stock = $registro["stock"];
            return true;
        } else {
            return false;
        }
    }
    function buscarabm($criterionombre, $paginadestino)
    {
        //$id = $this->id;
        $sql = "select * from productos where nombre like '%$criterionombre%' ";
        $resultado = $this->cnx->execute($sql);
        //para evitar errores en la consulta
        //me aseguro que el resultado no sea nulo
        //y que la stock de filas afectadas sea mayour a cero
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Id. </th><th>Nombre</th><th>Precio bs.</th><th>stock</th><th>Modificar</th><th>Eliminar</th></tr>";
            while ($registro = $this->cnx->next($resultado)) {
                $id = $registro["id"];
                $nombre = $registro["nombre"];
                $precio = $registro["precio"];
                $stock = $registro["stock"];
                $linkmodificar = "<a href='$paginadestino?id=$id&op=2'>Modificar</a>";
                $linkeliminar = "<a href='$paginadestino?id=$id&op=3'>Eliminar</a>";

                echo "<tr><th>$id</th><th>$nombre</th><th>$precio</th><th>$stock</th><th>$linkmodificar</th><th>$linkeliminar</th></tr>";
            }
            echo "</table>";
        } else {
            return false;
        }
    }
    function buscar_seleccion($criterionombre, $paginadestino)
    {
        $sql = "select * from productos where nombre like '%$criterionombre%' ";
        $resultado = $this->cnx->execute($sql);
        //para evitar errores en la consulta
        //me aseguro que el resultado no sea nulo
        //y que la stock de filas afectadas sea mayour a cero
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            echo "<table class='table' style='margin-top: 20px;'>";
            echo "
            <thead class='thead-dark'>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Id.</th>
                    <th scope='col'>Nombre</th>
                    <th scope='col'>Precio Bs.</th>
                    <th scope='col'>stock</th>
                    <th scope='col'>Adicionar</th>
                </tr>
            </thead>
            <tbody>";
            $nro = 1;
            while ($registro = $this->cnx->next($resultado)) {
                $id = $registro["id"];
                $nombre = $registro["nombre"];
                $precio = $registro["precio"];
                $stock = $registro["stock"];
                //$linkseleccionar = "<a href='$paginadestino?id=$id&op=4'>Adicionar al carrito</a>";
                //en html nosotros podemos inventarnos atributos para así pasar esos atributos y usarlos como parámetros
                $linkseleccionar = "
                <button 
                    type='button' 
                    class='btn btn-primary' 
                    data-id= '$id'
                    data-nombre= '$nombre'
                    data-precio= '$precio'
                    data-stock = '$stock'
                    data-toggle='modal' 
                    data-target='#exampleModal'>Adicionar
                </button>
                ";

                echo "
                <tr>
                    <th scope='row'>$nro</th>
                    <td>$id</td>
                    <td>$nombre</td>
                    <td>$precio</td>
                    <td>$stock</td>
                    <td>$linkseleccionar</td>
                </tr>
                ";
                $nro++;
            }
            echo "
                </tbody>
            </table>
            ";
        } else {
            return false;
        }
    }
}
