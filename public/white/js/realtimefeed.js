function getColors() {
    const colors = ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF",
        "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b",
        "#F012BE", "#3D9970", "#111111", "#AAAAAA",
        "#BD666E", "#547A56", "#7C0D70", "#836816", "#5889D8", "#FF892D", "#F6B54D", "#C3AE58",
        "#DBA27B", "#A81656",
        "#02D6B9", "#4E73FF", "#F2CC68", "#D7AE08", "#7D2A38", "#C0BF00", "#7CA196", "#C0C3C4",
        "#773E7E", "#B78C0C",
        "#271284", "#70DDD4", "#934723", "#9E5B8D", "#A70413", "#D29BEB", "#59905A", "#29959C",
        "#526DE4", "#C62677",
        "#2EDFE0", "#7015D9", "#5054F8", "#0BF38D", "#CA1384", "#3C4097", "#519B76", "#B280E7",
        "#83A78F", "#C4F96A",
        "#AF9449", "#8C6F62", "#B1BC0E", "#847085", "#E1F1E0", "#7DA781", "#588988", "#55EADB",
        "#B568BF", "#391870"
    ];
    return colors;
};

function themeColors(){
    const colors = [
        "#7734a9","#8448b1","#925cba","#9f70c2","#ad85cb","#bb99d4","#c8addc",
        "#7734A9", "#9A34A9", "#A93494", "#A93471", "#A9344E",
        "#A93C34", "#A95F34", "#A98234", "#A9A534", "#89A934",
        "#65A934", "#42A934", "#34A948", "#34A96B", "#34A98E",
        "#34A0A9", "#347DA9", "#345AA9", "#3437A9", "#5334A9"
      ];
    return colors;
}

function loadRealtimeFeed() {
    $("#realtime-marketfeed").block({message: 'Refreshing Prices'});
    $.get('/reporting/realtime', {
        'rd': Math.random()
    }, function(data) {
        $("#realtime-marketfeed").html(data);
        $("#btn-refresh-feed").click(loadRealtimeFeed);
        let account_balance = $("#realtime-marketfeed").find("#hd_account_balance").val();
        $("#account-balance-val").html("$" + account_balance );
    });
}
function getBreakdownChart(data) {
    const breakdownConfig = {
        type: 'bar',
        data: data,
        fill: false,
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Holdings Breakdown'
                }
            }
        },
    };
    return breakdownConfig;
}

function drawLineChart(portfolio) {
    let symbols = [];
    let datasets = [];
    let colors = getColors();
    let indexOf = 0;
    for (symbol in portfolio) {
        symbols.push(symbol);
        let dataset = {};
        dataset.label = symbol;
        dataset.data = [portfolio[symbol].qty];
        borderColor = colors[indexOf];
        dataset.fill = false;
        datasets.push(dataset);
        indexOf++;
    }
    const breakdownConfig = {
        type: 'line',
        data: {
            labels: symbols,
            datasets: datasets
        },
    };
    return breakdownConfig;
}


function initChartBreakDown() {
    var breakdownChart = document.getElementById("breakdown-pie-chart").getContext("2d");
    var gradientStroke = breakdownChart.createLinearGradient(0, 230, 0, 50);
    gradientStroke.addColorStop(1, 'rgba(72,72,176,0.2)');
    gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke.addColorStop(0, 'rgba(119, 52, 169, 0.1)'); //purple colors

    $.get('/reporting/breakdown', {
        'rd': Math.random()
    }, function(portfolio) {
        let labels = [];
        let data = [];

        for (symbol in portfolio) {
            labels.push(symbol);
            data.push(portfolio[symbol].qty);
        }

        const holdingBreakDown = {
            labels: labels,
            datasets: [{
                label: '',
                data: data,
                //backgroundColor: themeColors(),
                backgroundColor: gradientStroke,
                hoverBackgroundColor: gradientStroke,
                borderColor: '#1f8ef1',
                borderWidth: 2,
                hoverOffset: 4, borderDash: [],borderDashOffset: 0.0
            }]
        };
        var myChart = new Chart(breakdownChart, getBreakdownChart(holdingBreakDown));

        //var breakdownLineChart = document.getElementById("breakdown-line-chart").getContext("2d");
        // let lineChart = new Chart(breakdownLineChart, drawLineChart(portfolio));
    });
};
