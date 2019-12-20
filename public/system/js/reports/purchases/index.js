$(document).ready(function () {

    //Barchart graph
    var graph_data = JSON.parse($("#graph_data").html());
    console.log(graph_data);

    var labels = new Array();
    var datas = new Array();

    for (var i = 0; i < graph_data.length; i++){
        labels.push(graph_data[i].name);
        datas.push(graph_data[i].total);
    }

    new Chart(document.getElementById("chart2"),
        {
            "type":"bar",
            "data":{"labels":labels,
                "datasets":[{
                    "label":"Total de paquetes comprados",
                    "data":datas,
                    "fill":false,
                    "backgroundColor":["rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],
                    "borderColor":["rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"],
                    "borderWidth":1
                }]
            }
        });



    //Pi Chart
    var graph_vs = JSON.parse($("#graph_vs").html());
    console.log(graph_vs);


    var labels = new Array();
    var datas = new Array();

    for (var i = 0; i < graph_vs.length; i++){

        if( graph_vs[i].status == "APPROVED" ){
            labels.push("Aprobado");
        }else{
            labels.push("Pendiente");
        }

        datas.push(graph_vs[i].total);
    }

    new Chart(document.getElementById("chart1"),
        {
            "type":"pie",
            "data":{"labels":labels,
                "datasets":[{
                    "label":"Comparativa de estatus de compra",
                    "data":datas,
                    "fill":false,
                    "backgroundColor":["rgba(70, 212, 70, .2)", "rgba(247, 68, 68, .2)"],
                    "borderColor":["rgba(70, 212, 70, 1)", "rgba(247, 68, 68, 1)"],
                    "borderWidth":1
                }]
            }
        });


});