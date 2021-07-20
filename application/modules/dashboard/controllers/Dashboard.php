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
			$data['noCompanies'] = $this->general_model->countCompanies();

			$arrParam = array("status" => 1);
			$data['companyInfo'] = $this->general_model->get_app_company($arrParam);
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

	public function change_company()
	{
			$idCompany = $this->input->post("id_company");
			$arrParam = array("idCompany" => $idCompany);
			$company = $this->general_model->get_app_company($arrParam);

			$sessionData = array(
				'idCompany' => $idCompany,
				'companyName' => $company[0]['company_name']
			);
			$this->session->set_userdata($sessionData);	
			$this->session->set_flashdata('retornoExito', "The Company was changed!");

			$dashboardURL = $this->session->userdata("dashboardURL");
			redirect(base_url($dashboardURL), 'refresh');
	}
	
	
}