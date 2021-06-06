<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Login_model extends CI_Model {

	    function __construct(){        
	        parent::__construct();
     
	    }
	    
	    /**
	     * Valida los datos del formulario de ingreso (login y password) contra la base de datos del aplicativo
	     * @author BMOTTAG
	     * @since  8/11/2016
	     */
	    public function validateLogin($arrData)
		{
	    	$user = array();
	    	$user["valid"] = false;
			
	    	$login = str_replace(array("<",">","[","]","*","^","-","'","="),"",$arrData["login"]);   
	    	$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$arrData["passwd"]); 
			$passwd = md5($passwd);
			
	    	$sql = "SELECT * FROM user WHERE log_user = '$login' and password = '$passwd'";
	    	$query = $this->db->query($sql);

	    	if ($query->num_rows() > 0){	    		
	    		//$encrypt = $this->danecrypt->encode($passwd);
	    		foreach($query->result() as $row){
	    			//if (strcmp($row->PAS_USUARIO, $encrypt)===0){
	    				$user["valid"] = true;
	    				$user["id"] = $row->id_user;
	    				$user["firstname"] = $row->first_name;
	    				$user["lastname"] = $row->last_name;
						$user["logUser"] = $row->log_user;
	    				$user["movil"] = $row->movil;
						$user["state"] = $row->state;
						$user["role"] = $row->fk_id_user_role;
						$user["photo"] = $row->photo;
	    			//}	    			
	    		}
	    	}
			
			//var_dump($user); die();
	    	$this->db->close();	    	
	    	return $user;
	    }
		
	    /**
	     * Redirecciona el usuario al módulo correspondiente dependiendo de los datos almacenados en la session
	     * @author BMOTTAG
	     * @since  8/11/2016
		 * @review  18/12/2016
	     */
	    public function redireccionarUsuario()
		{
			$state = $this->session->userdata("state");
			$userRol = $this->session->userdata("role");
			$dashboardURL = $this->session->userdata("dashboardURL");
			
	    	switch($state){
	    		case 0: //NEW USER, must change the password
	    				redirect("/employee","location",301);
	    				break;
	    		case 1: //ACTIVE USER
						redirect($dashboardURL,"location",301);
	    				break;
	    		case 2: //INACTIVE USER
	    				$this->session->sess_destroy();
	    				redirect("/login","location",301);
	    				break;
	    		default: //No sé como llegaron hasta acá, pero los devuelvo al Login.
	    				$this->session->sess_destroy();
	    				redirect("/login","location",301);
	    				break;
	    	}
	    }
		
	    
	}