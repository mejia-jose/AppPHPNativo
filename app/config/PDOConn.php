<?php
date_default_timezone_set('America/Bogota');
require_once 'config.php';

class db {
    /*Funciones de operacion retorna 0 o 1*/
    function query($sql,$params=null){
        try {
            
            $conn= new PDO(connstring,user,pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $sw= true; 
        } catch (Exception $ex) {
            echo "ERROR: " . $ex->getMessage();
            // $sw=json_encode(array("mensaje" => $ex->getMessage()));
            $sw=false;
        }
    return $sw;
    }

    /*Devuelve una fila*/
    function row($sql,$params=null){
        try {
            
            $conn= new PDO(connstring,user,pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $ex) {
            echo "ERROR: " . $ex->getMessage();
        }
    return $row;
    }

    /*Devuelve una id del que se insertó*/
    function DataRow($sql,$params=null){
        try {
            
            $conn= new PDO(connstring,user,pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $DataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $ex) {
            echo "ERROR: " . $ex->getMessage();
        }
    return $DataRow;
    }

    /*Devuelve una tabla*/
    function table($sql,$params=null){
        $data=array();
        
        try {
            
            $conn= new PDO(connstring,user,pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            while( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;   
            }  
        } catch (Exception $ex) {
            echo "ERROR: " . $ex->getMessage();
        }
    return $data;
    }

    /*Devuelve una conjunto de id de los registros actualizados*/
    function DataTable($sql,$params=null){
        $data=array();
        
        try {
            
            $conn= new PDO(connstring,user,pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            while( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;   
            }  
        } catch (Exception $ex) {
            echo "ERROR: " . $ex->getMessage();
        }
    return $data;
    }

    
    function urlraiz()
    {
        $url = "http://localhost";
        return $url;
    }
}

?>

