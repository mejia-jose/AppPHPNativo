<?php 
require_once RUTA_APP.'/config/PDOConn.php';

class Empleado
{

  public function listar_empleados()
  {
    $db = new db();
    $sql = "SELECT e.id,e.nombre,email,sexo,area_id,boletin,descripcion,a.nombre AS nombrearea
            FROM empleado e
            INNER JOIN areas a ON a.id = e.area_id ORDER BY e.id DESC";
    $res = $db->table($sql);
    return $res;
  }

  public function areas()
  {
    $db = new db();
    $sql="SELECT id AS cod, nombre FROM areas ORDER BY nombre ASC";  
    return $db->table($sql);
  }

  public function roles()
  {
    $db = new db();
    $sql="SELECT id, nombre FROM roles ORDER BY nombre ASC";  
    return $db->table($sql);
  }

  public function validar_correo($correo)
  {        
    $db = new db(); 
    $sql = "SELECT id,email FROM empleado WHERE email = :email";
    $params = array(':email' => $correo);
    $res = $db->row($sql, $params);
    return $res;
  }

  public function insertar_empleado($nombre,$correo,$sexo,$area,$desc,$boletin)
  {
    $db = new db();
    $sql = "INSERT INTO empleado (nombre,email,sexo,area_id,boletin,descripcion)
            VALUES (:nombre,:email,:sexo,:area_id,:boletin,:descripcion)";
    $params = array(':nombre' => $nombre,
                    ':email' => $correo,
                    ':sexo' => $sexo,
                    ':area_id' => $area,
                    ':boletin' => $boletin,
                    ':descripcion' => $desc);
    $res = $db->query($sql, $params);
    return $res;
  }

  public function insertar_rol_empleado($idempleado,$idrol)
  {
    $db = new db();
    $sql = "INSERT INTO empleado_rol (empleado_id,rol_id)
            VALUES (:empleado,:rol)";
    $params = array(':empleado' => $idempleado,':rol' => $idrol);
    $res = $db->query($sql, $params);
    return $res;
  }

  public function eliminar_rol($cod)
  {
     $db = new db();
     $delete = "DELETE FROM empleado_rol WHERE empleado_id = :id";
     $res = $db->query($delete,array(':id' => $cod));
     return $res;
  }

  public function eliminar_empleado($cod)
  {
     $db = new db();
     $delete = "DELETE FROM empleado WHERE id = :id";
     $res = $db->query($delete,array(':id' => $cod));
     return $res;
  }

  public function roles_empleado($cod)
  {
    $db = new db();
    $sql="SELECT empleado_id,rol_id FROM empleado_rol WHERE empleado_id = :id";  
    return $db->table($sql,array(':id' => $cod));
  }

  public function formatear_correo($email)
  {
    $db = new db();
    $update = "UPDATE empleado SET email = '' WHERE email = :email";
    $res = $db->query($update,array(':email'=>$email));
    return $res;

  }

  public function editar_empleado($cod,$nombre,$correo,$sexo,$areas,$desc,$boletin)
  {
    $db = new db();
    $update = "UPDATE empleado SET 
                               nombre = :n,
                               email = :e,
                               sexo = :s,
                               area_id = :a,
                               boletin = :b,
                               descripcion = :d 
                               WHERE id = :id";
    $params = array(':id' =>$cod,':n'=>$nombre,':e' =>$correo,':s'=>$sexo,':a'=>$areas,':b'=>$boletin,':d'=>$desc);
    $res = $db->query($update,$params);
    return $res;
  }
 


  public function editarUsuariosTeams($cod,$identificacion,$nombres,$apellidos,$email,$tipo,$pass){
    $update = "UPDATE usuarios_teams SET identificacion = :id, 
                                         nombres = :nombres, 
                                         apellidos = :ape, 
                                         correo = :correo, 
                                         tipo = :tipo, 
                                         password = :pass 
                                         WHERE codigo = :cod";
    $params =  array(':cod'=>$cod,
                   ':id'=>$identificacion,
                   ':nombres'=>$nombres,
                   ':ape'=>$apellidos,
                   ':correo'=>$email,
                   ':tipo'=>$tipo,
                   ':pass'=>$pass);

    $res = $this->query($update,$params);
    return $res;

  }
 
}

?>