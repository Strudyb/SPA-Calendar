<template>
  <div class="vx-col w-full md:w-12/12 mb-base">
      <vs-tabs position="left" color="danger">
        <vs-tab label="Anasayfa Menu Alti Slider" >
          <vx-card no-shadow v-for="(option,index)  in HomeUnderMenuSlider" :key="index">
            <div  class="vx-col  w-full md:w-12/12 mb-base">
              <vs-input :label="'H1 Aciklama'"  v-model="option.h1" class="mt-5 w-full"  />
              <vs-input :label="'H2 Aciklama'"  v-model="option.h2" class="mt-5 w-full"  />
              <vs-input :label="'Video Url'"  v-model="option.video" class="mt-5 w-full"  />
              <vs-input :label="'Resim URL'"  v-model="option.image" class="mt-5 w-full"  />
              <vs-input :label="'Button Url'"  v-model="option.url" class="mt-5 w-full"  />
              <vs-button class="bg-danger" @click="removeThis(index,'HomeUnderMenuSlider')" >{{$t('RemoveThis')}}</vs-button>
            </div>
            <vs-divider></vs-divider>
          </vx-card>
          <vs-button class="mr-6" @click="addOptions('HomeUnderMenuSlider')" >{{$t('AddNew')}}</vs-button>
          <div class="flex flex-wrap items-center justify-end">
            <vs-button class="ml-auto mt-2" @click="SaveData('HomeUnderMenuSlider')">{{$t('save')}}</vs-button>
          </div>
        </vs-tab>

      </vs-tabs>
  </div>

</template>

<script>
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import vSelect from 'vue-select'


export default {
  components: {
    flatPickr,
    vSelect
  },

  data () {
    return {
      HomeUnderMenuSlider:
      [
        {
          h1: '',
          h2: '',
          video: '',
          image: '',
          url: ''
        }
      ],



    }
  },
  methods:{
    addOptions (type) {
      this[type].push({})
    },
    removeThis (index, type) {
      this[type].splice(index, 1)
    },
    SaveData (dataType) {
      const obj = {
        [dataType]: this[dataType],
        type: dataType
      }
      console.log(obj)
      this.$store.dispatch('custom/addItem', obj).then((response) => {
        this.$vs.notify({
          title: 'Başarılı',
          text:' İçerik Başarıyla Eklendi',
          iconPack: 'feather',
          icon: 'icon-success',
          color: 'success'
        })

      }).catch(error => {
        this.$vs.notify({
          title: 'Hata',
          text: 'İçerik Eklenemedi.',
          iconPack: 'feather',
          icon: 'icon-alert-circle',
          color: 'danger'
        })
      })
    },

  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  },
  created () {
    this.$store.dispatch('custom/fetchItems')
      .then((response) => {
        response.data.forEach(element => {
          if (element.type === 'HomeUnderMenuSlider') {
            this[element.type].push(JSON.parse(element.JsonData)[element.type])
            this[element.type].splice(0, 1)
            this[element.type] = this[element.type][0]
          } else {
            this[element.type] = JSON.parse(element.JsonData)[element.type]
          }

        })

      })
      .catch((error) => { console.log(error) })

  }
}
</script>
