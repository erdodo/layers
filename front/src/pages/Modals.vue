<template>
    <div>
        <!-- begin:: New Property -->
        <div class="modal fade" tabindex="-1" id="addProperty">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group my-2">
                            <label for="">Özellik ismi</label>
                            <input type="text" class="form-control" v-model="addPropertyName" placeholder="Özellik İsmi"/>
                        </div>
                        <div class="form-group my-2">
                            <label for="">Özellik Tipi</label>
                            <select class="form-select" aria-label="Select example" v-model="addPropertyType">
                                <option>Özellik Tipi</option>
                                <option value="text">Yazı</option>
                                <option value="number">Sayi</option>
                                <option value="link">Url</option>
                            </select>
                        </div>
                        <button class="btn btn-light-primary form-control my-2" @click="addProperty">Ekle</button>

                    </div>

                </div>
            </div>
        </div>
        <!-- end: New property -->
        <!-- begin:: Edit Property -->
        <div class="modal fade" tabindex="-1" id="updateProperty">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group my-2">
                            <label for="">Özellik ismi</label>
                            <input type="text" class="form-control" v-model="getUpdatePropData.name" placeholder="Özellik İsmi"/>
                        </div>
                        <div class="form-group my-2">
                            <label for="">Özellik Tipi</label>
                            <select class="form-select" aria-label="Select example" v-model="getUpdatePropData.type">
                                <option>Özellik Tipi</option>
                                <option value="text">Yazı</option>
                                <option value="number">Sayi</option>
                                <option value="link">Url</option>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label for="">İçerik</label>
                            <input type="text" class="form-control" v-model="getUpdatePropData.propertyContent.content" placeholder="Özellik İsmi"/>
                        </div>
                        <button class="btn btn-light-primary form-control my-2" @click="updateProperty">Güncelle</button>

                    </div>

                </div>
            </div>
        </div>
        <!-- end: Edit property -->
        <!-- begin:: New Layer -->
        <div class="modal fade" tabindex="-1" id="addLayer">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group my-2">
                            <label for="">Katman ismi</label>
                            <input type="text" class="form-control" v-model="addLayer.name" placeholder="Katman ismi"/>
                        </div>
                        <div class="form-group my-2">
                            <label for="">Katman İkon</label>
                           <input type="text" class="form-control" v-model="addLayer.icon" placeholder="Katman ismi"/>
                        </div>
                        <div class="form-group my-2">
                            <label for="">Katman Detay</label>
                            <textarea class="form-control" v-model="addLayer.detail" cols="30" rows="10"></textarea>
                        </div>
                        <button class="btn btn-light-primary form-control my-2" @click="addLayerFunc">Ekle</button>

                    </div>

                </div>
            </div>
        </div>
        <!-- end: New Layer -->
    </div>
</template>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2';
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                addPropertyName: '',
                addPropertyType: '',
                addLayer: {
                    name: '',
                    detail: '',
                    icon: '',
                },
            }
        },
        methods: {
            addProperty(){
                axios.get('update/propertyAdd', {
                    params: {
                        name: this.addPropertyName,
                        type: this.addPropertyType,
                        url: this.$route.path
                    }
                }).then(response => {
                    if(response.data.status == true){
                        Swal.fire({
                            title: 'Başarılı',
                            text: 'Özellik eklendi',
                            icon: 'success',
                            confirmButtonText: 'Tamam'
                        }).then(() => {
                            this.addPropertyName = '';
                            this.addPropertyType = '';
                        });
                    }
                }).catch(error => {
                    console.log(error);
                    Swal.fire({
                        title: 'Hata',
                        text: 'Özellik eklenemedi',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                })
            },
            updateProperty(){
                axios.get('update/propertyUpdate', {
                    params: {
                        prop:this.getUpdatePropData
                    }
                }).then(response => {
                    if(response.data.contentStatus == true && response.data.propStatus == true){
                        Swal.fire({
                            title: 'Başarılı',
                            text: 'Özellik güncellendi',
                            icon: 'success',
                            confirmButtonText: 'Tamam'
                        })
                    }else{
                        Swal.fire({
                            title: 'Hata',
                            text: 'Özellik güncellenemedi',
                            icon: 'error',
                            confirmButtonText: 'Tamam'
                        })
                    }
                }).catch(error => {
                    console.log(error);
                    Swal.fire({
                        title: 'Hata',
                        text: 'Özellik güncellenemedi',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                })
            },
            addLayerFunc(){
                axios.get('update/layerAdd', {
                    params: {
                        name: this.addLayer.name,
                        detail: this.addLayer.detail,
                        icon: this.addLayer.icon,
                        url: this.$route.path,
                        token:123
                    }
                }).then(response => {
                    if(response.data.status == true){
                        Swal.fire({
                            title: 'Başarılı',
                            text: 'Katman eklendi',
                            icon: 'success',
                            confirmButtonText: 'Tamam'
                        }).then(() => {
                            this.addLayer.name = '';
                            this.addLayer.detail = '';
                            this.addLayer.icon = '';
                        });
                    }
                }).catch(error => {
                    console.log(error);
                    Swal.fire({
                        title: 'Hata',
                        text: 'Katman eklenemedi',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                })
            },
        },
        computed:{
            ...mapGetters([
                'getUpdatePropData'
            ])
        },
        watch:{
            getUpdatePropData(){
                console.log(this.getUpdatePropData);
            }
        }
    }
</script>

<style>

</style>