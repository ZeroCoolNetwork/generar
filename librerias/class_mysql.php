<?php

/**
 * @author Noe Francisco Martinez Merino <nfrancisco@gmail.com>
 * @category GPL License 
 * @name GeneraProyect ;
 * 
 */
class MySql {

    public static function SelectDb() {
        $link = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
        $db_list = mysql_list_dbs($link);
        $select = '<select name="database" id="database">
            <option value=""></option>';
        while ($row = mysql_fetch_object($db_list)) {
            $select .='<option value="' . $row->Database . '">' . $row->Database . '</option>';
        }

        $select .= '</select>';

        return $select;
    }

    public static function GenaraTable($DataBase = false) {

        $msg = "";
        $dbname = $DataBase;

        if (!mysql_connect(DB_SERVER, DB_USER, DB_PASS)) {
            echo 'Error en la Coneccion';
            exit;
        }

        $sql = "SHOW TABLES FROM $dbname";
        $result = mysql_query($sql);

        if (!$result) {
            $msg .= "Error no existe la tabla en la lista\n";
            $msg .= 'MySQL Error: ' . mysql_error();
            exit;
        }

        while ($row = mysql_fetch_row($result)) {
            $msg.= ' <li class="nav-header">' . $row[0] . '</li>';
            $msg .= '<li><a href="#" id="table" database="' . $dbname . '" data-id="' . $row[0] . '">Registrar</a></li>';
            $msg .= '<li><a href="#" id="manto" database="' . $dbname . '" data-id="' . $row[0] . '">Mantenimiento</a></li>';
        }

        mysql_free_result($result);

        return $msg;
    }

    public static function Consulta($query, $database) {
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
        mysql_select_db($database);
        if (!$link = mysql_query($query, $con)) {
            die(mysql_error());
        }

        return $link;
    }

    public function formularioEdit($tabla, $id, $database) {
        $tipo = "";
        header("Content-Type: text/html; charset=iso-8859-1");
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
        mysql_select_db($database);
        $result = mysql_query("select * from $tabla", $con);
        $ids = mysql_field_name($result, 0);
        $result1 = mysql_query("select * from $tabla where $ids = $id", $con);

        $total_campos = mysql_num_fields($result);
        $total_registros = mysql_num_rows($result1);
        $this->_form .= '<form id="editar" method="post" action="../accion/editar.php"><p>
            <input type="hidden" name="database" id="database" value="' . $database . '"/>
            <input type="hidden" name="table" id="table" value="' . $tabla . '" />
        <input type="hidden" name="id" id="id" value="' . $id . '" />';

        for ($j = 0; $j < $total_registros; $j++) {

            for ($i = 0; $i < $total_campos; $i++) {
                $tipo .= mysql_field_flags($result, $i);
                $tipos = explode(' ', $tipo);
                if ($tipos[2] == "auto_increment") {
                    
                } else {

                    $this->_form .= '<div class="span3"><label>' . mysql_field_name($result, $i) . '</label><input type="text" value="' . mysql_result($result1, $j, $i) . '" name="' . mysql_field_name($result, $i) . '" id="' . mysql_field_name($result, $i) . '"></div>';
                }
            }
        }
        $this->_form .= '<div class="span4"><label></label><label><button class="btn btn-primary">Guardar</button></label></div>';
        $this->_form .= '</p></form>';
        return $this->_form;
    }

    public function formularioIdAutoincrement($tabla, $database) {
        $tipo = "";
        $tipos = "";
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
        mysql_select_db($database);
        $result = mysql_query("select * from $tabla", $con);
        $total_campos = mysql_num_fields($result);
        $this->_form .= '<form id="guardar" method="post" action="../accion/guardar.php"><p>
            <input type="hidden" name="database" id="database" value="' . $database . '"/>
            <input type="hidden" name="table" id="table" value="' . $tabla . '" />';

        for ($i = 0; $i < $total_campos; $i++) {
            $tipo .= mysql_field_flags($result, $i);
            $tipos = explode(" ", $tipo);
            if ($tipos[2] == "auto_increment") {
                
            } else {

                $this->_form .= '<div class="span4"><label>' . mysql_field_name($result, $i) . '</label><input type="text" name="' . mysql_field_name($result, $i) . '" id="' . mysql_field_name($result, $i) . '" required /></div>';
            }
        }
        $this->_form .= '<div class="span4"><label></label><label><button class="btn btn-primary">Guardar</button></label></div>';
        $this->_form .= '</p></form>';

        return $this->_form;
    }

    public function GuardarForm($tabla, $database) {
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
        mysql_select_db($database);
        $result = mysql_query("select * from $tabla", $con);
        $total_campos = mysql_num_fields($result);
        $campos = array();
        $val = array();
        for ($i = 0; $i < $total_campos; $i++) {
            $campos[$i] = mysql_field_name($result, $i);
            $val[$i] = $_POST[mysql_field_name($result, $i)];
        }

        $valores = "'" . implode(array_values($val), "','") . "'";
        $camp = implode(array_values($campos), ',');
        $q = 'INSERT INTO `' . $tabla . '` (' . $camp . ') VALUES (' . $valores . ')';

        $sql = mysql_query($q, $con) or die(mysql_error());
        return $msg = "Registro Guardado";
    }

    public function EliminarDatos($tabla, $id, $database) {
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
        mysql_select_db($database);
        $result = mysql_query("select * from $tabla", $con);
        $ids = mysql_field_name($result, 0);
        $del = mysql_query("DELETE FROM $tabla where $ids = $id");
        $msg = 'Registro Eliminado';
        return $msg;
    }

    public function Editar($tabla, $id, $database) {
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
        mysql_select_db($database);
        $result = mysql_query("select * from $tabla", $con);
        $total_campos = mysql_num_fields($result);
        $campos = array();
        $val = array();
        

        $ids = mysql_field_name($result, 0);

        for ($i = 1; $i < $total_campos; $i++) {
            $campos[$i] = mysql_field_name($result, $i);
            $val[$i] = $_POST[mysql_field_name($result, $i)];
        }

            
        $valores = array_values($val);
        $camp = array_values($campos);

        $j = 0;
        $query = "UPDATE " . $tabla . " SET ";
        while ($camp[$j]) {
            if ($j > 0) {
                $query.=", ";
            }

            $query.=$camp[$j] . " = '" . $valores[$j] . "'";
            $j++;
        }
        $query.="  WHERE $ids = $id ";
        mysql_query($query) or die(mysql_error());
        $msg = "Registro Actualizado";
        return $msg;
    }

}

