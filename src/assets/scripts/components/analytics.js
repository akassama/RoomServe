var $tooltipColor           = 'rgb(10, 20, 64, 0.8)';
var $textColor              = '#696E86';
var $analyticsFilter        = $('#analytics-filter');

var $colors = [];
$colors[0]   = chroma.scale(['#ef4003', '#ffa159', '#ffead9']).mode('lch').colors(6); // orange
$colors[1]   = chroma.scale(['#ff7800', '#ffc859', '#ffeabf']).mode('lch').colors(6); // orange 2
$colors[2]   = chroma.scale(['#39CC72', '#66E698', '#F0FCF5']).mode('lch').colors(6); // green
$colors[3]   = chroma.scale(['#009cb3', '#59d5c4', '#bfefe8']).mode('lch').colors(6); // green 2
$colors[4]   = chroma.scale(['#0083e8', '#59bfff', '#bfe6ff']).mode('lch').colors(6); // blue
$colors[5]   = chroma.scale(['#1951f3', '#74a8ff', '#c9ddff']).mode('lch').colors(6); // blue 2
$colors[6]   = chroma.scale(['#5b12e1', '#9b6dff', '#d8c7ff']).mode('lch').colors(6); // purple
$colors[7]   = chroma.scale(['#da0ba2', '#ff59d2', '#f4bfe6']).mode('lch').colors(6); // pink
$colors[8]   = chroma.scale(['#dc0d0d', '#f75d5d', '#ffabab']).mode('lch').colors(6); // red

// Analytics
function analyticsInit($refresh) {
    $refresh = $refresh || false;

    $('[data-analytics][data-url]').each(function($chart_key) {
        var $analytic               = $(this);
        var $settings               = analyticSettings($analytic);

        if (!$refresh) {
            var panelTemplate = Handlebars.compile ( $("#analytics-panel-template").html() );
                $settings['wrap'].append(panelTemplate());
        }

        // check url
        if ( checkAttr($settings['url']) ) {
            var formData = new FormData($analyticsFilter[0]);

            // get data
            $.ajax({
                type: "POST",
                url: $settings['url'],
                data: formData,
                dataType: "json",
                mimeType: "multipart/form-data",
                contentType: false,
                processData: false,
                success: function ($data) {
                    analyticCreate($analytic, $chart_key, $settings, $data, $refresh);
                },
                error: function() {
                    $settings['wrap'].addClass('pls_analytics-empty');
                    $settings['wrap'].removeClass('loading');
                },
                beforeSend: function() {
                    $settings['wrap'].addClass('loading');
                }
            });
        }

    });

}


// Analytics
function analyticsGroupInit($refresh) {
    $refresh = $refresh || false;

    $('[data-analytics-group][data-url]').each(function() {
        var $group                  = $(this);
        var $url                    = $group.data('url');

        // check url
        if ( checkAttr($url) ) {
            var formData = new FormData($analyticsFilter[0]);

            // get data
            $.ajax({
                type: "POST",
                url: $url,
                data: formData,
                dataType: "json",
                mimeType: "multipart/form-data",
                contentType: false,
                processData: false,
                success: function ($data) {

                    if ($data) {

                        $group.find('[data-analytics]:not([data-url])').each(function() {
                            var $analytic = $(this);
                            var $settings = analyticSettings($analytic);

                            analyticCreate($analytic, $settings, $data[$settings['id']]);
                        });

                    }
                   
                },
                error: function() {
                    $group.addClass('pls_analytics-empty');
                    $group.removeClass('loading');
                },
                beforeSend: function() {
                    $group.addClass('loading');
                }
            });
        }

    });

}


// Analytic Settings
function analyticSettings($analytic) {
    var $settings           = [];
    $settings['id']         = $analytic.attr('id');
    $settings['dom']        = document.getElementById($settings['id']);
    $settings['wrap']       = $analytic.closest('.pls_analytics-panel');
    $settings['url']        = $analytic.data('url');
    $settings['type']       = $analytic.data('analytics');

    $settings['wrap'].removeClass('pls_analytics-empty');

    return $settings;
}


// Analytics - Create
function analyticCreate($analytic, $chart_key, $settings, $data, $refresh) {

    if ($data['chart'].length) {
        var $option = {};

        switch($settings['type']) {

            // line
            case 'line':
                $option = analyticsLine($data);
                break;
            // line
            case 'bar':
                $option = analyticsBar($data);
                break;
            // funnel
            case 'funnel':
                $option = analyticsFunnel($data);
                break;
            // pie
            case 'pie':
                $option = analyticsPie($data, $chart_key);
                break;
            case 'quick-stats':
                analyticsQuickStats($data, $settings['wrap'], $refresh);
                break;
        }

        // chart init
        if ($option && typeof $option === "object" && $settings['type'] != "quick-stats") {

            var $myChart = echarts.init($settings['dom']);
            $myChart.setOption($option, true);

            if (!$refresh) {
                var titleTemplate = Handlebars.compile ( $("#analytics-title-template").html() );
                $settings['wrap'].prepend(titleTemplate({'title': $data.title, 'description': $data.description}));

                // responsive
                $(window).on('resize', function(){
                    if($myChart != null && $myChart != undefined) {
                        $myChart.resize();
                    }
                });
            }
        }

        tooltipInit();
    }
    else {
        $settings['wrap'].addClass('pls_analytics-empty');
    }
    $settings['wrap'].removeClass('loading');
}

// Refresh
function analyticsRefresh() {

    $('#analytics-filter').on('change changed.bs.select click', 'select', function() {
        analyticsInit(true);
    });

}


// Bar
function analyticsBar($data, $settings) {
    var $series = [];

    // create data
    var opacity = '5';
    var currency = '';
    if ($data.currency) {
        currency = $data.currency+' ';
    } 
    
    var chart_data = [];
    var line_chart = [];
    var line_name  = '';
    $.each($data.chart, function(key, chart) {
        var $color_key = Math.floor(Math.random()*$colors.length);

        if (chart.color) {
            $color_key = chart.color;
        }
        var color = colorToRgb($colors[$color_key][1]) + ', ';
        
        chart_data = [];
        
        $.each(chart.data, function(key, chart_data_item) {
            chart_data.push(chart_data_item.value)
        });
        
        if(chart.draw_line_chart)
        {
            line_chart = chart_data;
            line_name  = chart.name;
        }
            
        var item = {
            name: chart.name,
            type: 'bar',
            smooth: true,
            lineStyle: {
                normal: {
                    opacity: 0
                }
            },
            areaStyle: {normal: {}},
            itemStyle: {
                normal: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: 'rgba('+color+' 0.'+(opacity+3)+')'},
                            {offset: 0.7, color: 'rgba('+color+' 0.'+opacity+')'},
                            {offset: 1, color: 'rgba('+color+' 0.2)'}
                        ]
                    )
                }
            },
            data: chart_data
        };

        $series.push(item);
        
    });
    if(line_chart)
    {
        var line = {
            name: line_name,
            type: 'line',
            symbolSize: 6,
            smooth: true,
            itemStyle: { 
                normal: { 
                    color: 2,
                }
            },
            data: line_chart
        };
        $series.push(line);
    }
    
    var labels = [];
    $.each($data.labels, function(key, label_item){
        labels.push(label_item.label + (label_item.sublabel?("\r\n" + label_item.sublabel): ''));
    })
    // options
    var $option = {
        tooltip : {
            backgroundColor: $tooltipColor,
            showContent: true,
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                label: {
                    backgroundColor: $tooltipColor,
                }
            },
            formatter: function (params) {
                return params[0].name + '<br />' + params[0].value;
            }
        },
        grid: {
            x: 60, y: 20, x2: 20, y2: 40
        },
        xAxis: {
            data: labels,
            axisLabel: {
                inside: false,
                textStyle: {
                    color: $textColor,
                }
            },
            axisTick: {
                show: false
            },
            axisLine: {
                show: false,
            },
            z: 10
        },
        yAxis: {
            axisLine: {
                show: false,
            },
            axisTick: {
                show: false
            },
            axisLabel: {
                textStyle: {
                    color: $textColor,
                }
            },
        },
        series: $series,
    };

    return $option;
}


// Line
function analyticsLine($data, $settings) {
    var $series = [];

    // create data
    var currency = '';
    if ($data.currency) {
        currency = $data.currency+' ';
    }
    var chart_data = [];
    
    $.each($data.chart, function(key, chart) {
        var $color_key = Math.floor(Math.random()*$colors.length);

        if (chart.color) {
            $color_key = chart.color;
        }
        var color = colorToRgb($colors[$color_key][1]) + ', ';
        
        chart_data = [];
        $.each(chart.data, function(key, chart_data_item) {
            chart_data.push(chart_data_item.value)
        });

        var item = {
            name: chart.name,
            type: 'line',
            smooth: true,
            symbolSize: 6,
            lineStyle: {
                normal: {
                    color: 'rgba('+color+' 0.6)',
                }
            },
            areaStyle: {normal: {}},
            itemStyle: {
                normal: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: 'rgba('+color+' 0.2)'},
                            {offset: 0.7, color: 'rgba('+color+' 0.0)'},
                            {offset: 1, color: 'rgba('+color+' 0.0)'}
                        ]
                    ),
                    borderColor: 'rgba('+color+' 0.8)',
                }
            },
            data: chart_data
        };

        $series.push(item);
        
    });

    var labels = [];
    $.each($data.labels, function(key, label_item){
        labels.push(label_item.label + (label_item.sublabel?("\r\n" + label_item.sublabel): ''));
    })
    
    // options
    var $option = {
        tooltip : {
            backgroundColor: $tooltipColor,
            showContent: true,
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                label: {
                    backgroundColor: $tooltipColor,
                }
            },
        },
        grid: {
            x: 40, y: 20, x2: 5, y2: 20
        },
        xAxis: {
            data: labels,
            axisLabel: {
                inside: false,
                textStyle: {
                    color: $textColor,
                }
            },
            axisTick: {
                show: false
            },
            axisLine: {
                show: false,
            },
            z: 10
        },
        yAxis: {
            axisLine: {
                show: false,
            },
            axisTick: {
                show: false
            },
            axisLabel: {
                textStyle: {
                    color: $textColor,
                }
            },
        },
        series: $series,
    };

    return $option;
}


// Funnel
function analyticsFunnel($data) {
    var $series = [];
    
    // colors
    var $colors = chroma.scale(['#ffb54a','#ed5200', '#ce2e4a', '#5f1a47']).mode('lch').colors(6);

    // create data
    $.each($data.data, function(key, item) {
        var color = $colors[key];

        var item = {
            value: item, 
            name: $data.name[key],
            itemStyle: {
                normal: {
                    color: color
                },
            },
        };

        $series.push(item);

    });

    // options
    var $option = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c}"
        },
        calculable: false,
        series: {
            name: 'Members',
            type: 'funnel',
            left: '10%',
            top: 0,
            bottom: 0,
            width: '80%',
            min: 3,
            max: 500,
            sort: 'descending',
            gap: 2,
            funnelAlign: 'center',
            animation: true,
            label: {
                normal: {
                    show: true,
                    position: 'inside'
                },
                emphasis: {
                    textStyle: {
                        fontSize: 20
                    }
                }
            },
            labelLine: {
                normal: {
                    length: 10,
                    lineStyle: {
                        width: 1,
                        type: 'solid'
                    }
                }
            },
            itemStyle: {
                normal: {
                    borderColor: '#fff',
                    borderWidth: 1
                }
            },
            data: $series
        },
    };

    return $option;

}


// Pie
function analyticsPie($data, $chart_key) {
    var $series = [];

    var $color_key = Math.floor(Math.random()*$colors.length);

    // create data
    $.each($data.chart, function(key, row) {
        var color = $colors[($data.color?$data.color:$color_key)][key];

        if ($data['custom_color']) {
            color = $data['custom_color'][key];
        }

        var item = {
            
            value: row['value'],
            name: row['label'],
            itemStyle: {
                normal: {
                    color: color
                },
            },
        };

        $series.push(item);

    });

    var currency = '';
    if ($data.currency) {
        currency = $data.currency+' ';
    }

    // options
    var $option = {
        tooltip : {
            trigger: 'item',
            backgroundColor: $tooltipColor,
            formatter: function (params) {
                var target;
                var subvalue = '';
                for (var i = 0, l = $data.chart.length; i < l; i++) {
                    if ($data.chart[i]['label'] == params.name) {
                        
                        target = $data.chart[i]['value'];
                        if ($data.chart[i]['subvalue']) {
                            subvalue = ' ('+$data.chart[i]['subvalue']+')';
                        }
                    }
                }
                return params.name + ' - ' + currency + target + subvalue;
            }
        },
        legend: {
            textWidth: 100,
            type: 'plain',
            icon: 'circle',
            orient: 'vertical',
            left: '32%',
            textStyle: {
                verticalAlign: 'top',
                lineHeight: 66,
            },
            itemWrap: true,
            y: 'center',
            formatter: function(name){
                var target;
                var subvalue = '';
                for (var i = 0, l = $data.chart.length; i < l; i++) {
                    if ($data.chart[i]['label'] == name) {
                        target = $data.chart[i]['value'];

                        if (currency) {
                            target = numberFormatExpress(target, true);
                        }

                        if ($data.chart[i]['subvalue']) {
                            subvalue = ' ('+$data.chart[i]['subvalue']+')';
                        }
                    }
                }
                return name + ' - ' + currency + target + subvalue;
            },
            data: $data.name,
        },
        series: {
            name: $data.title,
            type: 'pie',
            radius: [21, 60],
            label: false,
            center: ['15%', '50%'],
            hoverOffset: 5,
            dimensions: ['highest'],
            data: $series
        },
    };

    return $option;

}


// Quick stats
function analyticsQuickStats($data, $wrap, $refresh) {
    $refresh = $refresh || false;
    var templateData = {};
    
    if ($refresh) {
        $.each($data.chart, function(key, item) {
            $('#quick-stat-'+item.name+' [data-counter=true]').text(item.stat);
        });
    }
    else {
        templateData['data'] = $data.chart;
        var template = Handlebars.compile ( $("#analytics-quick-stats-template").html() );
        $wrap.append(template(templateData));
    }

    counterInit();
}


// Period switcher
function analyticPeriodSwitcher() {
    var input_from = $('input[name="filter[date-start]"]');
    var input_to   = $('input[name="filter[date-end]"]');
    var format     = 'DD MMMM YYYY';

    $('#pls_analytic-period-switcher label').on('click', function(e) {
        e.preventDefault();

        var self = $(this);
        var input = self.find('input');
        var type = input.val();
        var wrap = self.closest('.pls_actionbar-period-swicher');
        var set_date = [];
        var date = [];

        // type
        switch(type) {
            case "today":
                set_date['from']    = moment().format(format);
                set_date['to']      = set_date['from'];
                break;

            case "yesterday":
                set_date['from']    = moment().subtract(1, 'days').format(format);
                set_date['to']      = set_date['from'];
                break;

            case "this-week":
                set_date['from']    = moment().startOf('week').format(format);
                set_date['to']      = moment().endOf('week').format(format);
                break;

            case "past-week":
                set_date['from']    = moment().startOf('week').subtract(1, 'week').format(format);
                set_date['to']      = moment().endOf('week').subtract(1, 'week').format(format);
                break;

            case "this-month":
                set_date['from']    = moment().startOf('month').format(format);
                set_date['to']      = moment().endOf('month').format(format);
                break;

            case "past-month":
                set_date['from']    = moment().startOf('month').subtract(1, 'month').format(format);
                set_date['to']      = moment().endOf('month').subtract(1, 'month').format(format);
                break;
        }


        if (type != 'custom-date') {
            input_from.val(set_date['from']);
            input_to.val(set_date['to']).change();
        }

        input.prop('checked', true).change();
    });

    // daterange
    $('#pls_analytic-period-daterange input').on('change', function(e) {
        var self        = $(this);
        var type        = self.val();
        var wrap_from   = $('#custom-date-from');
        var wrap_to     = $('#custom-date-to');

        var date_from   = new Date(input_from.val());
        var date_to     = new Date(input_to.val());

        wrap_from.text( moment(date_from).format('MMMM Do YYYY') );
        wrap_to.text( moment(date_to).format('MMMM Do YYYY') );

        analyticsInit(true);
    });
}


// INIT
$(document).on('ready', function() {
    analyticsInit();
    analyticsGroupInit();
    analyticsRefresh();
    analyticPeriodSwitcher();
});