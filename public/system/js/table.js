$(document).ready(function () {

    var order_by = 0;
    var order_type = "asc";
    if ($("#table_principal").attr("order-by") != undefined) {
        order_by = $("#table_principal").attr("order-by");
    }

    if ($("#table_principal").attr("type-order") != undefined) {
        order_type = $("#table_principal").attr("type-order");
    }

    $('#table_principal').DataTable({
        // dom: 'Bfrtip',
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ],
        "order": [[order_by, order_type]],
        "aaSorting": [[0, "desc"]],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No existen registros para mostrar",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No existen registros para mostrar",
            "infoFiltered": "(Filtrando de _MAX_ registros)",
            "paginate": {
                "previous": "Anterior",
                "next": "Siguiente"
            },
            "search": "Buscar"
        }
    });
    //$('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');


    $(this).on('click', '.btn-delete', function (e) {
        e.preventDefault();

        var route = $(this).attr('href');
        var message_used = "";

        Swal.fire({
            title: 'Mensaje',
            text: '¿Deseas eliminar el registro seleccionado?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: 'get',
                    url: route,
                    dataType: 'json',
                    beforeSend: function () {
                        blockForm();
                    },
                    error: function () {
                        unblockForm();

                        errorAlert('Experimentamos fallas técnicas, intentelo más tarde.');
                    },
                    success: function (response) {
                        unblockForm();

                        if (response.status == true) {
                            swal({
                                title: "¡Excelente!",
                                text: response.message,
                                type: "success",
                                showCancelButton: false,
                                confirmButtonText: "Aceptar",
                            }).then((result) => {
                                window.location = response.url;
                            });
                        } else {
                            errorAlert(response.message);
                        }
                    }
                });

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Swal.fire(
                //     'Cancelled',
                //     'Your imaginary file is safe :)',
                //     'error'
                // )
            }
        })

    });


});