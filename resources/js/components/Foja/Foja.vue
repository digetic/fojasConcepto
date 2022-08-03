<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <i class="far fa-bookmark"></i> &nbsp;
              Evaluación Foja de Concepto
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
                <h3 class="card-title">
                  <i class="fas fa-file-signature"></i> &nbsp;
                   <template v-if="datEva.periodo == 1">
                      1° Semestre
                   </template>
                   <template v-else-if="datEva == 2">
                      2° Semestre
                   </template>
                   <template v-else>
                      Anual
                   </template>
                   ( {{datEva.inicio | moment('DD/MM/YYYY')}} al {{datEva.fin | moment('DD/MM/YYYY')}} )
                </h3>
              </div>
              <div class="card-body">
                <form action="">
                    <div class="separador">
                    <div class="text-center">
                        <h4><b>DATOS PERSONALES</b></h4>
                    </div>
                    <table border="1" style="width: 100%">
                        <tr>
                            <td colspan="2" class="text-center sb" style="width: 50%">EVALUADOR</td>
                            <td colspan="2" class="text-center sb" style="width: 50%">EVALUADO</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="espmarg">
                            <dl>
                                <dt class="st">NOMBRE:</dt>
                                <dd class="st">
                                {{ evaluador.nombre }}
                                </dd>
                                <dt class="st">DESTINO</dt>
                                <dd class="st">{{ evaluador.d3 }}</dd>
                                <dt class="st">CARGO</dt>
                                <dd class="st">{{ evaluador.cargo }}</dd>
                            </dl>
                            </td>
                            <td colspan="2" class="espmarg">
                            <dl>
                                <dt class="st">NOMBRE:</dt>
                                <dd class="st">
                                {{ datos.nombre }}
                                </dd>
                                <!-- Realizar los cambios necesarios para obtener el destino -->
                                <dt class="st">DESTINO</dt>
                                <dd class="st">{{ datos.d4 }}</dd> 
                                <!-- Fin de los cambios a realizar -->
                                <dt class="st">CARGO</dt>
                                <dd class="st">{{ datos.cargo }}</dd>
                            </dl>
                            </td>
                        </tr>
                    </table>
                    <div>
                        <br>
                    </div> 
                    </div>
                    <br />
                    <!-- 
                    DATOS PARA LAS NOTAS DE LA FOJA DE CONCEPTO
                    -->
                    <div class="separador">
                    <div class="text-center">
                        <h4><b>CALIFICACIONES</b></h4>
                    </div>
                    <table border="1" style="width: 100%">          
                        <tr>
                            <td colspan="2" class="text-center sb" style="width: 45%">CONCEPTUAL</td>
                            <td colspan="2" class="text-center sb" style="width: 55%">OBJETIVA</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="espmarg">
                            <div class="form-group">
                                <label class="st" for="calificacionLiteral">
                                <b>CALIFICACIÓN LITERAL</b></label
                                >
                                <textarea
                                class="form-control"
                                style="text-transform: uppercase"
                                v-model="liteConc"
                                id="eliteral"
                                rows="4"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <form v-on:submit.prevent>
                                <div class="form-group">
                                    <label class="st" for="calificacionLiteral">
                                    <b>CALIFICACIÓN NUMÉRICA</b></label
                                    >
                                    <input
                                    type="number"
                                    style="text-transform: uppercase"
                                    v-model="notaConc"
                                    step="0.01"
                                    min="0"
                                    max="100"
                                    id="notaConc"
                                    class="form-control"
                                    />
                                </div>
                                </form>
                            </div>
                            </td>
                            <td rowspan="3" class="espmarg" style="vertical-align: top;">
                            <form v-on:submit.prevent="agregarNotas">
                                <div class="row">
                                <div class="form-group col-sm-8">
                                    <label class="st" for="pregunta"
                                    ><b>ASPECTOS OBJETIVOS</b></label
                                    >
                                    <select
                                    class="form-control custom-select"
                                    :disabled="validarPreguntas"
                                    id="menuPreguntas"
                                    v-model="preguntaSelecionada"
                                    >
                                    <option v-for="pregunta of preguntas" :value="pregunta">
                                        {{ pregunta.detalle }}
                                    </option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label class="st" for="disabledTextInput"
                                    ><b>NOTA</b></label
                                    >
                                    <input
                                    type="number"
                                    style="text-transform: uppercase"
                                    v-model="notaObj"
                                    :disabled="validarPreguntas"
                                    step="0.01"
                                    min="0"
                                    max="100"
                                    id="notaObj"
                                    class="form-control"
                                    />
                                </div>                          
                                </div>
                                <div class="form-group">
                                <button
                                    type="submit"
                                    :disabled="validarPreguntas"
                                    class="btn btn-primary btn-sm btn-block"
                                >
                                    REGISTRAR
                                </button>
                                </div>
                            </form>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                <tr>
                                    <th class="text-center">OPCIONES</th>
                                    <th class="text-center">ASPECTO OBJETIVO</th>
                                    <th class="text-center">NOTA</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(cali, index) of calificacion">
                                    <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        @click="eliminarNota(index)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    </td>
                                    <td class="text-center">{{ cali.pregunta }}</td>
                                    <td :style="color(cali.nota)" class="text-center">
                                    <b>{{ cali.nota }}</b>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center sb" >PROMEDIOS</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="espmarg">
                            <dl>
                                <dt class="st">NOTA CALIFICACION CONCEPTUAL</dt>
                                <dd class="st text-center" :style="color(notaConc)">
                                <b>{{ notaConc }}</b>
                                </dd>
                                <dt class="st">NOTA CALIFICACION OBJETIVA PROMEDIO</dt>
                                <dd
                                class="st text-center"
                                :style="color(promedioNotaObjetiva)"
                                >
                                <b>{{ promedioNotaObjetiva }}</b>
                                </dd>
                            </dl>
                            </td>
                        </tr>
                    </table>
                    <div>
                        <br>
                    </div> 
                    </div>
                    <br />
                    <div class="separador">
                    <div class="text-center">
                        <h4><b>DESIGNACIONES Y NOMBRAMIENTOS</b></h4>
                    </div>

                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 100px">FECHA</th>
                            <th class="text-center" style="width: 300px">
                            CLASE Y NRO. DE DOCUMENTO
                            </th>
                            <th class="text-center">DETALLE</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(desg, index) of desigNombr">
                            <td class="text-center">
                            {{ desg.fecha | moment('DD/MM/YYYY') }}
                            </td>
                            <td class="text-center">
                            {{ desg.ndoc }} - {{ desg.doc }}
                            </td>
                            <td>{{ desg.desc }}</td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                    <br />
                    <div class="separador">
                    <div class="text-center">
                        <h4><b>SANCIONES DISCIPLINARIAS</b></h4>
                    </div>
                    <br />
                    <table class=" table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 100px">FECHA</th>
                            <th class="text-center" style="width: 250px">
                            CLASE Y NRO. DE DOCUMENTO
                            </th>
                            <th class="text-center">TIEMPO</th>
                            <th class="text-center" style="width: 150px">SANCION</th>
                            <th class="text-center">MOTIVO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(san, index) of sanciones">
                            <td class="text-center">
                            {{ san.fecha | moment('DD/MM/YYYY') }}
                            </td>
                            <td class="text-center">
                            {{ san.ndoc }} - {{ san.documento }}
                            </td>
                            <td class="text-center">{{ san.dias }}</td>
                            <td >{{ san.sancion }}</td>
                            <td >{{ san.falta2 }}</td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </form>
                <br />
                <button @click="cancelar" class="btn btn-danger">Cancelar</button>
                <button
                    type="submit"
                    @click="guardarNotas"
                    :disabled="validar"
                    class="btn btn-success"
                >
                    ENVIAR
                </button>
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
        /**
         * Variables llegadas de la ruta
         */
        d4: this.$route.params.d4,
        e: this.$route.params.e,
        id: this.$route.params.id,
        perCod: this.$route.params.perCod,
        jpid: this.$route.params.jpid,
        /**
         * Variables de la vista
         */
        preguntaSelecionada: {}, //<-- el seleccionado estará aquí
        notaObj: 0,
        notaConc: 0,
        liteConc: "",
        preguntas: [],
        calificacion: [],
        preguntaCali: [],
        notasPre: [],
        datos: [],
        evaluador: [],
        notaObje: 0,
        //VARIABLES DESIGNACION Y NOMBRAMIENTOS
        desigNombr: [],
        //VARIABLES SANCIONES DISCIPLINARIAS
        sanciones: [],
        //VARIABLE PARA DATOS DE LA EVALUACION
        datEva: [],

        year: '',
    };
  },
  /**
   * NOTAS ->PROMEDIO
   * 
   * CALIFICACION OBJETIVA
   * CALIFICACION CONCEPTUAL
   */
  computed: {
    validar() {
      var tam = this.preguntas.length; // Obtenemos el valor del tamaño del array de calificaciones objetivas
      if (this.liteConc != "" && tam == 0 ) {
        return false;
      } else {
        return true;
      }
    },
    validarPreguntas() {
      var tam = this.preguntas.length; // Obtenemos el valor del tamaño del array de calificaciones objetivas
      if (tam > 0) {
        return false;
      } else {
        return true;
      }
    },
    promedioNotaObjetiva() {
      var suma = 0;
      if (this.notasPre.length > 0) {
        for (var x = 0; x < this.notasPre.length; x++) {
          suma += parseFloat(this.notasPre[x]);
        }
        var valor = suma / this.notasPre.length;

        return valor.toFixed(2);
      } else {
        return 0;
      }
    },
    formatted(date) {
      return Vue.filter("date")(date);
    },
  },
  methods: {
    agregarNotas() {
      /**
       * Algoritmo para eliminar opciones de un select
       */
      var tam = this.calificacion.length; // Obtenemos el valor del tamaño del array de calificaciones objetivas
      var ind = this.preguntas.indexOf(this.preguntaSelecionada); //Obtenemos el index del valor a desabilitar del array


      if (ind >= 0 && tam >= 0) {
        this.calificacion.push({
          idpregunta: this.preguntaSelecionada.id,
          pregunta: this.preguntaSelecionada.detalle,
          nota: this.notaObj,
        });

        this.preguntaCali.push(this.preguntaSelecionada.id);
        this.notasPre.push(this.notaObj);
        this.preguntas.splice(ind, 1); // eliminamos el valor del array
        this.preguntaSelecionada = {}; // Siempre reiniciar los valores
        this.notaObj = 0;
      } 
    },
    eliminarNota(index) {
      this.preguntas.push({
        detalle: this.calificacion[index].pregunta,
        id: this.calificacion[index].idpregunta,
      });
      this.calificacion.splice(index, 1);
      this.notasPre.splice(index,1)
    },
    color(nota) {
      if (nota >= 0 && nota < 50) {
        return { color: "#B01208" };
      }
      if (nota >= 50 && nota < 70) {
        return { color: "#B0AD08" };
      }
      if (nota >= 70 && nota <= 100) {
        return { color: "#07900B" };
      }
    },
    guardarNotas() {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
      });

      if (this.notaConc >= 0 && this.notaConc <=100) {
        swalWithBootstrapButtons
        .fire({
          title: "¿Esta seguro de Guardar la evaluacion?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Aceptar",
          cancelButtonText: "Cancelar",
          reverseButtons: true,
        })
        .then((result) => {
          if (result.value) {
            let me = this;
            axios
              .post("/guardarNota", {
                juPer: this.id,
                literal: this.liteConc.toUpperCase(),
                numerica: this.notaConc,
                cal: me.calificacion,
                jpid: this.jpid
              })
              .then(function (response) {
                swalWithBootstrapButtons.fire(
                  "Evaluado",
                  "La Evaluacion a sido guardada",
                  "success"
                );
                me.$router.push({
                  name: "PersonalFoja",
                  params:{
                      d4: me.d4,
                      e: me.e,
                      id: me.id
                  }
                });
                console.log(response);
              })
              .catch(function (error) {
                // handle error
                console.log(error);
              })
              .then(function () {
                // always executed
              });
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
          }
        });
      } else {
        swalWithBootstrapButtons.fire(
          "Error",
          "La Calificacion Conceptual Numerica debe ser entre 0 a 100 puntos.",
          "error"
        );
      }

      
    },
    cancelar() {
      this.$router.push({
        name: "PersonalFoja",
        params:{
            d4: this.d4,
            e: this.e,
            id: this.id
        }
      });
    },
    datosEvaluado() {
      let me = this;
      axios
        .post("/datosEvaluado", {
          perCod: this.perCod,
          id: this.id,
          eva: this.e
        })
        .then(function (response) {
          me.datos = response.data;  
          var  d = me.datos.division;
          me.listarPreguntas(d);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })

    },
    
    listarPreguntas(d) {
        let me = this;
        axios
          .post("/preguntasObjetivas", {
            'division' : d
          })
          .then(function (response) {
            me.preguntas = response.data;
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
    },
    datosEvaluador() {
      
      let me = this;
      axios
        .post("/datosEvaluador", {
          id: me.id
        })
        .then(function (response) {
          console.log(response);
          me.evaluador = response.data;          
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })

    },
    fecha1(date) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      var primerDia = new Date(today.getFullYear(), 0, 1);

      const cas = new Date(this.fechadesg);
      cas.setHours(0, 0, 0, 0);
      return date > today || date < primerDia;
    },
    /**
     * fUNCIONES PARA AGREGAR DESIGNACIONES Y NOMBRAMIENTOS
     */
    listarDesignaciones() {
      const today = new Date();
        let me = this;
            axios
          .post(me.$web+"/api/listDesgAño", {
                id: me.perCod,
                date:today.getFullYear()
          },{
              headers: {'token': me.$tokensipefab}
          })
          .then(function (response) {
            console.log(response);
              me.desigNombr = response.data;
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
    },
    /**
     * FUNCION QE DEVUELVE LOS DATOS DE LA EVALUACION
     */
    DatosEvaluacion() {
      let me = this;
      axios
        .post("/evaDat", {
          e: me.e
        })
        .then(function (response) {
          console.log(response);
          me.datEva = response.data;
          me.year = me.datEva.ano
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          // always executed
        });
    },
    /**
     * FUNCIONES PARA LISTAR SANCIONES DISCIPLINARIAS
     */
    listarSanciones() {

        const today = new Date();
        let me = this;
            axios
          .post(me.$web+"/api/listDemgAño", {
                id: me.perCod,
                date:today.getFullYear()
          },{
              headers: {'token': me.$tokensipefab}
          })
          .then(function (response) {
            console.log(response);
               me.sanciones = response.data;
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
    },
  },
  mounted() {
    console.log(this.perCod);
    this.datosEvaluado();
    this.datosEvaluador();
    this.DatosEvaluacion();
    this.listarSanciones();
    this.listarDesignaciones();
  },
};
</script>

<style>
.st {
  font-size: 18px;
}

.espmarg {
  padding: 10px;
}
.sb {
  font-size: 20px;
  font-weight: bold;
}

.separador {
  border-bottom: 1px solid black;
  padding-top: 5px;
}

</style>>