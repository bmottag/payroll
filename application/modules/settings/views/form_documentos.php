<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<a class="btn btn-primary btn-xs" href="<?php echo base_url('settings/documentos_procesos/' . $infoProcesos[0]['id_proceso_informacion'] . '/1'); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-image"></i> <strong>DOCUMENTOS </strong> - <?php echo $infoProcesos[0]['title']; ?> - <?php echo $listaTemas[0]['tema']; ?>
				</div>
				<div class="panel-body">
				
					<form  name="form_map" id="form_map" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("settings/do_upload_doc"); ?>">
					<input type="hidden" class="form-control" id="hddidProcesosInfo" name="hddidProcesosInfo" value="<?php echo $infoProcesos[0]['id_proceso_informacion']; ?>" />
					<input type="hidden" class="form-control" id="hddCodigo" name="hddCodigo" value="<?php echo $infoProcesos[0]['codigo']; ?>" />
					<input type="hidden" class="form-control" id="hddidTema" name="hddidTema" value="<?php echo $listaTemas[0]['id_tema']; ?>" />
					<input type="hidden" id="hddidDocumento" name="hddidDocumento" value="<?php echo $information?$information[0]["id_procesos_documento"]:""; ?>"/>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="codigo">Código: *</label>
							<div class="col-sm-5">
								<input type="text" id="codigo" name="codigo" class="form-control" value="<?php echo $information?$information[0]["cod"]:""; ?>" placeholder="Código" maxlength="80" required >
							</div>
						</div>
				
						<div class="form-group">
							<label class="col-sm-4 control-label" for="nombre">Nombre: *</label>
							<div class="col-sm-5">
								<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $information?$information[0]["shortName"]:""; ?>" placeholder="Nombre" maxlength="200" required >
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="orden">Orden: *</label>
							<div class="col-sm-5">
								<select name="orden" id="orden" class="form-control" required>
									<option value='' >Select...</option>
									<?php for ($i = 1; $i <= 70; $i++) { ?>
										<option value='<?php echo $i; ?>' <?php if ($information && $i == $information[0]["orden"]) { echo 'selected="selected"'; } ?> ><?php echo $i; ?></option>
									<?php } ?>									
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="estado">Estado: *</label>
							<div class="col-sm-5">
								<select name="estado" id="estado" class="form-control" required>
									<option value=''>Seleccione...</option>
									<option value=1 <?php if($information && $information[0]["estado"] == 1) { echo "selected"; }  ?>>Activo</option>
									<option value=2 <?php if($information && $information[0]["estado"] == 2) { echo "selected"; }  ?>>Inactivo</option>
								</select>
							</div>
						</div>
				
						<div class="col-lg-6">				
							<div class="form-group">					
								<label class="col-sm-5 control-label" for="hddTask">Adjuntar documento</label>
								<div class="col-sm-5">
									 <input type="file" name="userfile" />
								</div>
							</div>
						</div>
					
						<div class="col-lg-6">				
							<div class="form-group">
								<div class="row" align="center">
									<div style="width:50%;" align="center">
										<button type="submit" id="btnSubmit" name="btnSubmit" class='btn btn-primary'>
												Guardar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
										</button>
									</div>
								</div>
							</div>
						</div>
				</form>

					<?php if($error){ ?>
					<div class="col-lg-12">
						<div class="alert alert-danger">
						<?php 
							echo "<strong>Error :</strong>";
							pr($error); 
						?><!--$ERROR MUESTRA LOS ERRORES QUE PUEDAN HABER AL SUBIR LA IMAGEN-->
						</div>
					</div>
					<?php } ?>
					
					<div class="col-lg-12">
						<div class="alert alert-danger">
								<strong>Nota :</strong><br>
								Tamaño máximo: 3000 KB
								
						</div>
					</div>

					
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->