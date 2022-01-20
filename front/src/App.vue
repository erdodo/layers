<template>
  <div>
    <div class="d-flex flex-column flex-root">
      <!--begin::Page-->
      <div class="page d-flex flex-row flex-column-fluid">
        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
          <Header/>
          <router-view></router-view>
          <Footer/>
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Page-->
    </div>
    <ActivityLogs/>
    <Chat/>
    <RightButton/>
    <RightButtonModal/>
    <CreateModal/>
    <Modals/>
    <ScroolTopButton/>
  </div>

</template>
<script>
import Header from '@/pages/Header.vue'

import Footer from '@/pages/Footer.vue'
import ActivityLogs from '@/pages/ActivityLogs.vue'
import Chat from '@/pages/Chat.vue'
import RightButton from '@/pages/RightButton.vue'
import RightButtonModal from '@/pages/RightButtonModal.vue'
import CreateModal from '@/pages/CreateModal.vue'
import ScroolTopButton from '@/pages/ScroolTopButton.vue'
import Modals from '@/pages/Modals.vue'
export default {
  data() {
    return {
      katmanMi: false,
    }
  },
  components: {
    Header,
    Footer,
    ActivityLogs,
    Chat,
    RightButton,
    RightButtonModal,
    CreateModal,
    ScroolTopButton,
    Modals
  },
  watch: {
    '$route' (to) {
      if(to.name=='Katman'){
        this.katmanMi = true
      }else{
        this.katmanMi = false
      }
    }
  }
}
</script>