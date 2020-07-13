<?php

include_once 'config.php';

abstract class DB
{

    private static $db_host = host;
    private static $db_user = user;
    private static $db_pass = pass;
    protected $db_name = BD;
    protected $query;
    protected $rows = array();
    private $conn;
    public $ok = true;
    public $code = '00000';
    public $feedback = array();
    public $insert_id;


# Conectar a la base de datos

    private function open_connection(){

            $this->conn = new mysqli(self::$db_host, self::$db_user,
                self::$db_pass, $this->db_name);

    }

# Desconectar la base de datos

    private function close_connection()
    {
        $this->conn->close();
    }

# Ejecutar un query simple del tipo INSERT, DELETE, UPDATE

    protected function execute_single_query()
    {
        $this->open_connection();
        if ($this->conn->query($this->query)) {
            $this->close_connection();
            $this->ok = true;
            $this->code = '201'; //Sql ejecutada con exito
            $this->construct_response();
        } else {
            $this->ok = false;
            $this->code = '400'; //sql no ejecutada
            $this->construct_response();
        }
    }

# Traer resultados de una consulta en un Array

    protected function get_results_from_query()
    {
        //	echo 'select query : '.$this->query.'<br>';
        $this->open_connection();
        if ($this->conn == false) {
            $this->ok = false;
            $this->code = '400'; //error conexion bd
            $this->construct_response();
        } else {
            $result = $this->conn->query($this->query);
            if ($result != true) {
                $this->ok = false;
                $this->code = '404'; //sql no ejecutada
                $this->construct_response();

            } else {
                //
                if ($result->num_rows == 0) {
                    $this->ok = true;
                    $this->code = '204'; // el recordset viene vacio
                    $this->construct_response();
                } else {
                    for ($i = 0; $i < $result->num_rows; $i++) {
                        $this->rows[] = $result->fetch_assoc();
                    }
                    $result->close();
                    $this->ok = true;
                    $this->code = '200'; // el recordset vuelve con datos
                    $this->construct_response();
                }
            }
            $this->close_connection();
        }
    }
    function last_id(){
        $this->open_connection();
      $id=  $this->conn->insert_id;
        $this->close_connection();
        return $id;
    }


# Construye el array de respuesta de cualquier operación (ok : true/false, code : numero de codigo de error o exito, resource : el recordset correspondiente en caso de un select)

    protected function construct_response()
    {
        $this->feedback['ok'] = $this->ok;
        $this->feedback['code'] = $this->code;
    }


}


