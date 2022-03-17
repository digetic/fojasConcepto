<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <i class="far fa-bookmark"></i>
              Unidades a Evaluar
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
                    <h3 class="card-title">
                    <i class="fas fa-list-ul"></i>
                    Lista Unidades
                    </h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-4" v-model="criterio">
                                    <option value="d2">GRAN UNIDAD</option>
                                    <option value="d3">UNIDAD</option>
                                    <option value="d4">SECCION</option>
                                </select>
                                <input type="text"  class="form-control col-md-6" v-model="buscar" >
                                <button type="submit" class="btn btn-primary" @click="listarSecciones(1,buscar,criterio)"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th style="width: 100px" class="text-center">OPCIONES</th>
                                <th style="width: 350px" class="text-center">GRAN UNIDAD</th>
                                <th style="width: 350px" class="text-center">UNIDAD</th>
                                <th style="width: 300px" class="text-center">SECCION</th>
                                <th style="width: 100px" class="text-center">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr v-for="ls in listSecc">
                            <td class="text-center" style="vertical-align: middle;">
                                <div v-if="ls.estado === 2">
                                <button type="button" class="btn btn-primary btn-sm" @click="calEva(ls.d4, ls.d4c, ls.eva, ls.id)">
                                    <i class="fas fa-list"></i>
                                </button>
                                </div>
                                <div v-else-if="ls.estado === 0">
                                <button type="button" class="btn btn-primary btn-sm" @click="calEva(ls.d4, ls.d4c, ls.eva, ls.id)">
                                    <i class="fas fa-list"></i>
                                </button>
                                </div>
                                <div v-else>
                                <button type="button" class="btn btn-primary btn-sm" @click="inicioEva(ls.d4, ls.d4c, ls.eva, ls.id)">
                                    <i class="fas fa-user-check"></i>
                                </button> 
                                </div>                          
                            </td>                      
                            <td v-text="ls.d2" style="vertical-align: middle;"></td>
                            <td v-text="ls.d3" style="vertical-align: middle;"></td>
                            <td v-text="ls.d4" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;">
                                <div v-if="ls.estado === 0">
                                <span class="badge badge-danger">Finalizado</span>
                                </div>
                                <div v-else-if="ls.estado === 1">
                                <span class="badge badge-info">Sin Comenzar</span>
                                </div>
                                <div v-else>
                                <span class="badge badge-success">En progreso</span>
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
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      e: this.$route.params.e,
      listSecc: [],
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
      criterio : 'd2',
      buscar : '',
    }
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
  mounted() {
    this.listarSecciones(1,this.buscar,this.criterio);
  },
  methods: {
    cambiarPagina(page,buscar,criterio){
      let me = this;
      me.pagination.current_page = page;
      me.listarSecciones(page,buscar,criterio);
    },
    listarSecciones(page,busc,cri){
      let me = this;
        axios
          .post("/degsecev", {
            eva: this.e,
            page: page,
            buscar: busc,
            criterio: cri
          })
          .then(function (response) {
            console.log(response);
            me.listSecc = response.data.secciones.data;
            me.pagination = response.data.pagination;        
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
    },
    inicioEva(nd4, cod, eva, id){
        swal.fire({
          title: '¿Empezar la evaluacion de '+nd4+' ?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: 'info',
          cancelButtonColor: '#868077',
          confirmButtonText: 'Confirmar',
          cancelButtonText: 'Cancelar',
          buttonsStyling: true,
          reverseButtons: true
          }).then((result) => {
          if (result.value) {
            let me = this;
            axios
              .post("/asignarJurados", {
                dest4: cod,
                eva: eva,
                id: id
              })
              .then(function (response) {
                me.$router.push({
                  name: "PersonalFoja",
                  params:{
                      d4: cod,
                      e: eva,
                      id: id
                  }
                });
              })
              .catch(function (error) {
                // handle error
                console.log(error);
              })
          }else{
            console.log('no empezamos');
          }
        }) 
        

    },
    /**
     * Funcion para ir a la vista de la lista de designados a evaluar
     */
    calEva(nd4, cod, eva, id){
      this.$router.push({
        name: "PersonalFoja",
        params:{
            d4: cod,
            e: eva,
            id: id
        }
      });
    },
    
  }  
}
</script>

<style>

</style>