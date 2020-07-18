$(function () {
    "use strict";
    MorrisArea();
    MorrisLineChart();
    MorrisDonutChart();
    MorrisBarChart();
});

// Morris-chart
function MorrisArea() {
    Morris.Area({
        element: 'm_area_chart2',
        data: [{
            period: '2012',
            SiteA: 0,
            SiteB: 10,

        }, {
            period: '2013',
            SiteA: 106,
            SiteB: 71,

        }, {
            period: '2014',
            SiteA: 68,
            SiteB: 41,

        }, {
            period: '2015',
            SiteA: 89,
            SiteB: 285,

        }, {
            period: '2016',
            SiteA: 185,
            SiteB: 104,

        }, {
            period: '2017',
            SiteA: 146,
            SiteB: 102,

        }
        ],
        xkey: 'period',
        ykeys: ['SiteA', 'SiteB'],
        labels: ['Individual Score', 'Team Score'],
        pointSize: 1,
        fillOpacity: 0.3,
        pointStrokeColors: ['#f66d9b', '#007FFF'],
        behaveLikeLine: true,
        gridLineColor: '#efefef',
        lineWidth: 0,
        smooth: false,
        hideHover: 'auto',
        lineColors: ['#f66d9b', '#007FFF'],
        resize: true

    });

    Morris.Area({
        element: 'm_area_chart',
        data: [{
            period: '2012',
            iphoneX: 128,
            Nokia6: 23,
            oneplus: 78
        }, {
            period: '2013',
            iphoneX: 170,
            Nokia6: 45,
            oneplus: 98
        }, {
            period: '2014',
            iphoneX: 80,
            Nokia6: 60,
            oneplus: 85
        }, {
            period: '2015',
            iphoneX: 78,
            Nokia6: 205,
            oneplus: 135
        }, {
            period: '2016',
            iphoneX: 180,
            Nokia6: 124,
            oneplus: 78
        }, {
            period: '2017',
            iphoneX: 105,
            Nokia6: 56,
            oneplus: 85
        },
        {
            period: '2018',
            iphoneX: 210,
            Nokia6: 78,
            oneplus: 120
        }
        ],
        xkey: 'period',
        ykeys: ['iphoneX', 'Nokia6', 'oneplus'],
        labels: ['iphoneX', 'Nokia6', 'oneplus 6'],
        pointSize: 2,
        fillOpacity: 0.1,
        pointStrokeColors: ['#f66d9b', '#5CB65F', '#FFA117'],
        behaveLikeLine: true,
        gridLineColor: '#efefef',
        lineWidth: 1,
        hideHover: 'auto',
        lineColors: ['#f66d9b', '#5CB65F', '#FFA117'],
        resize: true

    });

    Morris.Area({
        element: 'e_area_chart',
        data: [{
            period: '2012',
            iphoneX: 10,
            Nokia6: 5,
            oneplus: 7
        }, {
            period: '2013',
            iphoneX: 35,
            Nokia6: 89,
            oneplus: 45
        }, {
            period: '2014',
            iphoneX: 25,
            Nokia6: 15,
            oneplus: 102
        }, {
            period: '2015',
            iphoneX: 80,
            Nokia6: 12,
            oneplus: 45
        }, {
            period: '2016',
            iphoneX: 30,
            Nokia6: 32,
            oneplus: 148
        }, {
            period: '2017',
            iphoneX: 25,
            Nokia6: 127,
            oneplus: 40
        }, {
            period: '2018',
            iphoneX: 98,
            Nokia6: 10,
            oneplus: 26
        }
        ],
        lineColors: ['#9367B4', '#17C2D7', '#f66d9b'],
        xkey: 'period',
        ykeys: ['iphoneX', 'Nokia6', 'oneplus'],
        labels: ['iphoneX', 'Nokia6', 'oneplus'],
        pointSize: 2,
        lineWidth: 0,
        resize: true,
        fillOpacity: 1,
        behaveLikeLine: true,
        gridLineColor: '#efefef',
        hideHover: 'auto'

    });
}
// LINE CHART
function MorrisLineChart() {
    var line = new Morris.Line({
        element: 'm_line_chart',
        resize: true,
        data: [{
            y: '2014 Q1',
            item1: 2356
        },
        {
            y: '2015 Q2',
            item1: 2586
        },
        {
            y: '2015 Q3',
            item1: 4512
        },
        {
            y: '2015 Q4',
            item1: 3265
        },
        {
            y: '2016 Q5',
            item1: 6258
        },
        {
            y: '2016 Q6',
            item1: 5234
        },
        {
            y: '2017 Q7',
            item1: 4725
        },
        {
            y: '2017 Q7',
            item1: 7526
        },
        {
            y: '2018 Q7',
            item1: 8452
        },
        {
            y: '2018 Q7',
            item1: 8931
        }
        ],
        xkey: 'y',
        ykeys: ['item1'],
        labels: ['Item 1'],
        gridLineColor: '#efefef',
        lineColors: ['#5CB65F'],
        lineWidth: 1,
        pointSize: 3,
        hideHover: 'auto'
    });
}
// Morris donut chart
function MorrisDonutChart() {
    Morris.Donut({
        element: 'm_donut_chart',
        data: [
            {
                label: "Online",
                value: 40,
            }, {
                label: "Store",
                value: 35
            }, {
                label: "Email",
                value: 8
            }, {
                label: "Agent",
                value: 17
            }],

        resize: true,
        colors: ['#5CB65F', '#17C2D7', '#9367B4', '#f66d9b'],
        backgroundColor: '#ffffff',
    });
}
// Morris bar chart
function MorrisBarChart() {
    Morris.Bar({
        element: 'm_bar_chart',
        data: [{
            y: '2012',
            a: 80,
            b: 56,
            c: 89
        }, {
            y: '2013',
            a: 75,
            b: 65,
            c: 38
        }, {
            y: '2014',
            a: 59,
            b: 30,
            c: 37
        }, {
            y: '2015',
            a: 75,
            b: 65,
            c: 40
        }, {
            y: '2016',
            a: 55,
            b: 40,
            c: 45
        }, {
            y: '2017',
            a: 75,
            b: 65,
            c: 40
        }, {
            y: '2018',
            a: 87,
            b: 88,
            c: 36
        }],
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['A', 'B', 'C'],
        barColors: ['#f66d9b', '#FFA117', '#3C89DA'],
        hideHover: 'auto',
        gridLineColor: '#efefef',
        resize: true
    });
}

// morris Bar stacked chart
var data = [
    { y: '2012', a: 80, b: 65, c: 55 },
    { y: '2013', a: 90, b: 70, c: 66 },
    { y: '2014', a: 100, b: 75, c: 77 },
    { y: '2015', a: 115, b: 75, c: 88 },
    { y: '2016', a: 120, b: 85, c: 99 },
    { y: '2017', a: 145, b: 85, c: 11 },
    { y: '2018', a: 160, b: 95, c: 45 }
],
    formatY = function (y) {
        return '$' + y;
    },
    formatX = function (x) {
        return x.src.y;
    },

    config = {
        data: data,
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['Total Income', 'Total Outcome'],
        fillOpacity: 0.6,
        hideHover: 'auto',
        stacked: true,
        resize: true,
        pointFillColors: ['#ffffff'],
        pointStrokeColors: ['black'],
        barColors: ['#f66d9b', '#FFA117', '#3C89DA'],
        gridLineColor: '#efefef',

    };

config.element = 'bar_stacked';
Morris.Bar(config);