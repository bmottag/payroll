<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Invoice_model extends CI_Model {

	    function __construct(){        
	        parent::__construct();      
	    }
		
		/**
		 * Add/Edit INVOICE
		 * @since 5/7/2021
		 */
		public function saveInvoice() 
		{				
				$idInvoice = $this->input->post('hddId');
				
				$data = array(
					'fk_id_param_client_i' => $this->input->post('idClient'),
					'invoice_number' => $this->input->post('invoiceNumber'),
					'terms' => $this->input->post('terms'),
					'invoice_date' => $this->input->post('invoiceDate')
				);			

				//revisar si es para adicionar o editar
				if ($idInvoice == '') {
					$query = $this->db->insert('invoice', $data);
				} else {
					$this->db->where('id_invoice', $idInvoice);
					$query = $this->db->update('invoice', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Add/Edit INVOICE SERIVICE
		 * @since 5/7/2021
		 */
		public function saveInvoiceService() 
		{				
				$idInvoice = $this->input->post('hddIdInvoice');
				$idInvoiceService = '';//$this->input->post('hddIdInvoice');
				$rate = $this->input->post('rate');
				$quantity = $this->input->post('quantity');

				$value = $rate * $quantity;
				
				$data = array(
					'fk_id_invoice' => $this->input->post('hddIdInvoice'),
					'service' => $this->input->post('service'),
					'description' => $this->input->post('description'),
					'quantity' => $quantity,
					'rate' => $rate,
					'value' => $value
				);			

				//revisar si es para adicionar o editar
				if ($idInvoiceService == '') {
					$query = $this->db->insert('invoice_services', $data);
				} else {
					$this->db->where('id_invoice', $idInvoiceService);
					$query = $this->db->update('invoice_services', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Inactive invoice service
		 * @since 5/7/2021
		 */
		public function inactiveInvoiceService() 
		{
			$idInvoiceService = $this->input->post('identificador');
		
			$data = array('invoice_service_status' => 2); //inactive status
			
			$this->db->where('id_invoice_service', $idInvoiceService);
			$query = $this->db->update('invoice_services', $data);
						
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		
		
		
	    
	}