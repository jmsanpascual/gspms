window.onload = function() {

    var doughnutData2 = [
        {
            value: 30,
            color: "#FDB45C"
        },
        {
            value: 50,
            color: "#46BFBD"
        },
        {
            value: 100,
            color: "#F7464A"
        },
        {
            value: 40,
            color: "#4D5360"
        },
        {
            value: 210,
            color: "#949FB1"
        }

    ];

    var ctx2 = document.getElementById("doughnut2").getContext("2d");
    var myDoughnut2 = new window.Chart(ctx2).Pie(doughnutData2, {animation: true});
}
