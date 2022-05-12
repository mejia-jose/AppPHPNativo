<?php
class Empleados extends Controlador
{
    public function __construct()
    {
        session_start();
        $this->mEmpleado = $this->modelo('Empleado');

        //vairables tipo POST
        $this->nombre = (isset($_POST['nombre'])) ? trim($_POST['nombre']) : "";
        $this->correo = (isset($_POST['correo'])) ? trim($_POST['correo']) : "";
        $this->sexo = (isset($_POST['sexo'])) ? trim($_POST['sexo']) : "";
        $this->areas = (isset($_POST['areas'])) ? trim($_POST['areas']) : "";
        $this->desc = (isset($_POST['desc'])) ? trim($_POST['desc']) : "";
        $this->boletin = (isset($_POST['boletin'])) ? trim($_POST['boletin']) : "";
        $this->roles = (isset($_POST['roles'])) ? trim($_POST['roles']) : "";
        $this->cod = (isset($_POST['codigo'])) ? trim($_POST['codigo']) : "";
        $this->codigo = (isset($_POST['cod'])) ? trim($_POST['cod']) : "";

        //variables get
        $this->idempleado = (isset($_GET['idempleado'])) ? trim($_GET['idempleado']) : "";

    }

    public function listarEmpleados()
    {
        $createtable = array('data' => array());
        $table = $this->mEmpleado->listar_empleados();
        foreach ($table as $datarow => $data)
        {
 
            $eliminar = '<a class="btn btn-default btn-lg" onclick="confirmar(\''.$data['id'].'\')">
                           <i style="width: 40px;" class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>';
            $editar = '<a class="btn btn-default btn-lg" onclick="editar(\''.$data['id'].'\',\''.$data['nombre'].'\',\''.$data['email'].'\',\''.$data['sexo'].'\',\''.$data['area_id'].'\',\''.$data['descripcion'].'\',\''.$data['boletin'].'\')">
                             <i style="width: 40px;" class="fa fa-pencil-square" aria-hidden="true"></i>
                        </a>';
            $sexo = ($data['sexo'] == "M") ? "Masculino" : "Femenino";
            $boletin = ($data['boletin'] == 1) ? "Si" : "No"; 
            
            array_push(
                    $createtable['data'], 
                    array(
                        $data['id'],
                        $data['nombre'], 
                        $data['email'],
                        $sexo,
                        $data['nombrearea'],
                        $boletin,
                        $eliminar,
                        $editar
                    )
                );
        }   
        $json = json_encode($createtable);
        echo $json;
    }
 
  //Función para las areas
  public function loadAreas()
  {
      $areas = $this->mEmpleado->areas();
      $json = json_encode($areas);
      echo $json;
  }

  //función para los roles
  public function loadRoles()
  {
      $roles = $this->mEmpleado->roles();
      $json = json_encode(array('success'=>false,'roles'=>""));

      if(count($roles) > 0)
      {
          $rolesEmpleado = ($this->idempleado != 0) ? $this->mEmpleado->roles_empleado($this->idempleado) : 0;
         $json = json_encode(array('success'=>true,'roles'=>$roles,"rol_asignado"=>$rolesEmpleado));
      }
      
      echo $json;
  }

  //función para el registro de empleados
  public function nuevo()
  {
      $estado = false;
      $mensaje = "Hubo un error";
      if($this->nombre != "" && $this->correo != "" && $this->sexo !="" && $this->areas != "" && $this->desc !="" && count( $this->roles) > 0)
      {
         $validarCorreo = $this->mEmpleado->validar_correo($this->correo);
         if(!$validarCorreo)
         {
             $boletin = ($this->boletin == 'on') ? 1 : 0;

             if($insert = $this->mEmpleado->insertar_empleado($this->nombre,$this->correo,$this->sexo,$this->areas,$this->desc,$this->boletin))
             {
                $empleado = $this->mEmpleado->validar_correo($this->correo);
                $roles = explode(',',$this->roles);

               for($i = 0; $i < count($roles); $i++)
               {
                   if($rolEmpleado = $this->mEmpleado->insertar_rol_empleado($empleado['id'],$roles[$i]))
                   {
                       $estado = true;
                   }
               }
             }
         }else
         {
            $mensaje = "Error, el correo electrónico ingresado ya pertenece a otro empleado.";
         }

      }else
      {
          $mensaje = "Error, debe rellenar todos los campos obligatorios del formulario.";
      }

      $json = json_encode(array("success" => $estado, "mensaje" => $mensaje));
      echo $json;
  }

  public function editar()
  {
    $estado = false;
    $mensaje = "Hubo un error";
    if($this->codigo != "" && $this->nombre != "" && $this->correo != "" && $this->sexo !="" && $this->areas != "" && $this->desc !="" && count( $this->roles) > 0)
    {
       $this->mEmpleado->formatear_correo($this->correo);

       $validarCorreo = $this->mEmpleado->validar_correo($this->correo);
       if(!$validarCorreo)
       {
           $boletin = ($this->boletin == 'on') ? 1 : 0;

           if($update = $this->mEmpleado->editar_empleado($this->codigo,$this->nombre,$this->correo,$this->sexo,$this->areas,$this->desc,$boletin))
           {
              $empleado = $this->mEmpleado->eliminar_rol($this->codigo);
              $roles = explode(',',$this->roles);

             for($i = 0; $i < count($roles); $i++)
             {
                 if($rolEmpleado = $this->mEmpleado->insertar_rol_empleado($this->codigo,$roles[$i]))
                 {
                     $estado = true;
                 }
             }
           }
       }else
       {
          $mensaje = "Error, el correo electrónico ingresado ya pertenece a otro empleado.";
       }

    }else
    {
        $mensaje = "Error, debe rellenar todos los campos obligatorios del formulario.";
    }

    $json = json_encode(array("success" => $estado, "mensaje" => $mensaje));
    echo $json;
  }

  public function eliminar()
  {
      $estado = false;
      $msj = "Hubo un error, inténtelo más tarde.";
    if($this->cod != "")
    {
         if($query = $this->mEmpleado->eliminar_rol($this->cod))
         {
            if($query1 = $this->mEmpleado->eliminar_empleado($this->cod))
            {
                $estado = true;
                $msj = "Ok";
            } 
         }
    }else
    {
        $mensaje = "Error, debe rellenar todos los campos obligatorios del formulario.";
    }

    $json = json_encode(array("success"=>$estado,"mensaje"=>$msj));
    echo $json;
  }

}

?>

