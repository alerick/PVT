<template>
  <v-container fluid>
    <v-card>
      <v-data-iterator :items="docsRequired" hide-default-footer>
        <template v-slot:header>
          <v-toolbar class="mb-0" color="ternary" dark flat>
            <v-toolbar-title>DOCUMENTOS PRESENTADOS</v-toolbar-title>
          </v-toolbar>
          <v-toolbar-title class="align-end font-weight-black text-center ma-0 pa-0 pt-5">
            <h3>Documentos Requeridos</h3>
          </v-toolbar-title>
          <v-row>
            <v-col v-for="(req,i) in docsRequired" :key="i" cols="12" class="py-1">
              <v-card dense>
                <v-col cols="12" class="py-0">
                  <v-list dense class="py-0">
                    <v-list-item class="py-0">
                      <v-col cols="1" class="py-0">
                        <v-list-item-content class="align-end font-weight-light">
                          <div>
                            <h3>{{i+1}}</h3>
                          </div>
                        </v-list-item-content>
                      </v-col>
                      <v-col cols="10" class="py-0 ml-n8">
                        <v-list-item-content
                          class="align-end font-weight-light py-0"
                        >{{ req.name }}</v-list-item-content>
                      </v-col>
                    </v-list-item>
                  </v-list>
                </v-col>
              </v-card>
            </v-col>
          </v-row>
        </template>
      </v-data-iterator>

      <v-data-iterator :items="docsOptional" hide-default-footer>
        <template v-slot:header>
          <v-toolbar-title class="align-end font-weight-black text-center ma-0 pa-0 pt-5">
            <h3>Documentos Adicionales</h3>
          </v-toolbar-title>
          <v-row>
            <v-col v-for="(opt,i) in docsOptional" :key="i" cols="12" class="py-1">
              <v-card dense>
                <v-col cols="12" class="py-0">
                  <v-list dense class="py-0">
                    <v-list-item class="py-0">
                      <v-col cols="1" class="py-0">
                        <v-list-item-content class="align-end font-weight-light">
                          <div>
                            <h3>{{i+1}}</h3>
                          </div>
                        </v-list-item-content>
                      </v-col>
                      <v-col cols="10" class="py-0 ml-n8">
                        <v-list-item-content
                          class="align-end font-weight-light py-0"
                        >{{ opt.name }}</v-list-item-content>
                      </v-col>
                    </v-list-item>
                  </v-list>
                </v-col>
              </v-card>
            </v-col>
          </v-row>
        </template>
        <template>
          <v-toolbar-title class="align-end font-weight-black text-left ma-0 pl-8 pt-5">
            <h5>Otros Documentos</h5>
          </v-toolbar-title>
          <v-row>
            <v-col cols="12" class="ma-0 px-10">
              <div
                class="align-end font-weight-light ma-0 pa-0"
                v-for="(note, index) of notes"
                :key="index"
              >
                {{index+1 +". "}} {{note.message}}
                <v-divider></v-divider>
              </div>
            </v-col>
          </v-row>
        </template>
      </v-data-iterator>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "DocumentsQualification",
  data: () => ({
    docsRequired: [],
    docsOptional: [],
    notes: []
  }),

  beforeMount() {
    this.getDocumentsSubmitted(this.$route.params.id);
    this.getNotes(this.$route.params.id);
  },

  methods: {
    async getDocumentsSubmitted(id) {
      try {
        this.loading = true;
        let res = await axios.get(`loan/${id}/document`);
        this.docsRequired = res.data.required
        this.docsOptional = res.data.optional
        console.log(this.docsRequired +" " +this.docsOptional);
      } catch (e) {
        console.log(e);
      } finally {
        this.loading = false;
      }
    },
    async getNotes(id) {
      try {
        this.loading = true;
        let res = await axios.get(`loan/${id}/note`);
        this.notes = res.data;
        console.log("NOTES  " + this.notes);
      } catch (e) {
        console.log(e);
      } finally {
        this.loading = false;
      }
    },
  }
};
</script>