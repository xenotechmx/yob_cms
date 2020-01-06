$(document).ready(function () {


    $(this).on("click", ".ver_detalle", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("href"),
            type: "GET",
            error: function (e) {
                console.log(e);
            },
            success: function (result) {

                console.log(result);
                swal({
                    title: "Detalle de empleo",
                    html: result,
                    customClass: 'swal-wide',
                    //type: 'error'
                });

            }
        });

    });


    $(this).on('click', '.btn-publish', function (e) {
        e.preventDefault();

        var route = $(this).attr('href');
        var message_used = "";

        Swal.fire({
            title: 'Mensaje',
            text: '¿Deseas publicar el empleo seleccionado?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, publicar',
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


    $(this).on("click", ".form_unpublish", function (e) {
        e.preventDefault();

        var href = $(this).attr("href");

        var form = "";
        form += '<div class="form-group text-left">';
        form += '   <label>Indica el motivo por el cual no será publicado el empleo (se enviará una notificación al empleador):</label>';
        form += '   <input class="form-control" id="reason_unpublish" type="text">';
        form += '</div>';

        swal({
            title: "Rechazar empleo",
            html: form,
            showCancelButton: true,
            confirmButtonText: 'Rechazar',
            cancelButtonText: 'Cancelar'
        }).then((willDelete) => {

            console.log(willDelete);
            if (willDelete.value) {

                var data = {};
                data.reason = $("#reason_unpublish").val();

                $.ajax({
                    url: href,
                    type: "GET",
                    data: data,
                    error: function (e) {
                        console.log(e);
                    },
                    success: function (response) {
                        console.log(response);
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

            } else {
            }

        });


    });


});