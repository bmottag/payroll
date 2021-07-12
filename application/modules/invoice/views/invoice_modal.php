<script type="text/javascript" src="<?php echo base_url("assets/js/validate/invoice/invoice.js"); ?>"></script>

<div class="modal-header">
	<h4 class="modal-title">Invoice Form</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<p class="text-danger"><small><i class="icon fa fa-exclamation-triangle"></i> Fields with * are required.</small></p>
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_invoice"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">Client: *</label>
					<select name="idClient" id="idClient" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($infoClients); $i++) { ?>
							<option value="<?php echo $infoClients[$i]["id_param_client"]; ?>" <?php if($information && $infoClients[$i]["id_param_client"] == $information[0]['fk_id_param_client_i']) { echo "selected"; }  ?>><?php echo $infoClients[$i]["param_client_name"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="invoiceNumber">Invoice Number: *</label>
					<input type="number" id="invoiceNumber" name="invoiceNumber" class="form-control" value="<?php echo $information?$information[0]["invoice_number"]:""; ?>" placeholder="Invoice Number" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">Date: *</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="invoiceDate" name="invoiceDate" data-target="#reservationdate" value="<?php echo $information?$information[0]["invoice_date"]:""; ?>" placeholder="Start date" required/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">

				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="terms">Terms: </label>
					<textarea id="terms" name="terms" placeholder="Terms" class="form-control" rows="3" ><?php echo $information?$information[0]["terms"]:""; ?></textarea>
				</div>
			</div>
		</div>
									
		<div class="form-group">
			<div id="div_load" style="display:none">		
				<div class="progress progress-striped active">
					<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
						<span class="sr-only">45% completado</span>
					</div>
				</div>
			</div>
			<div id="div_error" style="display:none">			
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<div id="span_msj"></div>
				</div>
			</div>	
		</div>
			
	</form>
</div>
<div class="modal-footer justify-content-between">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
		Save <span class="fa fa-save" aria-hidden="true">
	</button> 
</div>

<script>
  $(function () {
    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'YYYY-MM-DD'
    });
   });
 </script>