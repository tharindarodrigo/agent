/**
 * Created by Tharinda on 2015-02-14.
 */

function postForm(url, formData, type){
        $.ajax({
            url: url,
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            data: formData,
            success: function(data){
                if(!data.success){
                    $.each(data.errors, function(index, error){
                        //alert(error);
                        //$('input').find('#room_facility');

                        var id = '#'+index;
                        var div = $(id).closest('div').next('.customValidationAlert');
                        div.html(error);

                        div.slideDown(200);
                    });

                } else {
                    $('.customValidationAlert').hide(100);
                    $('form').find('input[type=text], textarea').val('');
                    if(type === 'insert' ){
                        toastr.success('successfully added!');
                    } else {
                        toastr.success('successfully updated!');
                    }
                }
            },
            error: function(){

            }
        });
}

function getTable(url, table_id , array){

    $.post(url, function(data, status){
        if(status === 'success'){
            var table = generateDataTable(data, table_id,array['dataFields']);
            $('.table-responsive').html(table);
            buttonClickEvents(url, table_id , array);

            $('#'+table_id).dataTable();


        }
    }, 'json');

}

function generateDataTable(jsonData, table_id, dataFieldsArray){
    var table = '<table id="'+  table_id +'" class="table table-bordered table-striped"><thead><tr><th>ID</th><th>City</th><th class="button-column"></th></tr></thead>'+
    '<tbody>';
    var table_row = '';

    var buttons =   '<button class="btn btn-xs btn-flat btn-primary edit-item" type="button"><span class="glyphicon glyphicon-edit"></span></button>'+
                    '<button class="btn btn-xs btn-flat btn-danger delete-item" type="button"><span class="glyphicon glyphicon-trash"></span></button>';
    var active_inactive ='';
    var x = 0;

    $.each(jsonData, function(i, tableRow){



        if(tableRow.val == '0'){
            active_inactive = '<button class="btn btn-xs btn-flat btn-success activate-item" type="button"><span class="glyphicon glyphicon-ok-circle"></span></button>'+
                                '<button class="btn btn-xs btn-flat btn-default disabled deactivate-item" type="button"><span class="glyphicon glyphicon-remove-circle"></span></button>';
        } else {
            active_inactive = '<button class="btn btn-xs btn-flat btn-default disabled activate-item" type="button"><span class="glyphicon glyphicon-ok-circle"></span></button>' +
            '<button class="btn btn-xs btn-flat btn-warning deactivate-item" type="button" ><span class="glyphicon glyphicon-remove-circle"></span></button>';
        }

        table_row += '<tr id="'+jsonData[i]['id']+'"><td>'+ (++x )+'</td>';
        $.each(dataFieldsArray, function(j, tableData){

            table_row += '<td>'+jsonData[i][dataFieldsArray[j]]+'</td>';
        });

        table_row  += '<td>'+buttons+active_inactive+'</td>'+'</tr>';

    });

    return table+table_row+'</tbody>';
}

function buttonClickEvents(url, table_id , array){
    var edit_item = '.edit-item';
    var delete_item = '.delete-item';
    var activate_item = '.activate-item';
    var deactivate_item = '.deactivate-item';

    $(edit_item).click(function(){
        var id = $(this).closest('tr').attr('id');
        $('.customValidationAlert').hide(100);
        editItem(array['edit_url'],id,array['form_bindings']['form_fields'], array['form_bindings']['db_fields']);
        $('.btn_cancel_update_item').click(function(){
            $('.btn_update_item, .btn_cancel_update_item').hide(300);
            $('.submit_btn').removeAttr("disabled");
            $('.submit_btn').fadeIn(300);
            $('.customValidationAlert').hide();
            $('form').find('input[type=text], textarea').val('');
        });
        $('#temp_id').val(id);
    });
    $(delete_item).click(function(){

        var id = $(this).closest('tr').attr('id');
        confirm("Delete Record", 'Do you really want to delete this Item?', 'No', 'Yes', function() {

            deleteItem(array['delete_url'], id);
            $.post(array['pages']['refresh'], {ajax: 'data'}, function(e) {
                getTable(url, table_id , array);
            });
        });

    });
    $(activate_item).click(function(){
        var id = $(this).closest('tr').attr('id');
        activateItem(array['activate_url'], id);
        $.post(array['pages']['refresh'], {ajax: 'data'}, function(e) {
            getTable(url, table_id , array);
        });
    });
    $(deactivate_item).click(function(){
        var id = $(this).closest('tr').attr('id');
        deactivateItem(array['deactivate_url'], id);
        $.post(array['pages']['refresh'], {ajax: 'data'}, function(e) {
            getTable(url, table_id, array);
        });
    });
}

function editItem(url,id, array_form_fields, array_db_fields){
    url =url+id
    $('.submit_btn').attr("disabled", true);


    $.post(url, function(data, status){
        if(status === 'success'){
            $.each(array_db_fields,function(index, item){
                $(array_form_fields[index]).val(data[0][array_db_fields[index]]);
            });

            $('.submit_btn').hide();
            $('.btn_update_item, .btn_cancel_update_item').fadeIn(300);
        }

    },'json');
}

function deleteItem(url,id){

    var url = url+id;
        $.post(url, function (data, status) {
            if (status === 'success') {
                if (data.success) {
                    toastr.success('Successfully Deleted');
                } else {
                    toastr.error('You cannot Delete this Item!');
                }
            } else {
                toastr.error('Error There was a problem please contact your Administrator');
            }
        }, 'json');

}

function activateItem(url,id){

    var url = url+id;
    $.post(url,function(data, status){
        if(status === 'success'){
            if(data.success){
                toastr.success('Successfully Activated');
            } else {
                toastr.error(data.error);
            }
        } else {
            toastr.warning('Error There was a problem please contact your Administrator');
        }
    }, 'json');

}

function deactivateItem(url,id){

    var url = url+id;
    $.post(url,function(data, status){
        if(status === 'success'){
            if(data.success){
                toastr.success('Successfully Deactivated');
            } else {
                toastr.error('Error Deactivating');
            }
        } else {
            toastr.warning('Error: There was a problem please contact your Administrator');
        }
    }, 'json');

}


function confirm(heading, question, cancelButtonTxt, okButtonTxt, callback1, callback2) {
    var confirmModal = $('<div class="modal fade">' +
    '<div class="modal-dialog">' +
    '<div class="modal-content">' +
    '<div class="modal-header">' +
    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
    '<h4 class="modal-title">' + heading + '</h4>' +
    '</div>' +
    '<div class="modal-body">' +
    '<p>' + question + '</p>' +
    '</div>' +
    '<div class="modal-footer">' +
    '<button type="button" class="btn btn-default" data-dismiss="modal" id="cancelbtn">' + cancelButtonTxt + '</button>' +
    '<button type="button" class="btn btn-primary " id="okButton">' + okButtonTxt + '</button>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>');
    confirmModal.find('#okButton').click(function(event) {
        callback1();
        confirmModal.modal('hide');
    });
    confirmModal.find('#cancelbtn').click(function(event) {
        callback2();
        confirmModal.modal('hide');
    });
    confirmModal.modal('show');
}

