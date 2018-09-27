
$(document).on('click','button#addTheses', function(){
    CKEDITOR.instances['theses'].updateElement();
    var theses = $.trim($('textarea#theses').val());
    if(theses != ''){
        $.ajax({
            url: siteURL+"/Users/updateTheses",
            type: 'Post',
            dataType: 'json',
            data: { theses : theses },
            success: function(data){
                if(data.status == 0){
                    swal('Something Went Wrong.');
                } else {
                    swal('Theses Updated `');
                }
            }
        });        
    } else {
        swal('Enter Theses Value.');
    }
});

function init_chart_doughnut() {

    if("undefined"!=typeof Chart && $(".canvasDoughnut").length ) {
        var a= {
            type:"doughnut",
            tooltipFillColor:"rgba(51, 51, 51, 0.55)",
            data: {
                labels:[
                "Votes Up",
                "Votes Down"
                ],
                datasets:[ {
                    data: [parseInt($('td#upVotesCount').text()),parseInt($('td#downVotesCount').text())], backgroundColor: ["#1ABB9C", "#E74C3C"], hoverBackgroundColor: ["#1ABB9C", "#E74C3C"]
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
        gauge.maxValue = parseInt($('#goal-text').text()); // set max gauge value
        gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
        gauge.animationSpeed = 20; // set animation speed (32 is default value)
        gauge.set(parseInt($('#userTotalComments').text())); // set actual value
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

function init_flot_chart(data) {
         var a = [];
         var b = [];
         $.each(data.pitchbase, function(key,val){
            var aa = [ gd(parseInt(val[0]),parseInt(val[1]),parseInt(val[2])),parseInt(val[3])];
            a.push(aa)
         });
         $.each(data.crunchBook, function(key,val){
            var bb = [ gd(parseInt(val[0]),parseInt(val[1]),parseInt(val[2])),parseInt(val[3])];
            b.push(bb)
         });

        var g= {
            series: {
                lines: {
                    show: !1, fill: !1
                },
                splines: {
                    show: !0, tension: .1, lineWidth: 1, fill: .7
                },
                points: {
                    radius: 0, show: !0
                },
                shadowSize:1
            },
            grid: {
                verticalLines: !0, hoverable: !0, clickable: !0, tickColor: "#d5d5d5", borderWidth: 1, color: "#fff"
            },
            colors:["rgba(38, 185, 154, 0.38)","rgba(3, 88, 106, 0.38)"],
            xaxis: {
                tickColor: "rgba(51, 51, 51, 0.06)", mode: "time", tickSize: [1, "day"], axisLabel: "Date", axisLabelUseCanvas: !0, axisLabelFontSizePixels: 12, axisLabelFontFamily: "Verdana, Arial", axisLabelPadding: 40
            },
            yaxis: {
                ticks: 10, tickColor: "rgba(51, 51, 51, 0.06)"
            },
            tooltip:!1
        };
        $.plot($("#chart_plot_01"), [a, b], g);
}


function init_sparklines() {
    "undefined"!=typeof jQuery.fn.sparkline&&($(".sparkline_one").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
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


function init_daterangepicker() {
    if("undefined"!=typeof $.fn.daterangepicker) {
        var a=function(a,b,c) {
            //console.log(a.toISOString(),b.toISOString(),c),
            $("#reportrange span").html(a.format("MMMM D, YYYY")+" - "+b.format("MMMM D, YYYY"))
        },
        b= {
            startDate:moment().subtract(28,"days"),
            endDate:moment(),
            minDate: moment().subtract(365, "days").format("M D, YYYY"),
            maxDate:moment().format("M D, YYYY"),
            dateLimit: {
                days: 60
            },
            showDropdowns:!0,
            showWeekNumbers:!1,
            timePicker:!1,
            timePickerIncrement:1,
            timePicker12Hour:!0,
            ranges: {
              "Last Two Weeks": [moment().startOf("week"),moment().startOf("week").subtract(13, "days")],
              "This Month": [moment().startOf("month"), moment().endOf("month")],
              "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")],
              "Last Two Months": [moment().subtract(2, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            },
            opens:"left",
            buttonClasses:["btn btn-default"],
            applyClass:"btn-small btn-primary",
            cancelClass:"btn-small",
            format:"DD/MM/YYYY",
            separator:" to ",
            locale: {
                applyLabel: "Submit", cancelLabel: "Clear", fromLabel: "From", toLabel: "To", customRangeLabel: "Custom", daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"], monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"], firstDay: 1
            }
        }
        ;
        $("#reportrange span").html(moment().subtract(29, "days").format("MMMM D, YYYY")+" - "+moment().format("MMMM D, YYYY")),
        $("#reportrange").daterangepicker(b,
        a),
        $("#reportrange").on("show.daterangepicker",
        function() {
            console.log("show event fired")
        }
        ),
        $("#reportrange").on("hide.daterangepicker",
        function() {
            console.log("hide event fired")
        }
        ),
        $("#reportrange").on("apply.daterangepicker",function(a, b) {
            var startDate = b.startDate.format("YYYY-MM-DD");
            var endDate = b.endDate.format("YYYY-MM-DD");
            var from = moment(startDate, 'YYYY-MM-DD');
            var to = moment(endDate, 'YYYY-MM-DD');
            var duration = to.diff(from, 'days');
            var duration = Math.abs(duration);
            if(duration < 13 || duration > 61){
                swal('Please Select between 15 to 60 days range Only.');
                return false;
            }
            callMapFunction(from.format("YYYY-MM-DD"),to.format("YYYY-MM-DD"));            
        }),
        $("#reportrange").on("cancel.daterangepicker",
        function(a, b) {
            console.log("cancel event fired")
        }
        ),
        $("#options1").click(function() {
            $("#reportrange").data("daterangepicker").setOptions(b, a)
        }
        ),
        $("#options2").click(function() {
            $("#reportrange").data("daterangepicker").setOptions(optionSet2, a)
        }
        ),
        $("#destroy").click(function() {
            $("#reportrange").data("daterangepicker").remove()
        }
        )
    }
}

$(document).ready(function(){

    init_chart_doughnut();  
    init_gauge();
    init_sparklines();
    init_daterangepicker();
    var to = moment().add('days', 1).format("YYYY-MM-DD");
    var from = moment().subtract(15, "days").format("YYYY-MM-DD");
    callMapFunction(from,  to);
    $('#clock1').jClocksGMT({
        title: 'Hawaii', 
        offset: '-10', 
        dst: false, 
        
    });
    $('#clock2').jClocksGMT({
        title: 'US Pacific', 
        offset: '-07', 
        dst: false, 
        
    });
    $('#clock3').jClocksGMT({
        title: 'US Central', 
        offset: '-06', 
        dst: false, 
        
    });
    $('#clock4').jClocksGMT({
        title: 'US Eastern', 
        offset: '-04', 
        dst: false, 
        
    });
    $('#clock5').jClocksGMT({
        title: 'Israel', 
        offset: '+03', 
        dst: false, 
    });
    $('#clock6').jClocksGMT({
        title: 'Tokyo, Japan', 
        offset: '+09', 
        dst: false, 
    });
   /* $('#divRss').FeedEk({
       // FeedUrl: 'http://www.vcaonline.com/news/rss/index.asp',
        FeedUrl: 'http://feeds.bbci.co.uk/news/business/rss.xml',
        MaxCount: 5,
        DateFormat: 'L',
        DateFormatLang: 'en',
        DescCharacterLimit: 0,
    });*/
          
});

function callMapFunction(from,  to){
    
    $.ajax({
        url: siteURL+"/Users/mapData",
        type: 'Post',
        dataType: 'json',
        data: { start : from,end: to},
        success: function(data){
            if(data.status == 0){
                swal('No Records found for '+from+' to '+to);
            } else {
                init_flot_chart(data);                
            }
        }
    });
} 


