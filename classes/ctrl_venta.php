<?php

namespace classes\ctrl_venta;

use Exception;

class Ctrl_Venta
{
    //si la venta se guarda bien, retorna el id de la venta, si no, retorna 0
    public static function guardar_venta($cnx, $objVenta, $carrito)
    {
        try {
            //con start transaction le avisamos al servidor que todas las operaciones ya sea insert, select, delete
            //que se ejecuten a partir de esta linea no se confirmen hasta que se haga un commit, o que se anulen en caso de 
            //que se haga un rollback
            $cnx->execute("start transaction");
            //en caso de que no se puedan guardar los datos, se ejecuta un rollback
            if (!$objVenta->guardar()) {

                $cnx->execute("rollback");
                return 0;
            } else {
                //para guardar el detalle de venta necesito el id del objVenta 
                $id_venta_guardada = $cnx->ultimo_id();
                //recorremos el carrito
                foreach ($carrito->list as $item) {
                    $item->setVenta_id($id_venta_guardada);
                    //en caso de que la conexión se destruya por deshuso, volvemos a setear la conexión
                    $item->setCnx($cnx);
                    if (!$item->guardar()) {
                        $cnx->execute("rollback");
                        return "hubo rollback";
                    }
                }
                //si se terminan de guardar todos los objetos del carrito en detalle_venta entonces confirmamos la transacción
                //y con esto gurdamos tanto la venta como el detalle venta
                $cnx->execute("commit");
                return $id_venta_guardada;
            }
        } catch (Exception $E) {
            $cnx->execute("rollback");
            return false;
        }
    }
}
