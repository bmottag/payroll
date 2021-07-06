<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("invoice_model");
        $this->load->model("general_model");
    }

	/**
	 * Invoice List
     * @since 4/7/2021
     * @author BMOTTAG
	 */
	public function index()
	{			
			$arrParam = array();
			$data['info'] = $this->general_model->get_invoice($arrParam);
			$data['pageHeaderTitle'] = "Invoice - List";

			$data["view"] = 'invoice';
			$this->load->view("layout", $data);
	}

    /**
     * Cargo modal - Invoice
     * @since 4/7/2021
     */
    public function cargarModalInvoice() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idInvoice"] = $this->input->post("idInvoice");	

			//filtro de param clientes activos 
			$arrParam = array("status" => 1);
			$data['infoClients'] = $this->general_model->get_param_clients($arrParam);
			
			if ($data["idInvoice"] != 'x') {
				$arrParam = array(
					"idInvoice" => $data["idInvoice"]
				);
				$data['information'] = $this->general_model->get_invoice($arrParam);
			}
			
			$this->load->view("invoice_modal", $data);
    }

	/**
	 * Update Invoice
     * @since 4/7/2021
     * @author BMOTTAG
	 */
	public function save_invoice()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idInvoice = $this->input->post('hddId');
			
			$msj = "A new Invoice was added!";
			if ($idInvoice != '') {
				$msj = "The Invoice was updated!";
			}

			if ($idInvoice = $this->invoice_model->saveInvoice()) {
				$data["result"] = true;		
				$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }

	/**
	 * Invoice details
     * @since 5/7/2021
     * @author BMOTTAG
	 */
	public function details($idInvoice)
	{
			if (empty($idInvoice) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}else{
				$data['invoiceDetails'] = FALSE;
				$arrParam = array('idInvoice' =>$idInvoice);
				$data['invoiceInfo'] = $this->general_model->get_invoice($arrParam);//invoice general info
				if(!$data['invoiceInfo']){
					show_error('ERROR!!! - You are in the wrong place.');
				}else{	
					$data['invoiceDetails'] = $this->general_model->get_invoice_details($arrParam);//invoice details

					$arrParam = array('idClient' =>$this->session->idClient);
					$data['appClient'] = $this->general_model->get_app_clients($arrParam);//app client info
					$data['pageHeaderTitle'] = "Invoice - Details";

					$data["view"] = 'invoice_details';
					$this->load->view("layout", $data);
				}
			}
	}

    /**
     * Cargo modal- formulario para editar las horas de los empleados
     * @since 2/2/2018
     */
    public function cargarModalInvoiceService() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['idInvoice'] = $this->input->post('idInvoice');;
						
			$this->load->view("modal_invoice_service", $data);
    }
	
	/**
	 * Save payroll hours
     * @since 2/2/2018
     * @author BMOTTAG
	 */
	public function save_invoice_service()
	{			
			header('Content-Type: application/json');
			$data = array();
						
			$data["idRecord"] = $idInvoice = $this->input->post('hddIdInvoice');

			$msj = "A new Service was added!";
			if ($idInvoice != '') {
				$msj = "A Service was updated!";
			}

			if ($idInvoice = $this->invoice_model->saveInvoiceService()) {
				$data["result"] = true;		
				$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }

	/**
	 * Delete programming
     * @since 5/7/2021
	 */
	public function delete_invoice_service()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$arrParam = array('idInvoiceService' =>$this->input->post('identificador'));
			$data['invoiceDetails'] = $this->general_model->get_invoice_details($arrParam);//invoice details
			$data["idRecord"] = $data['invoiceDetails'][0]['fk_id_invoice'];

			if ($this->invoice_model->inactiveInvoiceService()) 
			{				
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> The record was deleted!');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}				

			echo json_encode($data);
    }

	
}