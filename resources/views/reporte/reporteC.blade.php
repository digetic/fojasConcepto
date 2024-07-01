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
            <!-- <div style="position: absolute; top: 20px; right: 40px; width: 113.4px; height: 113.4px; border: 1px solid;">
                <img src={{$foto}} width="100%" height="100%">
            </div> -->
            <div style="padding-top: 30px; padding-bottom: 10px; text-align: center; font-size: 14.5px; font-weight: bold;">
                <p style="margin: 1px">FOJAS DE CONCEPTO</p>
                <p style="margin: -2px 8px 4px 0px">(ESCALAFÓN: SERVICIOS Y CIVIL)</p>
            </div>
         </header>
		<br>
        <section> {{-- Datos personales --}}
                
                 <table style=" background: #ffffff; width: 100%;">
                    <tbody>
                        <tr>
                            <td style="width: 40%;">
                                <strong>GRADO: </strong> <span >{{$usuario1->graCom}}</span> 
                            </td>
                            <td style="width: 60%;">
                                <strong>APELLIDOS Y NOMBRES: </strong> <span>{{$usuario2->paterno}} {{$usuario2->materno}} {{$usuario2->nombre}}</span> 
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <strong>CARNET MILITAR:</strong> <span >{{$usuario2->cm}}</span> 
                            </td>
                            <td style="width: 60%;">
                                <?php
                                    $date1 = date_create($fechaEvaluacion->inicio);
                                    $fechaasc1 = date_format($date1,"d/m/Y");
                                    $date2 = date_create($fechaEvaluacion->fin);
                                    $fechaasc2 = date_format($date2,"d/m/Y");
                        
                                ?>
                                <strong>PERIODO DE CALIFICACIÓN:</strong> <span ><?php echo $fechaasc1; ?> AL <?php echo $fechaasc2; ?></span> 
                            </td>
                            
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <strong>ESPECIALIDAD:</strong> <span >{{$usuario2->esp}} </span> 
                            </td>
                            <td style="width: 60%;">
                                <strong>SUBESPECIALIDAD:</strong> <span >{{$usuario2->subespe}}</span> 
                            </td>
                            
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 100%;">
                                <strong>DESTINO:</strong> <span >{{$usuario2->destino}}</span> 
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
                            <th rowspan="2" style="width: 65%; background-color: #D1D7E3;"><center>DETALLE</center> </th>
                            <th colspan="4" style="width: 45%; background-color: #D1D7E3;"><center>CALIFICACIONES</center></th>
                        </tr>
                        <tr>
                            <td style="text-align: center; background-color: #D1D7E3;">1ra.</td>
                            <td style="text-align: center; background-color: #D1D7E3;">2da.</td>
                            <td style="text-align: center; background-color: #D1D7E3;">3ra.</td>
                            <td style="text-align: center; background-color: #D1D7E3;">Promedio</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notas as $item)
                            <tr>
                                <td >{{$item['pre']}}</td>
                                <td ><center>{{$item['n1']}}</center></td>
                                <td ><center>{{$item['n2']}}</center></td>
                                <td ><center>{{$item['n3']}}</center></td>
                                <?php
                                        $promedioObjetivoIndividual = number_format($item['promedio'],2);
                            
                                    ?>
                                <td ><center><?php echo $promedioObjetivoIndividual; ?></center></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" style="background-color: #D1D7E3;">Promedio Objetivo</td>
                            <?php
                                $promedioObjetivo = number_format($promedioObjetiva,2);
                    
                            ?>
                            <td 
                            {{-- @php
                                if ($promedioObjetivo >= 70) {
                                    echo ' style=" color: green;"';
                                }
                                if ( $promedioObjetivo < 70 && $promedioObjetivo >= 50) {
                                    echo ' style=" color: yellow;"';
                                }
                                if ( $promedioObjetivo < 50 && $promedioObjetivo >= 0) {
                                    echo ' style=" color: red;"';
                                }
                            @endphp --}}
                            ><center><?php echo $promedioObjetivo; ?></center></td>
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
                            <th colspan="4" style="background-color: #D1D7E3; text-align: left; padding: 4px 3px;">1ra. CALIFICACIÓN {{$conceptual1['cargo']}} </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="height:30px; font-size: 10px; "><i> {{$conceptual1['literal']}} </i></td>
                        </tr>
                        <tr>
                            <td style="width: 37%;">Calificacion Conceptual Numérica</td>
                            <td style="width: 25%; text-align: center;">{{$conceptual1['numerica']}}</td>
                            <td style="width: 8%; padding: 7px 3px; text-align: center" rowspan="2">Firma</td>
                            <td style="width: 30%;" rowspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="2">{{$conceptual1['evaluador']}}</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="4">Grado, Nombre, Apellido y Cargo del Superior Calificador</td>
                        </tr> --}}
                        

                    </tbody>
                </table>
                <table id="calconc">{{-- 2do comandante --}}
                    <thead>
                        <tr>
                            <th colspan="4" style="background-color: #D1D7E3; text-align: left; padding: 4px 3px; ">2da. CALIFICACIÓN {{$conceptual2['cargo']}} </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="height:30px; font-size: 10px; "><i>{{$conceptual2['literal']}}</i></td>
                        </tr>
                        <tr>
                            <td style="width: 37%;">Calificacion Conceptual Numérica</td>
                            <td style="width: 25%; text-align: center;">{{$conceptual2['numerica']}}</td>
                            <td style="width: 8%; padding: 7px 3px; text-align: center" rowspan="2">Firma</td>
                            <td style="width: 30%;" rowspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="2"> {{$conceptual2['evaluador']}}</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="4">Grado, Nombre, Apellido y Cargo del Superior Calificador</td>
                        </tr> --}}
                    </tbody>
                </table>
                <table id="calconc">{{-- Comandante --}}
                    <thead>
                        <tr>
                            <th colspan="4" style="background-color: #D1D7E3; text-align: left; padding: 4px 3px;">3er. CALIFICACIÓN {{$conceptual3['cargo']}} </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="height:30px; font-size: 10px; "><i>{{$conceptual3['literal']}}</i></td>
                        </tr>
                        <tr>
                            <td style="width: 37%;">Calificacion Conceptual Numérica</td>
                            <td style="width: 25%; text-align: center;">{{$conceptual3['numerica']}}</td>
                            <td style="width: 8%; padding: 7px 3px; text-align: center" rowspan="2">Firma</td>
                            <td style="width: 30%;" rowspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="2">{{$conceptual3['evaluador']}}</td>
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
                            <th colspan="2" style="background-color: #D1D7E3; border: 1px solid #000; font-size: 13px; padding: 4px 3px; text-align: left;">3. PROMEDIO CONCEPTUAL</th>
                            <th style="width: 20%;"></th>
                            <th colspan="2" style="background-color: #D1D7E3; border: 1px solid #000; font-size: 13px; padding: 4px 3px; text-align: left;">4. PROMEDIO GENERAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $promedioConceptual1 = number_format($promedioConceptual,2);
                    
                            ?>
                        <tr>
                            <td style="border: 1px solid #000;">Primera</td>
                            <td style="border: 1px solid #000;"><center>{{$conceptual1['numerica']}}</center></td>
                            <td ></td>
                            <td style="border: 1px solid #000;">Promedio Objetivo</td>
                            <td style="border: 1px solid #000;"><center><?php echo $promedioObjetivo; ?></center></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">Segunda</td>
                            <td style="border: 1px solid #000;"><center>{{$conceptual2['numerica']}}</center></td>
                            <td></td>
                            <td style="border: 1px solid #000;">Promedio Conceptual</td>
                            <td style="border: 1px solid #000;"><center><?php echo $promedioConceptual1; ?></center></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">Tercera</td>
                            <td style="border: 1px solid #000;"><center>{{$conceptual3['numerica']}}</center></td>
                            <td></td>
                            <td style="border: 1px solid #000;"><strong>Nota Semestral:</strong></td>
                            <?php
                                $notaFinal1 = number_format($notaFinal,2);
                    
                            ?>
                            <td 
                            {{-- @php
                                if ($notaFinal1 >= 70) {
                                    echo ' style=" border: 1px solid #000; color: green;"';
                                }
                                if ( $notaFinal1 < 70 && $notaFinal1 >= 50) {
                                    echo ' style=" border: 1px solid #000; color: yellow;"';
                                }
                                if ( $notaFinal1 < 50 && $notaFinal1 >= 0) {
                                    echo ' style=" border: 1px solid #000; color: red;"';
                                }
                            @endphp --}}
                            style=" border: 1px solid #000;"><center><?php echo $notaFinal1; ?></center></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;"><strong>Promedio Conceptual:</strong></td>
                            <td  
                            {{-- @php
                                if ($promedioConceptual1 >= 70) {
                                    echo ' style=" border: 1px solid #000; color: green;"';
                                }
                                if ( $promedioConceptual1 < 70 && $promedioConceptual1 >= 50) {
                                    echo ' style=" border: 1px solid #000; color: yellow;"';
                                }
                                if ( $promedioConceptual1 < 50 && $promedioConceptual1 >= 0) {
                                    echo ' style=" border: 1px solid #000; color: red;"';
                                }
                            @endphp --}}
                            style=" border: 1px solid #000;"><center><?php echo $promedioConceptual1; ?></center></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                    </tbody>
                </table>
        </section>
        <section>{{-- Notificacion firma --}}
            <div style="font-size: 13px; padding-top: 10px; padding-bottom:20px;"><u><strong>5. NOTIFICACIÓN</strong></u></div>
            <table style="width: 100%; border-collapse: collapse; border-spacing: 0; border: black 1px ; margin-bottom: 5px;">{{-- promedio conceptual --}}
                <thead>
                    <tr>
                        <th colspan="2" style="  font-size: 12.5px; padding: 4px 3px; text-align: left; text-align: center;">{{$usuario1->graCom}} {{$usuario2->paterno}} {{$usuario2->materno}} {{$usuario2->nombre}}</th>
                        <th style="width: 2%;"></th>
                        <th colspan="2" style="  font-size: 12.5px; padding: 4px 3px; text-align: left;"><hr></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 12px;"></td>
                        <td ></td>
                        <td colspan="2" style="text-align: center; font-size: 12px;">FIRMA</td>
                    </tr>
                </tbody>
            </table>
            <div style="font-size: 12px; padding-top: 0px; text-align: right;"><i><strong>Lugar y Fecha:</strong>  {{$depa}}, {{$fecha}}</i></div>
        </section>
        <div class="page-break"></div> {{-- SALTO DE PAGINA --}}

        <br>
        <section>{{-- tabla designa --}}
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>6. DESIGNACIONES Y NOMBRAMIENTOS</strong></u></div>
            <div>
                <table id="designa">
                    <thead>
                        <tr>
                            <th style="width: 12%;">Fecha</th>
                            <th style="width: 28%;">Clase y Nro. de Documento</th>
                            <th style="width: 60%;">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($designaciones) > 0)
                            @foreach ($designaciones as $item)
                                <tr>
                                    <?php
                                        $date = date_create($item->fecha);
                                        $fechaasc = date_format($date,"d/m/Y");
                            
                                    ?>
                                    <td style="text-align: center"><?php echo $fechaasc; ?></td>
                                    <td style="text-align: center"> {{$item->ndoc}} - {{$item->doc}}</td>
                                    <td style="padding-left: 10px;">{{$item->desc}}</td>
                                </tr>
                            @endforeach  
                        @else
                        <tr>
                            <td style="">&nbsp;    </td>
                            <td style="">&nbsp;    </td>
                            <td style="padding-left: 1px;"> &nbsp;  </td>
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
                            <th style="width: 12%;">Fecha</th>
                            <th style="width: 28%;">Clase y Nro. de Documento</th>
                            <th style="width: 10%;">Tiempo</th>
                            <th style="width: 18%;">Sanción</th>
                            <th style="width: 32%;">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($sanciones) > 0)
                            @foreach ($sanciones as $item)
                                <tr>
                                    <?php
                                        $date = date_create($item->fecha);
                                        $fechaasc = date_format($date,"d/m/Y");
                            
                                    ?>
                                    <td style="text-align: center"><?php echo $fechaasc; ?></td>
                                    <td style="text-align: center"> {{$item->ndoc}} - {{$item->documento}}</td>
                                    <td style="text-align: center">{{$item->dias}}</td>
                                    <td style=" padding-left: 10px;">{{$item->sancion}}</td>
                                    <td style="font-size: 8px;">{{$item->falta2}}</td>
                                </tr> 
                            @endforeach
                        @else
                            <tr>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td>
                                <td style=" padding-left: 1px;">&nbsp;</td>
                                <td style="">&nbsp;</td>
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
            <p>ESCALA DE CALIFICACIONES (en escala de 0 a 100): 100 Excepcional; 90 a 99 Excelente; 80 a 89 Muy Bueno; 70 a 79 Bueno; 60 a 69 Regular; 50 a 59 Deficiente; 40 a 49 Malo; 30 a 39 Muy Malo; 10 a 29 No apto para el servicio; 0 Ausente.</p>
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
        
        <footer> {{-- QR --}}
            <div style="text-align: justify; width: 80%;">
                <span>Nota:</span>
                <ul>
                    <li>Las Calificaciones de 100 y menores de 30 se deberá justificar con un informe.</li>
                </ul>
            </div>
            
            <div style="position: fixed; bottom: 100px; right: 40px; width: 113.4px; height: 113.4px; border: 0px solid;">
                {{-- <p style="text-align: center; padding-top: 30px;">Foto <br> 3 x 3</p> --}}
                <img src="data:image/png;base64, {{!! base64_encode($qrband) !!}}">
            </div>
            
        </footer>
    </body>
</html>