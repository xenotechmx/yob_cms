$(document).ready(function () {

    $(this).on("click", "input[name='ilimited_total_jobs_to_post'], input[name='ilimited_total_profiles_to_view'], input[name='ilimited_duration_in_days'], input[name='ilimited_jobs_destacados']", function (e) {

        var checked = $(this).is(":checked");
        var input_to_function = $(this).attr("id");

        if(checked){
            $("input[name='"+input_to_function+"']").hide();
        }else{
            $("input[name='"+input_to_function+"']").show();
        }

    });

});