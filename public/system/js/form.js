$(document).ready(function () {
    $('form', this).on('submit', function (e) {
        e.preventDefault();

        var data = new FormData(this);

        // if( $('#fecha_disponibilidad').length > 0 ){
        //     data.append("fecha_disponibilidad", $('#fecha_disponibilidad').multiDatesPicker('getDates'));
        // }

        var url = $(this).attr('action');

        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: data,
            beforeSend: function () {
                blockForm();
            },
            error: function (e) {

                unblockForm();
                if (e.status == 422) {
                    modalErrors(JSON.parse(e.responseText));
                } else {
                    errorAlert('!Ups, algo salio mal!');
                }
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
                    }).then((willDelete) => {
                        window.location = response.url;
                    });

                } else {
                    errorAlert(response.message);
                }
            }
        });


    });
});


