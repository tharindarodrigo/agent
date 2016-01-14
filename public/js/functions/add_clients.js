
function sendData(url, formData){
    $.ajax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        data: formData,
        success: function (data) {
            var tablecontent = generateClientsTable(data);

            $('#clients_table').html(tablecontent);
            deleteClient();
        },

        error: function () {
            //alert('There was an error signing In');
        }
    });

}


function generateClientsTable(data){
    var table = '';
    if(data != null){
        $.each(data, function(index, item){

            table += '<tr>';
            table += '<td>'+item.name+'</td>';
            table += '<td>'+item.dob+'</td>';
            table += '<td>'+item.passport_number+'</td>';
            table += '<td>'+item.gender+'</td>';
            table += '<td><button type="button" class="btn btn-xs btn-danger delete_button" value="'+index+'"><b>X</b></button></td>';
            table += '</tr>';
        });

    }

    return table;
}

function deleteClient(){
    $('.delete_button').click(function(){
        var formData = new FormData();
        var url = 'http://'+window.location.host+'/bookings/destroy-client';
        formData.append('deletable', $(this).val());

        sendData(url, formData);

    });
    //sendData(url, formData);
}