<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Clase para consultas generales a una tabla
 */
class General_model extends CI_Model {

    /**
     * Consulta BASICA A UNA TABLA
     * @param $TABLA: nombre de la tabla
     * @param $ORDEN: orden por el que se quiere organizar los datos
     * @param $COLUMNA: nombre de la columna en la tabla para realizar un filtro (NO ES OBLIGATORIO)
     * @param $VALOR: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
     * @since 8/11/2016
     */
    public function get_basic_search($arrData) {
        if ($arrData["id"] != 'x')
            $this->db->where($arrData["column"], $arrData["id"]);
        $this->db->order_by($arrData["order"], "ASC");
        $query = $this->db->get($arrData["table"]);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }
	
	/**
	 * Delete Record
	 * @since 25/5/2017
	 */
	public function deleteRecord($arrDatos) 
	{
			$query = $this->db->delete($arrDatos ["table"], array($arrDatos ["primaryKey"] => $arrDatos ["id"]));
			if ($query) {
				return true;
			} else {
				return false;
			}
	}
	
	/**
	 * Update field in a table
	 * @since 11/12/2016
	 */
	public function updateRecord($arrDatos) {
		$data = array(
			$arrDatos ["column"] => $arrDatos ["value"]
		);
		$this->db->where($arrDatos ["primaryKey"], $arrDatos ["id"]);
		$query = $this->db->update($arrDatos ["table"], $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Lista de menu
	 * Modules: MENU
	 * @since 30/3/2020
	 */
	public function get_menu($arrData) 
	{		
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("menuStatus", $arrData)) {
			$this->db->where('menu_status', $arrData["menuStatus"]);
		}
		if (array_key_exists("columnOrder", $arrData)) {
			$this->db->order_by($arrData["columnOrder"], 'asc');
		}else{
			$this->db->order_by('menu_type, menu_order', 'asc');
		}
		
		$query = $this->db->get('param_menu');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}	

	/**
	 * Lista de roles
	 * Modules: ROL
	 * @since 30/3/2020
	 */
	public function get_roles($arrData) 
	{		
		if (array_key_exists("filtro", $arrData)) {
			$this->db->where('id_role !=', 99);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('id_role', $arrData["idRole"]);
		}
		
		$this->db->order_by('role_name', 'asc');
		$query = $this->db->get('param_role');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * User list
	 * @since 30/3/2020
	 */
	public function get_user($arrData) 
	{			
		$this->db->select();
		$this->db->join('param_role R', 'R.id_role = U.fk_id_user_role', 'INNER');
		if (array_key_exists("status", $arrData)) {
			$this->db->where('U.status', $arrData["status"]);
		}
		
		//list without inactive users
		if (array_key_exists("filtroStatus", $arrData)) {
			$this->db->where('U.status !=', 2);
		}
		
		if (array_key_exists("idUser", $arrData)) {
			$this->db->where('U.id_user', $arrData["idUser"]);
		}
		if (array_key_exists("idCompany", $arrData)) {
			$this->db->where('U.fk_id_app_company_u', $arrData["idCompany"]);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('U.fk_id_user_role', $arrData["idRole"]);
		}

		$this->db->order_by("first_name, last_name", "ASC");
		$query = $this->db->get("user U");

		if ($query->num_rows() >= 1) {
			return $query->result_array();
		} else
			return false;
	}
	
	/**
	 * Lista de enlaces
	 * Modules: MENU
	 * @since 31/3/2020
	 */
	public function get_links($arrData) 
	{		
		$this->db->select();
		$this->db->join('param_menu M', 'M.id_menu = L.fk_id_menu', 'INNER');
		
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('fk_id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("idLink", $arrData)) {
			$this->db->where('id_link', $arrData["idLink"]);
		}
		if (array_key_exists("linkType", $arrData)) {
			$this->db->where('link_type', $arrData["linkType"]);
		}			
		if (array_key_exists("linkStatus", $arrData)) {
			$this->db->where('link_status', $arrData["linkStatus"]);
		}
		
		$this->db->order_by('M.menu_order, L.order', 'asc');
		$query = $this->db->get('param_menu_links L');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * Lista de permisos
	 * Modules: MENU
	 * @since 31/3/2020
	 */
	public function get_role_access($arrData) 
	{		
		$this->db->select('P.id_access, P.fk_id_menu, P.fk_id_link, P.fk_id_role, M.menu_name, M.menu_order, M.menu_type, L.link_name, L.link_url, L.order, L.link_icon, L.link_type, R.role_name, R.style');
		$this->db->join('param_menu M', 'M.id_menu = P.fk_id_menu', 'INNER');
		$this->db->join('param_menu_links L', 'L.id_link = P.fk_id_link', 'LEFT');
		$this->db->join('param_role R', 'R.id_role = P.fk_id_role', 'INNER');
		
		if (array_key_exists("idPermiso", $arrData)) {
			$this->db->where('id_access', $arrData["idPermiso"]);
		}
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('P.fk_id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("idLink", $arrData)) {
			$this->db->where('P.fk_id_link', $arrData["idLink"]);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('P.fk_id_role', $arrData["idRole"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('M.menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("linkStatus", $arrData)) {
			$this->db->where('L.link_status', $arrData["linkStatus"]);
		}
		if (array_key_exists("menuURL", $arrData)) {
			$this->db->where('M.menu_url', $arrData["menuURL"]);
		}
		if (array_key_exists("linkURL", $arrData)) {
			$this->db->where('L.link_url', $arrData["linkURL"]);
		}		
		
		$this->db->order_by('R.id_role, M.menu_order, L.order', 'asc');
		$query = $this->db->get('param_menu_access P');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * menu list for a role
	 * Modules: MENU
	 * @since 2/4/2020
	 */
	public function get_role_menu($arrData) 
	{		
		$this->db->select('distinct(fk_id_menu), menu_url,menu_icon,menu_name,menu_order');
		$this->db->join('param_menu M', 'M.id_menu = P.fk_id_menu', 'INNER');

		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('P.fk_id_role', $arrData["idRole"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('M.menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("menuStatus", $arrData)) {
			$this->db->where('M.menu_status', $arrData["menuStatus"]);
		}
					
		//$this->db->group_by("P.fk_id_menu"); 
		$this->db->order_by('M.menu_order', 'asc');
		$query = $this->db->get('param_menu_access P');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Contar registros de un usuario para el año actual
	 * si es administrador cuenta todo
	 * @author BMOTTAG
	 * @since  14/11/2016
	 */
	public function countPayroll()
	{
		$idCompany = $this->session->userdata("idCompany");
		$userRol = $this->session->userdata("idRole");
		$idUser = $this->session->userdata("idUser");

		$year = date('Y');
		$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));

		$sql = "SELECT count(id_payroll) CONTEO";
		$sql.= " FROM payroll P";
		$sql.= " INNER JOIN param_jobs J ON J.id_job = P.fk_id_job";
		$sql.= " INNER JOIN param_client C ON C.id_param_client = J.fk_id_param_client";
		$sql.= " WHERE P.start >= '$firstDay'";
		$sql.= " AND C.fk_id_app_company = $idCompany";
		
		if($userRol == 2){ //If it is a normal user, just show the records of the user session
			$sql.= " AND P.fk_id_user = $idUser";
		}

        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->CONTEO;
	}

    /**
     * Payroll list
     * Modules: Dashboard - Payroll
     * @since 10/11/2016
     */
    public function get_payroll($arrData) 
	{
        $this->db->select("T.*, CONCAT(first_name, ' ', last_name) name, id_user, fk_id_app_company_u, first_name, last_name, log_user, J.job_description job_start");
        $this->db->join('user U', 'U.id_user = T.fk_id_user', 'INNER');
		$this->db->join('param_jobs J', 'J.id_job = T.fk_id_job', 'INNER');
		$this->db->join('param_client C', 'C.id_param_client = J.fk_id_param_client', 'INNER');
		$this->db->where('C.fk_id_app_company', $this->session->idCompany);
		
        if (array_key_exists("idUser", $arrData)) {
            $this->db->where('U.id_user', $arrData["idUser"]);
        }
		if (array_key_exists("idPayroll", $arrData)) {
			$this->db->where('T.id_payroll', $arrData["idPayroll"]);
		}

		if (array_key_exists("from", $arrData) && $arrData["from"] != '') {
			$this->db->where('T.start >=', $arrData["from"]);
		}				
		if (array_key_exists("to", $arrData) && $arrData["to"] != '' && $arrData["from"] != '') {
			$this->db->where('T.start <', $arrData["to"]);
		}
		if (array_key_exists("fecha", $arrData)) {
			$this->db->like('T.start', $arrData["fecha"]); 
		}
		
		$this->db->order_by('id_payroll', 'desc');
		
        if (array_key_exists("limit", $arrData)) {
            $query = $this->db->get('payroll T', $arrData["limit"]);
        }else{
        	$query = $this->db->get('payroll T');
        }


        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

	/**
	 * Company list
	 * @since 12/6/2020
	 */
	public function get_app_company($arrData) 
	{			
		$this->db->select();
		$this->db->join('app_param_cities C', 'C.id_city = APP.fk_id_city', 'INNER');
		if (array_key_exists("status", $arrData)) {
			$this->db->where('APP.company_status', $arrData["status"]);
		}
		if (array_key_exists("idCompany", $arrData)) {
			$this->db->where('APP.id_company', $arrData["idCompany"]);
		}
		$this->db->order_by("company_name", "ASC");
		$query = $this->db->get("app_company APP");

		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}else{
			return false;
		}
	}

	/**
	 * Job list
	 * @since 16/6/2021
	 */
	public function get_jobs($arrData) 
	{			
		$this->db->select('J.*, param_client_name');
		$this->db->join('param_client C', 'C.id_param_client = J.fk_id_param_client', 'INNER');
		$this->db->where('fk_id_app_company', $this->session->idCompany);
		if (array_key_exists("idJob", $arrData)) {
			$this->db->where('id_job', $arrData["idJob"]);
		}
		if (array_key_exists("jobStatus", $arrData)) {
			$this->db->where('J.status', $arrData["jobStatus"]);
		}
		if (array_key_exists("clientStatus", $arrData)) {
			$this->db->where('C.param_client_status', $arrData["clientStatus"]);
		}
		$this->db->order_by("C.param_client_name, J.job_description", "ASC");
		$query = $this->db->get("param_jobs J");

		if ($query->num_rows() >= 1) {
			return $query->result_array();
		} else{
			return false;
		}
	}

	/**
	 * Count active companies
	 * @author BMOTTAG
	 * @since  16/6/2021
	 */
	public function countCompanies()
	{
		$sql = "SELECT count(id_company) CONTEO";
		$sql.= " FROM app_company A";
		$sql.= " WHERE company_status = 1";
		
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->CONTEO;
	}

	/**
	 * Client list
	 * @since 12/6/2020
	 */
	public function get_param_clients($arrData) 
	{			
		$this->db->select();
		$this->db->where('fk_id_app_company', $this->session->idCompany);
		if (array_key_exists("status", $arrData)) {
			$this->db->where('C.param_client_status', $arrData["status"]);
		}
		if (array_key_exists("idParamClient", $arrData)) {
			$this->db->where('C.id_param_client', $arrData["idParamClient"]);
		}
		$this->db->order_by("param_client_name", "ASC");
		$query = $this->db->get("param_client C");

		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}else{
			return false;
		}
	}

	/**
	 * Invoice list
	 * @since 12/6/2020
	 */
	public function get_invoice($arrData) 
	{			
		$this->db->select();
		$this->db->join('param_client C', 'C.id_param_client = I.fk_id_param_client_i', 'INNER');
		$this->db->where('fk_id_app_company', $this->session->idCompany);
		if (array_key_exists("idParamClient", $arrData)) {
			$this->db->where('C.id_param_client', $arrData["idParamClient"]);
		}
		if (array_key_exists("idInvoice", $arrData)) {
			$this->db->where('I.id_invoice', $arrData["idInvoice"]);
		}
		$this->db->order_by("invoice_number", "DESC");
		$query = $this->db->get("invoice I");

		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}else{
			return false;
		}
	}

	/**
	 * Invoice details
	 * @since 12/6/2020
	 */
	public function get_invoice_details($arrData) 
	{			
		$this->db->select('S.*');
		$this->db->join('invoice I', 'I.id_invoice = S.fk_id_invoice', 'INNER');
		$this->db->join('param_client C', 'C.id_param_client = I.fk_id_param_client_i', 'INNER');
		$this->db->where('fk_id_app_company', $this->session->idCompany);
		$this->db->where('invoice_service_status', 1);
		if (array_key_exists("idInvoice", $arrData)) {
			$this->db->where('S.fk_id_invoice', $arrData["idInvoice"]);
		}
		if (array_key_exists("idInvoiceService", $arrData)) {
			$this->db->where('S.id_invoice_service', $arrData["idInvoiceService"]);
		}
		$this->db->order_by("id_invoice_service", "ASC");
		$query = $this->db->get("invoice_services S");

		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}else{
			return false;
		}
	}

	/**
	 * Countries list
	 * Modules: MENU
	 * @since 2/4/2020
	 */
	public function get_countries($arrData) 
	{		
		$this->db->select();
		$this->db->order_by('country', 'asc');
		$query = $this->db->get('app_param_countries');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Cities list
	 * @since 6/7/2021
	 */
	public function get_cities($arrData) 
	{		
		$this->db->select();		
		if (array_key_exists("idCountry", $arrData)) {
			$this->db->where('fk_id_contry', $arrData["idCountry"]);
		}		
		$this->db->order_by('C.city', 'asc');
		$query = $this->db->get('app_param_cities C');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Taxes list
	 * @since 20/7/2021
	 */
	public function get_taxes($arrData) 
	{			
		$this->db->select();
		$this->db->where('fk_id_app_company_t ', $this->session->idCompany);
		if (array_key_exists("idTax", $arrData)) {
			$this->db->where('id_param_company_taxes', $arrData["idTax"]);
		}
		$this->db->order_by("taxes_description", "ASC");
		$query = $this->db->get("param_company_taxes T");

		if ($query->num_rows() >= 1) {
			return $query->result_array();
		} else{
			return false;
		}
	}



}