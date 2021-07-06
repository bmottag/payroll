/**
 * Cities by country
 * @author bmottag
 * @since  6/7/2021
 */

$(document).ready(function () {
	   
    $('#idCountry').change(function () {
        $('#idCountry option:selected').each(function () {
            var idCountry = $('#idCountry').val();
            if (idCountry > 0 || idCountry != '') {
				$("#div_city").css("display", "inline");
				
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'access/citiesListInfo',
                    data: {'idCountry': idCountry},
                    cache: false,
                    success: function (data)
                    {
                        $('#idCity').html(data);
                    }
                });
            } else {				
                var data = '';
				$("#div_city").css("display", "none");
                $('#idCity').html(data);
            }
        });
    });
    
});