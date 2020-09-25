<template>

		<div class="container">
					<div class="row">

						<div class="cell-6">
							<div class="chartArea">
								<div class="chartHeader">

									<h3>ÜLKENİN DÜNYADAN İTHALATI</h3>
									<div>(Milyar $)</div>
								</div>
								<div class="chartCanvas">
									<e-charts autoresize
                                    :options="data0Chart"
                                     theme="ovilia-green"
                                      :loading="loading"
                                     auto-resize />
								</div>
							</div>

						</div>

						<div class="cell-6">
							<div class="chartArea">
								<div class="chartHeader">
									<h3>EN ÇOK İTHALAT YAPTIĞI 10 ÜLKE VE TÜRKİYE</h3>
									<div>(Milyar $)</div>
								</div>
								<div class="chartCanvas">
									<e-charts autoresize
                                    :options="data1Chart"
                                     theme="blue"
                                      :loading="loading"
                                     auto-resize />
								</div>
							</div>

						</div>
					</div>

					<div class="row">
						<div class="cell-6">
							<div class="chartArea">
								<div class="chartHeader">
									<h3>ÜLKENİN DÜNYADAN İTHALATI</h3>
									<div>(Milyar $)</div>
								</div>
								<div class="chartCanvas">
										<e-charts autoresize
                                    :options="topImportersChart"
                                     theme="blue"
                                      :loading="loading"
                                     auto-resize />
								</div>
							</div>

						</div>

						<div class="cell-6">
							<div class="chartArea">
								<table>
									<thead>
										<tr>
											<th>ÜLKE</th>
											<th>İTHALAT</th>
											<th>BİRİM FİYAT</th>
										</tr>
									</thead>
									<tbody>

										<tr v-for="(data,index) in topImporters" :key="index">
											<td>{{data.country}}</td>
											<td>{{numFormatter(data.trade)}} $ </td>
											<td>{{parseFloat(numberConvert(data.unitPrice,0))}} $/kg</td>
										</tr>


									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>

</template>

<script>
  import axios from 'axios'
import ECharts from 'vue-echarts/components/ECharts'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/legend'
import 'echarts/lib/chart/bar'
import theme from './theme.json'

ECharts.registerTheme('blue', theme)

    export default {
        components: {
            ECharts
        },
        computed: {

        },
        watch:{

        },
         data: () => ({
             loading: true,
             data0Chart: {
                title: {
                        text: 'ABD Chart'
                    },
                tooltip: {},
                xAxis: {
                    data:  [],
                    },
                yAxis: {},
                series: [
                    {
                    name: 'Milyar',
                    type: 'bar',
                    data: []
                     }
                  ]
            },
             data1Chart: {
                title: {
                        text: 'TR Chart'
                    },
                tooltip: {},
                xAxis: {
                    data:  [],
                    },
                yAxis: {},
                series: [
                    {
                    name: 'Milyar',
                    type: 'bar',
                    data: []
                     }
                  ]
            },
             topImportersChart: {
                title: {
                        text: 'TR Chart'
                    },
                tooltip: {},
                xAxis: {
                   data: []
                    },
                yAxis: {},
                series: [
                    {
                    name: 'Milyar',
                    type: 'bar',
                    data: []
                     }
                  ]
            },
            importDetails : [],
            data0 : [],
            data1 : [],
            topImporters : [],

            //new datas

        }),
        methods : {
        getImportDetails() {
          return new Promise((resolve, reject) => {
            axios.get(`https://api.ihracatradari.com/comtrade/getimportdetails?hs=${this.$route.query.id}&c=${this.$route.query.country}`)
              .then((response) => {
                  //console.log(response.data)
                this.importDetails = response.data
                resolve(response)
              })
              .catch((error) => { reject(error) })
             })
         },
        getData0() {
          return new Promise((resolve, reject) => {
            axios.get(`https://api.ihracatradari.com/comtrade/getchartdata?hs=${this.$route.query.id}&c=${this.$route.query.country}&t=0`)
              .then((response) => {
                this.data0 = response.data
                this.data0Chart.xAxis.data = this.data0.map((key ) => (key['key']))
                this.data0Chart.series[0].data = this.data0.map((value ) => parseFloat(this.numberConvert(value['value'],0)))
                //console.log(this.options.series[0].data)
                resolve(response)
              })
              .catch((error) => { reject(error) })
             })
         },
        getData1() {
          return new Promise((resolve, reject) => {
            axios.get(`https://api.ihracatradari.com/comtrade/getchartdata?hs=${this.$route.query.id}&c=${this.$route.query.country}&t=1`)
              .then((response) => {
                  this.data1 = response.data
                  this.data1Chart.xAxis.data = this.data1.map((key ) => (key['key']))
                  this.data1Chart.series[0].data = this.data1.map((value ) => parseFloat(this.numberConvert(value['value'],0)))
                  //console.log(this.data1)
                resolve(response)
              })
              .catch((error) => { reject(error) })
             })
         },
        getTopImporters() {
          return new Promise((resolve, reject) => {
            axios.get(`https://api.ihracatradari.com/comtrade/gettopimporters?hs=${this.$route.query.id}&c=${this.$route.query.country}&t=1`)
              .then((response) => {
                  //console.log(response.data)
                this.topImporters = response.data
                this.topImportersChart.xAxis.data = this.topImporters.map((country ) => (country['country']))
                this.topImportersChart.series[0].data = this.topImporters.map((trade ) => parseFloat(this.numFormatterBillion(trade['trade'],0)))

                resolve(response)
              })
              .catch((error) => { reject(error) })
             })
         },
        numberConvert(costOfIt, visualOfIt) {
            var visualOfIt = costOfIt.toString();

            var visualLeng = 6;
            var maxLeng = 4;
            var letterArrayIndex = 0;
            var letterArray = [" Bin", " Milyon", " Milyar", " Trilyon", " KatTrilyon", " KentTRilyon", " Sextillion", " Septillion", " Octillion", " Nonillion", " Decillion", " Undecillion", " Duodecillion", " Tredecillion", " Quatuordecillion", " Quindecillion", " Sexdecillion", " Septendecillion", " Octodecillion", " Novemdecillion", " Vigintillion", " Unvigintillion", " Duovigintillion", " Tresvigintillion", " Quatuorvigintillion", " Quinquavigintillion", " Sesvigintillion", " Septemvigintillion", " Octovigintillion", " Novemvigintillion", " Trigintillion", " Untrigintillion", " Duotrigintillion", " Trestrigintillion", " Quatuortrigintillion", " Quinquatrigintillion", " Sestrigintillion", " Septentrigintillion", " Octotrigintillion", " Novemtrigintillion", " Quadragintillion", " Unquadragintillion", " Duoquadragintillion", " Tresquadragintillion", " Quatuorquadragintillion", " Quinquaquadragintillion", " Sesquadragintillion", " Septemquadragintillion", " Octoquadragintillion", " Novemquadragintillion", " Quinquagintillion", " Unquinquagintillion", " Duoquinquagintillion", " Tresquinquagintillion", " Quatuorquinquagintillion", " Quinquaquinquagintillion", " Sesquinquagintillion", " Septenquinquagintillion", " Octoquinquagintillion", " Novemquinquagintillion", " Sexagintillion", " Unsexagintillion", " Duosexagintillion", " Tressexagintillion", " Quatuorsexagintillion", " Quinquasexagintillion", " Sexasexagintillion", " Septemsexagintillion", " Octosexagintillion", " Novemsexagintillion", " Septuagintillion", " Unseptuagintillion", " Duoseptuagintillion", " Tresseptuagintillion", " Quatuorseptuagintillion", " Quinquaseptuagintillion", " Sexaseptuagintillion", " Septenseptuagintillion", " Octoseptuagintillion", " Novemseptuagintillion", " Octogintillion", " Unoctogintillion", " Duooctogintillion", " Tresoctogintillion", " Quatuoroctogintillion", " Quinquaoctogintillion", " Sesoctogintillion", " Septemoctogintillion", " Octooctogintillion", " Novemoctogintillion", " Nonagintillion", " Unnonagintillion", " Duononagintillion", " Tresnonagintillion", " Quatuornonagintillion", " Quinquanonagintillion", " Sesnonagintillion", " Septemnonagintillion", " Octononagintillion", " Novemnonagintillion", " Centillion", " Uncentillion"];
            var leng = 4;
            var slic = 1;

            for (var g = 0; g < visualOfIt.length; g++) {
                if (visualOfIt.length <= visualLeng) {
                    if (leng < maxLeng) {
                        leng = maxLeng;
                    }


                    if (visualOfIt.length === leng) {
                        if (slic > 2) {
                            visualOfIt = costOfIt.toString().slice(0, slic);
                             console.log(visualOfIt)
                            //visualOfIt = costOfIt.toString().slice(0, slic) + letterArray[letterArrayIndex];
                            break;
                        } else {
                            visualOfIt = costOfIt.toString().slice(0, slic) + "." + costOfIt.toString().slice(slic, 3) ;
                           // visualOfIt = costOfIt.toString().slice(0, slic) + "," + costOfIt.toString().slice(slic, 3) + letterArray[letterArrayIndex];
                            break;
                        }
                    } else {
                        leng++;
                        slic++;
                    }
                } else {
                    maxLeng += 3;
                    visualLeng += 3;
                    letterArrayIndex++;
                }
            }
            //console.log(visualOfIt)
             return visualOfIt;
         },
        countPrice(costOfIt, visualOfIt) {
            var visualOfIt = costOfIt.toString();

            var visualLeng = 6;
            var maxLeng = 4;
            var letterArrayIndex = 0;
            var letterArray = [" Bin", " Milyon", " Milyar", " Trilyon", " KatTrilyon", " KentTRilyon", " Sextillion", " Septillion", " Octillion", " Nonillion", " Decillion", " Undecillion", " Duodecillion", " Tredecillion", " Quatuordecillion", " Quindecillion", " Sexdecillion", " Septendecillion", " Octodecillion", " Novemdecillion", " Vigintillion", " Unvigintillion", " Duovigintillion", " Tresvigintillion", " Quatuorvigintillion", " Quinquavigintillion", " Sesvigintillion", " Septemvigintillion", " Octovigintillion", " Novemvigintillion", " Trigintillion", " Untrigintillion", " Duotrigintillion", " Trestrigintillion", " Quatuortrigintillion", " Quinquatrigintillion", " Sestrigintillion", " Septentrigintillion", " Octotrigintillion", " Novemtrigintillion", " Quadragintillion", " Unquadragintillion", " Duoquadragintillion", " Tresquadragintillion", " Quatuorquadragintillion", " Quinquaquadragintillion", " Sesquadragintillion", " Septemquadragintillion", " Octoquadragintillion", " Novemquadragintillion", " Quinquagintillion", " Unquinquagintillion", " Duoquinquagintillion", " Tresquinquagintillion", " Quatuorquinquagintillion", " Quinquaquinquagintillion", " Sesquinquagintillion", " Septenquinquagintillion", " Octoquinquagintillion", " Novemquinquagintillion", " Sexagintillion", " Unsexagintillion", " Duosexagintillion", " Tressexagintillion", " Quatuorsexagintillion", " Quinquasexagintillion", " Sexasexagintillion", " Septemsexagintillion", " Octosexagintillion", " Novemsexagintillion", " Septuagintillion", " Unseptuagintillion", " Duoseptuagintillion", " Tresseptuagintillion", " Quatuorseptuagintillion", " Quinquaseptuagintillion", " Sexaseptuagintillion", " Septenseptuagintillion", " Octoseptuagintillion", " Novemseptuagintillion", " Octogintillion", " Unoctogintillion", " Duooctogintillion", " Tresoctogintillion", " Quatuoroctogintillion", " Quinquaoctogintillion", " Sesoctogintillion", " Septemoctogintillion", " Octooctogintillion", " Novemoctogintillion", " Nonagintillion", " Unnonagintillion", " Duononagintillion", " Tresnonagintillion", " Quatuornonagintillion", " Quinquanonagintillion", " Sesnonagintillion", " Septemnonagintillion", " Octononagintillion", " Novemnonagintillion", " Centillion", " Uncentillion"];
            var leng = 4;
            var slic = 1;

            for (var g = 0; g < visualOfIt.length; g++) {
                if (visualOfIt.length <= visualLeng) {
                    if (leng < maxLeng) {
                        leng = maxLeng;
                    }


                    if (visualOfIt.length === leng) {
                        if (slic > 2) {
                            //visualOfIt = costOfIt.toString().slice(0, slic);
                            visualOfIt = costOfIt.toString().slice(0, slic) + letterArray[letterArrayIndex];
                            break;
                        } else {
                            //visualOfIt = costOfIt.toString().slice(0, slic) + "." + costOfIt.toString().slice(slic, 3) ;
                           visualOfIt = costOfIt.toString().slice(0, slic) + "," + costOfIt.toString().slice(slic, 3) + letterArray[letterArrayIndex];
                            break;
                        }
                    } else {
                        leng++;
                        slic++;
                    }
                } else {
                    maxLeng += 3;
                    visualLeng += 3;
                    letterArrayIndex++;
                }
            }
            //console.log(visualOfIt)
             return visualOfIt;
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
        },
        numFormatterBillion(num) {
            // Alter numbers larger than 1k
            if (num >= 1e3) {
                let unit = Math.floor(((num).toFixed(0).length - 1) / 3) * 3
                var num = (num / ('1000000000')).toFixed(2)
                return num
            }
        },



       },
        created() {
            this.getImportDetails()
            this.getData0()
            this.getData1()
            this.getTopImporters()

        },

    }
</script>

<style>
#myCountry {
    width: 60%;
}


</style>
