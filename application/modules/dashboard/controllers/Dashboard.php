<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("dashboard_model");
		$this->load->model("general_model");
    }

	/**
	 * SUPER ADMIN DASHBOARD
	 */
	public function super_admin()
	{	
			$data['noClients'] = $this->general_model->countCients();

			$arrParam = array("status" => 1);
			$data['clients'] = $this->general_model->get_clients($arrParam);
			$data['pageHeaderTitle'] = "Dashboard SUPER ADMIN";

			$data["view"] = "dashboard_admin";
			$this->load->view("layout", $data);
	}
		
	/**
	 * ADMINISTRATO DASHBOARD
	 */
	public function admin()
	{				
			$data['noPayroll'] = $this->general_model->countPayroll();
						
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_payroll($arrParam);//search the last 5 records 
			$data['pageHeaderTitle'] = "Dashboard";

			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}

	public function change_client()
	{
			$idClient = $this->input->post("id_client");
			$arrParam = array("idClient" => $idClient);
			$clients = $this->general_model->get_clients($arrParam);

			$sessionData = array(
				'idClient' => $idClient,
				'companyName' => $clients[0]['client_name']
			);
			$this->session->set_userdata($sessionData);	
			$this->session->set_flashdata('retornoExito', "The Client was changed!");

			$dashboardURL = $this->session->userdata("dashboardURL");
			redirect(base_url($dashboardURL), 'refresh');
	}
	
	
}