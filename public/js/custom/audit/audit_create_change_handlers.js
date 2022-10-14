$("#audit_type").change(function(){
    var value = $("#audit_type").val();
    console.log(value);
    if(value == '4'){
       $("#audit_type_other").css({'display':'block'});
    }
    else{
       $("#audit_type_other").css({'display':'none'});
    }
    if(value == '3'){
        $("#non-confirmity-id").hide();
        $("#observation-id").hide();
        $("#psc-id").show();
    }
    else{
       $("#observation-id").show();
       $("#non-confirmity-id").show();
       $("#psc-id").hide();
    }
})

// date formatting code
$('body').on('change' , '#nc_corrective_action_complete_date' , function(){
    let dateinput = $(this).val();
    let date = moment(dateinput).format(date_format);
    $(this).val(date);
})
$('body').on('change' , '#obs_confirm_date' , function(){
    let dateinput = $(this).val();
    let date = moment(dateinput).format(date_format);
    $(this).val(date);
})
$('body').on('change' , '#nc_confirm_date' , function(){
    let dateinput = $(this).val();
    let date = moment(dateinput).format(date_format);
    $(this).val(date);
})
$('body').on('change' , '#nc_preventive_action_complete_date' , function(){
    let dateinput = $(this).val();
    let date = moment(dateinput).format(date_format);
    $(this).val(date);
})
$('body').on('change' , '#obs_corrective_action_complete_date' , function(){
    let dateinput = $(this).val();
    let date = moment(dateinput).format(date_format);
    $(this).val(date);
})
$('body').on('change' , '#observation_date' , function(){
    let dateinput = $(this).val();
    let date = moment(dateinput).format(date_format);
    $(this).val(date);
})
$('body').on('change' , '#obs_preventive_action_complete_date' , function(){
    let dateinput = $(this).val();
    let date = moment(dateinput).format(date_format);
    $(this).val(date);
})
$('body').on('change' , '.date' , function(){
    let dateinput = $(this).val();
    let date = moment(dateinput).format(date_format);
    $(this).val(date);
})
$('body').on('change' , '#preventive_action_complete_date_psc' , function(){
    let dateinput = $(this).val();
    let date = moment(dateinput).format(date_format);
    $(this).val(date);
})
$('body').on('change' , '#corrective_action_complete_date_psc' , function(){
    let dateinput = $(this).val();
    let date = moment(dateinput).format(date_format);
    $(this).val(date);
})

// CORRECTIVE ACTION INPUT INCREASE FOR NON-CONFIRMITY
function addmoreCA(){
    corrective_increasetext_NC_num_count++;
    let content  = `
                <label for="nc_corrective_action">Corrective Action/s</label>
                <div class="input-group">
                   <textarea class="form-control mr-2 mb-2" id="nc_corrective_action_${corrective_increasetext_NC_num_count}" name="nc_corrective_action[]" rows="2"></textarea>
                </div>
    `;
    $("#corrective_action_increase_NC").append(content);
    $("#corrective_action_increase_OBSERVATION").append(content);
    $("#corrective_action_increase_PSC").append(content);
}

// CORRECTIVE ACTION INPUT INCREASE FOR OBSERVATION
$("#corrective_increasetext_OBSERVATION").click(()=>{
    corrective_increasetext_OBSERVATION_num_count++;
    let content  = `
                <label for="nc_corrective_action">Corrective Action/s</label>
                <div class="input-group">
                    <textarea class="form-control mr-2 mb-2" id="nc_OBSERVATION_${corrective_increasetext_OBSERVATION_num_count}" name="nc_corrective_action[]" rows="2"></textarea>
                </div>
    `;
    $("#corrective_action_increase_OBSERVATION").append(content);
})

// CORRECTIVE ACTION INPUT INCREASE FOR PSC
$("#corrective_increasetext_PSC").click(()=>{
    corrective_increasetext_PSC_num_count++;
    let content  = `
                <label for="nc_corrective_action">Corrective Action/s</label>
                <div class="input-group">
                   <textarea class="form-control mr-2 mb-2" id="nc_corrective_action_${corrective_increasetext_PSC_num_count}" name="nc_corrective_action[]" rows="2"></textarea>
                </div>
    `;
    $("#corrective_action_increase_PSC").append(content);
})
// 
$("[name='firstt']").click(()=>{
    // alert('first');
    if($("#type_of_audit").val() == 'PSC'){
        $('#NO_OBS_tab').hide();
        $('#PSC_tab').show();
    }
});

//type of audit option render
$("#type_of_audit").change(()=>{
    const type_val = $("#type_of_audit").val()
    if(type_val == 'PSC')
    {
        $("#non_confirmity_id").hide()
        $("#observation_id").hide()
        $("#psc_id").show()
        $("#NO_OBS_tab").hide()
        $("#PSC_tab").show()
    }
    else
    {
        $("#non_confirmity_id").show()
        $("#observation_id").show()
        $("#psc_id").hide()
        $("#NO_OBS_tab").show()
        $("#PSC_tab").hide()
    }

    if(type_val == 'Others')
    {
        $("#audit_type_other").show()
    }
    else
    {
        $("#audit_type_other").hide()
    }
})


