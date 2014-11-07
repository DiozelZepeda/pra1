<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package     CodeIgniter
 * @subpackage  Rest Server
 * @category    Controller
 * @author      Phil Sturgeon
 * @link        http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Rest extends REST_Controller
{

    function __construct(){
        parent::__construct();  
        $this->CI = & get_instance(); //instancias que carga de la libreria.
        $this->CI->load->model('model_usuario'); 
    }

    function user_get()
    {
        if(!$this->get('id')){
            $this->response(NULL, 400);
        }

        $this->db->setCF('cuentausuario');
        $user2 = $this->db->query()->get($this->get('id'));
        $user = @$user2;

        if($user){
            $this->response($user, 200); // 200 being the HTTP response code
        }
        else{
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }
    
    
    function user_post()
    {

        $columns        = $this->post();

        $idalumno       = $this->post('idalumno');
        $idindicador    = $this->db->uuid1();


        $indicadores = array (  'fecha' => $this->post('fecha'),
                                'habilidad' => $this->post('habilidad'),
                                'aplicacion' => $this->post('aplicacion'),
                                'indicador' => $this->post('indicador'),
                                'descripcion' => $this->post('descripcion')

                             );

        $indicadordate = array (
                                    'dispositivo' => $this->post('dispositivo'),
                                    'latitud' => $this->post('latitud'),
                                    'longitud' => $this->post('longitud')
                                );
      
        //insert de la tabla que almacena los indicadores del alumno en cuestion.
        $columns = $this->CI->model_usuario->insert_alumnoindicador($idalumno, $idindicador);

        // insert datos en tablas de indicadores segun idindicador
        $columns = $this->CI->model_usuario->insert_indicadores($idindicador, $indicadores);
        $columns = $this->CI->model_usuario->insert_indicadordate($idindicador, $indicadordate);

    
        $this->response($columns, 200);
    }
    
    function user_delete()
    {
        $this->response(array('error' => 'User could not be found'), 404);
    }
    
    function users_get()
    {
        $this->response(array('error' => 'User could not be found'), 404);
    }
    
    public function send_post()
    {
        $this->response(array('error' => 'User could not be found'), 404);
    }


    public function send_put()
    {
        $this->response(array('error' => 'User could not be found'), 404);
    }
}