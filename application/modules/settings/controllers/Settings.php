<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("settings_model");
        $this->load->model("general_model");
		$this->load->helper('form');
    }
	
	/**
	 * users List
     * @since 15/12/2016
     * @author BMOTTAG
	 */
	public function users($state)
	{			
			$data['state'] = $state;
			
			if($state == 1){
				$arrParam = array("filtroState" => TRUE);
			}else{
				$arrParam = array("state" => $state);
			}
			
			$data['info'] = $this->general_model->get_user($arrParam);
			$data['pageHeaderTitle'] = "Settings - Users";
			
			$data["view"] = 'users';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario User
     * @since 15/12/2016
     */
    public function cargarModalUsers() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idUser"] = $this->input->post("idUser");	
			
			$arrParam = array("filtro" => TRUE);
			$data['roles'] = $this->general_model->get_roles($arrParam);

			if ($data["idUser"] != 'x') {
				$arrParam = array(
					"idUser" => $data["idUser"]
				);
				$data['information'] = $this->general_model->get_user($arrParam);
			}
			
			$this->load->view("users_modal", $data);
    }
	
	/**
	 * Update User
     * @since 15/12/2016
     * @author BMOTTAG
	 */
	public function save_user()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idUser = $this->input->post('hddId');

			$msj = "The User was added!";
			if ($idUser != '') {
				$msj = "The User was updated!";
			}			

			$log_user = $this->input->post('user');
			$email_user = $this->input->post('email');
			
			$result_user = false;
			$result_email = false;
			
			//verificar si ya existe el usuario
			$arrParam = array(
				"idUser" => $idUser,
				"column" => "log_user",
				"value" => $log_user
			);
			$result_user = $this->settings_model->verifyUser($arrParam);
			
			//verificar si ya existe el correo
			$arrParam = array(
				"idUser" => $idUser,
				"column" => "email",
				"value" => $email_user
			);
			$result_email = $this->settings_model->verifyUser($arrParam);

			$data["state"] = $this->input->post('state');
			if ($idUser == '') {
				$data["state"] = 1;//para el direccionamiento del JS, cuando es usuario nuevo no se envia state
			}

			if ($result_user || $result_email)
			{
				$data["result"] = "error";
				if($result_user)
				{
					$data["mensaje"] = " Error! User name already exist.";
					$this->session->set_flashdata('retornoError', '<strong>Error!</strong> User name already exist.');
				}
				if($result_email)
				{
					$data["mensaje"] = " Error! Email already exist.";
					$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Email already exist.');
				}
				if($result_user && $result_email)
				{
					$data["mensaje"] = " Error! User name and email already exist.";
					$this->session->set_flashdata('retornoError', '<strong>Error!</strong> User name and email already exist.');
				}
			} else {
					if ($this->settings_model->saveUser()) {
						$data["result"] = true;					
						$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
					} else {
						$data["result"] = "error";					
						$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
					}
			}

			echo json_encode($data);
    }
	
	/**
	 * Reset employee password
	 * Reset the password to '123456'
	 * And change the status to '0' to changue de password 
     * @since 11/1/2017
     * @author BMOTTAG
	 */
	public function resetPassword($idUser)
	{
			if ($this->settings_model->resetEmployeePassword($idUser)) {
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> You have reset the Employee pasword to: 123456');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
			
			redirect("/settings/employee/",'refresh');
	}	

	/**
	 * Change password
     * @since 15/4/2017
     * @author BMOTTAG
	 */
	public function change_password($idUser)
	{
			if (empty($idUser)) {
				show_error('ERROR!!! - You are in the wrong place. The ID USER is missing.');
			}
			
			$arrParam = array("idUser" => $idUser);
			$data['information'] = $this->general_model->get_user($arrParam);
			$data['pageHeaderTitle'] = "Settings - Change Password";
		
			$data["view"] = "form_password";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Update user password
	 */
	public function update_password()
	{
			$data = array();			
			
			$newPassword = $this->input->post("inputPassword");
			$confirm = $this->input->post("inputConfirm");
			$userState = $this->input->post("hddState");
			$idUser = $this->input->post("hddId");
			
			//Para redireccionar el usuario
			if($userState!=2){
				$userState = 1;
			}
			
			$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
						
			if($newPassword == $confirm)
			{					
				if ($this->settings_model->updatePassword()) {
					$msj = 'The password was updated';
					$msj .= "<br><strong>User name: </strong>" . $this->input->post("hddUser");
					$msj .= "<br><strong>Password: </strong>" . $passwd;
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
				}
			}else{
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Please enter the same value again.');
			}
						
			redirect(base_url('settings/change_password/' . $idUser), 'refresh');
	}

	/**
	 * job List
     * @since 15/12/2016
     * @author BMOTTAG
	 */
	public function job($state)
	{
			$data['state'] = $state;
		
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",				
				"column" => "state",
				"id" => $state
			);
			$data['info'] = $this->general_model->get_basic_search($arrParam);
			$data['pageHeaderTitle'] = "Settings - JOB CODE/NAME ";
			
			$data["view"] = 'job';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario job
     * @since 15/12/2016
     */
    public function cargarModalJob() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idJob"] = $this->input->post("idJob");	
			
			if ($data["idJob"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"table" => "param_jobs",
					"order" => "id_job",
					"column" => "id_job",
					"id" => $data["idJob"]
				);
				$data['information'] = $this->general_model->get_basic_search($arrParam);
			}
			
			$this->load->view("job_modal", $data);
    }
	
	/**
	 * Update job
     * @since 15/12/2016
     * @author BMOTTAG
	 */
	public function save_job()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idJob = $this->input->post('hddId');
			
			$msj = "The Job was added!";
			if ($idJob != '') {
				$msj = "The Job was updated!";
			}

			if ($idJob = $this->settings_model->saveJob()) {
				$data["result"] = true;		
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }

	/**
	 * Cambio de estado de los proyectos
     * @since 12/1/2019
     * @author BMOTTAG
	 */
	public function jobs_state($state)
	{	
			if ($this->settings_model->updateJobsState($state)) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', "The status was updated!");
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			redirect(base_url('settings/job/1'), 'refresh');
	}
	

	
}