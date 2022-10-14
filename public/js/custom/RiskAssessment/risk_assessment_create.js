
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.datepicker').datepicker({
      dateFormat: "dd-M-yy"
    });

    $('.summernote').summernote({
        toolbar: true
    });

    $('.datepicker').attr("autocomplete", "off");
    
    $('[data-toggle="tooltip"]').tooltip();
    $("#RiskForm").ajaxForm(formValidations);
    if($('#b_18_table tbody tr').length == 0){
        $('#b_18_tbody ').append('<td colspan="17" class="text-center" id="no_data">No Data Present</td>');
    }
    //console.log(templateData);
    if(templateData){

        for(i=0;i<templateData.length;i++){

            var hazardTypeName = templateData[i]['hazard_lists_code']+' '+templateData[i]['hazard_lists_name'];
           // console.log(i,templateData[i]);
            section2RowCount++;
            add_value(section2RowCount);
            section2Rows.push({

                section2RowCount:section2RowCount,

                hazardTypeId : templateData[i]['hazard_list_id'],
                hazardTypeName : hazardTypeName,

                hazardSubTypeId : templateData[i]['hazard_category_id'],
                hazardSubTypeName : templateData[i]['hazard_lists_code'],

                //hazardTypeName : $('#hazards-name').find(':selected').text(),
                //hazardTypeId : $('#hazards-name').find(':selected').val(),
                //hazardSubTypeName : $('#hazards_subtype').find(':selected').text(),
                //hazardSubTypeId : $('#hazards_subtype').find(':selected').val(),
                hazardEvent : templateData[i]['hazardEvent'],
                source : templateData[i]['source'],
                consequences : templateData[i]['consequences'],
                lkh1 : templateData[i]['lkh1'],
                svr1 : templateData[i]['svr1'],
                rf1 : templateData[i]['rf1'],
                control_measure : templateData[i]['control_measure'],
                lkh2 : templateData[i]['lkh2'],
                svr2 : templateData[i]['svr2'],
                rf2 : templateData[i]['rf2'],
                acFlag : templateData[i]['acFlag'],
                add_control : templateData[i]['add_control'],


                /*threats : templateData[i]['threats'],
                sources : templateData[i]['sources'],
                top_event : templateData[i]['top_event'],
                consequences : templateData[i]['consequences'],

                grr_p : templateData[i]['grr_p'],
                grr_e : templateData[i]['grr_e'],
                grr_a : templateData[i]['grr_a'],
                grr_r : templateData[i]['grr_r'],

                control_barrier : templateData[i]['control'],
                recovery_measure : templateData[i]['recovery_measure'],

                nrr_p : templateData[i]['nrr_p'],
                nrr_e : templateData[i]['nrr_e'],
                nrr_a : templateData[i]['nrr_a'],
                nrr_r : templateData[i]['nrr_r'],

                reduction_measure : templateData[i]['reduction_measure'],
                remarks : templateData[i]['remarks']*/
            });
        }
    }
    $('#section_2_array').val(JSON.stringify(section2Rows));
    //console.log(section2Rows);
    checkForAc();

    // MyScript

    // console.log('Hey 1');

    if($('#create').length)
    {
        // alert('HH');
        var options = {
            onSave: function(evt, formData) {

                console.log('Hey');
                $('#form_temp').val(formData);
                console.log($('#form_temp').val());
            },
        };

        $("#RAfrmSubmit").click(function(){

            $('.save-template').click();
            $("#risk_assessment_form").submit();

        })

        $('#create').formBuilder(options);

    }
    if($('#edit').length)
    {
        console.log(templateData);
        var d = templateData[0].json;

            var formRenderOptions = {
            formData: d
            }
            var formBuilder =  $('#edit').formBuilder(formRenderOptions);

            // $('#risk_form_tempassessment_form').submit(function() {
            //     // console.log(formBuilder.actions.getData('json', true));
            //     $('.save-template').click();
            //     $('#form_temp').val(formBuilder.actions.getData('json', true));
            //     // alert($('#form_temp').val());
            //     // alert('Second');

            //     // alert(formBuilder.actions.getData('json', true));
            //     if($('#form_temp').val()=='null'){
            //         alert('null');
            //         return false;
            //     }
            //     else{
            //         alert($('#form_temp').val());
            //         return true;
            //     }
            // });
            $("#RAfrmSubmit").click(function(){

                $('.save-template').click();
                $('#form_temp').val(formBuilder.actions.getData('json', true));
                // alert($('form_temp').val());
                $("#risk_assessment_form").submit();

            })

    }
    if($('#use').length)
    {

        var jsonForm = templateData[0].json;
        // alert(jsonForm);
        // var d ="";
        const formRenderOptions = {
            formData: jsonForm
        }
        var formRenderInstance = $('#use').formRender(formRenderOptions);
        // $('#risk_assessment_form').submit(function() {
        //     var test = JSON.stringify(formRenderInstance.userData);
        //     alert(test);
        //     $('#form_temp').val(test);
        //     if($('#user_data').val() == 'null'){
        //         return false;
        //     }
        //     else{
        //         return true;
        //     }
        // });
        $("#RAfrmSubmit").click(function(){

            var test = JSON.stringify(formRenderInstance.userData);
            // alert(test);
            $('#form_temp').val(test);
            // alert($('form_temp').val());
            $("#risk_assessment_form").submit();

        })
    }



});

$('#test').change(function(){

});
/*$('#template_dept').change(function(){
    //alert($(this).val());
    var selectedCode = $(this).val();

    if(selectedCode){
        $.ajax({
            url:'/getNewFormId',
            type:"GET",
            data:{
                    'selectedCode' : selectedCode
                },
            success:function(data){
                //alert(data);
                $('#formId').html(selectedCode+'-'+data);
                $('#formIdMessage').hide();
                $('#template_dept_id').val(data);
            },
            error:function (err){
                console.log('error : ',err);
            }
        });
    }
    else{
        $('#formIdMessage').show();
        $('#template_dept_id').val('');
        $('#formId').html('');
    }
})*/

var formValidations=
{
  beforeSubmit : function(e)
  {
    // click the save button programmatically

    /*if(!isAdmin && !$('#refId').val()){
        toastr.error('Please select Vessel code to generate form reference number');
        return false;
    }*/
    // if($('#create').length)
    // {
    //     // alert('HH');
    //     var options = {
    //         onSave: function(evt, formData) {

    //             console.log('Hey');
    //             $('#form_temp').val(formData);
    //             alert($('#form_temp').val());
    //         },
    //     };

    //     // $('#risk_assessment_form').submit(function() {

    //         $('.save-template').click();
    //         // alert()
    //         // $('#give').val(formData);
    //         console.log('Submit clicked');
    //         // if($('#form_temp').val()=='null'){
    //             // alert('false');
    //             // return false;
    //         // }
    //         // else{
    //         //     alert('true')
    //         //     return false;
    //         // }
    //     // });
    //     $('#create').formBuilder(options);

    // }
if($('#form_temp').val()=='null')
{
    return false;
}
    // if(isAdmin && !$('#template_name').val()){
    //     toastr.error('Please Enter a Template Name');
    //     return false;
    // }

    // if(section2Rows.length==0){
    //     toastr.error('Add Atleast 1 Risk Assessment');
    //     return false;
    // }

    return true;
  },
  success : function(data) {
    //alert('success');
    //console.log(data);

        toastr.success('Data submitted successfully');
    window.location.href = redirectAddress;
  },
  error: function (data) {
    //console.log(data);
    //alert('form could not be submitted');
    //toastr.error("Credo Publication Submission Failed ", "Error");
  }
};

function toggleReadMoreLess()
{

    document.getElementById("para").classList.toggle("show_less")

    var readMoreLessElem=document.getElementById("readMoreLessPara")
    //console.log(readMoreLessElem.innerHTML)
    if(readMoreLessElem.innerHTML.trim()=="Read More")
        readMoreLessElem.innerHTML="Read Less"
    else
        readMoreLessElem.innerHTML="Read More"
}

function previewImage(sender, event, id)
    {
        // Used to make Image object at the time of Temporary Save
        var validExts = new Array(".jpg", ".jpeg",".bmp",".png");
        var fileExt = sender.value;
        fileExt = fileExt.substring(fileExt.lastIndexOf('.'));

        if (validExts.indexOf(fileExt) < 0) {
            alert("Invalid file selected, valid files are of " +
                     validExts.toString() + " types.");
            $(sender).val('');
        }
        else{
            if(sender.files[0].size > 2000000) {
              alert("Please upload file less than 2MB. Thanks!!");
              $(sender).val('');
            }
            else{
              var reader = new FileReader();
              reader.onload = () =>
              {
                  //console.log(reader)
                  document.getElementById(id).style.display = 'block';
                  document.getElementById(id).setAttribute("src",reader.result)
                  imgData = {photo : reader.result.split(',')[1], photoName: event.target.files[0].name, photoSize: event.target.files[0].size }
                  // console.log("imgData::",imgData);

              }
              reader.readAsDataURL(event.target.files[0]);

              $('#profileImageUploadLabel').addClass('hidden');
              $('#profileImageUploadButton').removeClass('hidden');
            }
        }
    }

