<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte user</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> --}}

    <style>
        @page{
            /* margin: 1.5rem;
            margin-top:1.9rem;
            padding: 1rem; */
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }
        html {
            /*margin: 20pt 25pt;/*SUPERIOR INFERIOR Y DERECHA IZQUIERDA*/
            margin: 0px;
        }
        body {
        /*position: relative;*/
         /* width: 21.6cm;   
        height: 37cm;*/
        /* margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        margin-top: 0.5cm;
        margin-left: 2cm;
        margin-right: 1cm;
        margin-bottom: 1cm;
        /* font-family: Arial, sans-serif;  */
        font-size: 12.3px;
        /*font-family: SourceSansPro;*/
        }
        * {
            font-family: verdana, arial, sans-serif;
        }
        .page-break {
            page-break-after: always;
        }

        #calobj{
            width: 100%; 
            border-collapse: collapse; 
            border-spacing: 0; 
            border: black 1px; 
            margin-bottom: 5px;
        }

        #calobj th{
            width: 60%; 
            border: 1px solid #000;
        }

        #calobj td{
            border: 1px solid #000;
            padding-left: 1%;
        }

        #calconc{
            width: 100%; 
            border-collapse: collapse; 
            border-spacing: 0; 
            border: black 1px ; 
            margin-bottom: 5px;
        }

        #calconc th{
            width: 60%; 
            border: 1px solid #000;
        }

        #calconc td{
            border: 1px solid #000;
            padding-left: 1%;
        }

        #designa{
            width: 100%; 
            border-collapse: collapse; 
            border-spacing: 0; 
            border: black 1px ; 
            margin-bottom: 4px;
        }

        #designa th{
            border: 1px solid #000;
            background-color: #D1D7E3; 
        }
        #designa td{
            border: 1px solid #000;
            padding-left: 1%;
        }

        #sanciona{
            width: 100%; 
            border-collapse: collapse; 
            border-spacing: 0; 
            border: black 1px ; 
            margin-bottom: 4px;
        }

        #sanciona th{
            border: 1px solid #000;
            background-color: #D1D7E3; 
        }
        #sanciona td{
            border: 1px solid #000;
            padding-left: 1%;
        }

        #escala{
            width: 100%; 
            border-collapse: collapse; 
            border-spacing: 0; 
            border: black 1px ; 
            /* margin-bottom: 4px; */
        }

        #escala th{
            border: 1px solid #000;
            background-color: #D1D7E3; 
        }
        #escala td{
            border: 1px solid #000;
            /* padding-left: 1%; */
        }
    </style>
</head>
    <body>        
        <header> {{-- Cabecera --}}
            <div style="text-align: center; width: 250px; font-size: 11.5px; font-weight: bold;">
                <p style="margin: 0px">FUERZA AÉREA BOLIVIANA</p>
                <p style="margin: -2px 0px">DEPARTAMENTO I - PERSONAL EMGFAB</p>
                <p style="margin: -2px 0px;"><u><strong>BOLIVIA</strong></u></p>
            </div>
            <div style="position: absolute; top: 0px; right: 0px; width: 113.4px; height: 113.4px; border: 1px solid;">
                <img src={{$foto}} width="100%" height="100%">
                {{-- <img src="'http://sipefab.fab.bo/img/personal/'.{{$usuario->foto}}" width="100%" height="100%"> --}}
            </div>
            <div style="padding-top: 30px; padding-bottom: 10px; text-align: center; font-size: 14.5px; font-weight: bold;">
                <p style="margin: 1px">FOJAS DE CONCEPTO</p>
                <p style="margin: -2px 8px 4px 0px">(ESCALAFÓN: OFICIALES SUPERIORES Y SUBALTERNOS)</p>
            </div>
         </header>
		<br>
        <section> {{-- Datos personales --}}
                {{-- <div style=" padding-bottom: 100px;">
                    <div style="float: left; width: 200px;">
                        <label><strong>CM:</strong>31213054</label><br>
                        <strong>ESPECIALIDAD:</strong>SISTEMAS ELECTRICOS
                    </div>
                    <div style="float: left; width: 500px; ">
                        <label ><strong>GRADO Y NOMBRE:</strong> SGTO. 1RO. TEC.  JUAN MANUEL QUISBERT ANTONIO</label>
                    </div>
                </div> --}}
                
                 <table style=" background: #ffffff; width: 100%;">
                    <tbody>
                        <tr>
                            <td style="width: 40%;">
                                <strong>GRADO: </strong> <span >{{$usuario->graCom}}</span> 
                            </td>
                            <td style="width: 60%;">
                                <strong>APELLIDOS Y NOMBRES: </strong> <span>{{$usuario->paterno}} {{$usuario->materno}} {{$usuario->nombre}}</span> 
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <strong>CARNET MILITAR:</strong> <span >{{$usuario->cm}}</span> 
                            </td>
                            <td style="width: 60%;">
                                <strong>DESTINO:</strong> <span >{{$usuario->destino}}</span> 
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <strong>ESPECIALIDAD:</strong> <span >{{$usuario->esp}} - {{$usuario->subespe}}</span> 
                            </td>
                            <td style="width: 60%;">
                                <strong>PERIODO DE CALIFICACIÓN:</strong> <span >{{$fechaEvaluacion->inicio}} AL {{$fechaEvaluacion->fin}}</span> 
                            </td>
                        </tr>
                    </tbody>
                </table> 

        </section>    
        <br>
        <section> {{-- calificacion objetiva --}}
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>1. CALIFICACIÓN OBJETIVA</strong></u></div>
            <div>
                <table id="calobj">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 65%;"><center>DETALLE</center> </th>
                            <th colspan="4" style="width: 45%;"><center>CALIFICACIONES</center></th>
                        </tr>
                        <tr>
                            <td style="text-align: center;">1ra.</td>
                            <td style="text-align: center;">2da.</td>
                            <td style="text-align: center;">3ra.</td>
                            <td style="text-align: center;">Promedio</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notas as $item)
                            <tr>
                                <td >{{$item['pre']}}</td>
                                <td ><center>{{$item['n1']}}</center></td>
                                <td ><center>{{$item['n2']}}</center></td>
                                <td ><center>{{$item['n3']}}</center></td>
                                <td ><center>{{$item['promedio']}}</center></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="background-color: #717171">Promedio Objetivo</td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ><center>{{$promedioObjetiva}}</center></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section> {{-- calificacion objetiva --}}
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>2. CALIFICACIÓN CONCEPTUAL</strong></u></div>
                <table id="calconc">{{-- jefe de personal --}}
                    <thead>
                        <tr>
                            <th colspan="4" style="background-color: #D1D7E3; text-align: left; padding: 4px 3px;">1ra. Calificación del Comando de Escuadrón o Jefe de Sección</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="height:30px; font-size: 10px; "><i> {{$conceptual1['literal']}} </i></td>
                        </tr>
                        <tr>
                            <td style="width: 36%;">Calificacion Conceptual Numérica</td>
                            <td style="width: 17%; text-align: center;">{{$conceptual1['numerica']}}</td>
                            <td style="width: 12%; padding: 7px 3px;">Firma</td>
                            <td style="width: 35%;"></td>
                        </tr>
                        <tr>
                            <td colspan="4">{{$conceptual1['evaluador']}}</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="4">Grado, Nombre, Apellido y Cargo del Superior Calificador</td>
                        </tr> --}}
                        

                    </tbody>
                </table>
                <table id="calconc">{{-- 2do comandante --}}
                    <thead>
                        <tr>
                            <th colspan="4" style="background-color: #D1D7E3; text-align: left; padding: 4px 3px; ">2da. Calificación del Segundo Comandante o Sub-Jefe de Sección de Departamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="height:30px; font-size: 10px; "><i>{{$conceptual2['literal']}}</i></td>
                        </tr>
                        <tr>
                            <td style="width: 36%;">Calificacion Conceptual Numérica</td>
                            <td style="width: 17%; text-align: center;">{{$conceptual2['numerica']}}</td>
                            <td style="width: 12%; padding: 7px 3px;">Firma</td>
                            <td style="width: 35%;"></td>
                        </tr>
                        <tr>
                            <td colspan="4"> {{$conceptual2['evaluador']}}</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="4">Grado, Nombre, Apellido y Cargo del Superior Calificador</td>
                        </tr> --}}
                    </tbody>
                </table>
                <table id="calconc">{{-- Comandante --}}
                    <thead>
                        <tr>
                            <th colspan="4" style="background-color: #D1D7E3; text-align: left; padding: 4px 3px;">3er. Calificación del Comandante o Jefe de Departamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="height:30px; font-size: 10px; "><i>{{$conceptual3['literal']}}</i></td>
                        </tr>
                        <tr>
                            <td style="width: 36%;">Calificacion Conceptual Numérica</td>
                            <td style="width: 17%; text-align: center;">{{$conceptual3['numerica']}}</td>
                            <td style="width: 12%; padding: 7px 3px;">Firma</td>
                            <td style="width: 35%;"></td>
                        </tr>
                        <tr>
                            <td colspan="4">{{$conceptual3['evaluador']}}</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="4">Grado, Nombre, Apellido y Cargo del Superior Calificador</td>
                        </tr> --}}
                    </tbody>
                </table>
                <br>
                <table style="width: 100%; border-collapse: collapse; border-spacing: 0; border: black 1px ; margin-bottom: 5px;">{{-- promedio conceptual --}}
                    <thead>
                        <tr>
                            <th colspan="2" style="background-color: #D1D7E3; border: 1px solid #000; font-size: 13px; padding: 4px 3px; text-align: left;">3. Promedio Conceptual</th>
                            <th style="width: 20%;"></th>
                            <th colspan="2" style="background-color: #D1D7E3; border: 1px solid #000; font-size: 13px; padding: 4px 3px; text-align: left;">4. Promedio General</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #000;">Primera</td>
                            <td style="border: 1px solid #000;"><center>{{$conceptual1['numerica']}}</center></td>
                            <td ></td>
                            <td style="border: 1px solid #000;">Promedio Objetivo</td>
                            <td style="border: 1px solid #000;"><center>{{$promedioObjetiva}}</center></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">Segunda</td>
                            <td style="border: 1px solid #000;"><center>{{$conceptual2['numerica']}}</center></td>
                            <td></td>
                            <td style="border: 1px solid #000;">Promedio Conceptual</td>
                            <td style="border: 1px solid #000;"><center>{{$promedioConceptual}}</center></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">Tercera</td>
                            <td style="border: 1px solid #000;"><center>{{$conceptual3['numerica']}}</center></td>
                            <td></td>
                            <td style="border: 1px solid #000;"><strong>Nota Semestral:</strong></td>
                            <td style="border: 1px solid #000;"><center>{{$notaFinal}}</center></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><strong>Promedio Conceptual:</strong></td>
                            <td style="border: 1px solid #000;"><center>{{$promedioConceptual}}</center></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                    </tbody>
                </table>
        </section>
        <section>{{-- Notificacion firma --}}
            <div style="font-size: 13px; padding-top: 10px; padding-bottom:70px;"><u><strong>5. NOTIFICACIÓN</strong></u></div>
            <table style="width: 100%; border-collapse: collapse; border-spacing: 0; border: black 1px ; margin-bottom: 5px;">{{-- promedio conceptual --}}
                <thead>
                    <tr>
                        <th colspan="2" style="  font-size: 12.5px; padding: 4px 3px; text-align: left; text-align: center;">{{$usuario->graCom}} {{$usuario->paterno}} {{$usuario->materno}} {{$usuario->nombre}}</th>
                        <th style="width: 2%;"></th>
                        <th colspan="2" style="  font-size: 12.5px; padding: 4px 3px; text-align: left;"><hr></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 12px;">Grado, Apelllidos y Nombres</td>
                        <td ></td>
                        <td colspan="2" style="text-align: center; font-size: 12px;">FIRMA</td>
                    </tr>
                </tbody>
            </table>
            <div style="font-size: 12px; padding-top: 20px; text-align: right;"><i><strong>Lugar y Fecha:</strong> {{$depa}}, {{$fecha}}</i></div>
        </section>
        <div class="page-break"></div> {{-- SALTO DE PAGINA --}}

        <br>
        <section>{{-- tabla designa --}}
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>6. DESIGNACIONES Y NOMBRAMIENTOS</strong></u></div>
            <div>
                <table id="designa">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Clase y Nro. de Documento</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody >
                        @if (count($designaciones) > 0)
                            @foreach ($designaciones as $item)
                                <tr>
                                    <td style="width: 12%;">{{$item->fecha}}</td>
                                    <td style="width: 18%;">{{$item->doc}} {{$item->ndoc}}</td>
                                    <td style="width: 70%; padding-left: 1px;">{{$item->desc}}</td>
                                </tr>
                            @endforeach 
                        @else
                        <tr>
                            <td style="width: 12%;">&nbsp;    </td>
                            <td style="width: 18%;">&nbsp;    </td>
                            <td style="width: 70%; padding-left: 1px;"> &nbsp;  </td>
                        </tr>
                        @endif              

                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>{{-- tabla sanciona --}}
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>7. SANCIONES DISCIPLINARIAS</strong></u></div>
            <div>
                <table id="sanciona">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Clase y Nro. de Documento</th>
                            <th>Tiempo</th>
                            <th>Sanción</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($sanciones) > 0)
                            @foreach ($sanciones as $item)
                                <tr>
                                    <td style="width: 12%;">{{$item->fecha}}</td>
                                    <td style="width: 18%;">{{$item->documento}} {{$item->ndoc}}</td>
                                    <td style="width: 10%;">{{$item->dias}}</td>
                                    <td style="width: 35%; padding-left: 1px;">{{$item->sancion}}</td>
                                    <td style="width: 25%;">{{$item->falta2}}</td>
                                </tr> 
                            @endforeach
                        @else
                            <tr>
                                <td style="width: 12%;">&nbsp;</td>
                                <td style="width: 18%;">&nbsp;</td>
                                <td style="width: 10%;">&nbsp;</td>
                                <td style="width: 35%; padding-left: 1px;">&nbsp;</td>
                                <td style="width: 25%;">&nbsp;</td>
                            </tr> 
                        @endif                

                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>{{-- Horas de vuelo --}}
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>8. HORAS DE VUELO ANUAL</strong></u></div>
            <div>
                <table id="sanciona">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 12%;">Fecha</th>
                            <th rowspan="2" style="width: 12%;">Nro. de Documento</th>
                            <th rowspan="2" style="width: 10%;">Hrs. Total</th>
                            <th colspan="6" style="width: 20%;">Funcion</th>
                            <th rowspan="2" style="width: 20%;">Aeronave</th>
                        </tr>
                        <tr>
                            <td style="background-color: #D1D7E3; ">AV</td>
                            <td style="background-color: #D1D7E3; ">INST</td>
                            <td style="background-color: #D1D7E3; ">CAV</td>
                            <td style="background-color: #D1D7E3; ">NAV</td>
                            <td style="background-color: #D1D7E3; ">SAV</td>
                            <td style="background-color: #D1D7E3; padding: 1px;">NAV</td>
                            
                            
                        </tr>
                    </thead>
                    <tbody >
                        <tr>
                            <td style="width: 12%;">&nbsp;</td>
                            <td style="width: 18%;">&nbsp;   </td>
                            <td style="width: 10%;">&nbsp;   </td>
                            <td style="width: 5%;">&nbsp;  </td>
                            <td style="width: 5%;">&nbsp;  </td>
                            <td style="width: 5%;">&nbsp;  </td>
                            <td style="width: 5%;">&nbsp;  </td>
                            <td style="width: 5%;">&nbsp;  </td>
                            <td style="width: 5%;">&nbsp;  </td>
                            <td style="width: 10%;">&nbsp; </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>{{-- Revistas Militares --}}
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>9. REVISTAS MILITARES</strong></u></div>
            <div>
                <table id="sanciona">
                    <thead>
                        <tr>
                            <th>FECHA</th>
                            <th>FUNCION</th>
                            <th>UNIDAD</th>
                            <th>COMPAÑIA / ESCALAFÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($revistas) > 0)
                            @foreach ($revistas as $item)
                                <tr>
                                    <td style="width: 12%;">{{$item->fecha}}</td>
                                    <td style="width: 28%;">{{$item->funcion}}</td>
                                    <td style="width: 30%;">{{$item->lugar}}</td>
                                    <td style="width: 30%;">{{$item->compania}}</td>
                                </tr> 
                            @endforeach
                        @else
                            <tr>
                                <td style="width: 12%;">&nbsp;</td>
                                <td style="width: 28%;">&nbsp;</td>
                                <td style="width: 30%;">&nbsp;</td>
                                <td style="width: 30%;">&nbsp;</td>
                            </tr> 
                        @endif                                  

                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>{{-- Guia de interpretacion --}}
            <div style="padding-bottom: 5px; font-size: 14px;"><strong><center>GUIA DE INTERPRETACION Y CALIFICACION</center></strong></div>
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>1. CALIFICACIÓN OBJETIVA:</strong></u></div>
            <p>ESCALA DE CALIFICACIONES (LOS COLORES SON NETAMENTE REFERENCIALES)</p>
            <table id="escala">
                <tbody>
                    <tr>
                        <td style="width: 15%;">100</td>
                        <td style="width: 23%;">Excepcional</td>
                        <td style="width: 12%; background-color: blue"></td>
                        <td style="width: 15%;">50 a 59</td>
                        <td style="width: 23%;">Deficiente</td>
                        <td style=" width: 12%;background-color: rgb(255, 81, 0)"></td>
                    </tr>
                    <tr>
                        <td>90 a 99</td>
                        <td>Excelente</td>
                        <td style="background-color: rgb(0, 255, 76)"></td>
                        <td>40 a 49</td>
                        <td>Malo</td>
                        <td style="background-color: rgb(255, 102, 0)"></td>
                    </tr>
                    <tr>
                        <td>80 a 89</td>
                        <td>Muy Bueno</td>
                        <td style="background-color: green"></td>
                        <td>30 a 39</td>
                        <td>Muy Malo</td>
                        <td style="background-color: rgb(255, 136, 0)"></td>
                    </tr>
                    <tr>
                        <td>70 a 79</td>
                        <td>Bueno </td>
                        <td style="background-color: orange"></td>
                        <td>10 a 29</td>
                        <td>No apto para el servicio</td>
                        <td style="background-color: red"></td>
                    </tr>
                    <tr>
                        <td>60 a 69</td>
                        <td>Regular</td>
                        <td style="background-color: yellow"></td>
                        <td>0</td>
                        <td>Ausente</td>
                        <td style="background-color: white"></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <span>Se califica el desempeño anual en las siguientes áreas:</span>
                <div><strong>- Formacion para el trabajo:</strong>Si tiene los conocimientos necesarios para el desempeño de sus actuales funciones.</div>
                
                <div><strong>- Adaptacion al Trabajo Colectivo:</strong>Como trabaja y se conduce con su grupo.</div>
                
                <div><strong>- Iniciativa:</strong>Como se conduce sin supervisión y si aporta ideas para mejorar el rendimiento.</div>
                
                <div><strong>- Responsabilidad:</strong>Si acepta y desarrolla las funciones asignadas, si administra bien sus recursos personales.</div>
                
                <div><strong>- Raciocinio y Criterio: </strong>Facilidad y acierto con que toma sus decisiones, manera como rinde en condiciones difíciles y bajo tensión.</div>
                
                <div><strong>- Facilidad Comunicativa: </strong>Facilidad para expresar sus ideas verbalmente y por escrito.</div>
                
                <div><strong>- Liderazgo y Ascendiente: </strong>Tanto por parte de los subalternos como de sus camaradas y superiores.</div>
                
                <div><strong>- Espíritu Militar:</strong>Apego a la institución y vivencia de sus prácticas.</div>
                
                <div><strong>- Disciplina:</strong>Acatamiento e imposición de las normas militares.</div>
                
                <div><strong>- Espíritu de Superación: </strong>Si tiene inquietud para superarse ampliando sus conocimientos y capacidad.</div>
                
                <div><strong>- Conducta Militar y Civil:</strong>Comportamiento militar y social.</div>
                
                <div><strong>- Aptitud Física y Deportiva:</strong>Práctica de deportes, exceso o deficiencia de peso, vicios perjudiciales.</div>
                
            </div>
            <br>
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>2. CALIFICACIÓN CONCEPTUAL:</strong></u> En escala de 0 a 100.</div>
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>3. PROMEDIO CONCEPTUAL:</strong></u> La media aritmetica de las calificaciones parciales.</div>
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>4. PROMERIO GENERAL:</strong></u> La media aritmetica de las calificaciones objetiva y conceptual.</div>
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>5. NOTIFICACIÓN:</strong></u> El calificado dee ser notificado bajo su firma entregandosele una copia.</div>
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>6. DESIGNACIONES Y NOMBRAMIENTOS:</strong></u> Tanto las internas de la Unidad y recibidos por la superioridad.</div>
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>7. SANCIONES DISCIPLINARIAS:</strong></u> Todas las impuestas durante la gestion.</div>
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>8. HORAS DE VUELO:</strong></u> Total de horas acumuladas en la gestion.</div>
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>9. REVISTAS MILITARES:</strong></u> Revistas realizadas en la gestion.</div>
            <br>
        </section>
        <section>

        </section>
        
        <footer>
            <div style="text-align: justify; width: 80%;">
                <span>Nota:</span>
                <ul>
                    <li>Las notas mayores de 90 y menores de 30 se justificaran en la Calificacion Conceptual. (numeral 2)</li>
                    <li>La Calificacion de 100 Excecpcional deberá justificar con un informe.</li>
                </ul>
            </div>
            
            <div style="position: fixed; bottom: 100px; right: 40px; width: 113.4px; height: 113.4px; border: 0px solid;">
                {{-- <p style="text-align: center; padding-top: 30px;">Foto <br> 3 x 3</p> --}}
                <img src="data:image/png;base64, {{!! base64_encode($qrband) !!}}">
            </div>
            
        </footer>
    </body>
</html>