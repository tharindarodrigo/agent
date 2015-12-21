/**
 * Created by Tharinda on 2015-05-25.
 */


var fileCollection = new Array();

$('#images').on('change',function(e){

    var files = e.target.files;

    $.each(files,function(i,file){
        fileCollection.push(file);
        var reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function(e){
            var template = '<div class="col-xs-12 col-md-3">' +
                '<a href="#" class="thumbnail">' +
                '<img style="" src="'+ e.target.result+'"/>' +
                '</a>' +
                '</div>';
            //alert(template);
            $('#images-to-upload').append(template);

        }
    });

});

