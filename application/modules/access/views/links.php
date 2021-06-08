<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'access/cargarModalLink',
                data: {'idLink': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
});
</script>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<!-- Default box -->
				<div class="card">
					<div class="card-header">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="x">
								<span class="fa fa-plus" aria-hidden="true"></span> Add a Submenu Link
						</button>

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
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success ">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
	</div>
    <?php
}
?> 

					<?php
						if($info){
					?>				
						<table class="table table-hover text-nowrap">
							<thead>
								<tr>
									<th>Menu name</th>
									<th>Link name</th>
									<th>Link URL</th>
									<th class="text-center">Link icon</th>
									<th class="text-center">Order</th>
									<th class="text-center">State</th>
									<th class="text-center">Edit</th>
								</tr>
							</thead>
							<tbody>							
							<?php
								foreach ($info as $lista):
										echo "<tr>";
										echo "<td>" . $lista['menu_name'] . "</td>";
										echo "<td>" . $lista['link_name'] . "</td>";
										echo "<td>" . $lista['link_url'] . "</td>";
										echo "<td class='text-center'>";
										echo '<button type="button" class="btn btn-danger btn-circle"><i class="fa ' . $lista['link_icon'] . '"></i>';
										echo "</td>";
										echo "<td class='text-center'>" . $lista['order'] . "</td>";
										echo "<td class='text-center'>";
										switch ($lista['link_state']) {
											case 1:
												$valor = 'Active';
												$clase = "text-success";
												break;
											case 2:
												$valor = 'Inactive';
												$clase = "text-danger";
												break;
										}
										echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
										echo "</td>";
										echo "<td class='text-center'>";
							?>
										<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_link']; ?>" >
											Edit <span class="fa fa-edit" aria-hidden="true">
										</button>
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