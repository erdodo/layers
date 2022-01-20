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
                        <button class="btn btn-light-primary form-control my-2" @click="ekle">Ekle</button>

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
                            <input type="text" class="form-control" v-model="updatePropertyName" placeholder="Özellik İsmi"/>
                        </div>
                        <div class="form-group my-2">
                            <label for="">Özellik Tipi</label>
                            <select class="form-select" aria-label="Select example" v-model="updatePropertyType">
                                <option>Özellik Tipi</option>
                                <option value="text">Yazı</option>
                                <option value="number">Sayi</option>
                                <option value="link">Url</option>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label for="">İçerik</label>
                            <input type="text" class="form-control" v-model="updatePropertyContent" placeholder="Özellik İsmi"/>
                        </div>
                        <button class="btn btn-light-primary form-control my-2" @click="update">Ekle</button>

                    </div>

                </div>
            </div>
        </div>
        <!-- end: Edit property -->
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
                updatePropertyName: '',
                updatePropertyType: '',
                updatePropertyContent: '',
            }
        },
        methods: {
            ekle(){
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
            update(){
                console.log(this.getUpdatePropData?.propertyContent?.id==null?this.getUpdatePropData?.propertyContent?.id:0);
                axios.get('update/propertyUpdate', {
                    params: {
                        id:this.getUpdatePropData.id,
                        name: this.updatePropertyName,
                        type: this.updatePropertyType,
                        contentId: this.getUpdatePropData.propertyContent.id,
                        content: this.updatePropertyContent,
                    }
                }).then(response => {
                    if(response.data.status == true){
                        Swal.fire({
                            title: 'Başarılı',
                            text: 'Özellik güncellendi',
                            icon: 'success',
                            confirmButtonText: 'Tamam'
                        }).then(() => {
                            this.updatePropertyName = '';
                            this.updatePropertyType = '';
                            this.updatePropertyContent = '';
                        });
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
            }
        },
        computed:{
            ...mapGetters([
                'getUpdatePropData'
            ])
        },
        watch: {
            getUpdatePropData(){
                this.updatePropertyName = this.getUpdatePropData.name;
                this.updatePropertyType = this.getUpdatePropData.type;
                this.updatePropertyContent = this.getUpdatePropData.propertyContent?.content ? this.getUpdatePropData.propertyContent.content : '';
            }
        }
    }
</script>

<style>

</style>