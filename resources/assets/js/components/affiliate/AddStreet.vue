<template>
  <v-dialog
    v-model="dialog"
    width="900"
  >
    <v-card>
      <v-toolbar dense flat color="tertiary">
        <v-toolbar-title v-show="address.edit">Añadir Dirección</v-toolbar-title>
        <v-toolbar-title v-show="!address.edit">Dirección</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon @click.stop="close()">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
  <v-container fluid >
      <v-row justify="center">
        <v-col cols="12" >
              <v-container class="py-0">
                <ValidationObserver ref="observer">
                  <v-form>
                    <v-row>
                      <v-col cols="12" md="3" v-show="address.edit">
                        <v-select
                          dense
                          :items="countryCities"
                          item-text="name"
                          item-value="id"
                          label="Ciudad"
                          v-model="address.city_address_id"
                        ></v-select>
                      </v-col>
                      <v-col cols="12" md="3" v-show="address.edit">
                        <ValidationProvider v-slot="{ errors }" vid="zone" name="zona" rules="min:3|max:20">
                          <v-text-field
                          :error-messages="errors"
                          dense
                          v-model="address.zone"
                          label="Zona"
                          class="purple-input"
                          ></v-text-field>
                        </ValidationProvider>
                      </v-col>
                      <v-col cols="12" md="4" v-show="address.edit">
                        <ValidationProvider v-slot="{ errors }" vid="street" name="calle" rules="min:3|max:20">
                          <v-text-field
                          :error-messages="errors"
                          dense
                          v-model="address.street"
                          label="Calle/Avenida"
                          class="purple-input"
                          ></v-text-field>
                        </ValidationProvider>
                      </v-col>
                      <v-col cols="12" md="2" v-show="address.edit">
                        <ValidationProvider v-slot="{ errors }" vid="number_address" name="nro" rules="min:1|max:10">
                          <v-text-field
                          :error-messages="errors"
                          dense
                          v-model="address.number_address"
                          label="Nro"
                          class="purple-input"
                          ></v-text-field>
                        </ValidationProvider>
                      </v-col>
                      <v-col cols="12" md="12">
                        <LMap :address.sync="address" :cities.sync="countryCities" :edit.sync="address.edit"/>
                      </v-col>
                    </v-row>
                  </v-form>
                </ValidationObserver>
            </v-container>
        </v-col>
      </v-row>
  </v-container>
  </v-card-text>
      <v-card-actions v-show="address.edit">
        <v-spacer></v-spacer>
        <v-btn @click.stop="adicionar()"
          color="error"
        >Guardar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import LMap from '@/components/affiliate/LMap'

export default {
  name: "affiliate-addresses",
  props: {
    bus: {
      type: Object,
      required: true
    },
    cities: {
      type: Array,
      required: true
    }
  },
  components: {
    LMap
  },
  data: () => ({
    dialog: false,
    address: {}
  }),
  mounted() {
    this.bus.$on('openDialog', (address) => {
      this.address = address
      this.dialog = true
    })
  },
  computed: {
    countryCities() {
      return this.cities.filter(o => o.name.toUpperCase() != 'NATURALIZADO')
    }
  },
  methods: {
    async adicionar() {
      if (await this.$refs.observer.validate()) {
        this.saveAddress()
        this.bus.$emit('saveAddress', this.address)
        this.close()
      }
  },
    close() {
      this.dialog = false
      this.address = {}
  },
    async saveAddress() {
      try{
          if (this.address.id) {
          let res = await axios.patch(`address/${this.address.id}`, this.address)
          this.toastr.success('Domicilio Modificado')
          this.bus.$emit('saveAddress', res.data)
          }
          else{
          let res = await axios.post(`address`, this.address)
          this.toastr.success('Domicilio Adicionado')
          this.bus.$emit('saveAddress', res.data)
          }
      } catch (e) {
        this.$refs.observer.setErrors(e)
      } finally {
        this.loading = false
      }
    }
  }
  }
</script>