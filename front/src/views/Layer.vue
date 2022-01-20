<template>
    <div>
        <ToolBar :breadcrumbs="breadcrumbs" />
        <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
            <!--begin::Post-->
            <div class="content flex-row-fluid" id="kt_content">
                <!--begin::Navbar-->
                <Detail :data="data" @updateProp="updateProp($events)"/>
                <!--begin::Row-->
                <Grafik :data="data" />
                <!--end::Row-->
                <Child :data="data" />
                <!--end::Navbar-->
            </div>
            <!--end::Post-->

        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    import ToolBar from '@/pages/ToolBar.vue'
    import Detail from './LayerPages/Detail.vue';
    import Grafik from './LayerPages/Grafik.vue';
    import Child from './LayerPages/Child.vue';

    export default {
        data() {
            return {
                data: [],
                breadcrumbs: [],
            }
        },
        created() {
            this.getData();
        },
        components: {
            ToolBar,
            Detail,
            Grafik,
            Child
        },
        methods: {
            getData() {
                axios.get('layers/getLayer', {
                    params: {
                        token: 123,
                        url: this.$route.path
                    }
                }).then(res => {
                    this.data = res.data;
                    document.title = this.data.layer.name;
                    this.getBreadcrumb();
                    console.log(this.data);
                })
            },
            getBreadcrumb() {
                axios.get('update/getBreadcrumb', {
                    params: {
                        token: 123,
                        url: this.$route.path
                    }
                }).then(res => {
                    this.breadcrumbs = res.data;
                })
            },
        },
        watch: {
            $route(to, from) {
                console.log(to, from);

                this.getData();
            }
        }
    }
</script>

<style>

</style>