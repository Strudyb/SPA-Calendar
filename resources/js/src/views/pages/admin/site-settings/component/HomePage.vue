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


        <vs-tab label="Anasayfa About Us Yazisi" >
          <vx-card>
               <div class="flex flex-wrap items-center mb-5 mt-5 h-full">
                      <span>{{$t('Content')}}</span>
                      <quill-editor v-model="about.homePageDesc" :label="$t('Content')" height="600" />
                      <span class="text-danger text-sm" v-show="errors.has('Content')">{{ errors.first('Content') ? $t('Content') : ''}}</span>
                    </div>
          </vx-card>
            <vs-input :label="'Hizmet Kataloğu Linki (ex = https://google.com)'"  v-model="about.url" class="mt-5 w-full"  />
           <vs-button class="ml-auto mt-2" @click="SaveData('about')">{{$t('save')}}</vs-button>
        </vs-tab>


        <vs-tab label="Hizli Randevu Hizmet Listesi" >
          <vx-card no-shadow v-for="(option,index)  in QuickServiceList" :key="index">
            <div  class="vx-col  w-full md:w-12/12 mb-base">
              <vs-input :label="'Hizmet Adi'"  v-model="option.key" class="mt-5 w-full"   v-validate="'required| min:3'"/>
              <vs-button class="bg-danger" @click="removeThis(index,'QuickServiceList')" >{{$t('RemoveThis')}}</vs-button>
            </div>
            <vs-divider></vs-divider>
          </vx-card>
          <vs-button class="mr-6" @click="addOptions('QuickServiceList')" >{{$t('AddNew')}}</vs-button>
          <div class="flex flex-wrap items-center justify-end">
            <vs-button class="ml-auto mt-2" @click="SaveData('QuickServiceList')">{{$t('save')}}</vs-button>
          </div>
        </vs-tab>


        <vs-tab label="4Lu Box Sayilari" >
          <vx-card >
              <vs-input :label="'Toplam Uyeler'"  v-model="fourBox.allusers" class="mt-5 w-full"  />
                 <vs-divider></vs-divider>
              <vs-input :label="'Toplam Imalatcı'"  v-model="fourBox.providers" class="mt-5 w-full"  />
                 <vs-divider></vs-divider>
              <vs-input :label="'Istihdam'"  v-model="fourBox.employments" class="mt-5 w-full"  />
              <vs-input :label="'E-ticaret Hacmi'"  v-model="fourBox.exportvolume" class="mt-5 w-full"  />
               <div class="flex flex-wrap items-center justify-end">
                <vs-button class="ml-auto mt-2" @click="SaveData('fourBox')">{{$t('save')}}</vs-button>
          </div>
          </vx-card>
        </vs-tab>

      </vs-tabs>
  </div>

</template>

<script>
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import vSelect from 'vue-select'

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import { quillEditor } from 'vue-quill-editor'

export default {
  components: {
    flatPickr,
    quillEditor,
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
      QuickServiceList:
      [
        {
          key: '',
        }
      ],
      fourBox :
        {
          allusers: '',
          providers: '',
          employments: '',
          exportvolume: ''
        },


        about:{ homePageDesc : '', url:''}
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
