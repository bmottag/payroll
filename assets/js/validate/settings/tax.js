$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      return true;
    }
  });

  $("#taxes_value").bloquearTexto().maxlength(2);
  $("#taxes_description").convertirMayuscula();
  $('#form').validate({
    rules: {
      taxes_description:     { required: true, minlength: 3, maxlength:30 },
      taxes_value:    { required: true, maxlength:2 }
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

    $(".btn-danger").click(function () {  
      var oID = $(this).attr("id");
      
      //Activa icono guardando
      if(window.confirm('Are you sure to delete the Tax?'))
      {
          $(".btn-danger").attr('disabled','-1');
          $.ajax ({
            type: 'POST',
            url: base_url + 'settings/delete_tax',
            data: {'identificador': oID},
            cache: false,
            success: function(data){
                        
              if( data.result == "error" )
              {
                alert(data.mensaje);
                $(".btn-danger").removeAttr('disabled');              
                return false;
              } 
                      
              if( data.result )//true
              {                                                         
                $(".btn-danger").removeAttr('disabled');

                var url = base_url + "settings/company";
                $(location).attr("href", url);
              }
              else
              {
                alert('Error. Reload the web page.');
                $(".btn-danger").removeAttr('disabled');
              } 
            },
            error: function(result) {
              alert('Error. Reload the web page.');
              $(".btn-danger").removeAttr('disabled');
            }

          });
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
          url: base_url + "settings/save_tax", 
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

              var url = base_url + "settings/company";
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
