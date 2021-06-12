<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("payroll_model");
    }

	/**
	 * Form Add Payroll
     * @since 09/11/2016
     * @author BMOTTAG
	 */
	public function add_payroll($id = 'x')
	{
			$this->load->model("general_model");
			//jobs list - (actives items)
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "status",
				"id" => 1
			);
			$data['jobs'] = $this->general_model->get_basic_search($arrParam);
			
			//search for the last user record
			$arrParam = array(
				"idUser" => $this->session->userdata("idUser"),
				"limit" => 1
			);			
			$data['record'] = $this->general_model->get_payroll($arrParam);

			$view = 'form_add_payroll';
			
			//if the last record doesn't have finish time
			if($data['record'] && $data['record'][0]['finish'] == 0){
				$view = 'form_end_payroll';
			}
			$data['pageHeaderTitle'] = "Time Stamp";
			
			$data["view"] = $view;
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save payroll
     * @since 09/11/2016
     * @author BMOTTAG
	 */
	public function save_payroll()
	{			
			$hour = date("G:i");
			
			if ($this->payroll_model->savePayroll()) {
                $this->session->set_flashdata('retornoExito', '<strong>Time Stamp</strong><br>Have a nice shift, you started at ' . $hour . '.');
            } else {
                $this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
            }
			
			$dashboard = $this->session->userdata("dashboardURL");
			redirect($dashboard,'refresh');
	}
	
	/**
	 * Update finish time payroll
     * @since 11/11/2016
     * @author BMOTTAG
	 */
	public function update_payroll()
	{				
			if ($this->payroll_model->updatePayroll()) {

				//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
				//START search info for the task
				$idPayroll =  $this->input->post('hddIdentificador');
				$infoPayroll = $this->payroll_model->get_payrollbyid($idPayroll);
				//END of search				

				//update working time and working hours
				$hour = date("G:i");
				if ($this->payroll_model->updateWorkingTimePayroll($infoPayroll)) {
					$this->session->set_flashdata('retornoExito', '<strong>Time Stamp</strong><br>Have a good night, you finished at ' . $hour . '.');
				}else{
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> bad at math.');
				}
				
            } else {
                $this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
            }

			$dashboard = $this->session->userdata("dashboardURL");
			redirect($dashboard,'refresh');
	}
	
	/**
	 * Location
     * @since 22/11/2016
     * @author BMOTTAG
	 */
	public function view_location()
	{
			$this->load->view('location');
	}
	
    /**
     * Cargo modal- formulario para editar las horas de los empleados
     * @since 2/2/2018
     */
    public function cargarModalHours() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;

			//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
			//START search info for the task
			$idTask =  $this->input->post('idTask');
			$data['information'] = $this->payroll_model->get_payrollbyid($idTask);
			//END of search				
						
			$this->load->view("modal_hours_worker", $data);
    }
	
	/**
	 * Save payroll hours
     * @since 2/2/2018
     * @author BMOTTAG
	 */
	public function savePayrollHour()
	{			
			header('Content-Type: application/json');
			$data = array();
						
			$idTask = $this->input->post('hddIdentificador');
			$data["idRecord"] = $idTask;

			if ($this->payroll_model->savePayrollHour()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'You have update the payroll hour');
				
				//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
				//START search info for the task
				$idTask =  $this->input->post('hddIdentificador');
				$infoTask = $this->payroll_model->get_payrollbyid($idTask);
				//END of search	

				//update working time and working hours
				if ($this->payroll_model->updateWorkingTimePayroll($infoTask)) {
					$this->session->set_flashdata('retornoExito', 'You have update the payroll hour');
				}else{
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> bad at math.');
				}
				
				
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }

	
}