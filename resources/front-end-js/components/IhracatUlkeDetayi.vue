<template>
            <div class="exportDetailsTable">
                <h1>{{country_details.countryName}}</h1>

                <div class="exportCountryRate">
                    <span class="bold">{{country_details.year}}</span> yılı toplam ithalatı
                    <span class="bold"> {{country_details.totalImportValue  }} $</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>GTİP</th>
                            <th class="">İTHALAT</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr v-for="(data,index) in country_details.items" :key="index">
                            <td>
                                <a href="#"  @click="goToNextPage(data.id)">
                                    <span class="gtipNumber">{{data.id}}</span>
                                    <span class="gtipDescription">
                                       {{data.hsCode.gtip2desc}}
                                    </span>
                                </a>
                            </td>
                            <td>
                                <a href="#"  @click="goToNextPage">
                                    <span class="exportValue">{{numFormatter(data.trade)}}</span>
                                    <span class="exportCurrency"> $</span>
                                </a>
                            </td>
                        </tr>








                    </tbody>
                </table>
            </div>
</template>

<script>

  import axios from 'axios'

    export default {
        components: {

        },

        data: () => ({
            country_details : [],
        }),
        computed: {

        },
        methods : {
        fetchCountryDetail() {
          return new Promise((resolve, reject) => {
            axios.get(`https://api.ihracatradari.com/comtrade/getcountryimports?hs=&c=${this.$route.query.country}`)
              .then((response) => {
                  console.log(response.data)
                this.country_details = response.data
                resolve(response)
              })
              .catch((error) => { reject(error) })
             })
         },
          numFormatter(num) {
            // Alter numbers larger than 1k
            if (num >= 1e3) {
                var units = ["Bin", "Milyon", "Milyar", "Trilyon"];

                // Divide to get SI Unit engineering style numbers (1e3,1e6,1e9, etc)
                let unit = Math.floor(((num).toFixed(0).length - 1) / 3) * 3
                // Calculate the remainder
                var num = (num / ('1e'+unit)).toFixed(2)
                var unitname = units[Math.floor(unit / 3) - 1]

                // output number remainder + unitname
                return num + ' ' + unitname
            }

            // return formatted original number
            return this.toLocaleString()
            },


          goToNextPage(id) {
             this.$router.push({path: '/ihracat-ulke-tum-detaylari', query : {id:id, country: this.$route.query.country}});
         }

        },
        created() {
            this.fetchCountryDetail()
        }
    }
</script>


