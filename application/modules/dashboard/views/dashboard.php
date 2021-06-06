<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Dashboard</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
			
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-12">
				<div class="info-box">
					<span class="info-box-icon bg-info"><i class="far fa-clock"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Time Stamp</span>
						<span class="info-box-number"><?php echo $noPayroll; ?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Last Payroll Records</h3>
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
              		<!-- /.card-header -->

                    <?php
                    	if(!$info){ 
                            echo '<div class="col-lg-12">
                                    <small>
                                    <p class="text-danger"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> No data was found.</p>
                                    </small>
                                </div>';
                    	}else{
                    ?>
					<div class="card-body table-responsive p-0" style="height: 300px;">
						<table class="table table-head-fixed text-nowrap">
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
					</div>
					<!-- /.card-body -->
					<?php	} ?>
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>
</section>