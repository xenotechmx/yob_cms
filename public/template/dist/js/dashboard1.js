$(document).ready(function () {

    var category_employes = JSON.parse($("#category_employes").text());
    var donut_values = new Array();
    for (let i = 0; i < category_employes.length; i++) {
        var inn = {};
        inn.label = category_employes[i].category;
        inn.value = category_employes[i].total;
        donut_values.push(inn);
    }

    console.log(donut_values);


    var jobs_apply_by_month = JSON.parse($("#jobs_apply_by_month").text());
    console.log(jobs_apply_by_month);


    // Dashboard 1 Morris-chart
    var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];


    Morris.Area({
        element: 'morris-area-chart2',
        data: jobs_apply_by_month,
        xkey: 'period',
        ykeys: ['Postulaciones'],
        labels: ['Postulaciones'],
        pointSize: 0,
        fillOpacity: 0.4,
        pointStrokeColors:['#01c0c8'],
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        lineWidth: 0,
        smooth: true,
        hideHover: 'auto',
        lineColors: ['#01c0c8'],
        resize: true,
        xLabelFormat : function (x) {
            console.log(x.getMonth());
            return months[x.getMonth()];
        }
    });

    // Morris donut chart

    Morris.Donut({
        element: 'morris-donut-chart',
        data: donut_values,
        resize: true,
        colors:['#fb9678', '#01c0c8', '#4F5467']
    });



});