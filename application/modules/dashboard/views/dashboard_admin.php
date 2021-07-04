<?php
	$retornoExito = $this->session->flashdata('retornoExito');
	if ($retornoExito) {
?>
		<script>
			$(function() {
				toastr.success('<?php echo $retornoExito ?>')
		  	});
		</script>
<?php
	}

	$retornoError = $this->session->flashdata('retornoError');
	if ($retornoError) {
?>
		<script>
			$(function() {
				toastr.error('<?php echo $retornoError ?>')
		  	});
		</script>
<?php
	}
?> 

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-12">
				<div class="info-box">
					<span class="info-box-icon bg-primary"><i class="far fa-building"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Clients</span>
						<span class="info-box-number"><?php echo $noClients; ?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-5">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Change Client</h3>
					</div>

					<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/change_client"); ?>" >
						<div class="card-body">
							<p class="text-primary"><i class="icon fa fa-exclamation-triangle"></i> Select the client.</p>
							<div class="form-group">
								<label for="id_client">Client: *</label>
								<select name="id_client" id="id_client" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php for ($i = 0; $i < count($clients); $i++) { ?>
										<option value="<?php echo $clients[$i]["id_client"]; ?>" <?php if($clients[$i]["id_client"] == $this->session->userdata("idClient")) { echo "selected"; }  ?>><?php echo $clients[$i]["client_name"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="card-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>