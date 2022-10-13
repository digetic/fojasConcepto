<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              Designacion de Evaluadores
            </h1>
          </div>
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Modals & Alerts</li>
            </ol>
          </div> -->
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-shield-alt"></i> &nbsp;
                  {{ nomUnidad }}
                </h3>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <div class="col-md">
                    <div class="row">
                      <div class="col-6">
                        <br>
                        <div class="row">
                          <div class="col-12">
                            <label class="stlabel" for="pregunta"><b>PERSONAL</b></label>
                            <v-select
                              label="text"
                              
                              :options="personal"
                              v-model="nuevoEncargado"
                            >
                              <template v-slot:no-options="{ search, searching }">
                                <template v-if="searching">
                                  Lo sentimos, no hay opciones de coincidencia.<em>{{
                                    search
                                  }}</em
                                  >.
                                </template>
                                <em v-else
                                  >Lo sentimos, no hay opciones de coincidencia.</em
                                >
                              </template>
                            </v-select>
                            <br />
                           
                          </div>
                           
                        </div>
                        <div class="row">
                          <div class="col-6">
                               <button
                                type="button"
                                class="btn btn-primary btn-sm btn-block"
                                v-on:click="obtenerEncargado"
                                :disabled="valAsigExt"
                              >
                                AGREGAR EVALUADOR
                              </button>   
                          </div>
                          <div class="col-6">
                            <button
                                type="button"
                                class="btn btn-primary btn-sm btn-block"
                                v-on:click="ModalExterno"
                                :disabled="valAsigExt"
                              >
                                EVALUADOR EXTERNO
                              </button>  
                          </div>
                        </div>
                        
                      </div>
                      <div class="col-6">
                        <br>
                        <label class="stlabel" for="pregunta"><b>SECCIÓN</b></label>
                        <select
                          class="form-control"
                          id="menuPreguntas"
                          v-model="dest4"
                          :disabled="valD4"
                        >
                          <option v-for="d4 of destinos4" :value="d4">
                            {{ d4.descripcion }}
                          </option></select
                        ><br />
                        <button
                          type="button"
                          class="btn btn-primary btn-sm btn-block"
                          v-on:click="obtenerSeccion"
                        >
                          AGREGAR SECCIÓN
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <table class="table table-bordered table-striped table-sm">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 100px">OPCIONES</th>
                          <th class="text-center">CALIFICADOR</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(cali, index) of calificadores">
                          <td class="text-center">
                            <button
                              type="button"
                              class="btn btn-danger btn-sm"
                              @click="eliminarCalificador(index)"
                            >
                              <i class="far fa-trash-alt"></i>
                            </button>
                          </td>
                          <td class="text-center">{{ cali.nombre }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-sm-6">
                    <table class="table table-bordered table-striped table-sm">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 100px">OPCIONES</th>
                          <th class="text-center">SECCIONES</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(cali, index) of seccion">
                          <td class="text-center">
                            <button
                              type="button"
                              class="btn btn-danger btn-sm"
                              @click="eliminarSeccion(index)"
                            >
                              <i class="far fa-trash-alt"></i>
                            </button>
                          </td>
                          <td class="text-center">{{ cali.nombre }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="d-flex flex-row-reverse bd-highlight">
                  <button type="button" class="btn btn-success btn-sm p-2 bd-highlight" :disabled="valAsig" @click="guardarJurados">Asignar</button> &nbsp;
                  <button type="button" class="btn btn-danger btn-sm p-2 bd-highlight" @click="cancelar">Cancelar</button>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->


    <div class="modal fade"  data-backdrop="static" id="EvaluadorExterno">
        <div class="modal-dialog modal-lg ">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">EVALUADOR EXTERNO</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">                    
                    <div class="col-sm-12">
                        <label for="">PERSONAL:</label>
                        <v-select
                            label="text"
                            :options="ApersoExt"
                            v-model="perExt"
                        >
                            //EN CASO QUE NO SE ENCENTRE EL VALOR EN LA LISTA
                            <template v-slot:no-options="{ search, searching }">
                            <template v-if="searching">
                                Lo sentimos, no hay opciones de coincidencia.<em>{{
                                search
                                }}</em
                                >.
                            </template>
                            <em v-else
                                >Lo sentimos, no hay opciones de coincidencia.</em
                            >
                            </template>
                        </v-select>

                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
              <button type="button" class="btn btn-primary" @click="obtenerEncargadoExterno()">ASIGNAR</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>







  </div>
</template>

<script>
export default {
  mounted() {
    
    this.NomUnidad();
    this.ListarPersonal();
    this.Destino4();
  },

  data() {
    return {
        destinos1: [],
        destinos2: [],
        destinos3: [],
        destinos4: [],
        dest1: [],
        dest2: 0,
        dest3: 0,
        dest4: [],
        per: [],
        nomUnidad: "",
        //VALORES QUE LLEGAN DESDE LA RUTA
        de1: this.$route.params.des1,
        de2: this.$route.params.des2,
        de3: this.$route.params.des3,
        evaluacion: this.$route.params.e,
        //VALORES PARA LA DESIGNACION
        calificadores: [],
        idCalificadores: [],
        seccion: [],
        idseccion: [],
        nuevoEncargado: [],
        personal: [],
        designado: [],
        //VALORES PARA ESTADO DE DESIGNACION
        estdesgi: null,
        ApersoExt: [],
        perExt: []
    };
  },
  computed: {
    valD4(){
        if (this.destinos4.length > 0 ) {
            return false;
        } else {
            return true;
        }
    },
    valAsig() {
        var c = this.idCalificadores.length;
        var s = this.idseccion.length;
        if (c > 0 && s > 0) {
            return false;
        } else {
            return true;
        }
    },
    valAsigExt() {
         var tam = this.calificadores.length;
        if (tam < 3) {
            return false;
        } else {
            return true;
        }
    }
  },
  methods: {
    NomUnidad(){

        let me = this;
            axios
          .post("/nomUni", {
              id: me.de3
          })
          .then(function (response) {
               me.nomUnidad = response.data.descripcion
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          }) 

    },    
    Destino4(){
          
          let me = this;
          axios
            .post("/noDesgUni", {
              eva: me.evaluacion,
              dest3: me.de3
            })
            .then(function (response) {
              me.destinos4 = response.data;
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
    },
    ListarPersonal(){
      let me = this;
            axios
          .post("/listaPersonalDesignacion", {
              destino1: me.de1,
                destino2: me.de2,
                destino3: me.de3
          })
          .then(function (response) {
               me.personal = response.data;
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
    },
    obtenerEncargado() {
      try {
        var tam = this.calificadores.length;
        if (tam < 3) {
          if (!this.idCalificadores.includes(this.nuevoEncargado.id)) {
            if (this.nuevoEncargado.id != undefined) {
              this.calificadores.push({
                id: this.nuevoEncargado.id,
                orden: this.nuevoEncargado.orden,
                gradCom: this.nuevoEncargado.gradCom,
                cargo: this.nuevoEncargado.cargo,
                nombre: this.nuevoEncargado.text,
                promo: this.nuevoEncargado.promo,
                d3: this.nuevoEncargado.d3
              });
              this.idCalificadores.push(this.nuevoEncargado.id);
              this.nuevoEncargado = [];
            } else {
              swal.fire("Error", "Seleccione un Evaluador.", "error");
            }
          } else {
            swal.fire(
              "Duplicidad de Evaluador",
              "Ya selecciono a esta persona para ser evaluador.",
              "error"
            );
          }
        } else {
          swal.fire(
            "Maximo de Evaluadores",
            "Ya alcanzo al máximo de asignacion de evaluadores.",
            "error"
          );
        }
      } catch (error) {
        swal.fire("Error", "Seleccione un Evaluador.", "error");
      }
    },

    obtenerEncargadoExterno() {
      try {
        var tam = this.calificadores.length;
        if (tam < 3) {
          if (!this.idCalificadores.includes(this.perExt.id)) {
            if (this.perExt.id != undefined) {
              this.calificadores.push({
                id: this.perExt.id,
                orden: this.perExt.orden,
                gradCom: this.perExt.gradCom,
                cargo: this.perExt.cargo,
                nombre: this.perExt.text,
                promo: this.perExt.promo,
                d3: this.perExt.d3
              });
              this.idCalificadores.push(this.perExt.id);
              this.perExt = []; 
            $('#EvaluadorExterno').modal('hide');  
            } else {
              swal.fire("Error", "Seleccione un Evaluador.", "error");
            }
          } else {
            swal.fire(
              "Duplicidad de Evaluador",
              "Ya selecciono a esta persona para ser evaluador.",
              "error"
            );
          }
        } else {
          swal.fire(
            "Maximo de Evaluadores",
            "Ya alcanzo al máximo de asignacion de evaluadores.",
            "error"
          );
        }
      } catch (error) {
        swal.fire("Error", "Seleccione un Evaluador.", "error");
      }
    },
    eliminarCalificador(index) {
      this.calificadores.splice(index, 1);
      this.idCalificadores.splice(index, 1);
    },
    
    obtenerSeccion() {
      try {
        var ind = this.destinos4.indexOf(this.dest4);
        if (ind >= 0) {
          if (!this.idseccion.includes(this.dest4.id)) {
            this.seccion.push({
              nombre: this.dest4.descripcion,
              id: this.dest4.id
            });
            this.idseccion.push(this.dest4.id)
            this.dest4 = [];
          } else {
            swal.fire(
              "Duplicidad de Sección",
              "Ya selecciono a esta sección.",
              "error"
            );
          }
          this.destinos4.splice(ind,1);
        } else {
          swal.fire("Error", "Seleccione una Sección.", "error");
        }
      } catch (error) {
        swal.fire("Error", "Seleccione un Sección.", "error");
      }
    },
    eliminarSeccion(index) {
      this.destinos4.push({
          descripcion: this.seccion[index].nombre,
          id: this.seccion[index].id
      });
      this.seccion.splice(index, 1);
      this.idseccion.splice(index, 1);
    },
    /**
     * Guardado de jurados
     */
    guardarJurados(){
      swal.fire({
          title: '¿DESEA ASIGNAR ESTOS EVALUADORES?', // TITULO 
          icon: 'question', //ICONO (success, warnning, error, info, question)
          showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
          confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
          cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
          confirmButtonText: 'CONFIRMAR', //TITULO DEL BOTON CONFIRMAR
          cancelButtonText: 'CANCELAR', //TIUTLO DEL BOTON CANCELAR
          buttonsStyling: true,
          reverseButtons: true
          }).then((result) => {
          if (result.value) {
            let me = this;
            axios
              .post("/guardarJurados", {
                eva: me.evaluacion,
                dest1: this.de1,
                dest2: this.de2,
                dest3: this.de3,
                seccion: this.idseccion,
                calificadores: this.calificadores
              })
              .then(function (response) {
                console.log(response);
                Swal.fire(
                    response.data.titulo,
                    response.data.mensaje,
                    response.data.tipo
                    
                )
                me.$router.push({
                  name: "ListaUnidadesDesignaciones",
                  params:{
                      e: me.evaluacion
                  }
                });
              })
              .catch(function (error) {
                // handle error
                console.log(error);
              })

          }
      })
      
    },
    // /**
    //  * Boton cancelar
    //  */
    cancelar(){
      this.$router.push({
            name: "ListaUnidadesDesignaciones",
            params:{
                e: this.evaluacion
            }
          });
    },
    /**
     * evaluador externo
     */
    ModalExterno(){
      let me = this;
            axios
          .post("/listperext", {
                dest2: me.de2,
                dest3: me.de3
          })
          .then(function (response) {
            console.log(response);
              me.ApersoExt = response.data;            
              $('#EvaluadorExterno').modal('show'); 
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
      
    }
  },
};
</script>

<style>
.stlabel {
  font-size: 20px;
}

@media (min-width: 992px) {
  .modal-lg {
    max-width: 70%;
  }
  .modal-lg2 {
    max-width: 50%;
  }
}
</style>