<script type="text/javascript" src="<?php echo base_url("assets/js/validate/payroll/hours.js"); ?>"></script>

<div class="modal-header">
	<h4 class="modal-title">Edit User Hours</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<p class="text-danger"><small><i class="icon fa fa-exclamation-triangle"></i> Fields with * are required.</small></p>
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $information["id_payroll"]; ?>"/>
		<input type="hidden" id="hddObservation" name="hddObservation" value="<?php echo $information["observation"]; ?>"/>

<?php 
$inicio = $information['start'];
$fechaInicio = substr($inicio, 0, 10); 
$horaInicio = substr($inicio, 11, 2);
$minutosInicio = substr($inicio, 14, 2);

$fin = $information['finish'];
$fechaFin = substr($fin, 0, 10); 
$horaFin = substr($fin, 11, 2);
$minutosFin = substr($fin, 14, 2);
?>

		<!-- se pasan los datos anteriores para compararlos con los nuevos -->
		<input type="hidden" id="hddInicio" name="hddInicio" value="<?php echo $inicio; ?>"/>
		<input type="hidden" id="hddFin" name="hddFin" value="<?php echo $fin; ?>"/>
		
		<input type="hidden" id="hddfechaInicio" name="hddfechaInicio" value="<?php echo $fechaInicio; ?>"/>
		<input type="hidden" id="hddhoraInicio" name="hddhoraInicio" value="<?php echo $horaInicio; ?>"/>
		<input type="hidden" id="hddminutosInicio" name="hddminutosInicio" value="<?php echo $minutosInicio; ?>"/>
		<input type="hidden" id="hddfechaFin" name="hddfechaFin" value="<?php echo $fechaFin; ?>"/>
		<input type="hidden" id="hddhoraFin" name="hddhoraFin" value="<?php echo $horaFin; ?>"/>
		<input type="hidden" id="hddminutosFin" name="hddminutosFin" value="<?php echo $minutosFin; ?>"/>
		
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">Start date: *</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="start_date" name="start_date" data-target="#reservationdate" value="<?php echo $fechaInicio; ?>" placeholder="Start date" required/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
				</div>
			</div>
			
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="lastName">Start hour: *</label>
					<select name="start_hour" id="start_hour" class="form-control" required>
						<option value='' >Select...</option>
						<?php
						for ($i = 0; $i < 24; $i++) {
							
							$i = $i<10?"0".$i:$i;
							?>
							<option value='<?php echo $i; ?>' <?php
							if ($information && $i == $horaInicio) {
								echo 'selected="selected"';
							}
							?>><?php echo $i; ?></option>
						<?php } ?>									
					</select>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="lastName">Start minutes: *</label>
					<select name="start_min" id="start_min" class="form-control" required>
						<?php
						for ($xxx = 0; $xxx < 60; $xxx++) {
							
							$xxx = $xxx<10?"0".$xxx:$xxx;
						?>
							<option value='<?php echo $xxx; ?>' <?php
							if ($information && $xxx == $minutosInicio) {
								echo 'selected="selected"';
							}
							?>><?php echo $xxx; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">End date: *</label>
                    <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="finish_date" name="finish_date" data-target="#reservationdate2" value="<?php echo $fechaFin; ?>" placeholder="End date" required/>
                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
				</div>
			</div>
			
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="lastName">End hour: *</label>
					<select name="finish_hour" id="finish_hour" class="form-control" required>
						<option value='' >Select...</option>
						<?php
						for ($i = 0; $i < 24; $i++) {
							
							$i = $i<10?"0".$i:$i;
							?>
							<option value='<?php echo $i; ?>' <?php
							if ($information && $i == $horaFin) {
								echo 'selected="selected"';
							}
							?>><?php echo $i; ?></option>
						<?php } ?>									
					</select>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="lastName">End minutes: *</label>
					<select name="finish_min" id="finish_min" class="form-control" required>
						<?php
						for ($xxx = 0; $xxx < 60; $xxx++) {
							
							$xxx = $xxx<10?"0".$xxx:$xxx;
						?>
							<option value='<?php echo $xxx; ?>' <?php
							if ($information && $xxx == $minutosFin) {
								echo 'selected="selected"';
							}
							?>><?php echo $xxx; ?></option>
						<?php } ?>
					</select>
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

    $('#reservationdate2').datetimepicker({
        format: 'YYYY-MM-DD'
    });
   });
 </script>