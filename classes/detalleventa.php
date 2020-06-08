<?php

namespace classes\detalleventa;

class DetalleVenta
{
    private $id;
    private $venta_id;
    private $producto_id;
    private $cantidad;
    private $precio;
    //atributo solo para memoria, no para la base de datos
    private $nombre;
    //atributo para la conexion
    private $cnx;

    //metodo constructor
    function inicializar($id, $venta_id, $producto_id, $cantidad, $precio, $nombre)
    {
        $this->id = $id;
        $this->venta_id = $venta_id;
        $this->producto_id = $producto_id;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->nombre = $nombre;
    }
    function __construct($cnx)
    {
        $this->cnx = $cnx;
        $this->inicializar(0, 0, 0, 0, 0, "");
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getVenta_id()
    {
        return $this->venta_id;
    }

    public function setVenta_id($venta_id)
    {
        $this->venta_id = $venta_id;
    }

    public function getProducto_id()
    {
        return $this->producto_id;
    }

    public function setProducto_id($producto_id)
    {
        $this->producto_id = $producto_id;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setCnx($cnx)
    {
        $this->cnx = $cnx;
    }

    function guardar()
    {
        $venta_id = $this->venta_id;
        $producto_id = $this->producto_id;
        $cantidad = $this->cantidad;
        $precio = $this->precio;

        $sql = "insert into detalleventas values(null,$venta_id, $producto_id, $cantidad, $precio)";
        $resultado = $this->cnx->execute($sql);

        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
