<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1>
                <i class="far fa-bookmark"></i>
                Calificacion de Fojas de Concepto
            </h1>
          </div>
          <div class="col-sm-4">
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
                  <i class="fas fa-clipboard-list"></i> &nbsp;
                  Instrucciones
                </h3>
              </div>
              <div class="card-body">
                    <table border="1" style="width: 100%">
                        <tr>
                            <td colspan="2" class="text-center sb" style="width: 50%">CALIFICACIONES</td>
                            <td colspan="2" class="text-center sb" style="width: 50%">EVALUACION ACTUAL</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="espmarg">
                            <dl>
                                <dt class="st">OBJETIVA:</dt>
                                <dd class="st">Se califica el desempeño anual en diferentes areas, con una escala de calificación de:
                                </dd>
                                <ul>
                                    <li style="color: #B01208;">Malo -> 0 - 49</li>
                                    <li style="color: #B0AD08;">Regular -> 50 - 69</li>
                                    <li style="color: #07900B;">Bueno -> 70 - 100</li>
                                </ul>
                                <dt class="st">CONCEPTUAL:</dt>
                                <dd class="st">Se califica aspectos positivos y/o negativos destacables del calificado, en forma literal y númerica (0 a 100).
                                </dd>
                                <dt class="st">NOTA:</dt>
                                <ul>
                                    <li>Las notas mayores a 90 y menores de 30 se justificarán en la Califcación Conceptual</li>
                                    <li>La calificación de 100 deberá justificar con un informe.</li>
                                </ul>
                            </dl>
                            </td>
                            <td colspan="2" class="espmarg">
                                <template v-if="code == 200">
                                    <dl>
                                        <dt class="st">Gestion:</dt>
                                        <dd class="st">
                                            <div class="text-center">
                                                {{datos.ano}}
                                            </div>                                            
                                        </dd>
                                        <dt class="st">Fecha Inicio:</dt>
                                        <dd class="st">
                                            <div class="text-center">
                                                {{datos.inicio}}
                                            </div>                                            
                                        </dd>

                                        <dt class="st">Fecha Final:</dt>
                                        <dd class="st">
                                            <div class="text-center">
                                                {{datos.final}}
                                            </div>                                            
                                        </dd>

                                        <dt class="st">Semestre:</dt>
                                        <dd class="st">
                                            <div class="text-center" v-if="datos.periodo == 1">
                                                Primer Semestre
                                            </div> 
                                            <div class="text-center" v-if="datos.periodo == 2">
                                                Segundo Semestre
                                            </div> 
                                            <div class="text-center" v-if="datos.periodo == 3">
                                                Anual
                                            </div>                                            
                                        </dd>
                                    </dl> 

                                    <div class="d-flex justify-content-center">
                                        <button type="button btn-sm" class="btn btn-primary" @click="calificar(datos.evaluacion)">EMPEZAR CALIFICACION</button>
                                    </div>                            
                                </template>
                                <template v-else>
                                    <div class="alert alert-success text-center" role="alert">
                                        NO EXISTE UNA EVALUACION ACTUAL
                                    </div>
                                </template>
                            
                            </td>
                        </tr>
                    </table>
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
            datos: [],
            code: ""
        }
    },
    created() {
        this.datosIndex();
    },
    methods: {
        datosIndex(){
            let me = this;
            var url='/evalactual'
            axios
                .get(url)
                .then(function (response) {
                    me.code = response.data.code
                    if(me.code == 200){
                      me.datos = response.data.evaluacion
                    }
                })
                .catch(function (error) {
                // handle error
                console.log(error);
                });
        },
        calificar(eva){
            this.$router.push({
            name: "FojasDestList",
            params:{
                e: eva
            }
          });
        }
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
</style>