<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="far fa-bookmark"></i>
              FOJAS DE CONCEPTO
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
            <div class="card card-dark card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="col-sm-10">
                    <h3 class="card-title">
                      <i class="fas fa-search"></i>
                      Evaluaciones
                    </h3>  
                  </div>
                  <div class="col-sm-2" >
                    <router-link @click.native="$router.go()" to='/nuevaEvaluacion'>
                      <button type="button" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus"></i> Añadir Nueva Evaluación
                      </button>
                    </router-link> 
                  </div>
                </div> 
              </div>
              <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-4" v-model="criterio">
                                <option value="p.periodo">Periodo</option>
                                <option value="p.ano">Año</option>
                            </select><!-- el arroba @ es el simplificado del v-on -->
                            <input type="text" v-model="buscar" @keyup="BuscarEvaluacion()" class="form-control" placeholder="Texto a buscar"  style="text-transform:uppercase">
                            <!-- <button type="submit" @click="listarPersonal(1,buscar,criterio)" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Buscar</button> -->
                        </div>
                    </div>
                </div>
                <div class="table-wrapper-scroll-y my-custom-scrollbar" id="myTable">

                    
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>   
                                    <th class="text-center">Opciones</th>                                 
                                    <th class="text-center">Año</th>
                                    <th class="text-center">Periodo</th>
                                    <th class="text-center">Fecha de Evaluacion</th>
                                    <th class="text-center">Fecha de Periodo</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="evaluacion in arrayEvaluaciones">
                                  <td class="text-center">
                                      <!-- *** Direccionamiento a designacion de habilitar de calificadores */ -->
                                      <router-link
                                      type="button"
                                      class="btn btn-primary btn-sm"
                                       data-toggle="tooltip" data-placement="top" title="Asignar Evaluadores"
                                      :to="{
                                          name: 'ListaUnidadesDesignaciones',
                                          params: { e: evaluacion.id },
                                      }"
                                      >
                                      <i class="fas fa-file-signature"></i>
                                      </router-link>
                                      &nbsp;
                                      <!-- Fin de Direccionamiento -->
                                      <button
                                      type="button"
                                      class="btn btn-danger btn-sm"
                                       data-toggle="tooltip" data-placement="top" title="Eliminar Evaluación"
                                      @click.prevent="eliminarEvaluacion(evaluacion.id)"
                                      >
                                      <i class="fa fa-trash" aria-hidden="true"></i>
                                      </button>
                                      &nbsp;
                                      <!-- Fin de Direccionamiento -->
                                      <button v-if="evaluacion.estado == 1"
                                      type="button"
                                      class="btn btn-info btn-sm"
                                       data-toggle="tooltip" data-placement="top" title="Finalizar Evaluación"
                                      @click.prevent="finalizarEvaluacion(evaluacion.id, evaluacion.efinal)"
                                      >
                                      <i class="fa fa-times" aria-hidden="true"></i>
                                      </button>
                                  </td>
                                  <td class="text-center">{{evaluacion.ano}}</td>

                                  <td v-if="evaluacion.periodo == 3" class="text-center">
                                      ANUAL
                                  </td>
                                  <td
                                      v-else
                                      class="text-center"
                                  >{{evaluacion.periodo}}º Semestre</td>

                                  <td class="text-center">
                                      {{
                                      evaluacion.einicio + " al " + evaluacion.efinal
                                      }}
                                      &nbsp;
                                      <button
                                      type="button"
                                      class="btn btn-warning btn-sm"
                                      v-on:click.prevent="
                                          cambioFecha(evaluacion.idfechaEvaluacion)
                                      "
                                      >
                                      <i class="fas fa-edit"></i>
                                      </button>
                                  </td>
                                  <td class="text-center">
                                      {{ evaluacion.pinicio + " al " + evaluacion.pfin }}
                                  </td>
                                  <td class="text-center">
                                      <div v-if="evaluacion.estado == 1">
                                      <span class="badge badge-success">Activo</span>
                                      </div>
                                      <div v-else-if="evaluacion.estado == 2">
                                      <span class="badge badge-danger">Finalizado</span>
                                      </div>
                                  </td>
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


      <!-- Modal Actualizacion de Fecha -->
      <div class="modal fade" id="actualizarFecha">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Nueva Fecha de Evaluacion</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                    <label for="recipient-name" class="col-form-label stlabel">Fecha de Evaluacion Actual:</label>
                    <div class="text-center">
                        <label  class="stlabel">{{eInicio}} &nbsp; al &nbsp; {{eFin}}</label>
                    </div>
                    
                    </div>
                    <div class="form-group">
                    <label for="recipient-name" class="col-form-label stlabel">NuevaFecha de Evaluacion:</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6 dat">
                            <label class="stlabel" for="eInicio">Inicio</label><br>
                            <date-picker value-type="format" format="YYYY/MM/DD"
                                placeholder="Seleccione Fecha"
                                v-model="ninicio"
                                :disabled-date="efecha1"
                            ></date-picker><br>                    
                        </div>
                        <div class="col-md-6 dat">
                            <label class="stlabel" for="eFinal">Finalización</label>
                            <date-picker value-type="format" format="YYYY/MM/DD"
                                placeholder="Seleccione Fecha"
                                v-model="nfinal"
                                :disabled-date="efecha2"
                            ></date-picker><br>                    
                        </div>
                    </div>                
                </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-secondary" @click="cerrarModal1()" data-dismiss="modal">Cerrar</button>
              <button type="button" @click="EditarFechaEvaluacion()" class="btn btn-primary">Guardar Cambios</button>
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
    const today = new Date();
    return {
        idUsuario: 0,
        ninicio: null,
        nfinal: '',
        npinicio: null,
        npfinal: '',
        idEvaluacion : 0,
        arrayEvaluaciones : [],
        nomUni: '',
        eInicio: '',
        eFin: '',
        pInicio:'',
        pFin: '',
        pagination : {
            'total' : 0,
            'current_page' : 0,
            'per_page' : 0,
            'last_page' : 0,
            'from' : 0,
            'to' : 0,
        },
        offset : 3,
        criterio : 'p.periodo',
        buscar : ''
    }
  },
  computed: {
    isActived   : function(){
        return this.pagination.current_page;
    },
    //creando funcion para calcular los elementos de la paginacion
    pagesNumber : function(){
        //si la pagina llega hasta la ultima pagina esta me va retornar un arrary vacio
        if(!this.pagination.to){
            return [];
        }

        var from =  this.pagination.current_page - this.offset;
        if(from < 1){
            from = 1;
        }

        var to = from + (this.offset * 2);
        if(to >= this.pagination.last_page){
            to = this.pagination.last_page;
        }

        var pagesArray = [];
        while(from <= to){
            pagesArray.push(from);
            from++;
        }
        return pagesArray;
    }
  },
  mounted() {
    this.ListarEvaluaciones(1);
  },
  methods: {
    nombreUnidad(){
      let me = this;
      axios
          .post("/URL", {
            dato: valor
          })
          .then(function (response) {
            //Respuesta de la peticion
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })

    },
    cambiarPagina(page,buscar,criterio){
        let me = this;
        //actualizando la pagina actual
        me.pagination.current_page = page;
        me.ListarEvaluaciones(page,buscar,criterio);
    },
    ListarEvaluaciones(page){
      let me = this;
      axios
      .post("/listarEvaluaciones", {
          page: page,
          buscar: me.buscar.toUpperCase(),
          criterio: me.criterio,
      })
      .then(function (response) {
          console.log(response);
          me.arrayEvaluaciones = response.data.evaluaciones.data;
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
            this.ListarEvaluaciones(1)
        }, 360)
    },
    /**
     * editar fecha de evaluacion
     */
    efecha1(date) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      return date > new Date(today.getTime()+ 40 * 24 * 3600 * 1000) || date < new Date("01/01/"+ today.getFullYear());

    },
    efecha2(date) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      const inicioe = new Date(this.ninicio);
      inicioe.setHours(0, 0, 0, 0)
      return date < new Date(inicioe.getTime()) || date > new Date(inicioe.getTime() + 90 * 24 * 3600 * 1000);
    },
    cambioFecha(id){
      let me = this;
      me.idEvaluacion = id
      axios
      .post("/fechaEvaluacion", {
          id: id
      })
      .then(function (response) {
          console.log(response);
          me.eInicio= response.data.einicio
          me.eFin= response.data.efinal
      })
      .catch(function (error) {
          // handle error
          console.log(error);
      })
        $('#actualizarFecha').modal('show');
    },
    cerrarModal1(){
      this.ninicio= null;
      this.nfinal = null;
    },
    EditarFechaEvaluacion(){
       swal.fire({
          title: '¿Seguro desea editar esta Fecha?', // TITULO 
          icon: 'question', //ICONO (success, warnning, error, info, question)
          showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
          confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
          cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
          confirmButtonText: 'Confirmar', //TITULO DEL BOTON CONFIRMAR
          cancelButtonText: 'Cancelar', //TIUTLO DEL BOTON CANCELAR
          buttonsStyling: true,
          reverseButtons: true
        }).then((result) => {
        if (result.value) {                
            let me = this;
            axios
            .post("/editarFechaEval", {                        
                'einicio' : me.ninicio,
                'efinal' : me.nfinal,
                'id' : me.idEvaluacion
            })
            .then(function (response) {
                console.log(response);
                swal.fire(
                    "Aceptado", //TITULO
                    "Se edito correctamente la fecha de evaluacion.", //TEXTO DE MENSAJE
                    "success" // TIPO DE MODAL (success, warnning, error, info)
                );
                $('#actualizarFecha').modal('hide');
                me.ListarEvaluaciones(1);
                me.cerrarModal1();

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
     * ELIMINAR EVALUACION
     */
    eliminarEvaluacion(id){
        swal.fire({
          title: '¿Esta seguro de eliminar esta evaluacion?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: 'red',
          confirmButtonText: 'Confirmar',
          cancelButtonText: 'Cancelar',
          buttonsStyling: true,
          reverseButtons: true
          }).then((result) => {
          if (result.value) {
            let me = this;
            axios.put('/eliminarEvaluacion',{//se coloca todo lo que se va actualizar
                'id' : id,
            }).then(function (response) {    
              swal.fire("Aceptado",
                "La evaluacion a sido eliminada.",
                "success");
              me.ListarEvaluaciones(1);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
          }
        })      
      },
      /**
       * FINALIZA LA EVALUACION
       */
      finalizarEvaluacion(id, efecha){
        const today = new Date();
        var cr = today.toISOString().split('T')[0]
        if (cr <= efecha) {
          swal.fire({
              title: 'La evaluacion aun no cumple la fecha de termino para la calificación de las Fojas de Cocepto. \n ¿Desea finalizar la evaluación?', // TITULO 
              icon: 'question', //ICONO (success, warnning, error, info, question)
              showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
              confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
              cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
              confirmButtonText: 'Confirmar', //TITULO DEL BOTON CONFIRMAR
              cancelButtonText: 'Cancelar', //TIUTLO DEL BOTON CANCELAR
              buttonsStyling: true,
              reverseButtons: true
              }).then((result) => {
              if (result.value) {
                this.finEvlauacion(id);
              }
          })
        } else {
          this.finEvlauacion(id);
        }
        
      },
      finEvlauacion(id){
        swal.fire({
          title: '¿Esta seguro de finalizar esta evaluacion?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: 'red',
          confirmButtonText: 'Confirmar',
          cancelButtonText: 'Cancelar',
          buttonsStyling: true,
          reverseButtons: true
          }).then((result) => {
          if (result.value) {
            let me = this;
            axios.put('/finalizararEvaluacion',{//se coloca todo lo que se va actualizar
                'id' : id,
            }).then(function (response) {    
              swal.fire("Aceptado",
                "La evaluacion a sido finalizada.",
                "success");
                console.log(response);
              me.ListarEvaluaciones(1);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
          }
        }) 
      }
  },
  
};
</script>

<style>
.stlabel{
    font-size: 20px;
}
</style>