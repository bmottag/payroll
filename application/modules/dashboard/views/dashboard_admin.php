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
					<span class="info-box-icon bg-primary"><i class="fa fa-puzzle-piece"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Companies</span>
						<span class="info-box-number"><?php echo $noCompanies; ?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-5">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Change Company</h3>
					</div>

					<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/change_company"); ?>" >
						<div class="card-body">
							<p class="text-primary"><i class="icon fa fa-exclamation-triangle"></i> Select the company.</p>
							<div class="form-group">
								<label for="id_client">Company: *</label>
								<select name="id_company" id="id_company" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php for ($i = 0; $i < count($companyInfo); $i++) { ?>
										<option value="<?php echo $companyInfo[$i]["id_company"]; ?>" <?php if($companyInfo[$i]["id_company"] == $this->session->userdata("idCompany")) { echo "selected"; }  ?>><?php echo $companyInfo[$i]["company_name"]; ?></option>	
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