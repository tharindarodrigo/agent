/**
 * Created by Tharinda on 2015-07-28.
 */
function loadCities(country_id){
    var url = 'http://'+window.location.host+'/control-panel/general/cities/get-cities/'+country_id;
    var cities = '';
    $.ajax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        success: function(data){
            $.each(data,function(i,item){
                cities += '<option value="'+item.id+'">'+item.city+'</option>';
            });
            $('select[name="city_id"]').html(cities);

        }
    });
}