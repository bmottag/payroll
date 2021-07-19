<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Settings_model extends CI_Model {

	    
		/**
		 * Verify if the user already exist by the social insurance number
		 * @author BMOTTAG
		 * @since  8/11/2016
		 * @review 10/12/2020
		 */
		public function verifyUser($arrData) 
		{
				if (array_key_exists("idUser", $arrData)) {
					$this->db->where('id_user !=', $arrData["idUser"]);
				}			

				$this->db->where($arrData["column"], $arrData["value"]);
				$query = $this->db->get("user");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
		
		/**
		 * Add/Edit USER
		 * @since 8/11/2016
		 */
		public function saveUser() 
		{
				$idUser = $this->input->post('hddId');
				
				$data = array(
					'first_name' => $this->input->post('firstName'),
					'last_name' => $this->input->post('lastName'),
					'log_user' => $this->input->post('user'),
					'movil' => $this->input->post('movilNumber'),
					'email' => $this->input->post('email'),
					'fk_id_user_role' => $this->input->post('id_role')
				);	

				//revisar si es para adicionar o editar
				if ($idUser == '') 
				{
					$data['fk_id_client_app'] = $this->session->userdata("idClient");
					$data['status'] = 0;//si es para adicionar se coloca estado inicial como usuario nuevo
					$data['password'] = 'e10adc3949ba59abbe56e057f20f883e';//123456
					$query = $this->db->insert('user', $data);
					$idUser = $this->db->insert_id();
				} else {
					$data['status'] = $this->input->post('status');
					$this->db->where('id_user', $idUser);
					$query = $this->db->update('user', $data);
				}
				if ($query) {
					return $idUser;
				} else {
					return false;
				}
		}
		
	    /**
	     * Reset user´s password
	     * @author BMOTTAG
	     * @since  11/1/2017
	     */
	    public function resetEmployeePassword($idUser)
		{
				$passwd = '123456';
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd,
					'status' => 0
				);

				$this->db->where('id_user', $idUser);
				$query = $this->db->update('usuarios', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }

	    /**
	     * Update user´s password
	     * @author BMOTTAG
	     * @since  8/11/2016
	     */
	    public function updatePassword()
		{
				$idUser = $this->input->post("hddId");
				$newPassword = $this->input->post("inputPassword");
				$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd
				);

				$this->db->where('id_user', $idUser);
				$query = $this->db->update('user', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }
		
		/**
		 * Add/Edit JOB
		 * @since 10/11/2016
		 */
		public function saveJob() 
		{				
				$idJob = $this->input->post('hddId');
				
				$data = array(
					'fk_id_param_client' => $this->input->post('idClient'),
					'job_description' => $this->input->post('jobName')
				);			

				//revisar si es para adicionar o editar
				if ($idJob == '') {
					$data['status'] = 1;
					$query = $this->db->insert('param_jobs', $data);
				} else {
					$data['status'] = $this->input->post('statusJob');
					$this->db->where('id_job', $idJob);
					$query = $this->db->update('param_jobs', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Update jobs status
		 * @since 12/1/2019
		 */
		public function updateJobsStatus($status) 
		{
			//if it comes from the active view, then inactive everything
			//else do nothing and continue with the activation
			if($status == 1){
				//update all status to inactive
				$data['status'] = 2;
				$this->db->where('fk_id_client', $this->session->userdata("idClient"));
				$query = $this->db->update('param_jobs', $data);
			}

			//update status
			$query = 1;
			if ($jobs = $this->input->post('job')) {
				$tot = count($jobs);
				for ($i = 0; $i < $tot; $i++) {
					$data['status'] = 1;
					$this->db->where('id_job', $jobs[$i]);
					$query = $this->db->update('param_jobs', $data);					
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Add/Edit USER
		 * @since 4/7/2021
		 */
		public function saveParamClient() 
		{
				$idClient = $this->input->post('hddId');
				
				$data = array(
					'param_client_name' => $this->input->post('clientName'),
					'param_client_contact' => $this->input->post('contact'),
					'param_client_movil' => $this->input->post('movilNumber'),
					'param_client_email' => $this->input->post('email'),
					'param_client_address' => $this->input->post('address')
				);	

				//revisar si es para adicionar o editar
				if ($idClient == '') {
					$data['fk_id_app_client'] = $this->session->userdata("idClient");
					$data['param_client_status'] = 1;
					$data['date_issue'] = date("Y-m-d");
					$query = $this->db->insert('param_client', $data);
				}else{
					$data['param_client_status'] = $this->input->post('status');
					$this->db->where('id_param_client', $idClient);
					$query = $this->db->update('param_client', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Update company information
		 * @since 19/7/2021
		 */
		public function saveCompany() 
		{
				$idClient = $this->input->post('hddId');
				
				$data = array(
					'client_name' => $this->input->post('clientName'),
					'client_contact' => $this->input->post('contact'),
					'client_movil' => $this->input->post('movilNumber'),
					'client_address' => $this->input->post('address'),
					'client_gst' => $this->input->post('gst'),
					'fk_id_city' => $this->input->post('idCity')
				);	

				$this->db->where('id_client', $idClient);
				$query = $this->db->update('app_client', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		
	    
	}