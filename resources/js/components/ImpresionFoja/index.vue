<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="card-title">
                <h1>
                    <i class="far fa-bookmark"></i> &nbsp;
                    Impresión de Fojas de Concepto
                </h1>
            </h3>
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
            <div class="card card-dark card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Elija una Sección
                </h3>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                          <label class="stlabel" for="pregunta"><b>Evaluaciones</b></label>
                          <v-select
                              label="text"
                              :options="evaluaciones"
                              v-model="eva"
                              @input="limpiar"
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
                    </div>
                    <div class="col-sm-8">
                          <label class="stlabel" for="pregunta"><b>Seccion</b></label>
                          <v-select
                              label="descripcion"
                              :options="destinos3"
                              v-model="dest3"  
                              @input="limpiar"       
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
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                      <button type="button" @click="listarPersonal" class="btn btn-primary btn-block btn-sm">
                        <i class="fa fa-users" aria-hidden="true"></i> &nbsp; Listar Personal
                      </button>
                    </div>
                  </div>
              </div>
              <!-- /.card -->
            </div>

            <div class="card card-dark card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-clipboard-list"></i>
                  Lista Personal
                </h3>
              </div>
              <div class="card-body">
                <template v-if="personal.length > 0">
                  <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th style="width: 100px" class="text-center">OPCIONES</th>
                            <th style="width: 350px" class="text-center">GRAN UNIDAD</th>
                            <th style="width: 350px" class="text-center">CARGO</th>
                            <th style="width: 350px" class="text-center">DESTINO</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr v-for="ls in personal">                          
                          <td class="text-center" >
                            <button type="button" @click="EstadoImpresion(ls.per_codigo, ls.division)" class="btn btn-danger btn-sm">
                              <i class="fas fa-print"></i>
                            </button>         
                                                    
                          </td>                      
                          <td>{{ls.grado}} {{ls.complemento}} {{ls.nombre}} {{ls.paterno}} {{ls.materno}} </td>
                          <td v-text="ls.cargo"></td>
                          <td v-text="ls.destino"></td>
                      </tr>
                    </tbody>                    
                  </table>
                  <nav>
                      <ul class="pagination">
                          <li class="page-item" v-if="pagination.current_page > 1">
                              <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                          </li>
                          <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                              <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                          </li>
                          <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                              <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                          </li>
                      </ul>
                  </nav>
                </template>
                <template v-else>
                  <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Nota:</h5>
                    Debe seleccionar una sección para ver el personal.
                  </div>
                </template>                
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
  </div>
</template>

<script>
export default {
    data() {
        return {
            destinos3: [],
            dest3: [],
            $des3: null,
            personal: [],
            num: 0,
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            $depa: '',
            evaluaciones: [],
            eva: null
        }
    },
    mounted() {
        this.listardestinos3()
        this.listarEvalauciones()
    },
    computed: {
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
    },
    methods: {
        limpiar(){
          this.personal = [];
        },
        /**
         * FUNCIONES LISTADOR UNIDADES CON EVALUADORES DESIGNADOS
         */
        cambiarPagina(page){
          let me = this;
          //actualizando la pagina actual
          me.pagination.current_page = page;
          me.listarPersonal(page);
        },
        listarPersonal(page){

          if (this.eva == "" || this.dest3 == "") {
              swal.fire(
                  "Precaución", //TITULO
                  "Debe seleccionar una evaluacion y una sección.", //TEXTO DE MENSAJE
                  "warning" // TIPO DE MODAL (success, warning, error, info)
              );
          } else {
            if (this.eva == null || this.dest3 == null) {
              swal.fire(
                  "Aceptado", //TITULO
                  "Debe seleccionar una evaluacion y una sección.", //TEXTO DE MENSAJE
                  "warning" // TIPO DE MODAL (success, warning, error, info)
              );
            } else {
              try {
                let me = this;
                  axios
                    .post(me.$web+"/api/listaPersonal3", {
                          destino: me.dest3.id,
                          page: page
                    },{
                        headers: {'token': me.$tokenfoja}
                    })
                    .then(function (response) {
                      me.personal = response.data.personal.data
                      me.pagination = response.data.pagination
                      console.log( response);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
              } catch (error) {
                this.personal = []
                // console.log(this.des3);
              }
            }
            
          }
            
        },
        listarEvalauciones(){
          try {
            let me = this;
            me.personal= [];
            axios
                .get('/listEva')
                .then(function (response) {
                  console.log(response);
                me.evaluaciones = response.data;
                })
                .catch(function (error) {
                // handle error
                console.log(error);
                })
                .then(function () {
                // always executed
                });
          } catch (error) {
            this.evaluaciones = [];
          }
            
        },
        listardestinos3() {
            let me = this;
              axios
                .post(me.$web+"/api/dest3cal", {
                      id: window.user.user.percod
                },{
                    headers: {'token': me.$tokenfoja}
                })
                .then(function (response) {
                  // console.log(response);
                    me.destinos3 = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        EstadoImpresion(id, d){
          let me = this;
          axios
            .post("/estadoimpresion", {
              per_codigo: id
            })
            .then(function (response) {
              console.log(response);
              if (response.data.code == 200) {
                if (response.data.estado == 1) {
                  me.Notas(id, d, me.dest3.nombre, me.eva.eva)
                } else {
                  swal.fire(
                    "Advertencia",
                    "Aun tiene evaluaciones pendientes.",
                    "warning"
                  );
                }
              } else {
                swal.fire(
                  "Advertencia",
                  "No tiene evaluaciones designadas o evaluadas.",
                  "warning"
                );
              }
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
        },
        Notas(perCodigo, d, depa, eva){
          
           window.open('http://fojasconcepto.test/datosfoja/'+perCodigo+'/'+d+'/'+depa+'/'+eva);
        }
        
    },
};
</script>

<style>
</style>