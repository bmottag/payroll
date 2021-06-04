<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("dashboard_model");
		$this->load->model("general_model");
    }

	/**
	 * Index Page for this controller.
	 * Basic dashboard
	 */
	public function index()
	{	
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			
			$data['infoMaintenance'] = FALSE;
			$data['noJobs'] = FALSE;
			
			//cuenta payroll para el usuario 
			$arrParam["task"] = 1;//buscar por timestap
			$data['noTareas'] = $this->general_model->countTask($arrParam);
			
			$data['noSafety'] = $this->dashboard_model->countSafety();//cuenta registros de safety
			$data['noHauling'] = $this->dashboard_model->countHauling();//cuenta registros de hauling
			$data['noDailyInspection'] = $this->dashboard_model->countDailyInspection();//cuenta registros de DailyInspection
			$data['noHeavyInspection'] = $this->dashboard_model->countHeavyInspection();//cuenta registros de HeavyInspection
			$data['noSpecialInspection'] = $this->dashboard_model->countSpecialInspection();//cuenta registros de SpecialInspection
			
			//informacion de un dayoff si lo aprobaron y lo negaron
			$data['dayoff'] = $this->dashboard_model->dayOffInfo();

			//Filtro datos por id del Usuario
			$arrParam["idEmployee"] = $this->session->userdata("id");

			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_task($arrParam);//search the last 5 records 
			
			$data['infoSafety'] = $this->general_model->get_safety($arrParam);//info de safety
			
			$arrParam["limit"] = 6;//Limite de registros para la consulta
			$data['infoWaterTruck'] = $this->general_model->get_special_inspection_water_truck($arrParam);//info de water truck
			$data['infoHydrovac'] = $this->general_model->get_special_inspection_hydrovac($arrParam);//info de hydrovac
			$data['infoSweeper'] = $this->general_model->get_special_inspection_sweeper($arrParam);//info de sweeper
			$data['infoGenerator'] = $this->general_model->get_special_inspection_generator($arrParam);//info de generador
		
			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	/**
	 * System general info
     * @since 28/3/2020
     * @author BMOTTAG
	 */
	public function info()
	{		
			$data["view"] ='general_info';
			$this->load->view("layout", $data);
	}
	
	/**
	 * SUPER ADMIN DASHBOARD
	 */
	public function admin()
	{	
			$this->load->model("general_model");
			
			//cuenta payroll para el usuario 
			$data['noPayroll'] = $this->general_model->countPayroll();
						
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_payroll($arrParam);//search the last 5 records 

			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}

	/**
	 * Calendario
     * @since 18/12/2020
     * @author BMOTTAG
	 */
	public function calendar()
	{
			$data["view"] = 'calendar';
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Consulta desde el calendario
     * @since 21/12/2020
     * @author BMOTTAG
	 */
    public function consulta() 
    {
	        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$start = $this->input->post('start');
			$end = $this->input->post('end');
			$start = substr($start,0,10);
			$end = substr($end,0,10);

			$arrParam = array(
				"from" => $start,
				"to" => $end
			);
			
			//informacion Work Order
			$workOrderInfo = $this->general_model->get_workorder_info($arrParam);

			//informacion Planning
			$planningInfo = $this->general_model->get_programming_info($arrParam);

			//Informacion de Payroll
			$payrollInfo = $this->general_model->get_task($arrParam);

			//Informacion de Hauling
			$haulingInfo = $this->general_model->get_hauling($arrParam);

			echo  '[';

			if($workOrderInfo)
			{
				$longitud = count($workOrderInfo);
				$i=1;
				foreach ($workOrderInfo as $data):
					echo  '{
						      "title": "W.O. #: ' . $data['id_workorder'] . ' - Job Code/Name: ' . $data['job_description'] . '",
						      "start": "' . $data['date'] . '",
						      "end": "' . $data['date'] . '",
						      "color": "green",
						      "url": "' . base_url("dashboard/info_by_day/" . $data['date']) . '"
						    }';

					if($i<$longitud){
							echo ',';
					}
					$i++;
				endforeach;
			}

			if($workOrderInfo && $planningInfo){
				echo ',';
			}

			if($planningInfo)
			{
				$longitud = count($planningInfo);
				$i=1;
				foreach ($planningInfo as $data):
					echo  '{
						      "title": "Planning. #: ' . $data['id_programming'] . ' - Job Code/Name: ' . $data['job_description'] . '",
						      "start": "' . $data['date_programming'] . '",
						      "end": "' . $data['date_programming'] . '",
						      "color": "yellow",
						      "url": "' . base_url("dashboard/info_by_day/" . $data['date_programming']) . '"
						    }';

					if($i<$longitud){
							echo ',';
					}
					$i++;
				endforeach;
			}

			if(($workOrderInfo || $planningInfo) && $haulingInfo){
				echo ',';
			}

			if($haulingInfo)
			{
				$longitud = count($haulingInfo);
				$i=1;
				foreach ($haulingInfo as $data):
					echo  '{
						      "title": "Hauling. #: ' . $data['id_hauling'] . ' - Report done by: ' . $data['name'] . ' - Hauling done by: ' . $data['company_name'] . '  - From Site: ' . $data['site_from'] . ' - To Site: ' . $data['site_to'] . ' - Truck - Unit Number: ' . $data['unit_number'] . ' - Material Type: ' . $data['material'] . '",
						      "start": "' . $data['date_issue'] . ' ' . $data['time_in'] . '",
						      "end": "' . $data['date_issue'] . ' ' . $data['time_out'] . '",
						      "color": "red",
						      "url": "' . base_url("dashboard/info_by_day/" . $data['date_issue']) . '"
						    }';

					if($i<$longitud){
							echo ',';
					}
					$i++;
				endforeach;
			}

			if(($workOrderInfo || $planningInfo || $haulingInfo) && $payrollInfo){
				echo ',';
			}
			
			if($payrollInfo)
			{
				$longitud = count($payrollInfo);
				$i=1;
				foreach ($payrollInfo as $data):
					$startPayroll = substr($data['start'],0,10);
					$payrollInfo = "Payroll: " . $data['first_name'] . ' ' . $data['last_name'];
					$payrollInfo .=	" Job Code/Name: " . $data['job_start'];
					$payrollInfo .= " - Working Hours: " . $data['working_hours'];

					if($data['task_description']){
						$taskDescription = trim(preg_replace('/\s+/', ' ', $data['task_description']));
						$payrollInfo .= " - Task description: " . $taskDescription;
					}
					echo  '{
						      "title": "' . $payrollInfo . '",
						      "start": "' . $data['start'] . '",
						      "end": "' . $data['finish'] . '",
						      "color": "blue",
						      "url": "' . base_url("dashboard/info_by_day/" . $startPayroll) . '"
						    }';

					if($i<$longitud){
							echo ',';
					}
					$i++;
				endforeach;
			}

			echo  ']';

    }

	/**
	 * Consulta desde el calendario
     * @since 22/12/2020
     * @author BMOTTAG
	 */
	public function info_by_day($infoDate)
	{	
			$data['fecha'] = $infoDate;
			$arrParam = array(
				"fecha" => $infoDate
			);

			//informacion Planning
			$data['planningInfo'] = $this->general_model->get_programming_info($arrParam);

			//Informacion de Payroll
			$data['payrollInfo'] = $this->general_model->get_task($arrParam);
			
			//informacion Work Order
			$data['workOrderInfo'] = $this->general_model->get_workorder_info($arrParam);

			//Informacion de Hauling
			$data['haulingInfo'] = $this->general_model->get_hauling($arrParam);
		
			//Informacion de FLHA
			$data['safetyInfo'] = $this->general_model->get_safety($arrParam);//info de safety

			//Informacion de TOOL BOX
			$data['toolBoxInfo'] = $this->general_model->get_tool_box($arrParam);//info de safety

			$data["view"] = "info_by_day";
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * General info
     * @since 26/12/2020
     * @author BMOTTAG
	 */
	public function settings()
	{		
			//busco datos parametricos
			$arrParam = array(
				"table" => "parametric",
				"order" => "id_parametric",
				"id" => "x"
			);
			$data['parametric'] = $this->general_model->get_basic_search($arrParam);	

			$data["view"] ='settings';
			$this->load->view("layout", $data);
	}
	
	
}