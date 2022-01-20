<template>
    <div class="row g-5 g-xxl-8 draggable-zone"  >
        <!--begin::Col-->
        <div class="col-xxl-6 draggable">
            <!--begin::Mixed Widget 5-->
            <div class="card card-xxl-stretch mb-xl-3">
                <!--begin::Beader-->
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Trends</span>
                        <span class="text-muted fw-bold fs-7">Latest trends</span>
                    </h3>
                    <div class="card-toolbar w-100" style="justify-content: center;">
                        <Chart :chartData="chartData"></Chart>
                    </div>
                </div>
                <!--end::Header-->
            </div>
            <!--end::Mixed Widget 5-->
        </div>
        <!--end::Col-->
    </div>
</template>

<script>
    import Chart from '@/components/chart.vue'
    export default {
        props: ['data'],
        components: {
            Chart
        },
        data() {
            return {
                chartData: {
                    title:'Katmanlar',
                    subtitle:'',
                    yTitle: '',
                    xTitle: '',
                    xBaslangic: null,
                    data:[]
                }
            }
        },
        created() {
            for(const child of Object.values(this.data.child)) {
                for(const props of Object.values(child.property)) {
                   if(props.type=='number'){
                       
                        this.chartData.data.push({
                           name: props.name,
                           data: [ parseInt(props.propertyContent.content)]
                        })
                   }
                }
            }
            console.log(this.chartData)
        },
        watch: {
            chartData() {
                console.log(this.chartData)
            }
        }
    }
    
</script>

<style>

</style>