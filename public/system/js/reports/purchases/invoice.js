$(document).ready(function () {

    $(this).on('click', '.btn-generate-invoice', function (e) {
        e.preventDefault();

        var route = $(this).attr('href');
        var message_used = "";

        Swal.fire({
            title: 'Mensaje',
            text: '¿Deseas generar la factura con los datos de facturación proporcionados?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, generar',
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