$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      return true;
    }
  });


jQuery.validator.addMethod("validacion", function(value, element, param) {
  
  var start_date = $('#start_date').val();
  var start_hour = $('#start_hour').val();
  var start_min = $('#start_min').val();
  var finish_date = $('#finish_date').val();
  var finish_hour = $('#finish_hour').val();
  var finish_min = $('#finish_min').val();
  
  var hddfechaInicio = $('#hddfechaInicio').val();
  var hddhoraInicio = $('#hddhoraInicio').val();
  var hddminutosInicio = $('#hddminutosInicio').val();
  var hddfechaFin = $('#hddfechaFin').val();
  var hddhoraFin = $('#hddhoraFin').val();
  var hddminutosFin = $('#hddminutosFin').val();
  
  if (hddfechaInicio == start_date &&  hddhoraInicio == start_hour  &&  hddminutosInicio == start_min &&  hddfechaFin == finish_date &&  hddhoraFin == finish_hour &&  hddminutosFin == finish_min) {
    return false;
  }else{
    return true;
  }
}, "One of the field have to be different.");

  $('#form').validate({
    rules: {
      start_date:       { required: true },
      start_hour:       { required: true },
      start_min:        { required: true },
      finish_date:      { required: true },
      finish_hour:      { required: true },
      finish_min:       { required: true },
      observation:      { required: true, validacion:true }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });

  $("#btnSubmit").click(function(){   
  
    if ($("#form").valid() == true){
    
        //Activa icono guardando
        $('#btnSubmit').attr('disabled','-1');
        $("#div_error").css("display", "none");
        $("#div_load").css("display", "inline");
      
        $.ajax({
          type: "POST", 
          url: base_url + "payroll/save_Payroll_Hour",
          data: $("#form").serialize(),
          dataType: "json",
          contentType: "application/x-www-form-urlencoded;charset=UTF-8",
          cache: false,
          
          success: function(data){
                                            
            if( data.result == "error" )
            {
              $("#div_load").css("display", "none");
              $("#div_error").css("display", "inline");
              $("#span_msj").html(data.mensaje);
              $('#btnSubmit').removeAttr('disabled');             
              return false;
            } 

            if( data.result )//true
            {                                                         
              $("#div_load").css("display", "none");
              $('#btnSubmit').removeAttr('disabled');

              var url = base_url + "settings/editHours/" + data.idRecord;
              $(location).attr("href", url);
            }
            else
            {
              alert('Error. Reload the web page.');
              $("#div_load").css("display", "none");
              $("#div_error").css("display", "inline");
              $('#btnSubmit').removeAttr('disabled');
            } 
          },
          error: function(result) {
            alert('Error. Reload the web page.');
            $("#div_load").css("display", "none");
            $("#div_error").css("display", "inline");
            $('#btnSubmit').removeAttr('disabled');
          }
          
    
        }); 
    
    }//if     
  });
});