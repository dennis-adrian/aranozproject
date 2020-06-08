<?php

namespace classes\conexion;

class Conexion
{
    private $servidor = "localhost";
    private $usuario = "root";
    private $password = "";
    private $basededatos = "aranoz";
    public $cnx;
    public function __construct()
    {
        $this->cnx = mysqli_connect($this->servidor, $this->usuario, $this->password, $this->basededatos);
    }
    public function execute($sql)
    {
        return mysqli_query($this->cnx, $sql);
    }
    //esta funcion nos devuleve el ultimo id que ha sido insertado
    public function ultimo_id()
    {
        return @mysqli_insert_id($this->cnx);
    }
    //esta funcion nos devuelve cuantas filas han sido afectadas en la misma consulta
    public function filas_afectadas()
    {
        return @mysqli_affected_rows($this->cnx);
    }
    public function close()
    {
        return @mysqli_close($this->cnx);
    }
    //esta funcion obtiene la siguiente fila de la tabla como un array
    public function next($resultadosql)
    {
        return @mysqli_fetch_array($resultadosql);
    }
    //esta funcion sirve para evitar un SQL Injection
    public function validar($cadena)
    {
        return mysqli_real_escape_string($this->cnx, $cadena);
    }
}
