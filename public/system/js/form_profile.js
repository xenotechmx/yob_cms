$(document).ready(function() {

    /*
        $(this).on('click', '.select-all', function() {

            //Se chequea los de la fila
            $('.'+$(this).attr('data-id')).each(function() {

                switch ($(this).attr('data-type')) {

                    case 'READ':
                        chkVista($(this));
                        break;

                    default:
                        chkCheck($(this));

                }

            });

        });

        $(this).on('click', '.select-row', function() {


            if ($('.'+$(this).attr('data-id')+"-CHK:eq(0)").is(':checked')) {

                chkVista($('.'+$(this).attr('data-id')+"-CHK:eq(0)"));

            } else {

                $('.'+$(this).attr('data-id')+"-CHK").not(':eq(0)').each(function() {

                    chkCheck($(this));

                });

            }

        });

        $(this).on('click', '.READ', function(e) {

            if (!$(this).is(':checked')) {
                $('.'+$(this).attr('data-row')+"-CHK").prop('checked', false);
            }

        });
    */

    $('form', this).on('submit', function (e) {
        e.preventDefault();

        var url = $(this).attr('action');
        $.ajax({
            type       : "POST",
            url        : url,
            data       : $(this).serialize(),
            dataType   : "JSON",
            beforeSend : function() {
                blockForm();
            },
            error: function(jgXHR, ajaxOptions, throwError) {

                unblockForm();
                if (jgXHR.status == 422) {
                    modalErrors(JSON.parse(jgXHR.responseText));
                } else {
                    errorAlert('!Ups, algo salio mal!');
                }
            },
            success    : function(response) {

                console.log(response);
                unblockForm();

                if (response.status == false) {
                    errorAlert(response.message);
                } else {
                    swal({
                        title: "¡Excelente!",
                        text: response.message,
                        type: "success",
                        showCancelButton: false,
                        confirmButtonText: "Aceptar",
                    }).then((willDelete) => {
                        window.location = response.url;
                    });
                }

            }

        });

    });

    $(this).on("click", "#form_profile input[type='checkbox']", function (e) {

        var checked = $(this).is(":checked");
        if( checked == true ){
            $(this).parent().find("input[type='hidden']").val("1");
        }else{
            $(this).parent().find("input[type='hidden']").val("0");
        }

    });

});


function getData(disable){
    var id = $("#id").val();
    var data = {};
    data.id = id;
    var url = $("#id").attr('data-url');
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        data: data,
        error: function(e){
            console.log(e);
        },
        success: function(result){

            $("#nombre").val(result.name);

            var permisos = result.permits;
            permisos = permisos.replace("{","");
            permisos = permisos.replace("}","");
            permisos = permisos.split(",");

            for(var i = 0; i < permisos.length; i++){
                permisos[i] = permisos[i].split(":");
                permisos[i][0] = permisos[i][0].replace('"', "");
                permisos[i][0] = permisos[i][0].replace('"', "");
            }

            for(var i = 0; i < permisos.length; i++){
                checkInputs(permisos[i][0], permisos[i][1]);
            }

            if(disable) {
                $(":input").prop("disabled", true);
            }
        }
    });

}


function checkInputs(id, permisos){

    if(permisos == 1){ // vista
        $('.read-'+id).prop('checked', true);
    }else if(permisos == 3){ //vista - alta
        $('.read-'+id).prop('checked', true);
        $('.create-'+id).prop('checked', true);
    }else if(permisos == 5){ //vista - cambios
        $('.read-'+id).prop('checked', true);
        $('.update-'+id).prop('checked', true);
    }else if(permisos == 9){//vista - baja
        $('.read-'+id).prop('checked', true);
        $('.delete-'+id).prop('checked', true);
    }


    else if(permisos == 2){//vista - baja
        $('.create-'+id).prop('checked', true);
    }
    else if(permisos == 4){//vista - baja
        $('.update-'+id).prop('checked', true);
    }

    else if(permisos == 6){ //alta - cambios
        $('.create-'+id).prop('checked', true);
        $('.update-'+id).prop('checked', true);
    }else if(permisos == 10){ //alta - baja
        $('.create-'+id).prop('checked', true);
        $('.delete-'+id).prop('checked', true);
    }

    else if(permisos == 12){ //cambios - baja
        $('.update-'+id).prop('checked', true);
        $('.delete-'+id).prop('checked', true);
    }

    else if(permisos == 8){ //cambios - baja
        $('.delete-'+id).prop('checked', true);
    }

    else if(permisos == 7){ //vista - alta - cambios
        $('.read-'+id).prop('checked', true);
        $('.create-'+id).prop('checked', true);
        $('.update-'+id).prop('checked', true);
    }

    else if(permisos == 11){ //vista - alta - baja
        $('.read-'+id).prop('checked', true);
        $('.create-'+id).prop('checked', true);
        $('.delete-'+id).prop('checked', true);
    }

    else if(permisos == 13){ //vista - cambios - baja
        $('.read-'+id).prop('checked', true);
        $('.update-'+id).prop('checked', true);
        $('.delete-'+id).prop('checked', true);
    }

    else if(permisos == 15){ //vista - create - baja - cambios
        $('.read-'+id).prop('checked', true);
        $('.create-'+id).prop('checked', true);
        $('.delete-'+id).prop('checked', true);
        $('.update-'+id).prop('checked', true);
    }

    else if(permisos == 14){ //create - baja - cambios
        $('.create-'+id).prop('checked', true);
        $('.delete-'+id).prop('checked', true);
        $('.update-'+id).prop('checked', true);
    }




    $('.update#2').prop('checked', true);

}


/**
 *
 *
 */
function chkVista(element)
{

    if (element.is(':checked')) {

        element.prop('checked', false)
            .attr('data-status', 0);

        //Se limpia toda la fila
        $('.'+element.attr('data-row')+"-CHK").prop('checked', false);

    } else {

        element.prop('checked', true)
            .attr('data-status', 1);

    }

}

/**
 *
 *
 *
 */
function chkCheck(element)
{
    if (element.is(':checked')) {

        element.prop('checked', false);

    } else {

        element.prop('checked', true);

        $('.'+element.attr('data-row')+"-CHK:eq(0)").prop('checked', true)
            .attr('data-status', 1);

    }
}