<?php
use Dompdf\Dompdf; //para incluir el namespace de la librería
 
 $dompdf = new Dompdf(); //crear el objeto de la clase Dompdf
//panorámico en A4
//$dompdf->setPaper('A4', 'landscape');
//$dompdf->setPaper( array(0, 0, 595.28, 841.89)); //x inicio, y inicio, ancho final, alto final
//$dompdf->setPaper(array(0, 0, 612.00, 935.433), 'landscape');
$dompdf->setPaper(array(0,0,612.00,1008.00), 'portrait');

?>

<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <title>Reporte user</title>
    <style>
        html {
            /*margin: 50pt 15pt;*/
            margin: 20pt 25pt;/*SUPERIOR INFERIOR Y DERECHA IZQUIERDA*/
            

        }

        body {
        /*position: relative;*/
         /* width: 21.6cm;   
        height: 37cm;*/
        margin: 0 auto;
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 12.3px;
        /*font-family: SourceSansPro;*/
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
    <body>
        <header>
            <div style="text-align: center; width: 180px; font-size: 11.5px;">
                <p style="margin: 0px">FUERZA AÉREA BOLIVIANA</p>
                  <p style="margin: -5px 0px">DEPARTAMENTO I - PERSONAL</p>
                  <p style="margin: -5px 0px;"><u><strong>BOLIVIA</strong></u></p>
            </div>
            <div style="position: absolute; top: 0px; right: 0px; width: 113.4px; height: 113.4px; border: 1px solid;">
                <p style="text-align: center; padding-top: 30px;">Foto <br> 3 x 3</p>
            </div>
            <div style="padding-top: 30px; padding-bottom: 10px; text-align: center; font-size: 14px; font-weight: bold;">
                <p style="margin: 1px">FOJAS DE CONCEPTO</p>
                <p style="margin: -6px 8px 4px 0px">(ESCALAFÓN: OFICIALES SUPERIORES Y SUBALTERNOS)</p>
            </div>
         </header>
        <section> {{-- Datos del evaluado --}}
            <div>
                <table style="padding: 3px; background: #ffffff; width: 100%;">
                    <tbody>
                        <tr style="padding: 1px;">
                            <td style="width: 45%;">
                                <strong>CM:</strong>{{$usuario->cm}}
                            </td>
                            <td style="width: 55%;">
                                <strong>GRADO Y NOMBRE:</strong> {{$usuario->grado}} {{$usuario->complemento}} {{$usuario->nombre}} {{$usuario->paterno}} {{$usuario->materno}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 45%;">
                                <strong>ESPECIALIDAD:</strong>SISTEMAS ELECTRICOS
                            </td>
                            <td style="width: 55%;">
                                <strong>DESTINO:</strong>{{$usuario->destino}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                @foreach ($fechaEvaluacion as $item )
                                <strong>PERIODO DE CALIFICACIÓN:</strong>{{$item->inicio}} al {{$item->fin}}
                                @endforeach
                                
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </section>
        <br>
        <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>1. CALIFICACIÓN OBJETIVA</strong></u></div>
        <section> {{-- calificacion objetiva --}}
            <div>
                <table id="calobj">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 65%;"><center>DETALLE</center> </th>
                            <th colspan="4" style="width: 45%;"><center>CALIFICACIONES <br> Primer semestre</center></th>
                        </tr>
                        <tr>
                            <td ><center>1ra.</center></td>
                            <td ><center>2da.</center></td>
                            <td ><center>3ra.</center></td>
                            <td ><center>Promedio</center></td>
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
        <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>2. CALIFICACIÓN CONCEPTUAL</strong></u></div>
        <section> {{-- calificacion objetiva --}}
            <div>
                <table id="calconc">{{-- jefe de personal --}}
                    <thead>
                        <tr>
                            <th colspan="4" style="background-color: #D1D7E3">1ra. Calificación del Comando de Escuadrón o Jefe de Sección</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="height:30px; font-size: 10px;"><i> {{$conceptual1['literal']}} </i></td>
                        </tr>
                        <tr>
                            <td style="width: 36%;">Calificacion Conceptual Numérica</td>
                            <td style="width: 17%;">{{$conceptual1['numerica']}}</td>
                            <td style="width: 12%; padding-left: 1px;">Firma</td>
                            <td style="width: 35%;"></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="color: red">Cap. DA. Elmer Hermosa Barrera         JEFE DE PERSONAL</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="4">Grado, Nombre, Apellido y Cargo del Superior Calificador</td>
                        </tr> --}}
                        

                    </tbody>
                </table>
                <table id="calconc">{{-- 2do comandante --}}
                    <thead>
                        <tr>
                            <th colspan="4" style="background-color: #D1D7E3">2da. Calificación del Segundo Comandante o Sub-Jefe de Sección de Departamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="height:30px; font-size: 10px;"><i>{{$conceptual2['literal']}}</i></td>
                        </tr>
                        <tr>
                            <td style="width: 36%;">Calificacion Conceptual Numérica</td>
                            <td style="width: 17%;">{{$conceptual2['numerica']}}</td>
                            <td style="width: 12%; padding-left: 1px;">Firma</td>
                            <td style="width: 35%;"></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="color: red">My. DEMA. Alex Silva Gutierrez      SEGUNDO COMANDANTE GADA "91"</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="4">Grado, Nombre, Apellido y Cargo del Superior Calificador</td>
                        </tr> --}}
                    </tbody>
                </table>
                <table id="calconc">{{-- Comandante --}}
                    <thead>
                        <tr>
                            <th colspan="4" style="background-color: #D1D7E3">3er. Calificación del Comandante o Jefe de Departamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="height:30px; font-size: 10px;"><i>{{$conceptual3['literal']}}</i></td>
                        </tr>
                        <tr>
                            <td style="width: 36%;">Calificacion Conceptual Numérica</td>
                            <td style="width: 17%;">{{$conceptual3['numerica']}}</td>
                            <td style="width: 12%; padding-left: 1px;">Firma</td>
                            <td style="width: 35%;"></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="color: red">Tcnl. DAEN. Juan Gomez Orellana         COMANDANTE GADA "91"</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="4">Grado, Nombre, Apellido y Cargo del Superior Calificador</td>
                        </tr> --}}
                    </tbody>
                </table>
                <br>
                <table style="width: 100%; border-spacing: 0; margin-bottom: 5px;">{{-- promedio conceptual --}}
                    <thead>
                        <tr>
                            <th colspan="2" style="background-color: #D1D7E3; border: 1px solid #000;" style="width: 40%; font-size: 13px;">3. Promedio Conceptual</th>
                            <th style="width: 20%;"></th>
                            <th colspan="2" style="background-color: #D1D7E3; border: 1px solid #000;" style="width: 40%; font-size: 13px;">4. Promedio General</th>
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
                            <td style="border: 1px solid #000;"><center>{{$promedioConceptual}}</center></td>promedioConceptual
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
            </div>
        </section>
        <br>
        <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>5. DESIGNACIONES Y NOMBRAMIENTOS</strong></u></div>
        <section>{{-- tabla designa --}}
            <div>
                <table id="designa">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Clase y Nro. de Documento</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
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
        <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>6. SANCIONES DISCIPLINARIAS</strong></u></div>
        <section>{{-- tabla sanciona --}}
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

            <div style="padding-bottom: 5px; font-size: 14px;"><strong><center>GUIA DE INTERPRETACION Y CALIFICACION</center></strong></div>
            <div style="padding-bottom: 4px; font-size: 13px;"><u><strong>1. CALIFICACIÓN OBJETIVA</strong></u></div>
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

            
            <span>Se califica el desempeño anual en las siguientes áreas:</span>
            <div><strong>- Formacion para el trabajo:</strong></div>
            Si tiene los conocimientos necesarios para el desempeño de sus actuales funciones.
            <div><strong>- Adaptacion al Trabajo Colectivo:</strong></div>
            Como trabaja y se conduce con su grupo.
            <div><strong>- Iniciativa:</strong></div>
            Como se conduce sin supervisión y si aporta ideas para mejorar el rendimiento.
            <div><strong>- Responsabilidad:</strong></div>
            Si acepta y desarrolla las funciones asignadas, si administra bien sus recursos personales.
            <div><strong>- Raciocinio y Criterio: </strong></div>
            Facilidad y acierto con que toma sus decisiones, manera como rinde en condiciones difíciles y bajo tensión.
            <div><strong>- Facilidad Comunicativa: </strong></div>
            Facilidad para expresar sus ideas verbalmente y por escrito.
            <div><strong>- Liderazgo y Ascendiente: </strong></div>
            Tanto por parte de los subalternos como de sus camaradas y superiores.
            <div><strong>- Espíritu Militar:</strong></div>
            Apego a la institución y vivencia de sus prácticas.
            <div><strong>- Disciplina:</strong></div>
            Acatamiento e imposición de las normas militares.
            <div><strong>- Espíritu de Superación: </strong></div>
            Si tiene inquietud para superarse ampliando sus conocimientos y capacidad.
            <div><strong>- Conducta Militar y Civil:</strong></div>
            Comportamiento militar y social.
            <div><strong>- Aptitud Física y Deportiva:</strong></div>
            Práctica de deportes, exceso o deficiencia de peso, vicios perjudiciales.




        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>Grdd</b></p>
            </div>
        </footer>
    </body>
</html>