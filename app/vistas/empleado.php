<!doctype html>
<html lang="es">

<head>
    <title>Prueba Técnica</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Mobland - Mobile App Landing Page Template">
    <meta name="keywords" content="HTML5, bootstrap, mobile, app, landing, ios, android, responsive">

    <!-- Font -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="public/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Main css -->
    <link href="public/css/style.css" rel="stylesheet">
    <link href="public/assets/css/toastr.min.css" rel="stylesheet">
    <style>
        .require
        {
            color:red;
        }
    </style>
</head>
<header class="bg-gradient" id="home">
    <h4>Prueba Técnica</h4>
</header>

<div class="content-header pd">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Lista de empleados</h1>
            </div>
        </div>
    </div>
</div>
<section class="content pd">
    <div class="row">
        <div class="col-lg-12 card card-default">
            <div class="box">
                <div class="box-body">
                    <div style="padding: 10px;">
                        <button type="button" id="nuevo" class="btn btn-success"><i class="fa fa-user"></i> Nuevo
                            empleado </button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover" id="tbl_empleado">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><i class="fa fa-user"></i> Nombre</th>
                                <th><i class="fa fa-envelope" aria-hidden="true"></i> Email</th>
                                <th><i class="fa fa-mars-stroke" aria-hidden="true"></i> Sexo</th>
                                <th><i class="fa fa-briefcase" aria-hidden="true"></i> Área</th>
                                <th><i class="fa fa-envelope-o" aria-hidden="true"></i> Boletín</th>
                                <th>Eliminar</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="m_registro_empleado">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_titulo">Nuevo empleado</h4>
            </div>
            <div class="modal-body">
                <form id="frmNuevo" method="POST">
                    <input type="hidden" name="cod" id="cod">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre completo <span class="require">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo del empleado">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Correo electrónico <span class="require">*</span></label>
                                <input type="text" class="form-control" id="correo" name="correo"
                                    placeholder="Ingrese una dirección  de correo electrónico">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Sexo <span class="require">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexo" id="sexo1" value="M">
                                    <label class="form-check-label" for="sexo1">Masculino </label><br>
                                    <input class="form-check-input" type="radio" name="sexo" id="sexo2" value="F">
                                    <label class="form-check-label" for="flexRadioDefault2">Femenino</label>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Área <span class="require">*</span></label>
                                <select class="form-control" id="areas" name="areas"> </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-floating">
                                    <label for="floatingTextarea">Descripción <span class="require">*</span></label>
                                    <textarea class="form-control" name="desc"  id="desc" placeholder="Escribir una descripción" id="floatingTextarea"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="boletin" name="boletin">
                                    <label class="form-check-label" for="defaultCheck1"> Deseo recibir boletín informativo</label>
                                </div>
                            </div>
                        </div>
                   </div>

                   <div class="row" id="divroles">
                       
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="registrar" class="btn btn-success"><i class="fa fa-save"></i> Registar
                    Información</button>
                <button type="button" id="guardarcambios" style="display:none;" class="btn btn-success"><i
                        class="fa fa-save"></i> Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="m_eliminar_empleado">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_titulo">Confirmación</h4>
            </div>
            <div class="modal-body">
                <form id="frmEliminar" method="POST">
                    <input type="hidden" name="codigo" id="codigo">
                    <h4>¿Esta seguro(a) que desea eliminar este empleado(a)?</h4>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="ok" class="btn btn-success"><i class="fa fa-trash-o" aria-hidden="true"></i> Ok</button>

            </div>
        </div>
    </div>
</div>

<footer class="my-5 text-center">
    <p class="mb-2"><small>COPYRIGHT © 2022. TODOS LOS DERECHOS RESERVADOS</small></p>

</footer>

<!-- jQuery and Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="public/js/jquery-3.2.1.min.js"></script>
<script src="public/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<!-- Datatable buttons -->
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="public/assets/js/toastr.min.js"></script>
<script src="public/js/empleados.js"></script>

</body>

</html>