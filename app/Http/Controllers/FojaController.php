<?php

namespace App\Http\Controllers;

use App\CalificacionConceptual;
use App\CalificacionObjetiva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use  Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use stdClass;

class FojaController extends Controller
{
    public function guardarNota(Request $request)
    {
        try {
            DB::beginTransaction();

            CalificacionConceptual::create([
                'idjuradoPersonal' => $request->jpid,
                'literal' => $request->literal,
                'numerica' => $request->numerica
            ]);

            $preObj = $request->preguntasCal;
            $notObj = $request->notasObje;
            $cont = 0;
            while ($cont < count($preObj)) {

                CalificacionObjetiva::create([
                    'iddetalleObjetiva' => $preObj[$cont],
                    'idjuradoPersonal' => $request->jpid,
                    'nota' => $notObj[$cont]
                ]);
                
                $cont++;
            }
            DB::table('jurado_personals')
            ->where('id',$request->jpid)
            ->update([
                'estado' => 0
            ]);

            DB::commit();
            return response()->json([
                'code' => 200
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 400
            ]);
        }
    }

    public function EstadoImpresion(Request $request)
    {
        $evaluacion = new EvaluacionController();
        $eva = $evaluacion->EvaluacionActual();
        //variable para saber si existe el personal en la tabla jurado_personal
        $perjur = DB::table('jurado_personals')->where('idpersonal', $request->per_codigo)->where('evaluacion',$eva)->exists();

        if ($eva != 0) {
            if ($perjur) {//Evaluaciones asignadas            
                //variable para saber la cantidad de evaluaciones terminadas
                $evat = new EvaluacionController();
                $evater = $evat->NumEvaluacionesTerminadas($request->per_codigo, $eva);
                // //variable para saber la cantidad de evaluaciones no terminadas
                $evant = new EvaluacionController();
                $evanter = $evant->NumEvaluacionNoTerminadas($request->per_codigo, $eva);

                if( $evater > 0 && $evanter == 0){
                    //Evaluaciones Terminadas
                    return response()->json([
                        "code"=> 200,
                        "estado"=> 1
                    ]);
                }else{
                    //Evaluaciones no terminadas
                    return response()->json([
                        "code"=> 200,
                        "estado" => 0
                    ]);
                }
            } else {//No exite una evaluacion asignada             
                return response()->json([
                    "code"=> 401
                ]);
            }  
        } else {
            return response()->json([
                "code"=> 401
            ]);
        }

        
    }



        /**
     * Funcion que muestra las notas de las evaluaciones terminadas
     */

    public function DatosFoja($id, $d,$depa,$eva)
    {
        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $conc = new stdClass();
        $conc->literal = 'vacio';
        $conc->numerica = 0;
        $json = json_encode($conc);
         //Evaluacion Actual
        $actual = new EvaluacionController();
        // $eva = $actual->EvaluacionActual();        
        //nuemro de evalauciones calificadas
        $neva = $actual->NumEvaluacionesTerminadas($id, $eva);
        //Preguntas Objetivas
        // $preguntas = new PreguntasController();
        // $pregun = $preguntas->preguntasObjetivasImp($d);
        //Datos del Evaluado
        $personal = DB::table('jurado_personals as jp')
                ->join('personals as p','p.per_codigo', 'jp.idpersonal')
                ->join('personal_especialidades as pe','p.per_codigo','pe.per_codigo')
                ->join('especialidades as e','pe.espe_cod','e.id')
                ->join('subespecialidades as se','pe.subespe_cod','se.id')
                ->join('nivel4_destinos as d4','d4.id','jp.dest4')
                ->join('nivel3_destinos as d3', 'd4.d3_cod','d3.id')
                ->select('p.per_foto as foto','p.per_nombre as nombre', 'p.per_paterno as paterno', 'p.per_materno as materno', 'jp.graCom','jp.cargo','d3.descripcion as destino','jp.division', 'p.per_cm as cm','e.nombre as esp','se.nombre as subespe')
                ->where('jp.idpersonal',$id)
                ->where('jp.evaluacion',$eva)
                ->first();

        
        //Desginaciones del Evaluado
        $designaciones = $this->listarDesignacionesImp($id, $eva);
        //Sanciones del Evaluado
        $sanciones = $this->listarSancionesImp($id, $eva);
        //Revistas del Evaluado
        $revistas = $this->listarRevista($id, $eva);
        //Fecahs del Periodo de Evaluacion
        $fechaEvaluacion = $this->FechaEvalaucion($eva);
        //Evaluaciones calificadas
        $evalu = $this->EvaluacionCalificada($id, $eva);
        foreach ($evalu as $key => $value) { //Array con las evaluaciones termiandas  
            $obj[$key] = $value->id;
        }        
        
        $c = 0;
        $p = 0;
        if ($neva == 1) {
            $cocep1 = $this->NotaConceptual($obj[0]);
            $conc1 = ['literal'=>$cocep1->literal, 'numerica'=>$cocep1->numerica, 'evaluador'=>$cocep1->grado.' '.$cocep1->nombre.' '.$cocep1->paterno.' '.$cocep1->materno.' - '.$cocep1->cargo];
            $conc2 = ['literal'=>'', 'numerica'=>'-', 'evaluador'=>' - '];
            $conc3 = ['literal'=>'', 'numerica'=>'-', 'evaluador'=>' - '];
            $proConcep = $cocep1->numerica;
            $nota1 = $this->NotasObjetivasList($obj[0]);
            foreach ($nota1 as $key => $value) {
                $notas[$key] = array('pre' => $value->detalle,'n1' => $value->nota, 'n2' => '-', 'n3' => '-', 'promedio' =>  $value->nota);
                $c  += 1;
                $p = $p + $value->nota;
            }
           $proObjetiva = round($p/$c,2);
        }
        if ($neva == 2) {
            $cocep1 = $this->NotaConceptual($obj[0]);
            $cocep2 = $this->NotaConceptual($obj[1]);
            $nota1 = $this->NotasObjetivasList($obj[0]);
            $nota2 = $this->NotasObjetivasList($obj[1]);
            $conc1 = ['literal'=>$cocep1->literal, 'numerica'=>$cocep1->numerica, 'evaluador'=>$cocep1->grado.' '.$cocep1->nombre.' '.$cocep1->paterno.' '.$cocep1->materno.' - '.$cocep1->cargo];
            $conc2 = ['literal'=>$cocep2->literal, 'numerica'=>$cocep2->numerica, 'evaluador'=>$cocep2->grado.' '.$cocep2->nombre.' '.$cocep2->paterno.' '.$cocep2->materno.' - '.$cocep2->cargo];
            $proConcep = round(($cocep1->numerica + $cocep2->numerica) / 2, 2);
            $conc3 = ['literal'=>'', 'numerica'=>'-', 'evaluador'=>' - '];
            foreach ($nota1 as $key => $value) {
                $promedio =  ($value->nota +  $nota2[$c]->nota) / 2;
                $notas[$key] = array('pre' => $value->detalle,'n1' => $value->nota, 'n2' => $nota2[$c]->nota, 'n3' => '-', 'promedio' =>  $promedio);
                $c  += 1;
                $p = $p + $promedio;
            }
           $proObjetiva = round($p/$c,2);
        }
        if ($neva == 3) {
            $cocep1 = $this->NotaConceptual($obj[0]);
            $cocep2 = $this->NotaConceptual($obj[1]);
            $cocep3 = $this->NotaConceptual($obj[2]);
            $conc1 = ['literal'=>$cocep1->literal, 'numerica'=>$cocep1->numerica, 'evaluador'=>$cocep1->grado.' '.$cocep1->nombre.' '.$cocep1->paterno.' '.$cocep1->materno.' - '.$cocep1->cargo];
            $conc2 = ['literal'=>$cocep2->literal, 'numerica'=>$cocep2->numerica, 'evaluador'=>$cocep2->grado.' '.$cocep2->nombre.' '.$cocep2->paterno.' '.$cocep2->materno.' - '.$cocep2->cargo];
            $conc3 = ['literal'=>$cocep3->literal, 'numerica'=>$cocep3->numerica, 'evaluador'=>$cocep3->grado.' '.$cocep3->nombre.' '.$cocep3->paterno.' '.$cocep3->materno.' - '.$cocep3->cargo];
            $proConcep = round(($cocep1->numerica + $cocep2->numerica + $cocep3->numerica) / 3, 2);
            $nota1 = $this->NotasObjetivasList($obj[0]);
            $nota2 = $this->NotasObjetivasList($obj[1]);
            $nota3 = $this->NotasObjetivasList($obj[2]);
            foreach ($nota1 as $key => $value) {
                $promedio =  ($value->nota +  $nota2[$c]->nota + $nota3[$c]->nota) / 3;
                $notas[$key] = array('pre' => $value->detalle,'n1' => $value->nota, 'n2' => $nota2[$c]->nota, 'n3' => $nota3[$c]->nota, 'promedio' =>  $promedio);
                $c  += 1;
                $p = $p + $promedio;
            }
            $proObjetiva = round($p/$c,2);
        }

        switch ($d) {
            case 1:
                $doc = 'reporte.reporteOOSS';
                break;
            case 2:
                $doc = 'reporte.reporteSSSS';
                break;
            case 3:
                $doc = 'reporte.reporteSSSS';
                break;
            case 4:
                $doc = 'reporte.reporteC';
                break;
        }

        $date = Carbon::parse($fechaEvaluacion->fin);
         
        $año = $date->isoFormat('YYYY');
        $mes = $date->isoFormat('MM');
        $dia = $date->isoFormat('D');
        $fecha = $dia.' de '.$meses[$mes-1].' de '.$año;
        
        
        $notaFinal = round(($proObjetiva + $proConcep) / 2 ,2);

        $qr = QrCode::format('png')->encoding('UTF-8')->size(100)->merge('../public/img/Sin título-1.png',.55,true)->generate("$personal->graCom $personal->paterno $personal->materno $personal->nombre \n Nota Promedio Objetiva: $proObjetiva \n Nota Promedio Conseptual: $proConcep \n Nota Final: $notaFinal");
        $qrband = $qr;
        $pdf = PDF::loadView( $doc,[
            'usuario' => $personal,
            'designaciones' =>$designaciones,
            'sanciones' => $sanciones,
            'revistas' => $revistas,
            'fechaEvaluacion' => $fechaEvaluacion,
            // // 'nuemroEvaluaciones' => $neva,
            // 'evaluCalificadas' => $obj[0]
            'notas' => $notas,
            'promedioObjetiva' => $proObjetiva,
            'conceptual1' => $conc1,
            'conceptual2' => $conc2,
            'conceptual3' => $conc3,
            'promedioConceptual' => $proConcep,
            'notaFinal' => $notaFinal,
            'foto' => 'http://sipefab.fab.bo/img/personal/'.$personal->foto,
            'fecha' => $fecha,
            'depa' => $depa,
            'qrband' => $qrband
        ])->setPaper(array(0, 0, 612.00, 935.433), 'portrait');

        return $pdf->stream();
        // return $per;
    }

    public function listarDesignacionesImp($id, $eva){
        $date = DB::table('evaluaciones as e')
            ->join('periodos as p', 'e.idperiodo','p.id')
            ->select('p.ano')
            ->where('e.id',$eva)
            ->first();
        $designaciones = DB::table('personal_designaciones')
            ->select('id','fecha', 'nro_doc as ndoc', 'documento as doc','descripcion as desc')
            ->where('per_codigo',$id)
            ->whereYear('fecha', $date->ano)
            ->orderBy('id')
            ->orderBy('fecha')
            ->get();
        
        return $designaciones;
    }
    
    public function listarSancionesImp($id, $eva){
        $date = DB::table('evaluaciones as e')
            ->join('periodos as p', 'e.idperiodo','p.id')
            ->select('p.ano')
            ->where('e.id',$eva)
            ->first();
        
        $sanciones = DB::table('personal_faltas as pf')
            ->join('nivel1_faltas as f1','pf.f1_cod','f1.id')
            ->join('nivel2_faltas as f2','pf.f2_cod','f2.id' )
            ->join('sanciones as s','pf.san_cod','s.id')
            ->select('pf.id','pf.per_codigo','pf.ndoc','pf.documento','pf.dias','pf.fecha_sancion as fecha','f1.descripcion as falta1', 'f2.descripcion as falta2','s.descripcion as sancion')
            ->where('pf.per_codigo',$id)
            ->whereYear('pf.fecha_sancion',  $date->ano)
            ->get();
        
        return $sanciones;
    }

    public function listarRevista($id, $eva)
    {
        $date = DB::table('evaluaciones as e')
            ->join('periodos as p', 'e.idperiodo','p.id')
            ->select('p.ano')
            ->where('e.id',$eva)
            ->first();

        $revistas = DB::table('personal_revistas as pr')
            ->join('personals as p','pr.per_codigo','p.per_codigo')
            ->select('pr.fecha','pr.funcion','pr.lugar','pr.compania')
            ->where('pr.per_codigo',$id)
            ->whereYear('pr.fecha',  $date->ano)
            ->where('pr.estado',1)
            ->get();
        
        return $revistas;
    }

    //Fecah de Evaluacion
    public function FechaEvalaucion($eva)
    {
        $periodo = DB::table('evaluaciones as e')
                            ->join('periodos as p','e.idperiodo','p.id')
                            ->select('p.inicio', 'p.fin')
                            ->where('e.id',$eva)
                            ->first();

        return $periodo;
    }

    public function EvaluacionCalificada($id, $eva)
    {
        /**
         * Muestra la evaluacioes terminadas
         */
        $evaluaciones = DB::table('jurado_personals')
            ->select('id')
            ->where('idpersonal',$id)
            ->where('evaluacion',$eva)
            ->where('estado',0)
            ->get();
        return $evaluaciones;
    }


    //Notas objetivas
    public function NotasObjetivasList($eva)
    {
        $notas = DB::table('objetiva_calificaciones as ca')
                    ->join('pregunta_objetivas as do','ca.iddetalleObjetiva', 'do.id')
                    ->select('ca.nota','do.detalle')
                    ->where('idjuradoPersonal',$eva)
                    ->orderBy('iddetalleObjetiva')
                    ->get();
        
        return $notas;
        
    }

    //Nota Conceptuañ
    public function NotaConceptual($id)
    {
        $concep = DB::table('conceptual_calificaciones as cc')
                    ->join('jurado_personals as jp', 'cc.idjuradoPersonal','jp.id')
                    ->join('jurados as j','jp.idjurado','j.id')
                    ->join('personals as p','j.per_cod','p.per_codigo')
                    ->select('cc.literal','cc.numerica','j.graCom as grado','j.cargo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno')
                    ->where('cc.idjuradoPersonal',$id)
                    ->first();
        return $concep;
    }
}
