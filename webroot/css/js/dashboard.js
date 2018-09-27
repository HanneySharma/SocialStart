function init_chart_doughnut() {
    if("undefined"!=typeof Chart&&(console.log("init_chart_doughnut"), $(".canvasDoughnut").length)) {
        var a= {
            type:"doughnut",
            tooltipFillColor:"rgba(51, 51, 51, 0.55)",
            data: {
                labels:[
                "Symbian",
                "Blackberry"
                ],
                datasets:[ {
                    data: [30, 70], backgroundColor: ["#1ABB9C", "#E74C3C"], hoverBackgroundColor: ["#1ABB9C", "#E74C3C"]
                }
                ]
            },
            options: {
                legend: !1, responsive: !1
            }
        }
        $(".canvasDoughnut").each(function() {
            var b = $(this);
            new Chart(b, a)
        });
    }
}

function init_gauge() {
   var opts = {
      angle: 0.15, // The span of the gauge arc
      lineWidth: 0.44, // The line thickness
      radiusScale: 1, // Relative radius
      pointer: {
        length: 0.6, // // Relative to gauge radius
        strokeWidth: 0.035, // The thickness
        color: '#000000' // Fill color
      },
      limitMax: false,     // If false, max value increases automatically if value > maxValue
      limitMin: false,     // If true, the min value of the gauge will be fixed
      colorStart: '#6FADCF',   // Colors
      colorStop: '#8FC0DA',    // just experiment with them
      strokeColor: '#E0E0E0',  // to see which ones work best for you
      generateGradient: true,
      highDpiSupport: true     // High resolution support
    };
        var target = document.getElementById('chart_gauge_01'); // your canvas element
        var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
        gauge.maxValue = 3000; // set max gauge value
        gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
        gauge.animationSpeed = 20; // set animation speed (32 is default value)
        gauge.set(1000); // set actual value
}


function init_skycons() {
    if("undefined"!=typeof Skycons) {
        var c,
        a=new Skycons( {
            color: "#73879C"
        }
        ),
        b=[
        "clear-day",
        "clear-night",
        "partly-cloudy-day",
        "partly-cloudy-night",
        "cloudy",
        "rain",
        "sleet",
        "snow",
        "wind",
        "fog"];
        for(c=b.length;
        c--;
        )a.set(b[c], b[c]);
        a.play()
    }
}

function init_flot_chart() {
   
        var a= [[gd(2017, 1, 1), 170], [gd(2017, 1, 7), 74], [gd(2017, 1, 14), 6], [gd(2017, 1, 21), 39]],
                b= [[gd(2017, 1, 1), 82], [gd(2017, 1, 7), 23], [gd(2017, 1, 14), 66], [gd(2017, 1, 21), 9]];

        var g= {
            series: {
                lines: {
                    show: !1, fill: !1
                },
                splines: {
                    show: !0, tension: .3, lineWidth: 2, fill: .4
                },
                points: {
                    radius: 0, show: !0
                },
                shadowSize:3
            },
            grid: {
                verticalLines: !0, hoverable: !0, clickable: !0, tickColor: "#d5d5d5", borderWidth: 1, color: "#fff"
            },
            colors:["rgba(38, 185, 154, 0.38)","rgba(3, 88, 106, 0.38)"],
            xaxis: {
                tickColor: "rgba(51, 51, 51, 0.06)", mode: "time", tickSize: [1, "day"], axisLabel: "Date", axisLabelUseCanvas: !0, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial", axisLabelPadding: 10
            },
            yaxis: {
                ticks: 10, tickColor: "rgba(51, 51, 51, 0.06)"
            },
            tooltip:!1
        };
        $.plot($("#chart_plot_01"), [a, b], g);
}


function init_sparklines() {
    "undefined"!=typeof jQuery.fn.sparkline&&(console.log("init_sparklines"), $(".sparkline_one").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
        type:"bar", height:"125", barWidth:13, colorMap: {
            7: "#a1a1a1"
        }
        , barSpacing:2, barColor:"#26B99A"
    }
    ), $(".sparkline_two").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
        type:"bar", height:"40", barWidth:9, colorMap: {
            7: "#a1a1a1"
        }
        , barSpacing:2, barColor:"#26B99A"
    }
    ), $(".sparkline_three").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
        type: "line", width: "200", height: "40", lineColor: "#26B99A", fillColor: "rgba(223, 223, 223, 0.57)", lineWidth: 2, spotColor: "#26B99A", minSpotColor: "#26B99A"
    }
    ), $(".sparkline11").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
        type:"bar", height:"40", barWidth:8, colorMap: {
            7: "#a1a1a1"
        }
        , barSpacing:2, barColor:"#26B99A"
    }
    ), $(".sparkline22").sparkline([2, 4, 3, 4, 7, 5, 4, 3, 5, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6], {
        type: "line", height: "40", width: "200", lineColor: "#26B99A", fillColor: "#ffffff", lineWidth: 3, spotColor: "#34495E", minSpotColor: "#34495E"
    }
    ), $(".sparkline_bar").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
        type:"bar", colorMap: {
            7: "#a1a1a1"
        }
        , barColor:"#26B99A"
    }
    ), $(".sparkline_area").sparkline([5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7], {
        type: "line", lineColor: "#26B99A", fillColor: "#26B99A", spotColor: "#4578a0", minSpotColor: "#728fb2", maxSpotColor: "#6d93c4", highlightSpotColor: "#ef5179", highlightLineColor: "#8ba8bf", spotRadius: 2.5, width: 85
    }
    ), $(".sparkline_line").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
        type: "line", lineColor: "#26B99A", fillColor: "#ffffff", width: 85, spotColor: "#34495E", minSpotColor: "#34495E"
    }
    ), $(".sparkline_pie").sparkline([1, 1, 2, 1], {
        type: "pie", sliceColors: ["#26B99A", "#ccc", "#75BCDD", "#D66DE2"]
    }
    ), $(".sparkline_discreet").sparkline([4, 6, 7, 7, 4, 3, 2, 1, 4, 4, 2, 4, 3, 7, 8, 9, 7, 6, 4, 3], {
        type: "discrete", barWidth: 3, lineColor: "#26B99A", width: "85"
    }
    ))
}
$(document).ready(function(){

    init_chart_doughnut();  
    init_gauge();
    init_sparklines();
    init_skycons();
    init_flot_chart();


    $('#divRss').FeedEk({
        FeedUrl: 'https://www.hospitalitynet.org/appointment/us.xml',
        MaxCount: 5,
        DateFormat: 'L',
        DateFormatLang: 'en'
    });
});