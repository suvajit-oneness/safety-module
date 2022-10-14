$(document).ready(function(){
    var options = {
        disabledActionButtons: ['data','save'],
        onSave: function(evt, formData) {
            $('#form_temp').val(formData);
            console.log('Hey formData');

        },
    };

    // $('#adminCreateTemplate').submit(function()
    //     if($('#form_temp').val() == 'null'){
    //         return false;
    //     }
    // )};
    $('#adminCreateTemplate').submit(function() {
        // console.log('Hey submit');
        $('.save-template').click();
        // $('#give').val(formData);
        if($('#form_temp').val()=='null'){
            return false;
        }
        else{
            // alert($('#form_temp').val());
            return true;
        }
    });
    $('#create').formBuilder(options);
});