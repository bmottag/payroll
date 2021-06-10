<script type="text/javascript" src="<?php echo base_url("assets/js/validate/payroll/payrollStart.js"); ?>"></script>


<section class="content">
	<div class="card card-primary card-outline">
		<div class="card-body row">
			<div class="col-5 text-center d-flex align-items-center justify-content-center">
				<div class="">
					<h2 class="text-primary">Start <strong>Shift</strong></h2>
					<p class="lead mb-5">
					  <?php echo date("Y-m-d G:i:s"); ?>
					</p>
				</div>
			</div>
			<div class="col-7">
				<form  name="form" id="form" method="post" action="<?php echo base_url("payroll/save_payroll"); ?>" >
				<div class="form-group">
					<label for="inputName">Address</label>
					<input id="latitud" name="latitud" type="hidden">					
					<input id="longitud" name="longitud" type="hidden">	
					<input id="address" name="address" type="hidden">	

					<div class="input-group mb-3">
						<input id="viewaddress" name="viewaddress" class="form-control rounded-0" type="text" disabled placeholder="Address">
						<span class="input-group-append">
						<a class="btn btn-primary" href=" <?php echo base_url().'payroll/add_payroll'; ?> "><i class="fa fa-sync-alt"></i> </a> 
						</span>
					</div>
				</div>
				<div class="form-group">
					<div id="map" style="width: 100%; height: 150px"></div>	
				</div>
				<div class="form-group">
					<label for="jobName">Job Code/Name</label>
					<select name="jobName" id="jobName" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($jobs); $i++) { ?>
							<option value="<?php echo $jobs[$i]["id_job"]; ?>" ><?php echo $jobs[$i]["job_description"]; ?></option>	
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="inputMessage">Task/Report Description	</label>
					<textarea id="taskDescription" name="taskDescription" class="form-control" rows="3"></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary" id='btnSubmit' name='btnSubmit'>Submit </button>
				</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script>
	var options = {
	  enableHighAccuracy: true,
	  timeout: 5000,
	  maximumAge: 0
	};

	function success(pos) {
	  var crd = pos.coords;

	  console.log('Your current position is:');
	  console.log('Latitude : ' + crd.latitude);
	  console.log('Longitude: ' + crd.longitude);
	  console.log('More or less ' + crd.accuracy + ' meters.');
	  $("#latitud").val(crd.latitude);
	  $("#longitud").val(crd.longitude);
	  var pos = {
				  lat: crd.latitude,
				  lng: crd.longitude
				};
	  map.setCenter(pos);
	  map.setZoom(14);
	  
	showLatLong(crd.latitude, crd.longitude);
	  
	  ultimaPosicionUsuario = new google.maps.LatLng(crd.latitude, crd.longitude);
      marcadorUsuario = new google.maps.Marker({
        position: ultimaPosicionUsuario,
        map: map
      });
	};

	function error(err) {
	  console.warn('ERROR(' + err.code + '): ' + err.message);
	};

	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		infoWindow.setPosition(pos);
		infoWindow.setContent(browserHasGeolocation ?
							  'Error: Error en el servicio de localizacion.' :
							  'Error: Navegador no soporta geolocalizacion.');
	  }
	

/**
 * INICIO --- Capturar direccion
 * http://www.elclubdelprogramador.com/2012/04/22/html5-obteniendo-direcciones-a-partir-de-latitud-y-longitud-geolocalizacion/
 */
function showLatLong(lat, longi) {
var geocoder = new google.maps.Geocoder();
var yourLocation = new google.maps.LatLng(lat, longi);
geocoder.geocode({ 'latLng': yourLocation },processGeocoder);

}
function processGeocoder(results, status){

if (status == google.maps.GeocoderStatus.OK) {
if (results[0]) {
document.forms[0].address.value=results[0].formatted_address;
document.forms[0].viewaddress.value=results[0].formatted_address;
} else {
error('Google no retorno resultado alguno.');
}
} else {
error("Geocoding fallo debido a : " + status);
}
}
/**
 * FIN
 */	
	
	function initMap() {
		var pais = new google.maps.LatLng(51.0209884,-114.1591999);
		var mapOptions = {
			center: pais,
			zoom: 11,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		map = new google.maps.Map(document.getElementById('map'), mapOptions);
		
		
		
		//Inicializa el objeto geocoder
		geocoder = new google.maps.Geocoder();
				
		navigator.geolocation.getCurrentPosition(success, error, options);
		
	}	

  </script>

			

	<script async defer		
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDt__a_n1IUtBPqj9ntMD5cNG8gYlcovWM&libraries=places&callback=initMap">
	</script>