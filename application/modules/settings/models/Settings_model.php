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
				if ($idUser == '') {
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
					'job_description' => $this->input->post('jobName'),
					'status' => $this->input->post('statusJob')
				);			

				//revisar si es para adicionar o editar
				if ($idJob == '') {
					$query = $this->db->insert('param_jobs', $data);
				} else {
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
		 * Add clent-user conecction
		 * @since 12/6/2021
		 */
		public function saveClientUserConnectionDocumentos($idUser) 
		{
				$idClient = $this->session->userdata("idClient");
				
				$data = array(
					'fk_id_client_app' => $idClient,
					'fk_id_user_app ' => $idUser
				);	
				$query = $this->db->insert('app_clients_users_connection', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
	    
	}