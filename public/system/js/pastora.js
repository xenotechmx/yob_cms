
$(document).ready(function(){

    if( $(".tabs_custom").length > 0 ){

        $(this).on("click", ".tabs_custom .options a", function () {
            $(".tabs_custom .options a").removeClass("active");
            $(this).addClass("active");

            var index = $(this).parent().find(".active").index();
            index = parseInt(index) + 1;

            $(".tabs_custom .content_options .content_tab").removeClass("active");
            $(".tabs_custom .content_options .content_tab:nth-child("+index+")").addClass("active");

        });

    }

});

function formActions(block)
{
    $('input, select, button, a, textarea, checkbox').each(function () {
        if( $(this).hasClass("disabled") ){
            $(this).attr('disabled', true);
        }else{
            $(this).attr('disabled', block);
        }
    });
}

function blockForm()
{
    formActions(true);
}

function unblockForm()
{
    formActions(false);
}

function successAlert(msg)
{
    swal("¡Excelente!", msg, "success");
}

function errorAlert(msg)
{
    swal("¡Ups, algo salio mal!", msg, "error");
}

function modalErrors(errorsArray)
{
    var message;

    message = "<p>Haz cometido los siguientes errores:</p><ul style='padding: 0;'>";

    for(var k in errorsArray.errors){
        message += "<ol style='padding: 0;'> " + errorsArray.errors[k] + "</ol>";
    }

    message += "</ul>";

    swal({
        title: "Mensaje",
        html: message,
        type: 'error'
    });
}

function asset() {
    var baseUrl = window.location.origin+"/u-erre/public/admin/dashboard/";
    return baseUrl;
}

/**
 * This method make the ajax request to promise
 * @param url full url to make request
 * @param data all data to sent on request
 * @param typeRequest the verb http to make the request
 * @return return the ajax object like promise
 */
function fetchData(url, data, typeRequest) {
    var type = 'POST';
    if(typeRequest) {
        type = typeRequest;
    }
    return $.ajax({
        method: type,
        data: data,
        processData: false,
        contentType: false,
        dataType: 'json',
        url: url,
        beforeSend: function () {
            blockForm();
        }
    }).always(function() {
        unblockForm();
    });
}
