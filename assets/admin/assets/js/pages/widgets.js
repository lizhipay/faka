$(function() {
"use strict";

    // small state
    $('.chart_1').sparkline('html', {
        type: 'bar',
        height: '60px',
        barSpacing: 3,
        barWidth: 2,
        barColor: '#17a2b8',        
    });
    $('.chart_3').sparkline('html', {
        type: 'bar',
        height: '60px',
        barSpacing: 3,
        barWidth: 2,
        barColor: '#28a745',        
    });
    $('.chart_4').sparkline('html', {
        type: 'bar',
        height: '60px',
        barSpacing: 3,
        barWidth: 2,
        barColor: '#45aaf2',        
    });
    $('.chart_2').sparkline('html', {
        type: 'bar',
        height: '60px',
        barSpacing: 3,
        barWidth: 2,
        barColor: '#f3ad06',        
    });
    // Summary 
    $('.chart').sparkline('html', {
        type: 'bar',
        height: '53px',
        barSpacing: 3,
        barWidth: 2,
        barColor: '#434750',        
    });

    $('.knob').knob({
		draw: function () {
		}
	});
});

$(function() {
    "use strict";
    var chart = c3.generate({
        bindto: '#chart-bar', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                ['data1', 11, 8, 15, 18, 19, 17],
                ['data2', 8, 7, 11, 11, 4, 8],
                ['data3', 8, 9, 8, 10, 12, 14],
            ],
            type: 'bar', // default type of chart
            colors: {
                'data1': '#467fcf', // blue            
                'data2': '#5eba00', // green
                'data3': '#f66d9b', // pink
            },
            names: {
                // name of each serie
                'data1': 'Income',            
                'data2': 'Growth',
                'data3': 'Expense',
            }
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
            },
        },
        bar: {
            width: 16
        },
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 20,
            top: 0
        },
    });
    // Small chart widgets
    var chart = c3.generate({
        bindto: '#chart-bg-users-1',
        padding: {
            bottom: -10,
            left: -1,
            right: -1
        },
        data: {
            names: {
                data1: 'Users online'
            },
            columns: [
                ['data1', 30, 40, 10, 40, 12, 22, 40]
            ],
            type: 'area'
        },
        legend: {
            show: false
        },
        transition: {
            duration: 0
        },
        point: {
            show: false
        },
        tooltip: {
            format: {
                title: function (x) {
                    return '';
                }
            }
        },
        axis: {
            y: {
                padding: {
                    bottom: 0,
                },
                show: false,
                tick: {
                    outer: false
                }
            },
            x: {
                padding: {
                    left: 0,
                    right: 0
                },
                show: false
            }
        },
        color: {
            pattern: ['#467fcf']
        }
    });
    var chart = c3.generate({
        bindto: '#chart-bg-users-2',
        padding: {
            bottom: -10,
            left: -1,
            right: -1
        },
        data: {
            names: {
                data1: 'Users online'
            },
            columns: [
                ['data1', 30, 40, 10, 40, 12, 22, 40]
            ],
            type: 'area'
        },
        legend: {
            show: false
        },
        transition: {
            duration: 0
        },
        point: {
            show: false
        },
        tooltip: {
            format: {
                title: function (x) {
                    return '';
                }
            }
        },
        axis: {
            y: {
                padding: {
                    bottom: 0,
                },
                show: false,
                tick: {
                    outer: false
                }
            },
            x: {
                padding: {
                    left: 0,
                    right: 0
                },
                show: false
            }
        },
        color: {
            pattern: ['#e74c3c']
        }
    });
    var chart = c3.generate({
        bindto: '#chart-bg-users-3',
        padding: {
            bottom: -10,
            left: -1,
            right: -1
        },
        data: {
            names: {
                data1: 'Users online'
            },
            columns: [
                ['data1', 30, 40, 10, 40, 12, 22, 40]
            ],
            type: 'area'
        },
        legend: {
            show: false
        },
        transition: {
            duration: 0
        },
        point: {
            show: false
        },
        tooltip: {
            format: {
                title: function (x) {
                    return '';
                }
            }
        },
        axis: {
            y: {
                padding: {
                    bottom: 0,
                },
                show: false,
                tick: {
                    outer: false
                }
            },
            x: {
                padding: {
                    left: 0,
                    right: 0
                },
                show: false
            }
        },
        color: {
            pattern: ['#5eba00']
        }
    });
    var chart = c3.generate({
        bindto: '#chart-bg-users-4',
        padding: {
            bottom: -10,
            left: -1,
            right: -1
        },
        data: {
            names: {
                data1: 'Users online'
            },
            columns: [
                ['data1', 30, 40, 10, 40, 12, 22, 40]
            ],
            type: 'area'
        },
        legend: {
            show: false
        },
        transition: {
            duration: 0
        },
        point: {
            show: false
        },
        tooltip: {
            format: {
                title: function (x) {
                    return '';
                }
            }
        },
        axis: {
            y: {
                padding: {
                    bottom: 0,
                },
                show: false,
                tick: {
                    outer: false
                }
            },
            x: {
                padding: {
                    left: 0,
                    right: 0
                },
                show: false
            }
        },
        color: {
            pattern: ['#f1c40f']
        }
    });
    // Members
    var chart = c3.generate({
        bindto: '#chart-bar-stacked', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                ['data1', 11, 8, 15, 18, 19, 17],
                ['data2', 7, 7, 5, 7, 9, 12]
            ],
            type: 'bar', // default type of chart
            groups: [
                [ 'data1', 'data2']
            ],
            colors: {
                'data1': '#467fcf', // blue
                'data2': '#f66d9b', // pink
            },
            names: {
                // name of each serie
                'data1': 'User',
                'data2': 'VIP'
            }
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
            },
        },
        bar: {
            width: 10
        },
        legend: {
            show: false, //hide legend
        },
        padding: {
            bottom: -20,
            top: 0,
            left: -6,
        },
    });
    // Marketing
    var chart = c3.generate({
        bindto: '#chart-area-spline-sracked', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                ['data1', 11, 8, 15, 18, 19, 17],
                ['data2', 7, 7, 5, 7, 9, 12]
            ],
            type: 'area-spline', // default type of chart
            groups: [
                [ 'data1', 'data2']
            ],
            colors: {
                'data1': '#467fcf', // blue
                'data2': '#f66d9b', // pink
            },
            names: {
                // name of each serie
                'data1': 'Last Month',
                'data2': 'This Month'
            }
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
            },
        },
        legend: {
            show: false, //hide legend
        },
        padding: {
            bottom: -20,
            top: 0,
            left: -7,
        },
    });
});

$(function() {
    "use strict";
    var dataStackedBar = {
        labels: ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6'],
        series: [
            [8000, 12000, 3600, 1300, 12000, 12000],
            [2000, 4000, 5000, 3000, 7000, 4000],
            [1000, 2000, 4000, 6000, 3000, 2000]
        ]
    };
    new Chartist.Bar('#stackedbar-chart', dataStackedBar, {
        height: "228px",
        stackBars: true,
        axisX: {
            showGrid: false
        },
        axisY: {
            labelInterpolationFnc: function(value) {
                return (value / 1000) + 'k';
            }
        },
        plugins: [
            Chartist.plugins.tooltip({
                appendToBody: true
            }),
            Chartist.plugins.legend({
                legendNames: ['Blue', 'Pink', 'Orange']
            })
        ]
    }).on('draw', function(data) {
        if (data.type === 'bar') {
            data.element.attr({
                style: 'stroke-width: 25px'
            });
        }
    });
});