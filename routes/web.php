<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//***********************************EVALUACION********************************* */
//DATOS DE LA ULTIMA EVALUAION REGISTRADA
Route::get('/ultFechEva','EvaluacionController@ultimaEvaluacion');
//REGISTRAR EVALUACIONES
Route::post('/evaluaciones/store', 'EvaluacionController@GuardarEvaluacion');
//LISTAR EVALUACIONES
Route::post('/listarEvaluaciones', 'EvaluacionController@ListarEvaluaciones');
Route::get('/listEva', 'EvaluacionController@ListEva');
//FECHA DE EVALUACION
Route::post('/fechaEvaluacion', 'EvaluacionController@FechaEvaluacion');
Route::post('/editarFechaEval', 'EvaluacionController@EditarFechaEval');
Route::put('/eliminarEvaluacion', 'EvaluacionController@EliminarEvaluacion');
Route::put('/finalizararEvaluacion', 'EvaluacionController@FinalizarEvaluacion');

//Devuelve si hay una evaluacion activa

Route::get('/ultEvalActiva','EvaluacionController@EvaluacionActiva');

//Lista unidades designadas con evaluadores

Route::post('/desgUni','JuradoController@ListarUnidadesAsignadas');

//Lista destinos 4 no asignados con evaluador
Route::post('/noDesgUni','JuradoController@ListarUnidadesNoAsignadas');

/**
 * Autor: Hidalgo Miranda Ariel Wilson
 * Fecha: 25/02/2021
 * Descripcion: Ruta de Datos para la vista principal de la Foja de Concepto
 */
// Muestra si tiene evaluaciones Desiganada
Route::get('/evalactual','EvaluacionController@EvaluacionDesignada');
//Secciones asignadas para ser evaluadas a el usuario
Route::post('/degsecev', 'EvaluacionController@listarDesignacionUsuario');



//***********************************JURADOS********************************* */
Route::post('/guardarJurados', 'JuradoController@GuardarJurados');
//LISTA UNIDADES CON JURADOS DESIGNADOS
Route::post('/listaUnidadesJurados','DestinosAsignadosController@ListaUnidadesDesignadas');
//EVALUADORES ASIGNADOS A UNA UNIDAD
Route::post('/jurados/seccion','DestinosAsignadosController@JuradosAsignados');

//Ruta para la asignacion del personal evaluado a el usuario 
//designando como evaluador
Route::post('/asignarJurados','JuradoController@asignarJurados');
//Actualizar el estado de la tabla jurado
Route::post('/actEstado', 'JuradoController@actEstado');


//***********************************PREGUNTAS OBJETIVAS********************************* */
/**
 * Controladores para las preguntas de la Calificacion Objetiva
 */
Route::post('/preguntasObjetivas', 'PreguntasController@preguntasObjetivas');

//**************************LISTA PERSONAL************************************/
//Ruta para Listar al personal a evaluar de la tabla "jurado_personal"
Route::post('/juradoPersonal','PersonalController@juradoPersonal');
//Ruta para datos del evaluador
Route::post('/datosEvaluador','PersonalController@datosEvaluador');
//Ruta para datos del evaluado
Route::post('/datosEvaluado','PersonalController@datosEvaluado');

//**************************DATOS FOJAS DE CONCEPTO************************************/
//Datos de la Evaluacion
Route::post('/evaDat','DatosFojaController@EvaluacionDatos');
//Ruta para guardar las notas del evaluado
Route::post('/guardarNota', 'FojaController@guardarNota');
//Ver Nota Objetiva
Route::post('/notasObjetiva', 'DatosFojaController@notasObjetiva');
//Ver Nota Conceptual
Route::post('/notaConceptual', 'DatosFojaController@notaConceptual');

//Funcion de los datos para la impresion de datos par ala foja
Route::post('/estadoimpresion','FojaController@EstadoImpresion');
//Ruta para adquirir las notas e impresion de la foja
Route::get('/datosfoja/{id}/{d}/{depa}/{eva}', 'FojaController@DatosFoja');


//**************************RUTAS DE ACCESO AL SISTEMA******************************* */


/**
 * RUTAS PARA CREACION DE USUARIOS
 */
Route::post('/crearUsuario','UsuarioController@CrearUsuario');
Route::post('/listarUsuarios','UsuarioController@ListarUsuarios');
Route::post('/datosUsuarios','UsuarioController@DatosUsuarios');
Route::put('/editarUsuarios','UsuarioController@EditarUsuario');
Route::put('/cambiarEstadoUsuario','UsuarioController@CambiarEstadoUsuario');
Route::get('/datosUsuario','UsuarioController@DatosUsuario');

//NOMBRE DEL USUARIO
Route::get('/datosP','UsuarioController@datosP');
Route::post('/editContrasena','UsuarioController@EditContrasena');



/**
 * Autor: Hidalgo Miranda Ariel Wilson
 * Fecha: 20/09/2020
 * Descripcion: Ruta de authenticacion
 */

Route::post('/authenticate/ingreso','Auth\LoginController@login');
Route::get('/authenticate/salir','Auth\LoginController@logout')->name('logout');
Route::get('/listarPermisos','Auth\LoginController@ListarPermisos');

/**
 * rutas para la admnitraciond e datos
 */
Route::post('/listarol','RoleController@ListarRole');
Route::post('/listarol2','RoleController@ListarRole2'); //Roles qu no tiene aasignado el usuario
Route::post('/listarolus','RoleController@ListarRoleUsuario');
Route::post('/listarPermisos','RoleController@ListarPermisos');
Route::post('/listaRolPermiso','RoleController@ListaRolPermiso');
Route::post('/guardarRol','RoleController@GuardarRol');
Route::post('/editarRol','RoleController@EditarRol');
Route::get('/listarRoles','RoleController@ListarRoles');
//rutas que permiten adicionar y quitar roles a los usuarios
Route::post('/agregarRol','RoleController@AgregarRol');
Route::post('/quitarRol','RoleController@QuitarRol');

/**
 * Rutas para listar permisos
 */
Route::post('/listapermisos','PermisoController@ListarPermisos');
Route::post('/guadarPermiso','PermisoController@GuardarPermisos');
Route::post('/editarPermiso','PermisoController@EditarPermisos');
Route::post('/datosPermiso','PermisoController@DatosPermiso');
Route::get('/listarModulos','PermisoController@ListarModulos');




Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
   ->where('optional','.*');

