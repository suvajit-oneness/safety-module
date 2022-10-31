var section2RowCount = 0;
var section2Rows = [];
var additionalControlRowCount = 0;
var additional_control = [];
//var add_control=0;

/* 
* Runs when hazard name is changed, fetches hazard list through fetchHazardSubTypes() with the selected id and places them in the drop-down
*/
$('#hazards-name').change(function(){

    // get the selected hazard name
    var selected_value = $(this).val(); 

    // clearing the form to avoid conflicting values
    clearSection2Form(); 

    // fetching hazard no according to hazard name
    var temp1 = fetchHazardSubTypes(selected_value)['hazards_name'];

    // Added By Onenesstechs - Data added for hazard cause and hazard details.
    var temp2 = fetchHazardSubTypes(selected_value)['hazards_causes'];
    var temp3 = fetchHazardSubTypes(selected_value)['hazards_details'];

    // adding hazard no drop-down options
    $('#hazards_subtype').html(temp1);

    // Added By Onenesstechs 
    $('#hazard_details').html(temp3); 
    $('#hazard_cause').html(temp2); 
});

/* 
* Runs when hazard no is changed, fetches hazard details from backend with the selected id and places them in the modal
*/
$('#hazards_subtype').change(function(){

    // get the selected hazard no 
    var selected_value = $(this).val();

    // fetching data for the selected hazard no
    $.ajax({
        url:'/fetchAllDataForSection2',
        type:"GET",
        data:{
                'id' : selected_value
            },  
        success:function(data){ 
            
            // placing data fetched into the modal
            $('#source').val(data.source);
            $('#event').val(data.event);
            $('#consequences').val(data.impact);

            // $('#control_measure').val(data.control);
            $('#control_measure').summernote('code',data.control);

            $('#svr1').val(data.ir_severity);
            $('#lkh1').val(data.ir_likelihood);
            $('#rf1').val(data.ir_risk_rating);          
            $('#svr2').val(data.rr_severity);
            $('#lkh2').val(data.rr_likelihood);
            $('#rf2').val(data.rr_risk_rating);
             document.getElementById('rf1_label').innerHTML = riskFactor[data.ir_risk_rating];
            document.getElementById('rf2_label').innerHTML = riskFactor[data.rr_risk_rating];
            // Commented by Onenesstechs for making this field editable
            // document.getElementById('consequences').disabled = true;
            // placing add control value according to the risk ratings
            if(data.rr_risk_rating>=1 && data.rr_risk_rating<=4){
                document.getElementById('acFlag').value = "No";
                document.getElementById('add_control').value = "No";;
            } 
            else {
                document.getElementById('acFlag').value = "Yes";  
                document.getElementById('add_control').value = "No";;  
            } 
            checkForRiskFactor();
        },
        error:function (err){
            console.log('error : ',err);
        }
    }); 
});
// this function call if when hazard name will be selected
$('#hazards-name').change(function(){
    // console.log('iii');
    $('#hazards_no').css('display','block');
    $('#hazards_subtype').css('display','block');

    // {Onenesstechs} - Showing the hazard cause and hazard details option
    $('.js-example-basic-single').select2();

    $('#hazard_cause').css('display','block');
    $('#hazard_cause_label').css('display','block');
    
    $('#hazard_details').css('display','block');
    $('#hazard_details_label').css('display','block');

    // {Onenesstechs} -----------------------------------------------------
});

// ----------New Auto completed for hazard cause and hazard details added by {Onenesstechs}-----
$('#hazards_subtype').on('change',function(){
    var value = $(this).val();
    $("#hazard_cause").val(value).change();
    $("#hazard_details").val(value).change();
})
// ----------------------{Onenesstechs}-----------------------------------------------------

/* 
* Runs when likelihood1 is changed, calculates risk factor and places in the text box
*/
$('#lkh1').change(function(){
    $('#rf1').val(calculateRiskRating($('#lkh1').val(),$('#svr1').val()));
    checkForRiskFactor();
})

/* 
* Runs when severity is changed, calculates risk factor and places in the text box
*/
$('#svr1').change(function(){
    $('#rf1').val(calculateRiskRating($('#lkh1').val(),$('#svr1').val()));
    checkForRiskFactor();
})

/* 
* Runs when likelihood2 is changed, calculates residual risk factor and places in the text box
*/
$('#lkh2').change(function(){
    $('#rf2').val(calculateRiskRating($('#lkh2').val(),$('#svr2').val()));
    checkForRiskFactor();
})

/* 
* Runs when severity2 is changed, calculates residual risk factor and places in the text box
*/
$('#svr2').change(function(){
    $('#rf2').val(calculateRiskRating($('#lkh2').val(),$('#svr2').val()));
    checkForRiskFactor();
})

/* 
* Calculates Risk Rating with the received parameters likelihood & severity
* Parameters likelihood(int), severity(int)
* Returns riskRating(int)
*/
function calculateRiskRating(likelihood, severity){
    var riskRating = likelihood*severity;
   // console.log('likelihood : '+likelihood+' | severity : '+severity+' | riskRating : '+riskRating);
    return riskRating
}

/* 
* Places Add Control value checking conditions, and places appropriate footer for section 1
*/
function checkForRiskFactor(){
    if($('#rf2').val()>=5){
        $('#acFlag').val('Yes');
    }
    else{
        $('#acFlag').val('No');
    }
    checkForAc();
    document.getElementById('rf1_label').innerHTML = getRiskFactorCode($('#rf1').val());
    document.getElementById('rf2_label').innerHTML = getRiskFactorCode($('#rf2').val());
}

/* 
* Fetches hazard no list from the backend with the id received as parameter
* Parameter int
* Returns string
*/
function fetchHazardSubTypes(id){

    var temp,temp1,temp2,temp3 = '';

    // fetching hazard no list from with id
    $.ajax({
        url:'/fetchHazardDataForSection2',
        type:"GET",
        async:false,
        data:{
                'id' : id
            },  
        success:function(data){

            // creating options list
            temp1 = '<option value="">Select a hazard name</option>';

            // Added by onenesstechs
            temp2 = '<option value="">Select a hazard details</option>';

            temp3 = '<option value="">Select a hazard cause</option>';

            for(i=0;i<data.length;i++){
                temp1+='<option value="'+data[i].id+'">'+data[i].hazards+'</option>';
                temp2+='<option value="'+data[i].id+'">'+data[i].hazard_details+'</option>';
                if(data[i].causes != null)
                    temp3+='<option value="'+data[i].id+'">'+data[i].causes+'</option>';
            }
        },
        error:function (err){
            console.log('error : ',err);
        }
    });

    // Added by Onenesstechs

    var temp = [];
    temp['hazards_name'] = temp1;
    temp['hazards_details'] = temp2;
    temp['hazards_causes'] = temp3;
    return temp; 
}

/* 
* Runs when 'Add Hazard' is clicked, empties out previous values if there and opens a new clean modal
*/
function addHazard(){

    // emptying out drop-downs

    // Comment out by Onenesstechs
    // $('#hazards-name').val('');
    // $('#hazards_subtype').val('');
    // ------------------------

    // this id is for edit, therefore, emptying out when adding a new one

    // Comment Out by Onenesstechs
    // $('#section_2_row_index').val('');
    // --------------------------   

    // show the modal  
    showHazardModal();
}

/* 
* Shows the hazard modal
*/
function showHazardModal(){
    $('#AddRowModal').modal('show');
}

/* 
* Closes the hazard modal and clears it's contents
*/
function closeModal(){
    $('#AddRowModal').modal('hide');   
    // clearSection2Form();
}

/* 
* Adds/Edits hazard details rows
*/
function saveSection2(){

    // get the hazard type and number
    var hazardType = $('#hazards-name').val();
    var hazardSubType = $('#hazards_subtype').val();

    // if both hazard type and number are present, proceed with the saving
    if(hazardType && hazardSubType){

        // get the row index from modal
        var rowCount = parseInt($('#section_2_row_index').val());
        //console.log('saveSection2 | rowCount : ',rowCount);

        // if row index is present, it is a previous row being saved
        if(rowCount){
            //console.log('saveSection2 | in if (will be edited)');
            editRow(rowCount);
            
        }

        // else it is a new row which is being added
        else{
            //console.log('saveSection2 | in else (will be added)');
            // no of rows increased
            section2RowCount++;
            additionalControlRowCount++;

            // save the row
            saveRow();    
        }   

        // hide the modal
        $('#AddRowModal').modal('hide');

        // save current global array to the form's hidden parameter
        $('#section_2_array').val(JSON.stringify(section2Rows));

        //console.log(section2Rows);
        clearSection2Form()
        checkForAc();
    }

    // else inform the user
    else{
        toastr.error('Please Select Hazard type and hazar no');
    }
    
}

/* 
* Adds a new row
*/
function saveRow(){
    
    // saving row in the array
    pushToGlobalSection2Array(section2RowCount);

    // get html table row acc. to current count
    var temp = getSection2Row(section2RowCount);
    var tempAC = getACRow(section2RowCount);

    //var temp2= getSection2Row(section2RowCount);

    // append html row to section 2 table
    $('#b_18_tbody').append(temp);
    $('#section2Body').append(tempAC);

    //console.log('after saving : ',section2Rows);
}

/* 
* Edits an existing row
* Parameter rowCount(int)
*/
function editRow(rowCount){

    //console.log('editRow | rowCount ',rowCount);

    section2Rows = section2Rows.filter(row=>row.section2RowCount!=rowCount);

    //console.log('section2Rows : ',section2Rows);

    pushToGlobalSection2Array(rowCount);
    removeRow(rowCount);
    $('#b_18_tbody').append(getSection2Row(rowCount));
}

/* 
* Pushes to the global array storing hazard details
* Parameter section2RowCount(int)
*/
function pushToGlobalSection2Array(section2RowCount){

    section2Rows.push({
        section2RowCount:section2RowCount,
        hazardTypeName : $('#hazards-name').find(':selected').text(),  
        hazardTypeId : $('#hazards-name').find(':selected').val(),  
        hazardSubTypeName : $('#hazards_subtype').find(':selected').text(),
        hazardSubTypeId : $('#hazards_subtype').find(':selected').val(),

        // Added by Onenesstechs
        hazardCauseName : $('#hazard_cause').find(':selected').text(),
        hazardCauseId : $('#hazard_cause').find(':selected').val(),
        hazardDetailsName : $('#hazard_details').find(':selected').text(),
        hazardDetailsId : $('#hazard_details').find(':selected').val(),
        // ---------------------------

        hazardEvent : $('#event').val(),
        source : $('#source').val(),
    //    consequences : $('#consequences').summernote('code'),
       consequences : $('#consequences').val(),
        lkh1 : $('#lkh1').val(),
        svr1 : $('#svr1').val(),
        rf1 : $('#rf1').val(),
        // control_measure : $('#control_measure').val(),
        control_measure : $('#control_measure').summernote('code'),
        lkh2 : $('#lkh2').val(),
        svr2 : $('#svr2').val(),
        rf2 : $('#rf2').val(),
        acFlag : $('#acFlag').val(),
        add_control : $('#add_control').val()
    });
}

/* 
* Removes row from table in the view
* Parameter rowCount(int)
*/
function removeRow(rowCount){
    $('#row_'+rowCount).remove();
}

/* 
* Creates table row html
* Parameter rowCount(int)
* Returns temp(string)
*/
function getSection2Row(rowCount){
    $('#no_data').remove();
    var temp = '';

    // console.log(rowCount)

    var row = section2Rows.find(row=>row.section2RowCount==rowCount);

    console.log(row);
    
    //console.log('riskMatriceColor : ',riskMatriceColor);
    //console.log('riskMatriceColor : ',riskMatriceColor.(row.grr_p));
    //console.log('riskMatriceColor : ',riskMatriceColor[row.grr_p]);
    //console.log('riskMatriceColor : ',riskMatriceColor['"'+row.grr_p+'"']);

    if(row){
        temp+='<tr id="row_'+rowCount+'">'+
                '<td>'+
                    rowCount+
                '</td>'+
                '<td>'+
                    row.hazardEvent+
                '</td>'+
                '<td>'+
                    row.hazardTypeName+
                '</td>'+
                
                //------------- Added by Onenesstechs------------
                '<td>'+
                    row.hazardDetailsName+
                '</td>'+
                '<td>'+
                    row.hazardCauseName+
                '</td>'+                
                //-----------------------------------------------   
                
                '<td>'+
                    row.consequences+
                '</td>'+
                '<td>'+
                    row.svr1+
                '</td>'+
                '<td>'+
                    row.lkh1+
                '</td>'+
                '<td style="background-color: '+riskMatriceColor[row.rf1]+'">'+
                    riskFactor[row.rf1]+
                '</td>'+                
                '<td>'+
                    row.control_measure+
                '</td>'+                
                '<td>'+
                    row.svr2+
                '</td>'+
                '<td>'+
                    row.lkh2+
                '</td>'+
                '<td style="background-color: '+riskMatriceColor[row.rf2]+'">'+
                    riskFactor[row.rf1]+
                '</td>'+
                '<td>'+
                    row.add_control+
                '</td>'+                
                '<td>'+
                    '<button class="btn btn-primary mr-2" type="button" onclick="editSection2Row('+rowCount+')"><i class="fa fa-edit"></i></button>'+
                    '<button class="btn btn-danger" type="button" onclick="deleteRow('+rowCount+')"><i class="fa fa-trash"></i></button>'+
                '</td>'+
            '</tr>';                
    }
    //checkForAc();
    
    return temp;
}

/* 
* Gets specific codes for risk rating
* Parameter riskFactor(int)
* Returns riskFactorCode(string)
*/
function getRiskFactorCode(riskFactor){

    var riskFactorCode;

    if(riskFactor<=2){
        riskFactorCode = 'VL';
    }
    else if(riskFactor>2 && riskFactor<=4){
        riskFactorCode = 'LR';
    }
    else if(riskFactor>4 && riskFactor<=9){
        riskFactorCode = 'MR';
    }
    else if(riskFactor>9 && riskFactor<=12){
        riskFactorCode = 'HR';
    }
    else{
        riskFactorCode = 'VH';
    }

    return riskFactorCode;
}

function getACRow(rowCount){
    var temp = '';
    temp = '<tr id="row_'+rowCount+'">'+
                '<td>'+rowCount+'</td>'+
                    '<td colspan="3">'+
                        '<input type="text" class="form-control mr-sm-2" id="additional_control_'+rowCount+'" name="additional_control_'+rowCount+'" onchange="add_value('+rowCount+')">'+
                    '</td>'+
                    '<td>'+
                        '<select class="form-control" id="additional_control_type_'+rowCount+'" name="additional_control_type_'+rowCount+'" onchange="add_value('+rowCount+')">'+
                                    '<option value="">Select Control Type</option>'+                                   
                                    '<option value="Acceptable">Acceptable</option>'+
                                    '<option value="Intolerable">Intolerable</option>'+                                    
                                '</select>'+
                            '</td>'+
                        '</tr>';
    return temp;
}

/* 
* Checks if additional control is required in any of the hazards
*/
function checkForAc(){
    //console.log('Additional controls : ',add_control);
    var acRequired = 0;
    for(var i=0;i<section2Rows.length;i++){
        if(section2Rows[i].acFlag=='Yes'){
            acRequired = 1;
        }
    }

    if(acRequired){
        $('#riskTableFooter').html('<div style="color:red">Contact Office</div>');
    }
    else{
        $('#riskTableFooter').html('<div style="color:green">Proceed with Job</div>');
    }

    if(section2Rows.length == 0){
        $('#riskTableFooter').html('');
    }
}

/* 
* Runs when 'Edit' button is clicked on a row, populates and shows modal
*/
function editSection2Row(rowCount){
    // alert(rowCount);
    var modalPopulated = populateModal(rowCount);
    if(modalPopulated){
        showHazardModal();    
    }
    else{
        toastr.error('Error populating modal');
    }    
}

/* 
* Runs when 'Delete' button is clicked on a row, confirms and deletes from required places and updates view
* Parameter rowCount(int)
*/
function deleteRow(rowCount){
    if(confirm("Are you sure you want to delete this?")){
        //console.log('true');
        section2RowCount--;
        section2Rows = section2Rows.filter(row=>row.section2RowCount!=rowCount);
       // console.log(section2Rows);
        $('#section_2_array').val(JSON.stringify(section2Rows));
        removeRow(rowCount);
        if($('#b_18_table tbody tr').length == 0){
            $('#b_18_tbody ').append('<td colspan="17" class="text-center" id="no_data">No Data Present</td>');
        }
        checkForAc();
    }
    else{
       //
        console.log('false');
    }

}

/* 
* Populates modal with data for editing
* Parameter rowCount(int)
* Returns 1 if successful, else  returns 0
*/
function populateModal(rowCount){
    // console.log('populateModal | row : ');
    if(rowCount){
        //clearSection2Form();
        $('#section_2_row_index').val(rowCount);
        var row = section2Rows.find(row=>row.section2RowCount==rowCount);
        // console.log('Section 2 row '+row);
        /*console.log('section 2 index in modal : ',$('#section_2_row_index').val());
        console.log('populateModal | row : ',row);*/
        console.log('populateModal | row : ',row);
        if(row){
            var temp = fetchHazardSubTypes(row.hazardTypeId);
            $('#hazards_subtype').html(temp);

            $('#hazards-name').val(row.hazardTypeId);

            $('#hazards_subtype').val(row.hazardSubTypeId);

            $('#source').val(row.source);
            $('#event').val(row.hazardEvent); 
           $('#sources').summernote('code',row.sources);              
            $('#hazard_no').summernote('code',row.hazard_no);
        //   $('#consequences').summernote('code',row.consequences);
            $('#consequences').val(row.consequences);
            $('#svr1').val(row.svr1);
            $('#lkh1').val(row.lkh1);
            $('#rf1').val(row.rf1);
            document.getElementById('rf1_label').innerHTML = riskFactor[row.rf1];
            $('#svr2').val(row.svr2);
            $('#lkh2').val(row.lkh2);
            $('#rf2').val(row.rf2);
            $('#acFlag').val(row.acFlag);
            document.getElementById('rf2_label').innerHTML = riskFactor[row.rf2];
            $('#add_control').val(row.add_control);
            $('#control_measure').summernote('code',row.control_measure);
            
           // $('.risk_select').change();

            return 1;
        }
    }
    return 0;
}

/* 
* Clears modal
*/
function clearSection2Form(){
    $('#source').val("");
    $('#event').val("");
    $('#hazard_no').summernote('reset');
//    $('#consequences').summernote('reset');
    $('#consequences').val("");
    $('#control_measure').summernote('reset');
    $('#svr1').val("").css("background-color", 'white');
    $('#lkh1').val("").css("background-color", 'white');
    $('#rf1').val("").css("background-color", 'white');
    // for clear
    $('#rf1_label').html("");
    $('#rf2_label').html("");
    // end clear
    $('#svr2').val("").css("background-color", 'white');
    $('#lkh2').val("").css("background-color", 'white');
    $('#rf2').val("").css("background-color", 'white');
    $('#acFlag').val("");
    $('#add_control').val("");

    return true;
}

function add_value(id){
    pushAdditionalControlGlobalArray(id);
    //console.log(additional_control);
    $('#additional_control').val(JSON.stringify(additional_control));
    //console.log($('#additional_control').val());
    var flag = 0;
    for(var i=0;i<additional_control.length;i++){
        if(additional_control[i].additional_control_type=='Intolerable'){
            flag = 1;
        }
    }

    if(flag){
        $('#ACTableFooter').html('<div style="color:red">Abort</div>');
    }
    else{
        $('#ACTableFooter').html('<div style="color:green">Go Ahead</div>');
    }

    if(additional_control.length == 0){
        $('#ACTableFooter').html('');
    }
}

function pushAdditionalControlGlobalArray(rowCount){
    //console.log('editRow | rowCount ',rowCount);
    //console.log('additionalControl before deletion : ',additional_control);
    // console.log('duplicateObj | duplicateObj ',duplicateObj);
    // additionalControl.splice(duplicateObj, 1);
    for(var i =0;i<additional_control.length;i++){
        if(additional_control[i].acRowCount==rowCount){
            additional_control = additional_control.filter(row=>row.acRowCount!=rowCount)
        }
    }
    //console.log('additionalControl after deletion : ',additional_control);
    additional_control.push({
        acRowCount:rowCount,
        additional_control : $('#additional_control_'+rowCount).val(),
        additional_control_type : $('#additional_control_type_'+rowCount).val()
    }); 
}