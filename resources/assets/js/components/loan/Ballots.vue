<template>
  <v-flex xs12 class="px-3">
    <ValidationObserver ref="observer">
    <v-form>
    <v-row justify="center">
      <v-col cols="12"  >
        <v-card>
          <v-container fluid >
            <v-row justify="center" class="py-0">
              <v-col cols="12" class="py-0" >
                <v-container class="py-0">
                  <v-row>
                    <v-col cols="12" md="4" class="py-0 text-center">
                      MODALIDAD DEL PRESTAMO
                    </v-col>
                    <v-col cols="12" md="4" class="py-0 text-center">
                      INTERVALO DE LOS MONTOS
                    </v-col>
                    <v-col cols="12" md="4" class="py-0 text-center">
                      INTERVALO DEL PLAZO EN MESES
                    </v-col>
                    <v-col cols="12" md="4" class="py-0">
                      <ValidationProvider v-slot="{ errors }" vid="modalities" name="Modalidad" rules="required">
                      <v-select
                        :error-messages="errors"
                        dense
                        v-model="loanTypeSelected"
                        :onchange="Onchange()"
                        :items="modalities"
                        item-text="name"
                        item-value="id"
                        :rules="[(v) => !!v || 'El campo de Modalidad de préstamo es requerido']"
                        required
                      ></v-select>
                      </ValidationProvider>
                    </v-col>
                    <v-col cols="12" md="4" class="py-0 text-center">
                      {{monto}}
                    </v-col>
                    <v-col cols="12" md="4" class="py-0 text-center" >
                      {{plazo}}
                    </v-col>
                  </v-row>
                </v-container>
              </v-col>
            </v-row>
          </v-container>
          <v-container class="py-0">
            <v-row>
              <v-col cols="12" md="12" class="text-center" >
                BOLETAS DE PAGO
              </v-col>
              <v-col cols="12" md="4" class="py-0"  >
                <ValidationProvider v-slot="{ errors }" name="1ra Boleta" rules="min:1|max:20" mode="aggressive">
                <v-text-field
                  :error-messages="errors"
                  dense
                  v-model="payable_liquid[0]"
                  label="1ra Boleta"
                  :readonly="!editar"
                  :outlined="editar"
                  :rules="[rules.required, rules.max]"
                ></v-text-field>
                </ValidationProvider>
              </v-col>
              <v-col cols="12" md="4" class="py-0" v-if="visible">
                <ValidationProvider v-slot="{ errors }" name="2ra Boleta" rules="min:1|max:20" mode="aggressive">
                <v-text-field
                  :error-messages="errors"
                  dense
                  v-model="payable_liquid[1]"
                  label="2ra Boleta"
                  :readonly="!editar"
                  :outlined="editar"
                   :rules="[rules.required, rules.max]"
                ></v-text-field>
                </ValidationProvider>
              </v-col>
              <v-col cols="12" md="4" class="py-0" v-if="visible" >
                <ValidationProvider v-slot="{ errors }" name="3ra Boleta" rules="min:1|max:20" mode="aggressive">
                <v-text-field
                  :error-messages="errors"
                  dense
                  v-model="payable_liquid[2]"
                  label="3ra Boleta"
                  :readonly="!editar"
                  :outlined="editar"
                   :rules="[rules.required, rules.max]"
                ></v-text-field>
                </ValidationProvider>
              </v-col>
              <v-col cols="12" class="py-0" >
                BONOS
              </v-col>
              <v-col cols="12" md="3" >
                <ValidationProvider v-slot="{ errors }" name="1er Bono" rules="min:1|max:20" mode="aggressive">
                <v-text-field
                  :error-messages="errors"
                  dense
                  v-model="bonos[0]"
                  label="Bono Frontera"
                  :readonly="!editar"
                  :outlined="editar"
                  :rules="[rules.max]"
                ></v-text-field>
                </ValidationProvider>
              </v-col>
              <v-col cols="12" md="3">
                <ValidationProvider v-slot="{ errors }" name="2do Bono" rules="min:1|max:20" mode="aggressive">
                <v-text-field
                  :error-messages="errors"
                  dense
                  v-model="bonos[1]"
                  label="Bono Oriente"
                  :readonly="!editar"
                  :outlined="editar"
                  :rules="[rules.max]"
                ></v-text-field>
                </ValidationProvider>
              </v-col>
              <v-col cols="12" md="3" >
                <ValidationProvider v-slot="{ errors }" name="3er Bono" rules="min:1|max:20" mode="aggressive">
                <v-text-field
                  :error-messages="errors"
                  dense
                  v-model="bonos[2]"
                  label="Bono Cargo"
                  :readonly="!editar"
                  :outlined="editar"
                   :rules="[rules.max]"
                ></v-text-field>
                </ValidationProvider>
              </v-col>
              <v-col cols="12" md="3">
                <ValidationProvider v-slot="{ errors }" name="4to Bono" rules="min:1|max:20" mode="aggressive">
                <v-text-field
                  :error-messages="errors"
                  dense
                  v-model="bonos[3]"
                  label="Bono Seguridad Ciudadana"
                  :readonly="!editar"
                  :outlined="editar"
                  :rules="[rules.max]"
                ></v-text-field>
                </ValidationProvider>
              </v-col>
            </v-row>
          </v-container>
        </v-card>
      </v-col>
    </v-row>
    </v-form>
    </ValidationObserver>
  </v-flex>
</template>
<script>

export default { 
  name: "dashboard-index",
  data: () => ({
    editar:true,
    monto:null,
    plazo:null,
    interval:[],
    loanTypeSelected:null,
    visible:false,
    num_type:9,
    rules: {
          required: value => !!value || 'El campos es requerido.',
          max: v => v.length <= 5 || 'El monto máximo es de 5 dígitos',
    
    }
  }),
   props: {
    contributions1: {
      type: Array,
      required: true
    },
    modalidad: {
      type: Object,
      required: true
    },
    bonos: {
      type: Array,
      required: true
    },
    payable_liquid: {
      type: Array,
      required: true
    },
    modalities: {
      type: Array,
      required: true
    },
    intervalos: {
      type: Object,
      required: true
    },
  },
   beforeMount() {
    this.getLoanIntervals()
  },
    mounted(){
    this.getLoanModality(this.$route.query.affiliate_id)
  },
  methods:
 {//caldula los intervalos deacuerdo a una modalidad
    Onchange(){
      for (this.i = 0; this.i< this.interval.length; this.i++) {
        if(this.loanTypeSelected==this.interval[this.i].procedure_type_id)
        {
          this.monto= this.interval[this.i].minimum_amount+' - '+this.interval[this.i].maximum_amount,
          this.plazo= this.interval[this.i].minimum_term+' - '+this.interval[this.i].maximum_term
          //intervalos es el monto, plazo y modalidad y id de una modalidad
          this.intervalos.maximun_amoun=this.interval[this.i].maximum_amount
          this.intervalos.maximum_term= this.interval[this.i].maximum_term
          this.intervalos.minimun_amoun=this.interval[this.i].minimum_amount
          this.intervalos.minimum_term= this.interval[this.i].minimum_term
          this.intervalos.procedure_type_id= this.loanTypeSelected
          this.num_type=this.loanTypeSelected
        }
      }
      this.getLoanModality(this.$route.query.affiliate_id)
      this.getBallots(this.$route.query.affiliate_id)
    },
    //Medodo donde identifica la modalidad de acuerdo a las caracteristicas de un affiliado
    async getLoanModality(id) {
      try {
        let resp = await axios.get(`affiliate/${id}/loan_modality`,{
          params: {
            procedure_type_id:this.num_type,
            external_discount:0,
          }
        })
          this.loan_modality= resp.data
          this.modalidad.id=this.loan_modality.id
          this.modalidad.name=this.loan_modality.name
          this.modalidad.quantity_ballots=this.loan_modality.loan_modality_parameter.quantity_ballots
          if(this.loan_modality.loan_modality_parameter.quantity_ballots>1)
          {
          this.visible=true
          }
          else{
          this.visible=false
        }
      }catch (e) {
        console.log(e)
      }finally {
        this.loading = false
      }
    },
    //Intervalos de Plazo y Meses de una modalidad
    async getLoanIntervals() {
      try {
        let res = await axios.get(`loan_interval`)
        this.interval = res.data
       }catch (e) {
        console.log(e)
      }finally {
        this.loading = false
      }
    },
    //Metodo para sacar boleta de un afiliado
    async getBallots(id) {
    try {
      let res = await axios.get(`affiliate/${id}/contribution`, {
        params:{
          city_id: this.$store.getters.cityId,
          sortBy: ['month_year'],
          sortDesc: [1],
          per_page: this.modalidad.quantity_ballots,
          page: 1,
        }
      })
      if(res.data.valid)
      {
        this.editar=false
        this.datos=res.data.data
        for (this.i = 0; this.i< this.datos.length; this.i++) {
          this.payable_liquid[this.i]= this.datos[this.i].payable_liquid,
          this.bonos[0]= this.datos[0].border_bonus,
          this.bonos[1]= this.datos[0].east_bonus,
          this.bonos[2]= this.datos[0].seniority_bonus,
          this.bonos[3]= this.datos[0].public_security_bonus
        }
          for(this.j = 0; this.j< this.datos.length; this.j++)
        {
          this.contributions1[this.j].payable_liquid=this.datos[this.j].payable_liquid
          if(this.j==0){
            this.contributions1[this.j].border_bonus= this.datos[this.j].border_bonus,
            this.contributions1[this.j].east_bonus= this.datos[this.j].east_bonus,
            this.contributions1[this.j].seniority_bonus= this.datos[this.j].seniority_bonus,
            this.contributions1[this.j].public_security_bonus= this.datos[this.j].public_security_bonus
          }
          else{
            this.contributions1[this.j].border_bonus=0,
            this.contributions1[this.j].east_bonus= 0,
            this.contributions1[this.j].seniority_bonus=0,
            this.contributions1[this.j].public_security_bonus=0
          }
        }
      }
    } catch (e) {
      console.log(e)
    } finally {
      this.loading = false
    }
  }
 }
};
</script>