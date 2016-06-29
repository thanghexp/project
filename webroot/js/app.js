
function updateStatus() {

    if($('#action').val() == 1) {
        $('#status').attr('disabled', false);
    } else {
        $('#status').attr('disabled', true);
    }    
    
}

function checkDelete(event) {
    var message = confirm('Do you really delete this record ?');
    if(message == false) {
        event.preventDefault();
    }
}

function actions(event) {
     if($('#action').val() == 0) {
        alert('You still not choose yet !!');
        event.preventDefault();
    } else {
        var temp = confirm('Do you really action this records ?');
        if(temp == false) {
            event.preventDefault();
        }
    }
}


$(document).ready(function() {
    $('#charts_sale').fadeOut();

    $('#show_charts').click(function() {
        if( $('#show_charts').val() == 1) {
            $('#charts_sale').fadeIn();
            $('#show_charts').val(0);
        } else {
            $('#charts_sale').fadeOut();
            $('#show_charts').val(1);
        }
    });

  
    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    })
    
});

