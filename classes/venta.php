<?php

namespace classes\venta;

class Venta
{
    private $id;
    private $fecha;
    private $cliente_id;
    private $estado;
    //atributo para la conexion
    private $cnx;

    //metodo constructor 
    function inicializar($id, $fecha, $cliente_id, $estado)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->cliente_id = $cliente_id;
        $this->estado = $estado;
    }
    function __construct($cnx)
    {
        $this->id = 0;
        $this->fecha = "";
        $this->cliente_id = 0;
        $this->estado = "";
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
    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getCliente_id()
    {
        return $this->cliente_id;
    }

    public function setCliente_id($cliente_id)
    {
        $this->cliente_id = $cliente_id;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    function guardar()
    {
        $cliente_id = $this->cliente_id;
        $fecha = $this->fecha;
        $estado = $this->estado;

        $sql = "insert into ventas values(null,'$fecha', $cliente_id, '$estado')";
        $resultado = $this->cnx->execute($sql);

        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function mostrarVentaPorCliente($idCliente, $nombrereporte)
    {
        $sql = "select * from ventas where cliente_id = $idCliente";
        $resultado = $this->cnx->execute($sql);
        //para evitar errores en la consulta
        //me aseguro que el resultado no sea nulo
        //y que la cantidad de filas afectadas sea mayour a cero
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            echo "<table class='table' style='margin-top: 20px;'>";
            echo "
            <thead class='thead-dark'>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Id.</th>
                    <th scope='col'>Fecha</th>
                    <th scope='col'>Estado</th>
                    <th scope='col'>Ver Reporte</th>
                </tr>
            </thead>
            <tbody>";
            $nro = 1;
            while ($registro = $this->cnx->next($resultado)) {
                $id = $registro["id"];
                $fecha = $registro["fecha"];
                $estado = $registro["estado"];
                //$linkseleccionar = "<a href='$paginadestino?id=$id&op=4'>Adicionar al carrito</a>";
                //en html nosotros podemos inventarnos atributos para así pasar esos atributos y usarlos como parámetros
                $linkseleccionar = "
                <a class='btn btn-primary' href='$nombrereporte?id=$id' target='_blank'> Ver reporte </a>
                ";

                echo "
                <tr>
                    <th scope='row'>$nro</th>
                    <td>$id</td>
                    <td>$fecha</td>
                    <td>$estado</td>
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
