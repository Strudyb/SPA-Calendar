<template>
         <div class="exportRepresentiveInfos">
							<div class="blockHeader">
								<h1>{{country_detail.nameTr}} <br>
									<small>Ülke Temsilcileri</small>
								</h1>
							</div>


                        	<div class="representiveArea" v-for="(representer,index) in representers " :key="index">
								<div class="representiveCard">
									<div class="representiveHeader">
										<h4>{{representer.name}}</h4>
										<div class="representiveTitle">
											{{representer.jobTitle}}
										</div>
										<div class="representiveCompany">
											{{representer.address.company}}
										</div>
									</div>


                                    <div class="representiveContact">
										<ul>
											<li>
												<span>Adres:</span>
											{{representer.address.street}}
												<a href="#" class="rightIcon"><i class="fa fa-map-marker"></i></a>
											</li>

											<li>
												<span>Telefon:</span>
												    <p v-for="(phone,index) in representer.phones " :key="index">{{phone}},</p>
												<a href="#" class="rightIcon"><i class="fa fa-phone"></i></a>
											</li>



											<li>
												<span>Faks:</span>
												 <p v-for="(fax,index) in representer.faxes " :key="index">{{fax}},</p>
											</li>

											<li>
												<span>E-Posta:</span>
												 <p v-for="(email,index) in representer.emails " :key="index">{{email}},</p>
												<a href="#" class="rightIcon"><i class="fa fa-envelope"></i></a>
											</li>

											<li>
												<span>Web Site:</span>
													{{representer.address.webSite}}
												<a href="#" class="rightIcon"><i class="fa fa-link"></i></a>
											</li>
										</ul>
									</div>



								</div>

							</div>


</div>
</template>

<script>

  import axios from 'axios'

    export default {
        components: {

        },

        data: () => ({
            representers : [],
            country_detail : [],
        }),
        computed: {

        },
        methods : {
        fetchCodeDetails() {
          return new Promise((resolve, reject) => {
            axios.get(`https://api.ihracatradari.com/comtrade/getcontacts?c=${this.$route.query.country}`)
              .then((response) => {
                  console.log(response.data)
                this.representers = response.data
                resolve(response)
              })
              .catch((error) => { reject(error) })
             })
         },
        fetchCountryDetail() {
          return new Promise((resolve, reject) => {
            axios.get(`https://api.ihracatradari.com/comtrade/getcountry?countryName=${this.$route.query.country}`)
              .then((response) => {
                  console.log(response.data)
                this.country_detail = response.data
                resolve(response)
              })
              .catch((error) => { reject(error) })
             })
         },


        },
        created() {
            this.fetchCodeDetails()
            this.fetchCountryDetail()
        }
    }
</script>


