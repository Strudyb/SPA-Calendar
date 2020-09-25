<template>
            <div class="exportDetailsTable">
                <h1>{{this.$route.query.id}}</h1>

                <div class="exportCountryRate">
                    <span class="bold"> {{code_details.hsCodeName  }} </span><br>
                     <span class="bold">{{code_details.year}}</span> yılı toplam ithalatı {{numFormatter(code_details.totalImportValue)}}$
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ULKE</th>
                            <th class="">İTHALAT</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr v-for="(data,index) in code_details.items" :key="index">

                            <td>
                                <a href="#"  @click="goToNextPage(data.country.name)">
                                    <span class="gtipNumber">{{data.country.nameTr}}</span>
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
            code_details : [],
        }),
        computed: {

        },
        methods : {
        fetchCodeDetails() {
          return new Promise((resolve, reject) => {
            axios.get(`https://api.ihracatradari.com/comtrade/gettopimportersbyhs?hs=${this.$route.query.id}`)
              .then((response) => {
                  console.log(response.data)
                this.code_details = response.data
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

           goToNextPage(country) {
             this.$router.push({path: '/ihracat-istatistik', query : {id:this.$route.query.id, country: country}});
         }

        },
        created() {
            this.fetchCodeDetails()
        }
    }
</script>


