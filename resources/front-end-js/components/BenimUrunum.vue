<template>
<div class="exportCountrySearch">

							<v-select id="myCountry"
                            class="w-full mt-5"
                            v-model="dataSelected"
                            :options="results"
                            @input="goToNextPage"
                            @search="query => search = query"
                            :getOptionLabel="option => option.gtip6desc"
                            :filterable="true"/>



</div>
</template>

<script>
  import axios from 'axios'
  import vSelect from 'vue-select'


    export default {
        components: {
            'v-select': vSelect
        },

        data: () => ({
            search : '',
            show : false,
            results: [],
            dataSelected: '',

        }),
        computed: {
            filtered () {
            return this.results.filter(data => data.includes(this.search))
            },

        },
        watch: {
         search: function (searchKey) {
             this.fetchCountries(searchKey)
            }
        },
        methods : {
        fetchCountries(key) {
          return new Promise((resolve, reject) => {
            axios.get(`https://api.ihracatradari.com/comtrade/gethscodes?q=${key}`)
              .then((response) => {
                  //console.log(response.data)
                this.results = response.data
                resolve(response)
              })
              .catch((error) => { reject(error) })
             })
         },
         goToNextPage() {
             this.$router.push({path: '/benim-urunum-ulke-detayi', query : { id: this.dataSelected.gtip6}});
         }
        },
        created() {
            this.fetchCountries()

        }
    }
</script>

<style>
#myCountry {
    width: 60%;
}


</style>
