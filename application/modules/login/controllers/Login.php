<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("login_model");
    }

	/**
	 * Index Page for this controller.
	 * @param int $id: id del vehiculo encriptado para el hauling
	 */
	public function index($id = 'x')
	{
			$this->session->sess_destroy();
			$this->load->view('login', $data);
	}
	
	public function validateUser()
	{
			$login = $this->security->xss_clean($this->input->post("inputLogin"));
			$passwd = $this->security->xss_clean($this->input->post("inputPassword"));
			
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "user",
				"order" => "id_user",
				"column" => "log_user",
				"id" => $login
			);
			$userExist = $this->general_model->get_basic_search($arrParam);

			if ($userExist)
			{
					$arrParam = array(
						"login" => $login,
						"passwd" => $passwd
					);
					$user = $this->login_model->validateLogin($arrParam); //brings user information from user table

					if(($user["valid"] == true)) 
					{
						$userRol = intval($user["rol"]);
						//busco url del dashboard de acuerdo al rol del usuario
						$arrParam = array(
							"idRol" => $userRol
						);
						$rolInfo = $this->general_model->get_roles($arrParam);

						$sessionData = array(
							"auth" => "OK",
							"id" => $user["id"],
							"dashboardURL" => $rolInfo[0]['dashboard_url'],
							"firstname" => $user["firstname"],
							"lastname" => $user["lastname"],
							"name" => $user["firstname"] . ' ' . $user["lastname"],
							"logUser" => $user["logUser"],
							"state" => $user["state"],
							"rol" => $user["rol"],
							"photo" => $user["photo"]
						);
												
						$this->session->set_userdata($sessionData);						
						$this->login_model->redireccionarUsuario();
					}else{					
						$data["msj"] = "<strong>" . $userExist[0]["first_name"] . "</strong> that's not your password.";
						$this->session->sess_destroy();
						$this->load->view('login', $data);
					}
			}else{
				$data["msj"] = "<strong>" . $login . "</strong> doesn't exist.";
				$this->session->sess_destroy();
				$this->load->view('login', $data);
			}
	}
	
	
}
