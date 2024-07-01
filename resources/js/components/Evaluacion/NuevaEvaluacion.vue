<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">    
                <div class="row">
                    <h1>
                        <i class="far fa-bookmark"></i>
                        REGISTRO NUEVA EVALUACIÓN
                    </h1>&nbsp; &nbsp;
                    <button class="btn btn-sm btn-danger" @click="atras()">
                        <i class="fas fa-undo"></i> &nbsp;
                        CANCELAR
                    </button>
                </div>                 
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                 <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                <router-link class="breadcrumb-item" to='/listaEvaluaciones'>Lista de Evaluaciones
                </router-link>
                 <li class="breadcrumb-item active">Nueva Evaluación</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <div>
        
    </div>

    <form-wizard @onComplete="GuardarEvaluacion()">
        <!-- PASO 1 @onComplete="Registrar()" -->
        <!-- <fieldset class="scheduler-border">
            <legend class="scheduler-border">DATOS SANCIONADO</legend>
            
        </fieldset> -->
        <tab-content title="INSTRUCCIONES" :selected="true">
            <div class="form-group" style="">
                <div class="row" style="margin-top: 5px; ">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <img :src="'/images/instrucciones.png'" width="100%" height="100%">
                    </div>
                    <div class="col-md-5">
                        <br>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">INSTRUCCIONES</legend>
                            <li class="letras">Las evaluaciones pueden ser calificadas anualmente o semestral.</li>
                            <li class="letras">El rango de fechas para la Evaluacion, debe estar en un maximo de 90 dias desde el incio del registro de la Evaluacion.</li>
                            <li class="letras">Los mensajes de Habilitacion seran enviados automaticamente.</li>
                            <li class="letras">Revise con cuidado los datos.</li>
                        </fieldset>                      
                    </div>
                </div>
            </div>
        </tab-content>

        <!-- PASO 2 -->
        <tab-content title="DATOS EVALUACIÓN">
            <div class="form-group">
                <div class="row" style="margin-top: 5px;">
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <img :src="'/images/calendario.png'" width="100%" height="100%">        
                    </div>
                    <div class="col-md-5">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">PERIODO DE EVALUACION</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="stlabel" for="eInicio">Periodo</label>
                                        <select class="form-control" v-model="formData.semestre" :class="hasError('semestre') ? 'is-invalid' : ''" @change="fechasAnual">
                                            <option value="1">1º SEMESTRE</option>
                                            <option value="2">2º SEMESTRE</option>
                                            <option value="3">ANUAL</option>
                                        </select>
                                    </div>
                                    <div v-if="hasError('semestre')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.semestre.required">Seleccione un valor porfavor.</div>
                                    </div>
                                    <div v-if="hasError('semestre')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.semestre.mustBeCool">Ya existe una evaluacion para ese semestre.</div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <dl>
                                                <dt class="st">Inicio</dt>
                                                <dd class="st">{{ pinicio }}</dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-6">
                                            <dl>
                                                <dt class="st">Final</dt>
                                                <dd class="st">{{ pfinal }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </fieldset>     
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">FECHA DE CALIFICACIÓN</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="stlabel" for="eInicio">Inicio</label> <br>
                                            <date-picker class="dat" value-type="format" format="YYYY/MM/DD"
                                                placeholder="Seleccione Fecha"
                                                v-model="formData.evinicio"
                                                :disabled-date="evfecha1"
                                                :class="hasError('evinicio') ? 'is-invalid' : ''"
                                            ></date-picker> 
                                            <div v-if="hasError('evinicio')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.evinicio.required">Campo rquerido.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="stlabel" for="eFinal">Finalización</label> <br>
                                            <date-picker class="dat" value-type="format" format="YYYY/MM/DD"
                                                placeholder="Seleccione Fecha"
                                                v-model="formData.evfinal"
                                                :disabled-date="evfecha2"
                                                :class="hasError('evfinal') ? 'is-invalid' : ''"
                                            ></date-picker>
                                            <div v-if="hasError('evfinal')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.evfinal.required">Campo requerido.</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </fieldset>                 
                    </div>
                    
                </div>
            </div>
            
            
        </tab-content>

        <!-- PASO 3 -->
        <tab-content title="REVISIÓN">
            <div class="form-group">
                <div class="row" style="margin-top: 5px;">
                     <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <img :src="'/images/revisionDatos.png'" width="100%" height="100%">        
                    </div>
                    <div class="col-md-3">   
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">REVISIÓN DE DATOS</legend>
                            <div align="center">
                                <dt class="st">Periodo de Evaluación</dt>
                                <template v-if="formData.semestre == 3">
                                <dd class="st">Anual</dd> 
                                </template>
                                <template v-else>
                                <dd class="st">{{formData.semestre}}° Semestre</dd>
                                </template>
                                <dd class="st">{{pinicio}} al {{pfinal}}</dd>                                    
                                <dt class="st">Fecha de Calificación</dt>
                                <dd class="st">{{formData.evinicio | moment("DD/MM/YYYY")}} al {{formData.evfinal | moment("DD/MM/YYYY")}}</dd> 
                                <dt class="st">Año</dt>
                                <dd class="st">{{nuevoaño}}</dd>    
                            </div>
                            
                                    
                        </fieldset> 
                    </div>                    
                </div>                
            </div>
        </tab-content>       
        
    </form-wizard>
  </div>
</template>

<script>

import {FormWizard, TabContent, ValidationHelper} from 'vue-step-wizard'
import { required, maxLength, sameAs } from 'vuelidate/lib/validators'

export default {
    name: 'BasicStepperForm',
    components: {
        FormWizard, TabContent
    },
    mixins: [ValidationHelper],
    data(){
        const today = new Date();
        return {
            //VARIABLES DE FORMULARIO
            formData:{
                semestre: 1,
                evinicio: null,
                evfinal: '',
            },
            año: '---',
            pinicio:  "01/01/"+ today.getFullYear(),
            pfinal: "06/30/" + today.getFullYear(),
            sigeva: [],
            actualaño: '',

            validationRules: [
                {

                },
                {
                    semestre: {required},
                     evinicio: {required},
                     evfinal: {required},
                }
            ]
        }
    },
    mounted() {
        this.UltimaEvaluacion();
        // this.ValidacionEvaluacion();
    },
    computed:{
        nuevoaño(){
        if (this.pinicio == null) {
            return this.año = '---';
        } else {
            const añoactual = new Date(this.pinicio);
            añoactual.setHours(0, 0, 0, 0);
            this.año = añoactual.getFullYear();
            return this.año;
        }  
    }
    },
    methods: {
        UltimaEvaluacion(){
             axios.get("/ultFechEva")
                .then(response=>{
                    console.log(response);
                    this.sigeva = response.data
                    if ( this.sigeva.periodo == 2) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ya existe demasiadas evaluaciones para este año.',
                            showConfirmButton: false,
                            timer: 5000
                        })
                        this.atras();
                    } else {
                        if (this.sigeva.periodo == 3) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Ya existe una evaluacion anual registrada.',
                                showConfirmButton: false,
                                timer: 5000
                            })
                            this.atras();
                        } 
                    }            
                })
                .catch(error=>{
                alert(error)
                })
        },
        fechasAnual(){
            const today = new Date();
            if (this.formData.semestre == 1) {
                this.pinicio =  "01/01/"+ today.getFullYear() ;
                this.pfinal = "06/30/" + today.getFullYear();
            }
            if (this.formData.semestre == 2) {
                this.pinicio =  "07/01/" + today.getFullYear();
                this.pfinal = "12/31/" + today.getFullYear() ;
            }
            if (this.formData.semestre == 3) {
                this.pinicio =  "01/01/"+ today.getFullYear() ;
                this.pfinal = "12/31/" + today.getFullYear() ;
                
            } 
        },
        evfecha1(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            return date < today || date > new Date(today.getTime() + 90 * 24 * 3600 * 1000);
        },
        evfecha2(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const inicioe = new Date(this.formData.evinicio);
            inicioe.setHours(0, 0, 0, 0)
            return date < new Date(inicioe.getTime()) || date > new Date(inicioe.getTime() + 90 * 24 * 3600 * 1000);
        },
        GuardarEvaluacion(){
            const today = new Date();
            console.log(today.getFullYear());
            console.log(this.formData.evfinal);
            if (this.sigeva.periodo == this.formData.semestre && this.sigeva.periodo == 1 && this.sigeva.ano == today.getFullYear() ) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ya existe una evaluacion para ese semestre.',
                    showConfirmButton: false,
                    timer: 2000
                })
            } else {
                if (this.sigeva.periodo == this.formData.semestre && this.sigeva.periodo == 2) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ya existe demasiadas evaluaciones para este año.',
                        showConfirmButton: false,
                        timer: 2000
                    })
                } else {
                    if (this.formData.semestre == 2  && this.sigeva.ano != today.getFullYear() ) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Debe registrar una evaluacion para el 1º semestre.',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else {
                        if (this.formData.semestre == 3 && this.sigeva.periodo == 1 && this.sigeva.ano == today.getFullYear() ) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Debe registrar el 2º semestre para la evaluación.',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        } else {
                            if (this.formData.semestre == 2  && this.sigeva.ano == today.getFullYear() && this.sigeva.periodo == 0 ) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Debe registrar una evaluacion para el 1º semestre.',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            } else {
                                let me = this;
                                axios.post('/evaluaciones/store',{
                                    'einicio': this.formData.evinicio,
                                    'efinal': this.formData.evfinal,
                                    'pinicio': this.pinicio,
                                    'pfinal': this.pfinal,
                                    'ano': this.año,
                                    'semestre': this.formData.semestre
                                }).then(function (response) {  
                                    Swal.fire(
                                        'Habilitado',
                                        'La Evaluacion a sido habilitada',
                                        'success'
                                    )
                                    me.atras();
                                })
                                .catch(function (error) {
                                    // handle error
                                    console.log(error);
                                })
                                .then(function () {
                                    // always executed
                                });
                            }
                        }
                        
                    }
                    
                    
                }
                
            }
        },        
        atras(){
            this.$router.push({
                name: "ListaEvaluaciones",
            });
        },  

        /**
         * validaciones de campos
         */
        onlyNumber ($event) { //SOLO NUMEROS
            //console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57)) { // 46 is dot
                $event.preventDefault();
            }
        },
        alphanumeric ($event) { //NUMEROS Y LETRAS
            // console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 122) && (keyCode < 48 || keyCode > 57)  && keyCode !== 209 && keyCode !== 241 && keyCode !== 32 && keyCode !== 45) { // 46 is dot
                $event.preventDefault();
            }
        },
        onlyletters ($event) { //SOLO letras
            console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 122) &&  keyCode !== 209 && keyCode !== 241 && keyCode !== 32) { // 46 is dot
                $event.preventDefault();
            }
        },
        numDoc ($event) { //SOLO NUMEROS y "/"
            //console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 47) { // 46 is dot
                $event.preventDefault();
            }
        },
    },

}
</script>

<style>
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
    width:auto;
    padding:0 5px;
    border-bottom:none;
}

.separador {
    border-left: 1px #000 solid;
    padding-left: 15px;
}
.dat {
    max-width: 100%;    
}
.letras{
    font-size: 13pt;
}
</style>