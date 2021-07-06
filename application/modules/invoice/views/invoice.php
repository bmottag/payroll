<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'invoice/cargarModalInvoice',
                data: {'idInvoice': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
});
</script>

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
			<div class="col-12">
				<!-- Default box -->
				<div class="card">
					<div class="card-header">
						<div class="btn-group btn-group-toggle">
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="x">
									<span class="fa fa-plus" aria-hidden="true"></span> Add Invoice
							</button>
						</div>
						<div class="card-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" name="table_search" class="form-control float-right" placeholder="Search">
								<div class="input-group-append">
									<button type="submit" class="btn btn-default">
										<i class="fas fa-search"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body table-responsive p-0">

					<?php 										
						if(!$info){ 
							echo '<div class="col-lg-12">
									<p class="text-danger"><span class="fa fa-alert" aria-hidden="true"></span> No data was found.</p>
								</div>';
						}else{
					?>
						<table class="table table-hover text-nowrap">
							<thead>
								<tr>
								<th class="text-center">#</th>
								<th>Client</th>
								<th class="text-center">Date</th>
								<th class="text-center">Edit</th>
								<th class="text-center">Details</th>
								</tr>
							</thead>
							<tbody>							
							<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['invoice_number'] . "</td>";
									echo "<td>" . $lista['param_client_name'] . "</td>";
									echo "<td class='text-center'>" . $lista['invoice_date'] . "</td>";
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_invoice']; ?>" >
										Edit <span class="fa fa-edit" aria-hidden="true">
									</button>
						<?php
									echo "</td>";
									echo "<td class='text-center'>";
						?>
									<a href="<?php echo 'invoice/details/' . $lista['id_invoice']; ?>" class="btn btn-danger btn-xs"> View Details <i class="fas fa-eye"></i></a>
                            <?php
                            		echo "</td>";
									echo "</tr>";
							endforeach;
							?>
							</tbody>
						</table>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!--INICIO Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal -->