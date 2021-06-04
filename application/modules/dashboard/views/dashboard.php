<div id="page-wrapper">
    <div class="row"><br>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						DASHBOARD
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->
    </div>
							
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success ">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<strong><?php echo $this->session->userdata("firstname"); ?></strong> <?php echo $retornoExito ?>		
			</div>
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?> 
			
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-book fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $noPayroll; ?></div>
                            <div>Time Stamp</div>
                        </div>
                    </div>
                </div>
    			
                <a href="#anclaPayroll">
                    <div class="panel-footer">
                        <span class="pull-left">Last Payroll Records</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
			
    <!-- /.row -->
    <div class="row">
    	<div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-book fa-fw"></i> Last Payroll Records
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <?php
                    	if(!$info){ 
                            echo '<div class="col-lg-12">
                                    <small>
                                    <p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No data was found.</p>
                                    </small>
                                </div>';
                    	}else{
                    ?>						
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>Employee</th>
								<th>Start</th>
								<th>Finish</th>
								<th>Working Hours</th>
								<th>Job Start</th>
								<th>Address Start</th>
								<th>Job Finish</th>
								<th>Address Finish</th>
								<th>Task description</th>
								<th>Observation</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
								echo "<tr>";
								echo "<td class='text-center'>" . $lista['first_name'] . " " . $lista['last_name'] . "</td>";
								echo "<td class='text-center'>" . $lista['start'] . "</td>";
								echo "<td class='text-center'>" . $lista['finish'] . "</td>";
								echo "<td class='text-right'>" . $lista['working_hours'] . "</td>";
								echo "<td class='text-center'>" . $lista['job_start'] . "</td>";
								echo "<td class='text-right'>" . $lista['address_start'] . "</td>";
								echo "<td class='text-center'>" . $lista['job_finish'] . "</td>";
								echo "<td class='text-right'>" . $lista['address_finish'] . "</td>";
								echo "<td class='text-right'>" . $lista['task_description'] . "</td>";
								echo "<td class='text-right'>" . $lista['observation'] . "</td>";
								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
					
					<!-- /.table-responsive -->
					<a href="<?php echo base_url("report/searchByDateRange/payroll"); ?>" class="btn btn-default btn-block">View more own records</a>
<?php	} ?>					
				</div>
				<!-- /.panel-body -->
			</div>
		</div>	
    </div>		
</div>
<!-- /#page-wrapper -->

<!-- Tables -->
<script>
$(document).ready(function() {
    $('#dataTables').DataTable({
        responsive: true,
		 "ordering": false,
		 paging: false,
		"searching": false,
		"pageLength": 25
    });	
});
</script>