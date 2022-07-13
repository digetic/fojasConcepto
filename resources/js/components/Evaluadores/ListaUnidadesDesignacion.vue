<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="far fa-bookmark"></i>
              DESIGNACION DE EVALUADORES
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/"><p>Home</p></router-link>
              </li>
              <li class="breadcrumb-item active"></li>Designación de Evaluadores
            </ol>
          </div>
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
                <div class="d-flex bd-highlight">
                        <div class="p-2 bd-highlight">
                        <i class="fa fa-align-justify"></i> &nbsp; Lista de Unidades &nbsp;
                        <button type="button"  class="btn btn-secondary" @click="nuevaEvaluacion()">
                            <i class="far fa-plus-square" aria-hidden="true"></i>&nbsp;&nbsp;Nuevo
                        </button>
                        </div>
                        <div class="ml-auto p-2 bd-highlight">
                        <button type="button" class="btn btn-danger" @click="atras()">
                            <i class="fas fa-undo-alt"></i> &nbsp;&nbsp;Atras
                        </button>
                        </div>
                    </div>  
              </div>
              <div class="card-body">
                  <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-4" v-model="criterio">
                                <option value="n1.descripcion">Entidad</option>
                                <option value="n2.descripcion">Gran Unidad</option>
                                <option value="n3.descripcion">Unidad</option>
                                <option value="n4.descripcion">Sección</option>
                            </select><!-- el arroba @ es el simplificado del v-on -->
                            <input type="text" v-model="buscar" @keyup="BuscarEvaluacion()" class="form-control" placeholder="Texto a buscar"  style="text-transform:uppercase">
                            <!-- <button type="submit" @click="listarPersonal(1,buscar,criterio)" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Buscar</button> -->
                        </div>
                    </div>
                  </div>
                  <div class="table-wrapper-scroll-y my-custom-scrollbar" id="myTable" >

                    
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>   
                                    <th class="text-center" style="width: 10%">Opciones</th>                                 
                                    <th class="text-center" style="width: 20%">Entidad</th>
                                    <th class="text-center" style="width: 25%">Gran Unidad</th>
                                    <th class="text-center" style="width: 25%">Unidad</th>
                                    <th class="text-center" style="width: 20%">Sección</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="aeu in asigEvaUni">
                                  <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm" @click="verJurados(aeu.id4)">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button> &nbsp;
                                    <!-- <button type="button" class="btn btn-warning btn-sm " @click="editarEvaluadores(ds.destino1,ds.destino2,ds.destino3,ds.destino4)">
                                    <i class="fas fa-edit"></i>
                                    </button> -->
                                  </td>
                                  <td class="text-center">{{aeu.d1}}</td>
                                  <td class="text-center">{{aeu.d2}}</td>
                                  <td class="text-center">{{aeu.d3}}</td>
                                  <td class="text-center">{{aeu.d4}}</td>
                                </tr>
                            </tbody>
                      </table>
                    <br>
                  </div>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div>
      <!-- /.container-fluid -->



        <!-- Modal Nueva Designacion -->
        <div class="modal fade" id="designarDestino">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Nueva Desiganación</h4>
                        <button type="button" class="close"  @click="cancelarElecion()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <label class="stlabel" for="pregunta"
                            ><b>GRAN UNIDAD</b></label
                            >
                            <select
                            class="form-control"
                            id="menuPreguntas"
                            v-model="dest2"
                            :disabled="valEntidad"
                            @change="Destino3"
                            >
                            <option v-for="d2 of Adestinos2" :value="d2.id">
                                {{ d2.descripcion }}
                            </option>
                            </select>
                        </div>
                        <div class="">
                            <label class="stlabel" for="pregunta"
                            ><b>UNIDAD</b></label
                            >
                            <select
                            class="form-control"
                            id="menuPreguntas"
                            v-model="dest3"
                            :disabled="valEntidad2"
                            >
                            <option v-for="d3 of Adestinos3" :value="d3.id">
                                {{ d3.descripcion }}
                            </option>
                            </select>
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2">
                                <button type="button" class="btn btn-danger btn-sm" @click="cancelarElecion()">CANCELAR</button>
                            </div>
                            <div class="p-2">
                                <button type="button" class="btn btn-success btn-sm" @click="seleccionarJurados()">ACEPTAR</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->



        <!-- Modal Ver Jurados -->
        <div class="modal fade" id="verJurados">
            <div class="modal-dialog modal-lg" style="width:40%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Evaluadores Designados</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-for="le in listaEvaluadores">
                        <li>{{le.nombre}}</li>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->













    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
    data() {
        return {
          asigEvaUni: [],
            listaDesignacion: [],
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            criterio : 'n1.descripcion',
            buscar : '',
            /**
            * Variables para destinos
            */
            Adestinos1: [],
            Adestinos2: [],
            Adestinos3: [],
            dest1: '',
            dest2: '',
            dest3: '',
            evaluacion: this.$route.params.e,
            /**
            * Lista de evaluadores por destino
            */
            listaEvaluadores: []
        }
    },
    mounted() {
      this.ListarEvaluUnidades(1);
    },
    computed:{
      isActived: function(){
          return this.pagination.current_page;
      },

      //Calcuar los elementos de la paginacion
      pagesNumber: function() {
        if(!this.pagination.to){
            return [];
        }

        var from = this.pagination.current_page - this.offset;
        if(from < 1){
            from = 1;
        }

        var to = from + (this.offset *2);
        if( to >= this.pagination.last_page){
            to = this.pagination.last_page;
        }

        var pagesArray = [];
        while( from <= to){
            pagesArray.push(from);
            from ++;
        }
        return pagesArray;
      },
      valEntidad(){
        var c = this.Adestinos2.length 
        if (c > 0) {
          return false;
        } else {
          return true;
        }
      },
      valEntidad2(){
        var c = this.Adestinos3.length 
        if (c > 0) {
          return false;
        } else {
          return true;
        }
      }
    },
    methods: {
        /**
         * FUNCIONES LISTADOR UNIDADES CON EVALUADORES DESIGNADOS
         */
        cambiarPagina(page,buscar,criterio){
          let me = this;
          //actualizando la pagina actual
          me.pagination.current_page = page;
          me.ListarEvaluUnidades(page,buscar,criterio);
        },
        ListarEvaluUnidades(page){
          let me = this;
          axios
          .post("http://sipefabapi2.test/api/uniAsig", {
              page: page,
              buscar: me.buscar.toUpperCase(),
              criterio: me.criterio,
              eva: me.evaluacion
          },{
                  headers: {'token': me.$tokenfoja}
              })
          .then(function (response) {
              console.log(response);
              me.asigEvaUni = response.data.destinos.data;
              me.pagination =response.data.pagination
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
        


        },
        BuscarEvaluacion(){
            clearTimeout(this.setTiemoutBuscador);
            this.setTiemoutBuscador = setTimeout(() => {
                this.ListarEvaluUnidades(1)
            }, 360)
        },


        /**
         * COMBOS MODAL SELECCIONAR UNIDAD
         */
        Destino2(){
            try {
                let me = this;
                 axios
                .post("http://sipefabapi2.test/api/destino2Combo", {
                    dest1: 5
                },{
                    headers: {'token': me.$tokensipefab}
                })
                .then(function (response) {
                    console.log(response);
                    me.Adestinos2 = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.Adestinos2 = [];
            } 
        },
        Destino3(){
            let me = this;
              axios
            .post("http://sipefabapi2.test/api/destino3Combo", {
                dest2: me.dest2
            },{
                headers: {'token': me.$tokensipefab}
            })
            .then(function (response) {
                console.log(response);
                me.Adestinos3 = response.data;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        },
        /**
         * MODAL PARA SELECCIONAR UNIDAD
         */
        nuevaEvaluacion(){
            this.Destino2();
            $('#designarDestino').modal('show');
        },
        seleccionarJurados(){
          if (this.dest2 != '' && this.dest3 != '') {
            $('#designarDestino').modal('hide');
            this.$router.push({
              name: "DesignacionJurado",
              params:{
                  des1: 5,
                  des2: this.dest2,
                  des3: this.dest3,
                  e: this.evaluacion
              }
            });
          } else {
            swal.fire(
              'Error',
              'Seleccione una Entidad',
              'error'
            )
          }
          
        },
        /**
        * Modal para ver los jurados seleccionados en cada Destino
        */
        verJurados(d4){
          let me = this;
          axios
            .post("/jurados/seccion", {
              d4: d4,
              eva: me.evaluacion
            })
            .then(function (response) {
              console.log(response);
              me.listaEvaluadores = response.data;
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
          $('#verJurados').modal('show');
        },
        cancelarElecion(){
          this.dest1 = '';
          this.Adestinos2 = [];
          $('#designarDestino').modal('hide');
        },
        /**
         * Funcion para el boton atras
         */
        atras(){
          this.$router.push({
              name: "ListaEvaluaciones"
            });
        }
    },
};
</script>

<style>
</style>