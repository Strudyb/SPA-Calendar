<template>
<div class="exportCountrySearch">

							<v-select id="myCountry"
                            class="w-full mt-5"
                            v-model="country"
                            :options="countries"
                            @input="goToNextPage"
                            @search="query => search = query"
                            :getOptionLabel="option => option.nameTr"
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
            show : false,
            countries: [],
            country: '',

        }),
        computed: {
            filtered () {
            return this.countries.filter(country => country.includes(this.search))
            },
        },
        methods : {
        fetchCountries() {
          return new Promise((resolve, reject) => {
            axios.get("https://api.ihracatradari.com/comtrade/getcountries")
              .then((response) => {
                  //console.log(response.data)
                this.countries = response.data
                resolve(response)
              })
              .catch((error) => { reject(error) })
             })
         },

         goToNextPage() {
             this.$router.push({path: '/benim-temsilcim-detayi', query : { country: this.country.name}});
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
