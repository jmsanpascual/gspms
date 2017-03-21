window.onload = function() {
    var doughnutData = [
        {
            label: 'Tes',
            labelColor: 'white',
            labelFontSize: '16',
            value: 30,
            color:"#F7464A"
        },
        {
            label: 'Tes5',
            labelColor: 'white',
            labelFontSize: '16',
            value : 50,
            color : "#46BFBD"
        },
        {
            label: 'Tes2',
            labelColor: 'white',
            labelFontSize: '16',
            value : 100,
            color : "#FDB45C"
        },
        {
            label: 'Tes3',
            labelColor: 'white',
            labelFontSize: '16',
            value : 40,
            color : "#949FB1"
        },
        {
            label: 'Tes6',
            labelColor: 'white',
            labelFontSize: '16',
            value : 120,
            color : "#4D5360"
        }

    ];

    var ctx = document.getElementById("doughnut3").getContext("2d");
    var myDoughnut = new Chart(ctx).Pie(doughnutData, {animation: true});

    var doughnutData2 = [
        {
            value: 30,
            color:"#FDB45C"
        },
        {
            value : 50,
            color : "#46BFBD"
        },
        {
            value : 100,
            color : "#F7464A"
        },
        {
            value : 40,
            color : "#4D5360"
        },
        {
            value : 210,
            color : "#949FB1"
        }

    ];

    var ctx2 = document.getElementById("doughnut2").getContext("2d");
    var myDoughnut2 = new Chart(ctx2).Pie(doughnutData2, {animation: true});
}
