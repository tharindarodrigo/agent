/**
 * Created by Tharinda on 2015-05-06.
 */
function postData(url, method, prefix, formData , successpage, defaultPage){
    $.ajax({
        url: url,
        method: method,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        data: formData,
        success: function(data){
            if(!data.validation){
                $.each(data.errors, function(index, error){
                    var id = '#'+prefix+index;
                    var div = $(id).closest('div').next('.custom_validation');
                    div.html(error);

                    div.slideDown(200);
                });
            } else {

                if(data.success){
                    window.location.href = successpage;
                } else {
                    $('.unsuccess_alert').html(data.alert).slideDown(200);
                }

            }

        },

        error: function(){
            alert('There was an error signing In');
        }

    });
}