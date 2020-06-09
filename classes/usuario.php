<?php

namespace classes\usuario;

class Usuario
{
    private $id;
    private $rol;
    private $nombre;
    private $email;
    private $direccion;
    private $login;
    private $password;
    private $telefono;
    //variable para la conexion
    private $cnx;

    function inicializar($id, $rol, $nombre, $email, $direccion, $login, $password, $telefono)
    {
        $this->id = $id;
        $this->rol = $rol;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->login = $login;
        $this->password = $password;
        $this->telefono = $telefono;
    }
    function __construct($cnx)
    {
        $this->id = 0;
        $this->rol = "";
        $this->nombre = "";
        $this->email = "";
        $this->direccion = "";
        $this->login = "";
        $this->password = "";
        $this->telefono = "";
        $this->cnx = $cnx;
    }

    function setId($id)
    {
        $this->id = $id;
    }
    function getId()
    {
        return $this->id;
    }
    public function getRol()
    {
        return $this->rol;
    }
    public function setRol($rol)
    {
        $this->rol = $rol;
    }
    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    function getNombre()
    {
        return $this->nombre;
    }
    function setEmail($email)
    {
        $this->email = $email;
    }
    function getEmail()
    {
        return $this->email;
    }
    function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
    function getDireccion()
    {
        return $this->direccion;
    }
    function setLogin($login)
    {
        $this->login = $login;
    }
    function getLogin()
    {
        return $this->login;
    }
    function setPassword($password)
    {
        $this->password = $password;
    }
    function getPassword()
    {
        return $this->password;
    }
    function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    function getTelefono()
    {
        return $this->telefono;
    }

    function guardar()
    {
        $nombre = $this->nombre;
        $rol = $this->rol;
        $email = $this->email;
        $dir = $this->direccion;
        $login = $this->login;
        $password = $this->password;
        $tel = $this->telefono;

        $sql = "INSERT INTO usuario VALUES(NULL, '$rol', '$nombre', '$email', 
        '$dir', '$login',md5('$password'), '$tel')";
        $resultado = $this->cnx->execute($sql);

        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function modificar()
    {
        $id = $this->id;
        $rol = $this->rol;
        $nombre = $this->nombre;
        $email = $this->email;
        $dir = $this->direccion;
        $login = $this->login;
        $password = $this->password;
        $tel = $this->telefono;
        $sql = "UPDATE usuario SET rol = '$rol', nombre ='$nombre', email = '$email', direccion = '$dir',  login = '$login', password = '$password', telefono = '$tel' WHERE id=$id";
        $resultado = $this->cnx->execute($sql);
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function eliminar()
    {
        $id = $this->id;
        $sql = "DELETE FROM usuario WHERE id=$id";
        $resultado = $this->cnx->execute($sql);
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function buscar($criterionombre)
    {
        //$id = $this->id;
        $sql = "SELECT * FROM usuario WHERE nombre LIKE '%$criterionombre%' ";
        $resultado = $this->cnx->execute($sql);
        //para evitar errores en la consulta
        //me aseguro que el resultado no sea nulo
        //y que la cantidad de filas afectadas sea mayour a cero
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            return $resultado;
        } else {
            return false;
        }
    }
    function buscarPorId($id)
    {
        //$id = $this->id;
        $sql = "SELECT * FROM usuario WHERE id = $id ";
        $resultado = $this->cnx->execute($sql);
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            //cada vez que se hace una consulta el apuntador apunta a un registro nulo
            //se debe apuntar al siguiente registro para obtener el primer registro de una consulta
            $registro = $this->cnx->next($resultado);
            $this->id = $id;
            $this->rol = $registro["rol"];
            $this->nombre = $registro["nombre"];
            $this->email = $registro["email"];
            $this->direccion = $registro["direccion"];
            $this->login = $registro["login"];
            $this->password = $registro["password"];
            $this->telefono = $registro["telefono"];
            return true;
        } else {
            return false;
        }
    }
    function loguear($login, $password)
    {
        //$id = $this->id;
        $sql = "SELECT * FROM usuario WHERE login = '$login' AND password = MD5('$password') ";
        $resultado = $this->cnx->execute($sql);
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            //cada vez que se hace una consulta el apuntador apunta a un registro nulo
            //se debe apuntar al siguiente registro para obtener el primer registro de una consulta
            $registro = $this->cnx->next($resultado);
            $this->id = $registro["id"];
            $this->rol = $registro["rol"];
            $this->nombre = $registro["nombre"];
            $this->email = $registro["email"];
            $this->direccion = $registro["direccion"];
            $this->login = $registro["login"];
            $this->telefono = $registro["telefono"];
            return true;
        } else {
            return false;
        }
    }
    function buscarabm($criterionombre, $paginadestino)
    {
        //$id = $this->id;
        $sql = "SELECT * FROM usuario WHERE nombre LIKE '%$criterionombre%' ";
        $resultado = $this->cnx->execute($sql);
        //para evitar errores en la consulta
        //me aseguro que el resultado no sea nulo
        //y que la cantidad de filas afectadas sea mayour a cero
        if (isset($resultado) && $this->cnx->filas_afectadas() > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Id. </th>
            <th>Rol</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Login</th>
            <th>Password</th>
            <th>Teléfono</th>
            <th>Modificar</th>
            <th>Eliminar</th>
            </tr>";
            while ($registro = $this->cnx->next($resultado)) {
                $id = $registro["id"];
                $rol = $registro["rol"];
                $nombre = $registro["nombre"];
                $email = $registro["email"];
                $direccion = $registro["direccion"];
                $login = $registro["login"];
                $password = $registro["password"];
                $telefono = $registro["telefono"];
                $linkmodificar = "<a href='$paginadestino?id=$id&op=2'>Modificar</a>";
                $linkeliminar = "<a href='$paginadestino?id=$id&op=3'>Eliminar</a>";

                echo "<tr>
                <th>$id</th>
                <th>$rol</th>
                <th>$nombre</th>
                <th>$email</th>
                <th>$direccion</th>
                <th>$login</th>
                <th>$password</th>
                <th>$direccion</th>
                <th>$linkmodificar</th>
                <th>$linkeliminar</th>
                </tr>";
            }
            echo "</table>";
        } else {
            return false;
        }
    }
}
