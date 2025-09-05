var colors = [
    '#28A745',
    '#FFC107',
    '#f36270',
    '#1E90FF',
    '#FF6347',
    '#6F42C1',
    '#E83E8C',
    '#FFB6C1',
    '#87CEFA',
    '#90EE90',
    '#FFD700',
    '#FFA07A',
    '#E0FFFF',
    '#F08080',
    '#D8BFD8',
    '#FFFACD'
];

const createChart = (el, color) => {
    var options = {
        series: [{name: "", data: [50, 85, 60, 100, 70, 45, 90, 75]}],
        chart: {height: 45, type: "area", sparkline: {enabled: !0}, animations: {enabled: !1}},
        colors: [getComputedStyle(document.documentElement).getPropertyValue(color).trim()],
        fill: {type: "gradient", gradient: {shadeIntensity: 1, opacityFrom: .5, opacityTo: .1, stops: [0, 90, 100]}},
        tooltip: {enabled: !1},
        dataLabels: {enabled: !1},
        grid: {show: !1},
        xaxis: {labels: {show: !1}, axisBorder: {show: !1}, axisTicks: {show: !1}},
        yaxis: {show: !1},
        stroke: {curve: "smooth", width: 1}
    }
    var chart = new ApexCharts(document.querySelector(el), options);
    chart.render();
}

const createPieChart = (el, series, arr_labels, unit = '', type = 'pie') => {
    var options = {
        series: series,
        chart: {
            type: type,
            height: 300,
            toolbar: {show: false}
        },

        labels: arr_labels,
        colors: colors,
        tooltip: {
            enabled: true,
            y: {
                formatter: val => formatVN(val, unit)
            }
        },
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: false,
            formatter: (val, opts) => {
                const raw = opts.w.config.series[opts.seriesIndex];
                return formatVN(raw, unit);
            }
        }
    };

    var chart = new ApexCharts(document.querySelector(el), options);
    chart.render();
}

const createChartLine = (el, series, arr_labels, unit = '') => {
    var options = {
        series: series,
        chart: {
            height: 300,
            type: "line",
            zoom: {enabled: false},
            toolbar: {show: false}
        },
        stroke: {
            width: [4, 4, 4],
            curve: "smooth",
            dashArray: [0, 8, 4]
        },
        dataLabels: {
            enabled: false,
            formatter: val => formatVN(val, unit)
        },
        markers: {size: 5},
        colors: colors,
        legend: {position: "top"},
        xaxis: {
            categories: arr_labels
        },
        yaxis: {
            labels: {
                formatter: val => formatVN(val)
            },
        },

        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: val => formatVN(val, unit)
            }
        }
    };

    var chart = new ApexCharts(document.querySelector(el), options);
    chart.render();
}

const createChartBar = (el, series, arr_labels, unit = '') => {
    var options = {
        series: series,
        chart: {
            type: 'bar',
            height: 300,
            zoom: {enabled: false},
            toolbar: {show: false}
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false,
            formatter: val => formatVN(val, unit)
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        colors: colors,
        xaxis: {
            categories: arr_labels,
        },
        yaxis: {
            labels: {
                formatter: val => formatVN(val)
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {formatter: val => formatVN(val, unit)}
        },
        legend: {
            position: 'top'
        }
    };

    var chart = new ApexCharts(document.querySelector(el), options);
    chart.render();
}

const createChartBarWithColor = (el, series, arr_labels, unit = '', color = '#28A745') => {
    var options = {
        series: series,
        chart: {
            type: 'bar',
            height: 300,
            zoom: {enabled: false},
            toolbar: {show: false}
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false,
            formatter: val => formatVN(val, unit)
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        colors: [color],
        xaxis: {
            categories: arr_labels,
        },
        yaxis: {
            labels: {
                formatter: val => formatVN(val)
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {formatter: val => formatVN(val, unit)}
        },
        legend: {
            position: 'top'
        }
    };

    var chart = new ApexCharts(document.querySelector(el), options);
    chart.render();
}

const formatVN = (val, unit = '') => {
    return val.toLocaleString("de-DE", {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }) + (unit || '');
}
