<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <i class="far fa-bookmark"></i>
              Personal a Evaluar
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Modals & Alerts</li>
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
                    <div class="card card-dark card-outline">
                        <div class="card-header">                        
                            <div class="d-flex bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <i class="fas fa-list-ul"></i>
                                    Lista Personal
                                </div>
                                <div class="ml-auto p-2 bd-highlight">
                                <button type="button" class="btn btn-danger" @click="atras()">
                                    <i class="fas fa-undo-alt"></i> &nbsp;Atras
                                </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                 <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                            <option value="p.per_nombre">NOMBRE</option>
                                            <option value="p.per_paterno">PATERNO</option>
                                            <option value="p.per_materno">MATERNO</option>
                                            <option value="jp.cargo">CARGO</option>
                                        </select>
                                        <input type="text"  class="form-control" v-model="buscar">
                                        <button type="submit" class="btn btn-primary" @click="listarPersonal(1,buscar,criterio)"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 100px" class="text-center">OPCIONES</th>
                                        <th style="width: 350px" class="text-center">NOMBRE</th>
                                        <th style="width: 200px" class="text-center">CARGO</th>
                                        <th style="width: 100px" class="text-center">ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr v-for="ls in listaEvaluados">
                                    <td class="text-center">
                                        <div v-if="ls.estado === 1">
                                          <button type="button" class="btn btn-primary btn-sm" @click="fojaConcepto(ls.per_codigo, ls.jpid)">
                                              <i class="fas fa-pencil-alt"></i>
                                          </button>
                                        </div>
                                        <div v-else>
                                          <button type="button" class="btn btn-info btn-sm" @click="verNotas(ls.jpid)">
                                              <i class="fas fa-eye"></i>
                                          </button>
                                        </div> 
                                        
                                    </td>
                                    <td>{{ls.graCom}} {{ls.per_nombre}} {{ls.per_paterno}} {{ls.per_materno}}</td>
                                    <td v-text="ls.cargo"></td>
                                    <td class="text-center">
                                        <div v-if="ls.estado === 1">
                                        <span class="badge badge-danger">Sin Evaluar</span>
                                        </div>
                                        <div v-else>
                                        <span class="badge badge-success">Evaluado</span>
                                        </div>                            
                                    </td>                      
                                </tr>
                                </tbody>
                                
                            </table>
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




      <div class="modal fade" id="notasModal">
        <div class="modal-dialog modal-lg2">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">NOTAS DE LA EVALUACION</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="text-center">
                    <h4>EVALUACION OBJETIVA</h4>
                  </div>                  
                  <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th style="width: 80%" class="text-center">ASPECTO OBJETIVO</th>
                            <th style="width: 20%" class="text-center">NOTA</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr v-for="no in notasObjetivas">
                        <td>{{no.detalle}}</td>
                        <td class="text-center">{{no.nota}}</td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td class="text-center">
                          <b>PROMEDIO</b>
                        </td>
                        <td class="text-center">
                          <b>{{promedio}}</b>                          
                        </td>
                      </tr>
                    </tfoot>
                      
                  </table>
                </div>
                <div class="col-sm-6">
                  <div class="text-center">
                    <h4>EVALUACION CONCEPTUAL</h4>                    
                  </div>
                  <dt class="stlabel">EVALUACION CONCEPTUAL:</dt>
                  <dd class="stlabel">{{ notaConceptual.literal }}</dd>
                  <dt class="stlabel">NUMERICA:</dt>
                  <dd class="stlabel text-center">{{ notaConceptual.numerica }}</dd>
                </div>
              </div>
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
      d4: this.$route.params.d4,
      e: this.$route.params.e,
      id: this.$route.params.id,
      listaEvaluados: [],
      /**
       * Variables para ver las notas
       */
      notasObjetivas: [],
      promedio: 0,
      notaConceptual: [],
      notaConcepNum: "",
      /**
       * Variables paginacion y buscador
       */
      pagination : {
        'total' : 0,
        'current_page' : 0,
        'per_page' : 0,
        'last_page' : 0,
        'from' : 0,
        'to' : 0,
      },
      offset : 3,
      criterio : 'p.per_nombre',
      buscar : '',
    
      
    }
  },
  mounted() {
    this.listarPersonal(1,this.buscar,this.criterio);
    this.actEstado();
    console.log(this.id);
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
  },
  methods: {
    cambiarPagina(page,buscar,criterio){
      let me = this;
      me.pagination.current_page = page;
      me.listarPersonal(page,buscar,criterio);
    },
    listarPersonal(page,busc,cri){
      let me = this;
      axios
        .post("/juradoPersonal", {
          dest4: this.d4,
          eva: this.e,
          id: this.id,
          page: page,
          buscar: busc,
          criterio: cri
        })
        .then(function (response) {
          // console.log(response);
          me.listaEvaluados = response.data.perjur.data;
          me.pagination = response.data.pagination;        
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
    },
    /**
     * Funcion para la redireccion a la vista de la
     * Foja de Concepto
     */
    fojaConcepto(perCod, jpid){
      this.$router.push({
        name: "Foja",
        params: {
          perCod: perCod,
          jur: this.id,
          d4: this.d4,
          e: this.e,
          jpid: jpid
        }
      });

    },
    /**
     * Funcion para abrir modal para ver notas
     */
    verNotas(jp){
      this.conceptual(jp);
      this.objetiva(jp);
      console.log(jp);
      $('#notasModal').modal('show');
    },
    objetiva(jpid){
      let me = this;
      axios
        .post("/notasObjetiva", {
          jpid: jpid,
        })
        .then(function (response) {
          // console.log(response);
          me.notasObjetivas = response.data.objetiva;
          me.promedio = response.data.promedio.toFixed(2); 
                   
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
    },
    conceptual(jpid){
      let me = this;
      axios
        .post("/notaConceptual", {
          jpid: jpid,
        })
        .then(function (response) {
          me.notaConceptual = response.data;          
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
    },
    /**
     * Funcion para actualizar el estado de la calificacin del destino
     */
    actEstado(){
      let me = this;
      axios
        .post("/actEstado", {
          destino: this.d4,
          jurado: this.id
        })
        .then(function (response) {
          // console.log(response);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
    },
    /**
     * Boton para retroceder de página
     */
    atras(){
      this.$router.push({
        name: "FojasDestList",
        params: {
            e: this.e
        }
      });
    }
  }
  
}
</script>

<style>
@media (min-width: 850px) {
  .modal-lg2 {
    max-width: 60%;
  }
}

.stlabel {
  font-size: 18px;
}
</style>