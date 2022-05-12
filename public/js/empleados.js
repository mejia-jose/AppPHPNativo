$(document).ready(function()
{
    combobox('areas', 'Empleados/loadareas', 'Seleccione...');
    listarEmpleados();
})

//funcíon javascript para listar los empleados en datatable
function listarEmpleados()
{
    $('#tbl_empleado').dataTable({
        ajax: "Empleados/listarEmpleados",
        "aoColumnDefs": [{
            "aTargets": [0]
        }],
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron programa",
            "sEmptyTable": "No hay Datos registrados en el sistema",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _END_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sLoadingRecords": "Cargando Datos...",
            "sSearch": "Buscar: ",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
        },
        "searching": true,
        "aaSorting": [
            [0, 'desc']
        ],
        "aLengthMenu": [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "Todos"] // change per page values here
        ],
        initComplete: function(oSettings, json) {
            $('[data-rel="tooltip"]').tooltip();
        },
        "iDisplayLength": 5
    });
}

//función click para abrirl el modal de nuevo empleado
$("#nuevo").click(function()
{
    loadRoles(0);
    $("#modal_titulo").html('Nuevo empleado');
    $("#frmNuevo")[0].reset();
    $("#guardarcambios").hide();
    $("#registrar").show()
    $("#m_registro_empleado").modal('show');
});

//función click para listar los roles con checkbox
function loadRoles(id)
{
    fetch('Empleados/loadRoles?idempleado='+id,{ metho:"POST" })
    .then( (res) => 
    {
        if(res.ok) { return res.json(); }
    })
    .then(( json ) => 
    {
        if(json.success)
        {
            let html = " <div class='col-md-12'><label>Roles <span class='require'>*</span></label></div><br>";
            json.roles.map( (item) =>
            { 
                
                html +=`<div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-check" >
                                    <input class="form-check-input" type="checkbox" value="${item.id}" id="${item.id}" name="roles">
                                    <label class="form-check-label" for="defaultCheck1">${ item.nombre}</label>
                                    </div>
                                </div>
                        </div>`;

            })

            $("#divroles").html(html);
        }
    }).catch( (err) =>
    {
        toastr.error("Ha ocurrido un error.");
    })
}

//función para listar las areas en el select
function combobox(id, url, inival, params)
{
    var localurl = url;
    $.ajax({
        url: localurl,
        type: "POST",
        data: {
            params: params
        },
        jsonpCallback: id,
        dataType: "JSON",
        success: function(json) 
        {
            
            var option = "<option value=''>" + inival + "</option>";
            $.each(json, function(k, v)
            {
                option += "<option value='" + v.cod + "'>" + v.nombre + "</option>";
            });
            $("#" + id).html(option);
        }
    });
}

function validaciones()
{
    let sexo = $("input[type='radio'][name='sexo']:checked").val();
    let checkbox = $("input[name=roles]:checked");
    let emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    sw = false;
    if ($.trim($("#nombre").val()) == '')
    {
        toastr.error("Por favor ingrese el nombre del empleado.");
        $("#nombre").focus();

    } else if ($("#correo").val() == '')
    {
        toastr.error("Por favor ingrese un correo electrónico.");
        $("#correo").focus();

    }else if (!emailRegex.test($("#correo").val()))
    {
        toastr.error("Correo electrónico invalido.");
        $("#correo").focus();

    } else if (sexo == undefined)
    {
        toastr.error("Por favor seleccione el sexo del empleado.");

    } else if ($("#areas").val() == '') {

        toastr.error("Por favor seleccione un área.");
        $("#areas").focus();

    } else if ($("#desc").val() == '') {

        toastr.error("Por favor ingrese una descripción.");
        $("#desc").focus();

    } else if(checkbox.length == 0)
    {
            toastr.error("Error: debe seleccionar uno o más roles para este empleado.");
        
    }else{
        sw = true;
    }

    return sw;
}

//función click para enviar los datos al servidor
$("#registrar").click(function()
{
    if(validaciones())
    {
        const jsonString =
        {
            'url' : 'Empleados/nuevo',
            'msj' : 'Empleado registrado correctamente',
            'options' : 'add'

        }
        jfetch(jsonString);
    }
  
})

function jfetch(jsonString)
{
    let arrayRoles = [];
    let checkbox = $("input[name=roles]:checked");
    checkbox.each(function()
    {
        if($(this).is(':checked'))
        {
            arrayRoles.push($(this).val());
       }
    });
    const {url,msj,option} = jsonString;
    const data = new FormData($("#frmNuevo")[0]);
    data.append('roles',arrayRoles);
    data.append('boletin', $("input[type='checkbox'][name='boletin']:checked").val());

    fetch(url, { method:"POST", body:data })
    .then( (res) => 
    {
        if(res.ok){ return res.json();} else { throw "Error, fallo en la comunicación"; }
    })
    .then( (json) =>
    {
        if(json.success)
        {
            toastr.success(msj);
            $("#m_registro_empleado").modal('hide');
            $('#tbl_empleado').DataTable().ajax.reload();
            $("#frmNuevo")[0].reset();
        }else
        {
            toastr.error(json.mensaje);
        }
    })
    .catch( ( err ) =>
    {
        toastr.error( err.mensaje );
    })
}

//modal de confirmar eliminación
function confirmar(id)
{
    $("#codigo").val(id);
    $("#m_eliminar_empleado").modal('show');
}

$("#ok").click(function()
{
    
    const data = new FormData($("#frmEliminar")[0]);
    fetch('Empleados/eliminar', { method:"POST", body:data })
    .then( (res) => 
    {
        if(res.ok){ return res.json();} else { throw "Error, fallo en la comunicación"; }
    })
    .then( (json) =>
    {
        if(json.success)
        {
            toastr.success("Empleado eliminado exitosamente.");
            $("#m_eliminar_empleado").modal('hide');
            $('#tbl_empleado').DataTable().ajax.reload();
        }else
        {
            toastr.error(json.mensaje);
        }
    })
    .catch( ( err ) =>
    {
        toastr.error( err.mensaje );
    })
        
    
})

function editar(id,nombre,email,sexo,area_id,descripcion,boletin)
{
    loadRoles(id)
    $("#nombre").val(nombre);
    $("#correo").val(email);
    $("#cod").val(id)
    if (sexo == 'M')
    {
         document.getElementById('sexo1').checked = true;
    }else
    {
          document.getElementById('sexo2').checked = true;
    }
    if(boletin == 1)
    {
        document.getElementById('boletin').checked = true;
    }else
    {
        document.getElementById('boletin').checked = false
    }
    $("#areas").val(area_id); 
    $("#desc").val(descripcion); 
    $("#modal_titulo").html('Editar empleado');
    $("#guardarcambios").show();
    $("#registrar").hide()
    $("#m_registro_empleado").modal('show');
}

$("#guardarcambios").click(function()
{
    if(validaciones())
    {
        const jsonString =
        {
            'url' : 'Empleados/editar',
            'msj' : 'Información actualizada correctamente',
            'options' : 'edit'

        }
        jfetch(jsonString);
    }
})

/* function loadRolesAsignados(id)
{
    fetch('Empleados/loadRoles?idempleado='+id,{ metho:"POST" })
    .then( (res) => 
    {
        if(res.ok) { return res.json(); }
    })
    .then(( json ) => 
    {
        if(json.success)
        {
            let html = " <div class='col-md-12'><label>Roles <span class='require'>*</span></label></div><br>";
            let check = ""
            json.roles.map( (item) =>
            {
                json.rol_asignado.map( (asignados) =>
                {
                   
                    if(asignados.rol_id == item.id)
                    {
                        check = 'checked="true"';
                        html =`<div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-check" >
                                    <input class="form-check-input" type="checkbox" value="${item.id}" id="${item.id}" name="roles" ${check}">
                                    <label class="form-check-label" for="defaultCheck1">${ item.nombre}</label>
                                    </div>
                                </div>
                        </div>`;
                        console.log(asignados.rol_id+' +'+item.id)

                    }
                })
                console.log(asignados.rol_id+' +'+item.id)

            })

            $("#divroles").html(html);
        }
    }).catch( (err) =>
    {
        toastr.error("Ha ocurrido un error.");
    })
}
 */