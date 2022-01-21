<template>
    <highcharts class="chart" :options="chartOptions" ref="chart"></highcharts>
</template>

<script>
    import {
        Chart
    } from 'highcharts-vue'
    import Highcharts from 'highcharts'
    import exportingInit from 'highcharts/modules/exporting'
    import stockInit from 'highcharts/modules/stock'

    exportingInit(Highcharts);
    stockInit(Highcharts)
    export default {
        props: {
            chartData: {
                type: Object,
                required: true,
                default: () => {
                    return({
                        title:'Başlık',
                        subtitle:'Alt Başlık',
                        yTitle: 'Y-Ekseni Başlık',
                        xTitle: 'X-Ekseni Başlık',
                        xBaslangic: 1,
                        data:[{
                            name: 'Installation',
                            data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
                        }]
                    })
                }
            }
        },
        data() {
            return {
                chartOptions: {
                    title: {
                        text: this.chartData.title
                    },

                    subtitle: {
                        text: this.chartData.subtitle
                    },

                    yAxis: {
                        title: {
                            text: this.chartData.yTitle
                        }
                    },

                    xAxis: {
                        title: {
                            text: this.chartData.xTitle
                        }
                    },

                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },

                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            },
                            pointStart: this.chartData.xBaslangic
                        }
                    },

                    series: this.chartData.data,
                    width: '100%',
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 700
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                }
            }
        },
        components: {
            highcharts: Chart
        }
    }
</script>

<style>
.highcharts-credits{
    display: none;
    width: 100%;
}
.chart{
    border-radius: 20px !important;
}
</style>