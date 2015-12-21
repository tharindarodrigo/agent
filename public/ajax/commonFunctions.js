/**
 * Created by Tharinda on 2015-05-03.
 */
function confirmDelete(){

    var model='<div class="modal modal-danger">'+
        '<div class="modal-dialog">'+
            '<div class="modal-content">'+
                '<div class="modal-header">'+
                    '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>'+
                    '<h4 class="modal-title">Delete Item</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                    '<p>One fine body…</p>'+
                '</div>'+
                '<div class="modal-footer">'+
                    '<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>'+
                    '<button type="button" class="btn btn-outline">Delete Item</button>'+
                '</div>'+
            '</div><!-- /.modal-content -->'+
        '</div><!-- /.modal-dialog -->'+
    '</div>';

}

function confirm(heading, question, cancelButtonTxt, okButtonTxt, callback1, callback2) {
    var confirmModal = $('<div class="modal modal-danger">' +
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
    '<button type="button" class="btn btn-outline pull-left" data-dismiss="modal" id="cancelbtn">' + cancelButtonTxt + '</button>' +
    '<button type="button" class="btn btn-outline" id="okButton">' + okButtonTxt + '</button>' +
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

function confirmDeleteItem(){
    $('.delete-button').click(function(){
        var deleteButton =$(this);
        confirm("Delete Record", 'Do you really want to delete this Item?', 'No', 'Yes', function() {
            deleteButton.closest('form').submit();
        });
    });
}