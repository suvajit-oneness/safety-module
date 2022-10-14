var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab);

// risk matrix

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    let risk_matrix = [{
            index: '1,1',
            value: 'VERY LOW RISK'
        },
        {
            index: '1,2',
            value: 'VERY LOW RISK'
        },
        {
            index: '2,1',
            value: 'VERY LOW RISK'
        },
        {
            index: '1,3',
            value: 'LOW RISK'
        },
        {
            index: '1,4',
            value: 'LOW RISK'
        },
        {
            index: '2,2',
            value: 'LOW RISK'
        },
        {
            index: '3,1',
            value: 'LOW RISK'
        },
        {
            index: '4,1',
            value: 'LOW RISK'
        },
        {
            index: '1,5',
            value: 'MODERATE RISK'
        },
        {
            index: '2,3',
            value: 'MODERATE RISK'
        },
        {
            index: '2,4',
            value: 'MODERATE RISK'
        },
        {
            index: '3,2',
            value: 'MODERATE RISK'
        },
        {
            index: '3,3',
            value: 'MODERATE RISK'
        },
        {
            index: '4,2',
            value: 'MODERATE RISK'
        },
        {
            index: '5,1',
            value: 'MODERATE RISK'
        },
        {
            index: '2,5',
            value: 'HIGH RISK'
        },
        {
            index: '3,4',
            value: 'HIGH RISK'
        },
        {
            index: '4,3',
            value: 'HIGH RISK'
        },
        {
            index: '5,2',
            value: 'HIGH RISK'
        },
        {
            index: '3,5',
            value: 'VERY HIGH RISK'
        },
        {
            index: '4,4',
            value: 'VERY HIGH RISK'
        },
        {
            index: '4,5',
            value: 'VERY HIGH RISK'
        },
        {
            index: '5,3',
            value: 'VERY HIGH RISK'
        },
        {
            index: '5,4',
            value: 'VERY HIGH RISK'
        },
        {
            index: '5,5',
            value: 'VERY HIGH RISK'
        }
    ]
    let option1 = '1';
    let option2 = '1';
    let find_index = option1 + ',' + option2;
    let risk_value = risk_matrix.filter(item => item.index == find_index);
    // console.log('find_index',find_index);
    // console.log('risk_value',risk_value);
    $('#IIARCF_safety_Result')[0].value = '';
    $('#IIARCF_HEALTH_Result')[0].value = '';
    $('#IIARCF_ENVIRONMENT_Result')[0].value = '';
    $('#IIARCF_OPERATIONAL_IMPACT_Result')[0].value = '';
    $('#IIARCF_MEDIA_Result')[0].value = '';

    // console.log('risk_matrix..',risk_matrix);
    $('[data-toggle="tooltip"]').tooltip();
    // SAFETY
    $('#IIARCF_safety_Severity').on('change', function() {
        try{
            let tmp = this.value;
            tmp = tmp.split(' ');
            tmp = tmp[tmp.length - 1];
            option1 = tmp;
            //   console.log(tmp);
            find_index = option1 + ',' + option2;
            risk_value = risk_matrix.filter(item => item.index == find_index);
            //   console.log('find_index',find_index);
            // console.log('risk_value',risk_value);
            if(risk_value[0] != undefined){
                $('#IIARCF_safety_Result')[0].value = risk_value[0].value;    
            }   
        }
        catch(err){
            console.log("Error in IIARCF_safety_Severity change event : ",err);
        }     
    });

    $('#IIARCF_safety_Likelihood').on('change', function() {
        try{
            let tmp2 = this.value;
            tmp2 = tmp2.split(' ');
            tmp2 = tmp2[tmp2.length - 1];
            option2 = tmp2;
            //   console.log(tmp2);
            find_index = option1 + ',' + option2;
            risk_value = risk_matrix.filter(item => item.index == find_index);
            //   console.log('find_index',find_index);
            // console.log('risk_value',risk_value);
            if(risk_value[0] != undefined){
                $('#IIARCF_safety_Result')[0].value = risk_value[0].value;    
            } 
        }
        catch(err){
            console.log("Error in IIARCF_safety_Likelihood change event : ",err);
        }
    });

    // HEALTH
    $('#IIARCF_HEALTH_Severity').on('change', function() {
        try{
            let tmp = this.value;
            tmp = tmp.split(' ');
            tmp = tmp[tmp.length - 1];
            option1 = tmp;
            //   console.log(tmp);
            find_index = option1 + ',' + option2;
            risk_value = risk_matrix.filter(item => item.index == find_index);
            //   console.log('find_index',find_index);
            // console.log('risk_value',risk_value);
            
            if(risk_value[0] != undefined){
                $('#IIARCF_HEALTH_Result')[0].value = risk_value[0].value;
            } 
        }
        catch(err){
            console.log("Error in IIARCF_HEALTH_Severity change event : ",err);
        }
    });

    $('#IIARCF_HEALTH_Likelihood').on('change', function() {
        try{
            let tmp2 = this.value;
            tmp2 = tmp2.split(' ');
            tmp2 = tmp2[tmp2.length - 1];
            option2 = tmp2;
            //   console.log(tmp2);
            find_index = option1 + ',' + option2;
            risk_value = risk_matrix.filter(item => item.index == find_index);
            //   console.log('find_index',find_index);
            // console.log('risk_value',risk_value);
            
            if(risk_value[0] != undefined){
                $('#IIARCF_HEALTH_Result')[0].value = risk_value[0].value;
            } 
        }
        catch(err){
            console.log("Error in IIARCF_HEALTH_Likelihood change event : ",err);
        }                
    });

    // ENVIRONMENT
    $('#IIARCF_ENVIRONMENT_Severity').on('change', function() {
        try{
            let tmp = this.value;
            tmp = tmp.split(' ');
            tmp = tmp[tmp.length - 1];
            option1 = tmp;
            //   console.log(tmp);
            find_index = option1 + ',' + option2;
            risk_value = risk_matrix.filter(item => item.index == find_index);
            //   console.log('find_index',find_index);
            // console.log('risk_value',risk_value);            
            if(risk_value[0] != undefined){
                $('#IIARCF_ENVIRONMENT_Result')[0].value = risk_value[0].value;
            } 
        }
        catch(err){
            console.log("Error in IIARCF_ENVIRONMENT_Severity change event : ",err);
        }        
    });

    $('#IIARCF_ENVIRONMENT_Likelihood').on('change', function() {
        try{
            let tmp2 = this.value;
            tmp2 = tmp2.split(' ');
            tmp2 = tmp2[tmp2.length - 1];
            option2 = tmp2;
            //   console.log(tmp2);
            find_index = option1 + ',' + option2;
            risk_value = risk_matrix.filter(item => item.index == find_index);
            //   console.log('find_index',find_index);
            // console.log('risk_value',risk_value);
            
            if(risk_value[0] != undefined){
                $('#IIARCF_ENVIRONMENT_Result')[0].value = risk_value[0].value;    
            } 
        }
        catch(err){
            console.log("Error in IIARCF_ENVIRONMENT_Likelihood change event : ",err);
        }         
    });


    // OPERATIONAL
    $('#IIARCF_OPERATIONAL_IMPACT_Severity').on('change', function() {
        try{
            let tmp = this.value;
            tmp = tmp.split(' ');
            tmp = tmp[tmp.length - 1];
            option1 = tmp;
            //   console.log(tmp);
            find_index = option1 + ',' + option2;
            risk_value = risk_matrix.filter(item => item.index == find_index);
            //   console.log('find_index',find_index);
            // console.log('risk_value',risk_value);
            
            if(risk_value[0] != undefined){
                $('#IIARCF_OPERATIONAL_IMPACT_Result')[0].value = risk_value[0].value;    
            } 
        }
        catch(err){
            console.log("Error in IIARCF_OPERATIONAL_IMPACT_Severity change event : ",err);
        } 
        
    });

    $('#IIARCF_OPERATIONAL_IMPACT_Likelihood').on('change', function() {
        try{
            let tmp2 = this.value;
            tmp2 = tmp2.split(' ');
            tmp2 = tmp2[tmp2.length - 1];
            option2 = tmp2;
            //   console.log(tmp2);
            find_index = option1 + ',' + option2;
            risk_value = risk_matrix.filter(item => item.index == find_index);
            //   console.log('find_index',find_index);
            // console.log('risk_value',risk_value);
            
            
            if(risk_value[0] != undefined){
                $('#IIARCF_OPERATIONAL_IMPACT_Result')[0].value = risk_value[0].value;
            } 
        }
        catch(err){
            console.log("Error in IIARCF_OPERATIONAL_IMPACT_Likelihood change event : ",err);
        }         
    });

    // MEDIA
    $('#IIARCF_MEDIA_Severity').on('change', function() {
        try{
            let tmp = this.value;
            tmp = tmp.split(' ');
            tmp = tmp[tmp.length - 1];
            option1 = tmp;
            //   console.log(tmp);
            find_index = option1 + ',' + option2;
            risk_value = risk_matrix.filter(item => item.index == find_index);
            //   console.log('find_index',find_index);
            // console.log('risk_value',risk_value);
            
            
            if(risk_value[0] != undefined){
                $('#IIARCF_MEDIA_Result')[0].value = risk_value[0].value;
            } 
        }
        catch(err){
            console.log("Error in IIARCF_MEDIA_Severity change event : ",err);
        }         
    });

    $('#IIARCF_MEDIA_Likelihood').on('change', function() {
        try{
           let tmp2 = this.value;
            tmp2 = tmp2.split(' ');
            tmp2 = tmp2[tmp2.length - 1];
            option2 = tmp2;
            //   console.log(tmp2);
            find_index = option1 + ',' + option2;
            risk_value = risk_matrix.filter(item => item.index == find_index);
            //   console.log('find_index',find_index);
            // console.log('risk_value',risk_value);
            $('#IIARCF_MEDIA_Result')[0].value = risk_value[0].value;
            
            if(risk_value[0] != undefined){
                $('#IIARCF_MEDIA_Result')[0].value = risk_value[0].value;
            } 
        }
        catch(err){
            console.log("Error in IIARCF_MEDIA_Likelihood change event : ",err);
        }   

        
    });

});


//investigation matrix


$(document).ready(function() {
    let flag1 = false;
    let flag2 = false;
    let value1 = '';
    let value2 = '';
    let c = 0;
    let append_str = '';

    let investigation_matrix = [{
            index: '1,1',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'S/M or F/M as applicable',
            data_display:'- FAC (First Aid Case, MTC(Medical Treatment Case)'
        },
        {
            index: '1,2',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'S/M or F/M as applicable',
            data_display:' - Health Treatment Onboard Case (HTOC)/ Potential Occupational Health Incident (POHI)'
        },
        {
            index: '1,3',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'S/M or F/M as applicable',
            data_display:'  - Low impact with no lasting effect -Minimal area exposed'
        },
        {
            index: '1,4',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'S/M or F/M as applicable',
            data_display:  ' -Notable incident with no impact on operations'
            
        },
        {
            index: '1,5',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'S/M or F/M as applicable',
            data_display:  '- Insignificant damage or loss to  vessel / equipment / cargo with direct cost less than 10,000 USD'
        },
        {
            index: '1,6',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'S/M or F/M as applicable',
            data_display:  ' No Coverage'
        },
        {
            index: '2,1',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display:  '-RWC (Restricted Work Case)'
        },
        {
            index: '2,2',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display:  ' -Health Medical Treatment Case(HMTC)'
        },
        {
            index: '2,3',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display:  '-Tempo impact  -Minor effects to small  area'
            
        },
        {
            index: '2,4',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display:  '- Minor operational failure resulting in ship being taken out of services for < 1 day'
        },
        {
            index: '2,5',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display:  '-Minor operational failure resulting in ship being taken out of service for < 1-Minor damage or loss to vessel/equipment/cargo with direct cost between 10,000 to 200,000 USD'
        },
        {
            index: '2,6',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display: ' Local Coverage'
        },
        {
            index: '3,1',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display: '-Lost Time Injury (LTI), moderate permanent partial disability'
        },
        {
            index: '3,2',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display: ' -Health Repatriation Case (HRC)'
        },
        {
            index: '3,3',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display:'- Short to medium-term impact  -Local area affected    -Not affecting ecosystem function'
        },
        {
            index: '3,4',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display: '-Moderate operational failure resulting in ship being taken out of service between 1 and 15 days  -Flag State Detention'
            
        },
        {
            index: '3,5',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display : '-Moderate damage or loss to Vessel/equipment / cargo with direct cost between 200,000  and 500,000 USD'
        },
        {
            index: '3,6',
            data_investigation_level: 'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
            data_authority: 'D/GM',
            data_display:'Regional Coverage'
        },
        {
            index: '4,1',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display:' Single fatality , severe, permanent / partial disability'
        },
        {
            index: '4,2',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display: '- Single health-related fatality'
        },
        {
            index: '4,3',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display:'-Medium to long-term impact  - Some impairment of ecosystem function   -Large area affected'
        },
        {
            index: '4,4',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display: '- Major operational failure resulting in ship being taken out of service between 15 and 30 days  -PSC detention -ISM major non-conformity'
        },
        {
            index: '4,5',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display: '- Major damage or loss to vessel / equipment / cargo with direct cost between 5000,000 and 2,000,000 USD',
        },
        {
            index: '4,6',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display: 'National Coverage'
        },
        {
            index: '5,1',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display:'Multiple Fatalities'
        },
        {
            index: '5,2',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display:'-Multiple health-related fatality'
        },
        {
            index: '5,3',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display:' -Long-term impact  -Lasting impairment of ecosystem function -Widespace effect   -severe impact to sensitive area'
        },
        {
            index: '5,4',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display:' -Very serious operational failure resulting in ship being taken out of services for > 30 days '
        },
        {
            index: '5,5',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display:'- Very serious damage or loss to vessel / equioment . cargo with direct cost more than 2,000,000 USD'
        },
        {
            index: '5,6',
            data_investigation_level: 'Full Investigation by shore team or person(s) who are independent to the ship team.',
            data_authority: 'GM',
            data_display:'international Coverage'
        }
    ];

    $('#First_Parameter').change(function() {
        value1 = this.value;
        // let value1 = $(this).val();

        console.log(value1);

        if(value1 == 1){
            $('#dynamic_column').html('Slight');
            
            $('#maxtrix_dynamic_table').css({'background-color':'#e0ca05'});
        }
        if(value1 == 2){
            $('#dynamic_column').html('Minor');
            $('#maxtrix_dynamic_table').css({'background-color':'#e0ca05'});

        }
        if(value1 == 3){
            $('#dynamic_column').html('Medium');
            $('#maxtrix_dynamic_table').css({'background-color':'orange'});

        }
        if(value1 == 4){
            $('#dynamic_column').html('Major');
            $('#maxtrix_dynamic_table').css({'background-color':'#d87d05'});

        }
        if(value1 == 5){
            $('#dynamic_column').html('Extreme');
            $('#maxtrix_dynamic_table').css({'background-color':'#cc0202da'});
        }






        flag1 = true;
        if (flag1 && flag2) {
            $('#err-text-msg').css({ 'display': 'none' });
            append_str = value1 + ',' + value2;
            let investigation_matrix_data = investigation_matrix.filter(item => item.index === append_str);
            investigation_matrix_data = investigation_matrix_data[0];
            $('#data_investigation_level').html(investigation_matrix_data.data_investigation_level);
            $('#data_authority').html(investigation_matrix_data.data_authority);
            $('#dynamic_data').html(investigation_matrix_data.data_display);
            $('#investigation_result').css({ 'display': 'block' });
            $('#nextBtn').css({ 'display': 'block' });
            
        } else {
            $('#err-text-msg').css({ 'display': 'block' });            
        }
        
    });

    $('#Second_Parameter').change(function() {
        value2 = this.value;
        flag2 = true;
       
        if(value2 == 1){
            $('#dynamic_header').html('Safety');
        }
        if(value2 == 2){
            $('#dynamic_header').html('Health');
        }
        if(value2 == 3){
            $('#dynamic_header').html('Environment');
        }
        if(value2 == 4){
            $('#dynamic_header').html('Process Loss / Failure');
        }
        if(value2 == 5){
            $('#dynamic_header').html('Asset / Property Damage');
        }
        if(value2 == 6){
            $('#dynamic_header').html('Media Coverage / Public Attention');
        }









        if (flag1 && flag2) {
            $('#err-text-msg').css({ 'display': 'none' });
            append_str = value1 + ',' + value2;
            let investigation_matrix_data = investigation_matrix.filter(item => item.index === append_str);
            investigation_matrix_data = investigation_matrix_data[0];
            $('#data_investigation_level').html(investigation_matrix_data.data_investigation_level);
            $('#dynamic_il').html(investigation_matrix_data.data_investigation_level);
            $('#data_authority').html(investigation_matrix_data.data_authority);
            $('#dynamic_co').html(investigation_matrix_data.data_authority);
            $('#dynamic_data').html(investigation_matrix_data.data_display);
            $('#investigation_result').css({ 'display': 'block' });
            $('#nextBtn').css({ 'display': 'block' });


        }else {
            $('#err-text-msg').css({ 'display': 'block' });
        }
        
    });
    
   

});

$(() => {


    // Multi-Select Initialize
    $('#rootcauses').multiselect();
    $('#ddd3').multiselect();
    $('#ddd3').multiselect();

    $('#preventiveactions').multiselect();
    $('#dd4').multiselect();


    //For fetching Sub dropdown

    $(".drop").change(function() {
        var e = $(this).val();
        var atr = $(this).attr("myid");
        console.log('i am here');
        if (Array.isArray(e)) {
            console.log('I am in if');
            for (i = 0; i < e.length; i++) {
                subajaxmulti(e[i], atr, i);
            }
        } else {
            console.log('I am in else',e);
            subajax(e, atr);
        }


    })

    $("#preventiveactions").change(function() {
        var e = $("#preventiveactions").val();
        var atr = $("#preventiveactions").attr("myid");


        if (Array.isArray(e)) {
            for (i = 0; i < e.length; i++) {

                subajaxmulti(e[i], atr, i);
            }
        } else {
            subajax(e, atr)
        }
        setInterval(function() { $('#dd4').multiselect('rebuild'); }, 2000);

    })

    $("#rootcauses").change(function() {
        var e = $("#rootcauses").val();
        var atr = $("#rootcauses").attr("myid");


        if (Array.isArray(e)) {
            for (i = 0; i < e.length; i++) {

                subajaxmulti(e[i], atr, i);
            }
        } else {
            subajax(e, atr)
        }
        setInterval(function() { $('#dd3').multiselect('rebuild'); }, 2000);

    })





    // for fetching ter dropdown
    $(".droptwo").change(function() {
        var e = $(this).val();
        var atr = $(this).attr("myidtwo");

        if (Array.isArray(e)) {
            for (i = 0; i < e.length; i++) {

                terajaxmulti(e[i], atr, i);
            }
        } else {
            terajax(e, atr)
        }

    })



    $("#dd3").change(function() {
        var e = $("#dd3").val();
        var atr = $("#dd3").attr("myidtwo");

        if (Array.isArray(e)) {
            for (i = 0; i < e.length; i++) {

                terajaxmulti(e[i], atr, i);
            }
        } else {
            terajax(e, atr)
        }
        setInterval(function() { $('#ddd3').multiselect('rebuild'); }, 2000);
    })





});

// helper

// sub ajax
function subajax(d, atr) {
    $.ajax({
        type: 'POST',
        url: "/api/subtype",
        data: { 'id': d },
        success: function(result) {
            console.log("result ",result);
            output = ""
            if (result.length < 1) {
                $("#display_" + atr).css("cssText", "display: none !important;");
                $("#display_d" + atr).css("cssText", "display: none !important;");
                $("#" + atr).html("");
                $("#d" + atr).html("");
            } else {
                for (let i = 0; i < result.length; i++) {
                    output += "<option value=" + result[i].id + ">" + result[i].type_sub_name + "</option>";
                }
                $("#display_" + atr).css("cssText", "display: block !important;");
            }

            // document.getElementById(atr).innerHTML = output
            console.log('ID : ',atr);
            console.log('output : ',output);
            // document.getElementById(atr).append = output
            document.getElementById(atr).innerHTML = document.getElementById(atr).innerHTML +  output;
                // $("#"+atr).html(output);

        }
    });
}

function subajaxmulti(d, atr, c) {
    $.ajax({
        type: 'POST',
        url: "/api/subtype",
        data: { 'id': d },
        success: function(result) {

            output = ""
            if (result.length < 1) {
                $("#display_" + atr).css("cssText", "display: none !important;");
                $("#display_d" + atr).css("cssText", "display: none !important;");
                $("#" + atr).html("");
                $("#d" + atr).html("");
            } else {
                for (let i = 0; i < result.length; i++) {
                    output += "<option value=" + result[i].id + ">" + result[i].type_sub_name + "</option>";
                }
                $("#display_" + atr).css("cssText", "display: block !important;");
            }

            if (c == 0) {
                document.getElementById(atr).innerHTML = output;
            } else {
                document.getElementById(atr).innerHTML += output;
            }

        }
    });
}

// Ter ajax
function terajax(f, atr) {
    $.ajax({
        type: 'POST',
        url: "/api/tertype",
        data: { 'id': f },
        success: function(result) {
            output = ""
            if (result.length < 1) {
                $("#display_" + atr).css("cssText", "display: none !important;");
                $("#" + atr).html("");
            } else {
                for (let i = 0; i < result.length; i++) {
                    output += "<option value=" + result[i].id + ">" + result[i].type_ter_name + "</option>";
                }
                $("#display_" + atr).css("cssText", "display: block !important;");;
            }
            document.getElementById(atr).innerHTML += output;
            // $("#"+atr).html(output);
        }
    });
}

function terajaxmulti(f, atr, c) {
    $.ajax({
        type: 'POST',
        url: "/api/tertype",
        data: { 'id': f },
        success: function(result) {

            output = ""
            if (result.length < 1) {
                $("#display_" + atr).css("cssText", "display: none !important;");
                $("#" + atr).html("");
            } else {
                for (let i = 0; i < result.length; i++) {
                    output += "<option value=" + result[i].id + ">" + result[i].type_ter_name + "</option>";
                }
                $("#display_" + atr).css("cssText", "display: block !important;");;
            }

            if (c == 0) {
                document.getElementById(atr).innerHTML = output;
            } else {
                document.getElementById(atr).innerHTML += output;
            }

        }
    });
}

function showTab(n) {
    // This function will display the specified tab of the form ...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    // ... and fix the Previous/Next buttons:
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        var tmp = `<div class="d-flex">
                        <button class="btn btn-primary mt-5 w-25 mr-auto numo-btn text-dark" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                        <button class="btn btn-primary mt-5 w-25 ml-auto numo-btn text-dark" type="button" id="nextBtn" onclick="nextPrev(1)">Submit Report </button>
                    </div>`;
        $('.step_last').html()
            // document.getElementById("nextBtn").innerHTML = "Submit Report";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }
    // ... and run a function that displays the correct step indicator:
    // fixStepIndicator(n)
}

function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm() || !validateFormTextarea() || !validateFormSelect()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form... :
    if (currentTab >= x.length) {
        //...the form gets submitted:
        document.getElementById("near_miss_form").submit();
        return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
}

function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].getAttribute('id') == 'Incident_header') {
            if (y[i].value == "") {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // and set the current valid status to false:
                valid = false; //changed by rohan for development actual value is false
            }
        } else {
            valid = true;
        }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
}

function validateFormTextarea() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("textarea");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
            // add an "invalid" class to the field:
            y[i].className += " invalid";
            // and set the current valid status to false:
            valid = true; //changed by rohan for development actual value is false
        }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
}

function validateFormSelect() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("select");
    if (y[0] != undefined) {
        // A loop that checks every input field in the current tab:
        // If a field is empty...
        if (y[0].value == 0) {
            // add an "invalid" class to the field:
            y[0].className += " invalid";
            // and set the current valid status to false:
            valid = true; //changed by rohan for development actual value is false
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
    }
    return valid; // return the valid status
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class to the current step:
    x[n].className += " active";
}


// submit data clicking on next button in each tab
$(document).ready(function() {
    // step:- investigation matrix
    // $('.investigation_tab#nextBtn').on('click', function() {
    //     console.log('INVESTIGATION MATRIX');
    //     var First_Parameter = $('#First_Parameter').val();
    //     First_Parameter = (First_Parameter == null) ? "N/A" : First_Parameter;
    //     var Second_Parameter = $('#Second_Parameter').val();
    //     Second_Parameter = (Second_Parameter == null) ? "N/A" : Second_Parameter;
    //     console.log('First_Parameter', First_Parameter);
    //     console.log('Second_Parameter', Second_Parameter);
    //     var report_id = $('#report_id').val();
    //     report_id = (report_id == null || report_id == '') ? "" : report_id;
    //     var saved_status = $('#saved_status').val();
    //     saved_status = (saved_status == null || saved_status == '') ? "" : saved_status;

    //     // save data for this step
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'POST',
    //         url: "/saveInvestigationMatrix",
    //         data: {
    //             'First_Parameter': First_Parameter,
    //             'Second_Parameter': Second_Parameter,
    //             'report_id': report_id,
    //             'saved_status': saved_status
    //         },
    //         success: function(result) {
    //             var data = JSON.parse(result);
    //             console.log(data);
    //             //    console.log(data.id);
    //             //    console.log(data.req);
    //             //    var user_id = data.id;
    //             $('#saved_status').attr("value", data.incidents_report.saved_status);
    //             $('#report_id').attr("value", data.report_id);
    //             if (data.incidents_report.saved_status == 'temporary') {
    //                 console.log('status is updated as temporary')
    //             }
    //             //    console.log($('#user_id').val());
    //             //    console.log('saved_status',saved_status_new);
    //         }
    //     });
    // });






    // step:- incident header
    // $('.incident_header#nextBtn').on('click', function() {
    //     console.log('INCIDENT HEADER');
    //     var Incident_header = $('#Incident_header').val();
    //     Incident_header = (Incident_header == null) ? "N/A" : Incident_header;
    //     console.log('Incident_header', Incident_header);
    //     var report_id = $('#report_id').val();
    //     report_id = (report_id == null || report_id == '') ? "" : report_id;
    //     console.log('report_id', report_id);

    //     var saved_status = $('#saved_status').val();
    //     saved_status = (saved_status == null || saved_status == '') ? "" : saved_status;
    //     console.log('saved_status', saved_status);

    //     var user_id = $('#user_id').val();
    //     user_id = (user_id == null || user_id == '') ? "" : user_id;
    //     console.log('user_id', user_id);

    //     // save data for this step
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'POST',
    //         url: "/saveIncidentHeader",
    //         data: {
    //             'Incident_header': Incident_header,
    //             'user_id': user_id,
    //             'report_id': report_id,
    //             'saved_status': saved_status
    //         },
    //         success: function(result) {
    //             var data = JSON.parse(result);
    //             console.log(data);

    //         }
    //     });
    // });






    // step:- first_step
    // $('.first_step#nextBtn').on('click', function() {
    //     console.log('FIRST STEP');
    //     var Vessel_Name = $('#Vessel_Name').val();
    //     Vessel_Name = (Vessel_Name == null) ? "N/A" : Vessel_Name;
    //     console.log('Vessel_Name', Vessel_Name);

    //     var Confidential = $('#Confidential').val();
    //     Confidential = (Confidential == null) ? "N/A" : Confidential;
    //     console.log('Confidential', Confidential);

    //     var Report_number = $('#Report_number').val();
    //     Report_number = (Report_number == null) ? "N/A" : Report_number;
    //     console.log('Report_number', Report_number);

    //     var media_involved = $('#media_involved').val();
    //     media_involved = (media_involved == null) ? "N/A" : media_involved;
    //     console.log('media_involved', media_involved);

    //     var Created_By_Name = $('#Created_By_Name').val();
    //     Created_By_Name = (Created_By_Name == '') ? "N/A" : Created_By_Name;
    //     console.log('Created_By_Name', Created_By_Name);

    //     var Created_By_Rank = $('#Created_By_Rank').val();
    //     Created_By_Rank = (Created_By_Rank == '') ? "N/A" : Created_By_Rank;
    //     console.log('Created_By_Rank', Created_By_Rank);

    //     var Date_of_incident = $('#Date_of_incident').val();
    //     Date_of_incident = (Date_of_incident == '') ? "N/A" : Date_of_incident;
    //     console.log('Date_of_incident', Date_of_incident);

    //     var Time_of_incident = $('#Time_of_incident').val();
    //     Time_of_incident = (Time_of_incident == '') ? "N/A" : Time_of_incident;
    //     console.log('Time_of_incident', Time_of_incident);

    //     var Date_report_created = $('#Date_report_created').val();
    //     Date_report_created = (Date_report_created == '') ? "N/A" : Date_report_created;
    //     console.log('Date_report_created', Date_report_created);

    //     var GMT = $('#GMT').val();
    //     GMT = (GMT == null) ? "N/A" : GMT;
    //     console.log('GMT', GMT);

    //     var Voy_No = $('#Voy_No').val();
    //     Voy_No = (Voy_No == '') ? "N/A" : Voy_No;
    //     console.log('Voy_No', Voy_No);

    //     var Master = $('#Master').val();
    //     Master = (Master == null || Master == '') ? 1 : Master;
    //     console.log('Master', Master);

    //     var Chief_officer = $('#Chief_officer').val();
    //     Chief_officer = (Chief_officer == null || Chief_officer == '') ? 1 : Chief_officer;
    //     console.log('Chief_officer', Chief_officer);

    //     var Chief_Engineer = $('#Chief_Engineer').val();
    //     Chief_Engineer = (Chief_Engineer == null || Chief_Engineer == '') ? 1 : Chief_Engineer;
    //     console.log('Chief_Engineer', Chief_Engineer);

    //     var fstEng = $('#fstEng').val();
    //     fstEng = (fstEng == null || fstEng == '') ? 1 : fstEng;
    //     console.log('fstEng', fstEng);

    //     var Charterer = $('textarea#Charterer').val();
    //     Charterer = (Charterer == '') ? "N/A" : Charterer;
    //     console.log('Charterer', Charterer);

    //     var Agent = $('textarea#Agent').val();
    //     Agent = (Agent == '') ? "N/A" : Agent;
    //     console.log('Agent', Agent);

    //     var Vessel_Damage = $('#Vessel_Damage').val();
    //     Vessel_Damage = (Vessel_Damage == null) ? "N/A" : Vessel_Damage;
    //     console.log('Vessel_Damage', Vessel_Damage);

    //     var Cargo_damage = $('#Cargo_damage').val();
    //     Cargo_damage = (Cargo_damage == null) ? "N/A" : Cargo_damage;
    //     console.log('Cargo_damage', Cargo_damage);

    //     var Third_Party_Liability = $('#Third_Party_Liability').val();
    //     Third_Party_Liability = (Third_Party_Liability == null) ? "N/A" : Third_Party_Liability;
    //     console.log('Third_Party_Liability', Third_Party_Liability);

    //     var Environmental = $('#Environmental').val();
    //     Environmental = (Environmental == null) ? "N/A" : Environmental;
    //     console.log('Environmental', Environmental);

    //     var Commercial_Service = $('#Commercial_Service').val();
    //     Commercial_Service = (Commercial_Service == null) ? "N/A" : Commercial_Service;
    //     console.log('Commercial_Service', Commercial_Service);

    //     var report_id = $('#report_id').val();
    //     report_id = (report_id == null || report_id == '') ? "" : report_id;
    //     console.log('report_id', report_id);

    //     var saved_status = $('#saved_status').val();
    //     saved_status = (saved_status == null || saved_status == '') ? "" : saved_status;
    //     console.log('saved_status', saved_status);

    //     var user_id = $('#user_id').val();
    //     user_id = (user_id == null || user_id == '') ? "" : user_id;
    //     console.log('user_id', user_id);

    //     // save data for this step
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'POST',
    //         url: "/saveIncidentReportDetails",
    //         data: {
    //             'user_id': user_id,
    //             'report_id': report_id,
    //             'saved_status': saved_status,
    //             'Vessel_Name': Vessel_Name,
    //             'Confidential': Confidential,
    //             'Report_number': Report_number,
    //             'media_involved': media_involved,
    //             'Created_By_Name': Created_By_Name,
    //             'Created_By_Rank': Created_By_Rank,
    //             'Date_of_incident': Date_of_incident,
    //             'Time_of_incident': Time_of_incident,
    //             'Date_report_created': Date_report_created,
    //             'GMT': GMT,
    //             'Voy_No': Voy_No,
    //             'Master': Master,
    //             'Chief_officer': Chief_officer,
    //             'Chief_Engineer': Chief_Engineer,
    //             'fstEng': fstEng,
    //             'Charterer': Charterer,
    //             'Agent': Agent,
    //             'Vessel_Damage': Vessel_Damage,
    //             'Cargo_damage': Cargo_damage,
    //             'Third_Party_Liability': Third_Party_Liability,
    //             'Environmental': Environmental,
    //             'Commercial_Service': Commercial_Service
    //         },
    //         success: function(result) {
    //             var data = JSON.parse(result);
    //             console.log(data);

    //         }
    //     });

    // });






    //step:- crew_injury
    // $('.crew_injury#nextBtn').on('click', function() {
    //     console.log('CREW INJURY');
    //     // incident_report table
    //     var Crew_Injury = $('#Crew_Injury').val();
    //     Crew_Injury = (Crew_Injury == null) ? "N/A" : Crew_Injury;
    //     console.log('Crew_Injury', Crew_Injury);

    //     // incident_report table
    //     var Other_Personnel_Injury = $('#Other_Personnel_Injury').val();
    //     Other_Personnel_Injury = (Other_Personnel_Injury == null) ? "N/A" : Other_Personnel_Injury;
    //     console.log('Other_Personnel_Injury', Other_Personnel_Injury);

    //     // incident_reports_crew_injury table
    //     var Fatality = $('#Fatality').val();
    //     Fatality = (Fatality == null) ? "N/A" : Fatality;
    //     console.log('Fatality', Fatality);

    //     // incident_reports_crew_injury table
    //     var Lost_Workday_Case = $('#Lost_Workday_Case').val();
    //     Lost_Workday_Case = (Lost_Workday_Case == null) ? "N/A" : Lost_Workday_Case;
    //     console.log('Lost_Workday_Case', Lost_Workday_Case);

    //     // incident_reports_crew_injury table
    //     var Restricted_Work_Case = $('#Restricted_Work_Case').val();
    //     Restricted_Work_Case = (Restricted_Work_Case == null) ? "N/A" : Restricted_Work_Case;
    //     console.log('Restricted_Work_Case', Restricted_Work_Case);

    //     // incident_reports_crew_injury table
    //     var Medical_Treatment_Case = $('#Medical_Treatment_Case').val();
    //     Medical_Treatment_Case = (Medical_Treatment_Case == null) ? "N/A" : Medical_Treatment_Case;
    //     console.log('Medical_Treatment_Case', Medical_Treatment_Case);

    //     // incident_reports_crew_injury table
    //     var Lost_Time_Injuries = $('#Lost_Time_Injuries').val();
    //     Lost_Time_Injuries = (Lost_Time_Injuries == null) ? "N/A" : Lost_Time_Injuries;
    //     console.log('Lost_Time_Injuries', Lost_Time_Injuries);

    //     // incident_reports_crew_injury table
    //     var First_Aid_Case = $('#First_Aid_Case').val();
    //     First_Aid_Case = (First_Aid_Case == null) ? "N/A" : First_Aid_Case;
    //     console.log('First_Aid_Case', First_Aid_Case);

    //     // incident_report table
    //     var Lead_Investigator = $('#Lead_Investigator').val();
    //     Lead_Investigator = (Lead_Investigator == '') ? "N/A" : Lead_Investigator;
    //     console.log('Lead_Investigator', Lead_Investigator);

    //     // supporting members----------incident_reports_supporting_team_members table
    //     var supporting_members_length = $('input[name="STM[]"]').length;
    //     var supporting_members = [];
    //     console.log('supporting_members_length', supporting_members_length);
    //     for (var i = 0; i < supporting_members_length; i++) {
    //         // console.log('in for loop');
    //         var tmp = $(`#STM_${i+1}`).val();
    //         tmp = (tmp == '') ? "N/A" : tmp;
    //         console.log('tmp', tmp);
    //         supporting_members.push(tmp);
    //     }

    //     var report_id = $('#report_id').val();
    //     report_id = (report_id == null || report_id == '') ? "" : report_id;
    //     console.log('report_id', report_id);

    //     var saved_status = $('#saved_status').val();
    //     saved_status = (saved_status == null || saved_status == '') ? "" : saved_status;
    //     console.log('saved_status', saved_status);

    //     var user_id = $('#user_id').val();
    //     user_id = (user_id == null || user_id == '') ? "" : user_id;
    //     console.log('user_id', user_id);
    //     // save data for this step
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'POST',
    //         url: "/saveIncidentCrewInjury",
    //         dataType: 'json',
    //         data: {
    //             'user_id': user_id,
    //             'report_id': report_id,
    //             'saved_status': saved_status,
    //             'Crew_Injury': Crew_Injury,
    //             'Other_Personnel_Injury': Other_Personnel_Injury,
    //             'Fatality': Fatality,
    //             'Lost_Workday_Case': Lost_Workday_Case,
    //             'Restricted_Work_Case': Restricted_Work_Case,
    //             'Medical_Treatment_Case': Medical_Treatment_Case,
    //             'Lost_Time_Injuries': Lost_Time_Injuries,
    //             'Lead_Investigator': Lead_Investigator,
    //             'supporting_members': supporting_members,
    //             'First_Aid_Case': First_Aid_Case
    //         },
    //         success: function(result) {
    //             var data = result;
    //             console.log('data::', data);

    //         }
    //     });

    // });






    // step:- vessel_details
    // $('.vessel_details#nextBtn').on('click', function() {
    //     console.log('VESSEL DETAILS');
    //     var Name = $('#Name').val();
    //     Name = (Name == null) ? "N/A" : Name;
    //     console.log('Name', Name);

    //     var Class_Society = $('#Class_Society').val();
    //     Class_Society = (Class_Society == null) ? "N/A" : Class_Society;
    //     console.log('Class_Society', Class_Society);

    //     var IMO_No = $('#IMO_No').val();
    //     IMO_No = (IMO_No == null) ? "N/A" : IMO_No;
    //     console.log('IMO_No', IMO_No);

    //     var Year_Built = $('#Year_Built').val();
    //     Year_Built = (Year_Built == null) ? "N/A" : Year_Built;
    //     console.log('Year_Built', Year_Built);

    //     var Type = $('#Type').val();
    //     Type = (Type == null) ? "N/A" : Type;
    //     console.log('Type', Type);

    //     var Owner = $('#Owner').val();
    //     Owner = (Owner == null) ? "N/A" : Owner;
    //     console.log('Owner', Owner);

    //     var Hull_No = $('#Hull_No').val();
    //     Hull_No = (Hull_No == null) ? "N/A" : Hull_No;
    //     console.log('Hull_No', Hull_No);

    //     var GRT = $('#GRT').val();
    //     GRT = (GRT == null) ? "N/A" : GRT;
    //     console.log('GRT', GRT);

    //     var Call_Sign = $('#Call_Sign').val();
    //     Call_Sign = (Call_Sign == null) ? "N/A" : Call_Sign;
    //     console.log('Call_Sign', Call_Sign);

    //     var Flag = $('#Flag').val();
    //     Flag = (Flag == null) ? "N/A" : Flag;
    //     console.log('Flag', Flag);

    //     var NRT = $('#NRT').val();
    //     NRT = (NRT == null) ? "N/A" : NRT;
    //     console.log('NRT', NRT);

    //     var Length = $('#Length').val();
    //     Length = (Length == null) ? "N/A" : Length;
    //     console.log('Length', Length);

    //     var breadth = $('#breadth').val();
    //     breadth = (breadth == null) ? "N/A" : breadth;
    //     console.log('breadth', breadth);

    //     var depth = $('#depth').val();
    //     depth = (depth == null) ? "N/A" : depth;
    //     console.log('depth', depth);

    //     var Port_of_Registry = $('#Port_of_Registry').val();
    //     Port_of_Registry = (Port_of_Registry == null) ? "N/A" : Port_of_Registry;
    //     console.log('Port_of_Registry', Port_of_Registry);

    // });






    // step:- EVENT INFORMATION
    // $('.event_information#nextBtn').on('click', function() {
    //     console.log('EVENT INFORMATION');
    //     var Place_of_the_incident_1st = $('#Place_of_the_incident_1st').val();
    //     Place_of_the_incident_1st = (Place_of_the_incident_1st == null) ? "N/A" : Place_of_the_incident_1st;
    //     console.log('Place_of_the_incident_1st', Place_of_the_incident_1st);

    //     var Place_of_the_incident_2nd = $('#Place_of_the_incident_2nd').val();
    //     Place_of_the_incident_2nd = (Place_of_the_incident_2nd == '') ? "N/A" : Place_of_the_incident_2nd;
    //     console.log('Place_of_the_incident_2nd', Place_of_the_incident_2nd);

    //     var Date_of_incident_event_information = $('#Date_of_incident_event_information').val();
    //     Date_of_incident_event_information = (Date_of_incident_event_information == '') ? "N/A" : Date_of_incident_event_information;
    //     console.log('Date_of_incident_event_information', Date_of_incident_event_information);

    //     var Time_of_incident_event_information_LMT = $('#Time_of_incident_event_information_LMT').val();
    //     Time_of_incident_event_information_LMT = (Time_of_incident_event_information_LMT == '') ? "N/A" : Time_of_incident_event_information_LMT;
    //     console.log('Time_of_incident_event_information_LMT', Time_of_incident_event_information_LMT);

    //     var Time_of_incident_event_information_GMT = $('#Time_of_incident_event_information_GMT').val();
    //     Time_of_incident_event_information_GMT = (Time_of_incident_event_information_GMT == null) ? "N/A" : Time_of_incident_event_information_GMT;
    //     console.log('Time_of_incident_event_information_GMT', Time_of_incident_event_information_GMT);

    //     var Location_of_incident = $('#Location_of_incident').val();
    //     Location_of_incident = (Location_of_incident == '') ? "N/A" : Location_of_incident;
    //     console.log('Location_of_incident', Location_of_incident);

    //     var Operation = $('#Operation').val();
    //     Operation = (Operation == null) ? "N/A" : Operation;
    //     console.log('Operation', Operation);

    //     var Others_operation_EI = $('#Others_operation_EI').val();
    //     Others_operation_EI = (Others_operation_EI == '') ? "N/A" : Others_operation_EI;
    //     console.log('Others_operation_EI', Others_operation_EI);

    //     var Vessel_Condition = $('#Vessel_Condition').val();
    //     Vessel_Condition = (Vessel_Condition == null) ? "N/A" : Vessel_Condition;
    //     console.log('Vessel_Condition', Vessel_Condition);

    //     var cargo_type_and_quantity = $('#cargo_type_and_quantity').val();
    //     cargo_type_and_quantity = (cargo_type_and_quantity == '') ? "N/A" : cargo_type_and_quantity;
    //     console.log('cargo_type_and_quantity', cargo_type_and_quantity);

    //     var Wind_force = $('#Wind_force').val();
    //     Wind_force = (Wind_force == null) ? "N/A" : Wind_force;
    //     console.log('Wind_force', Wind_force);

    //     var Direction = $('#Direction').val();
    //     Direction = (Direction == '') ? "N/A" : Direction;
    //     console.log('Direction', Direction);

    //     var Swell_height = $('#Swell_height').val();
    //     Swell_height = (Swell_height == null) ? "N/A" : Swell_height;
    //     console.log('Swell_height', Swell_height);

    //     var Swell_length = $('#Swell_length').val();
    //     Swell_length = (Swell_length == null) ? "N/A" : Swell_length;
    //     console.log('Swell_length', Swell_length);

    //     var Swell_direction = $('#Swell_direction').val();
    //     Swell_direction = (Swell_direction == '') ? "N/A" : Swell_direction;
    //     console.log('Swell_direction', Swell_direction);

    //     var Sky = $('#Sky').val();
    //     Sky = (Sky == null) ? "N/A" : Sky;
    //     console.log('Sky', Sky);

    //     var Visibility = $('#Visibility').val();
    //     Visibility = (Visibility == null) ? "N/A" : Visibility;
    //     console.log('Visibility', Visibility);

    //     var Rolling = $('#Rolling').val();
    //     Rolling = (Rolling == '') ? "N/A" : Rolling;
    //     console.log('Rolling', Rolling);

    //     var Pitcing = $('#Pitcing').val();
    //     Pitcing = (Pitcing == '') ? "N/A" : Pitcing;
    //     console.log('Pitcing', Pitcing);

    //     var Illumination = $('#Illumination').val();
    //     Illumination = (Illumination == null) ? "N/A" : Illumination;
    //     console.log('Illumination', Illumination);

    //     // TYPE OF LOSS
    //     var pi_club_information = $('#pi_club_information').val();
    //     pi_club_information = (pi_club_information == null) ? "N/A" : pi_club_information;
    //     console.log('pi_club_information', pi_club_information);

    //     var hm_informed = $('#hm_informed').val();
    //     hm_informed = (hm_informed == null) ? "N/A" : hm_informed;
    //     console.log('hm_informed', hm_informed);

    //     var remarks_tol = $('#remarks_tol').val();
    //     remarks_tol = (remarks_tol == '') ? "N/A" : remarks_tol;
    //     console.log('remarks_tol', remarks_tol);

    //     var report_id = $('#report_id').val();
    //     report_id = (report_id == null || report_id == '') ? "" : report_id;
    //     console.log('report_id', report_id);

    //     var saved_status = $('#saved_status').val();
    //     saved_status = (saved_status == null || saved_status == '') ? "" : saved_status;
    //     console.log('saved_status', saved_status);

    //     var user_id = $('#user_id').val();
    //     user_id = (user_id == null || user_id == '') ? "" : user_id;
    //     console.log('user_id', user_id);

    //     // save data for this step
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'POST',
    //         url: "/saveEventInformation",
    //         dataType: 'json',
    //         data: {
    //             'user_id': user_id,
    //             'report_id': report_id,
    //             'saved_status': saved_status,
    //             'Place_of_the_incident_1st': Place_of_the_incident_1st,
    //             'Place_of_the_incident_2nd': Place_of_the_incident_2nd,
    //             'Date_of_incident_event_information': Date_of_incident_event_information,
    //             'Time_of_incident_event_information_LMT': Time_of_incident_event_information_LMT,
    //             'Time_of_incident_event_information_GMT': Time_of_incident_event_information_GMT,
    //             'Location_of_incident': Location_of_incident,
    //             'Operation': Operation,
    //             'Others_operation_EI': Others_operation_EI,
    //             'Vessel_Condition': Vessel_Condition,
    //             'cargo_type_and_quantity': cargo_type_and_quantity,
    //             'Wind_force': Wind_force,
    //             'Direction': Direction,
    //             'Swell_height': Swell_height,
    //             'Swell_length': Swell_length,
    //             'Swell_direction': Swell_direction,
    //             'Sky': Sky,
    //             'Visibility': Visibility,
    //             'Rolling': Rolling,
    //             'Pitcing': Pitcing,
    //             'Illumination': Illumination,
    //             'pi_club_information': pi_club_information,
    //             'hm_informed': hm_informed,
    //             'remarks_tol': remarks_tol
    //         },
    //         success: function(result) {
    //             var data = result;
    //             console.log('data::', data);

    //         }
    //     });


    // });






    // step:- Incident in Brief
    // $('.incident_brief#nextBtn').on('click', function() {
    //     console.log('Incident in Brief');
    //     var Incident_in_brief = $('#Incident_in_brief').val();
    //     Incident_in_brief = (Incident_in_brief == '') ? "N/A" : Incident_in_brief;
    //     console.log('Incident_in_brief', Incident_in_brief);

    //     var report_id = $('#report_id').val();
    //     report_id = (report_id == null || report_id == '') ? "" : report_id;
    //     console.log('report_id', report_id);

    //     var saved_status = $('#saved_status').val();
    //     saved_status = (saved_status == null || saved_status == '') ? "" : saved_status;
    //     console.log('saved_status', saved_status);

    //     var user_id = $('#user_id').val();
    //     user_id = (user_id == null || user_id == '') ? "" : user_id;
    //     console.log('user_id', user_id);

    //     // save data for this step
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'POST',
    //         url: "/saveIncidentBrief",
    //         dataType: 'json',
    //         data: {
    //             'user_id': user_id,
    //             'report_id': report_id,
    //             'saved_status': saved_status,
    //             'Incident_in_brief': Incident_in_brief
    //         },
    //         success: function(result) {
    //             var data = result;
    //             console.log('data::', data);

    //         }
    //     });
    // });






    // step:- event log
    // $('.event_log#nextBtn').on('click', function() {
    //     console.log('event log');

    //     // display all dates
    //     var event_date_length = $('input[name="event_date[]"]').length;
    //     var event_date = [];
    //     console.log('event_date_length', event_date_length);
    //     for (var i = 0; i < event_date_length; i++) {
    //         // console.log('in for loop');event_date_1
    //         var tmp = $(`#event_date_${i+1}`).val();
    //         tmp = (tmp == '') ? "N/A" : tmp;
    //         event_date.push(tmp);
    //         console.log('date', tmp);
    //     }

    //     // display times
    //     var event_time_length = $('input[name="event_time[]"]').length;
    //     var event_time = [];
    //     console.log('event_time_length', event_time_length);
    //     for (var i = 0; i < event_time_length; i++) {
    //         // console.log('in for loop');event_time_1
    //         var tmp2 = $(`#event_time_${i+1}`).val();
    //         tmp2 = (tmp2 == '') ? "N/A" : tmp2;
    //         event_time.push(tmp2);
    //         console.log('time', tmp2);
    //     }

    //     // display remarks
    //     var event_remarks_length = $('textarea[name="event_remarks[]"]').length;
    //     var event_remarks = [];
    //     console.log('event_remarks_length', event_remarks_length);
    //     for (var i = 0; i < event_remarks_length; i++) {
    //         // console.log('in for loop');event_remarks_1
    //         var tmp3 = $(`#event_remarks_${i+1}`).val();
    //         tmp3 = (tmp3 == '') ? "N/A" : tmp3;
    //         // event_remarks = event_remarks + tmp3;
    //         event_remarks.push(tmp3);
    //         console.log('remarks', tmp3);
    //     }

    //     var report_id = $('#report_id').val();
    //     report_id = (report_id == null || report_id == '') ? "" : report_id;
    //     console.log('report_id', report_id);

    //     var saved_status = $('#saved_status').val();
    //     saved_status = (saved_status == null || saved_status == '') ? "" : saved_status;
    //     console.log('saved_status', saved_status);

    //     var user_id = $('#user_id').val();
    //     user_id = (user_id == null || user_id == '') ? "" : user_id;
    //     console.log('user_id', user_id);
    //     console.log('event_date', event_date);
    //     console.log('event_time', event_time);
    //     console.log('event_remarks', event_remarks);
    //     // save data for this step
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'POST',
    //         url: "/saveEventLog",
    //         dataType: 'json',
    //         data: {
    //             'user_id': user_id,
    //             'report_id': report_id,
    //             'saved_status': saved_status,
    //             'event_date': event_date,
    //             'event_time': event_time,
    //             'event_remarks': event_remarks
    //         },
    //         success: function(result) {
    //             var data = result;
    //             console.log('data::', data);

    //         }
    //     });


    // });






    // step:- INCIDENT INVESTIGATION AND ROOT CAUSE FINDINGS
    // $('.root_cause#nextBtn').on('click', function() {
    //     console.log('INCIDENT INVESTIGATION AND ROOT CAUSE FINDINGS');
    //     var report_id = $('#report_id').val();
    //     report_id = (report_id == null || report_id == '') ? "" : report_id;
    //     console.log('report_id', report_id);

    //     var saved_status = $('#saved_status').val();
    //     saved_status = (saved_status == null || saved_status == '') ? "" : saved_status;
    //     console.log('saved_status', saved_status);

    //     var user_id = $('#user_id').val();
    //     user_id = (user_id == null || user_id == '') ? "" : user_id;
    //     console.log('user_id', user_id);

    //     // display event details
    //     var Event_Details_IIARCF_length = $('textarea[name="Event_Details_IIARCF[]"]').length;
    //     var Event_Details_IIARCF = [];
    //     console.log('Event_Details_IIARCF_length', Event_Details_IIARCF_length);
    //     for (var i = 0; i < Event_Details_IIARCF_length; i++) {
    //         // console.log('in for loop');event_remarks_1
    //         var tmp = $(`#Event_Details_IIARCF_${i+1}`).val();
    //         tmp = (tmp == '' || tmp == null) ? "N/A" : tmp;
    //         Event_Details_IIARCF.push(tmp);
    //         console.log('tmp', tmp);
    //     }
    //     console.log('Event_Details_IIARCF', Event_Details_IIARCF);
    //     var Risk_category_IIARCF = $('#Risk_category_IIARCF').val();
    //     Risk_category_IIARCF = (Risk_category_IIARCF == null || Risk_category_IIARCF == '') ? "N/A" : Risk_category_IIARCF;
    //     console.log('Risk_category_IIARCF', Risk_category_IIARCF);

    //     var immediatecause = $('#immediatecause').val();
    //     immediatecause = (immediatecause == '' || immediatecause == null) ? "N/A" : immediatecause;
    //     console.log('immediatecause', immediatecause);

    //     var immediatecause_second = $('#dd2').val();
    //     immediatecause_second = (immediatecause_second == '' || immediatecause_second == null) ? "N/A" : immediatecause_second;
    //     console.log('immediatecause_second', immediatecause_second);

    //     var immediatecause_third = $('#ddd2').val();
    //     immediatecause_third = (immediatecause_third == '' || immediatecause_third == null) ? "N/A" : immediatecause_third;
    //     console.log('immediatecause_third', immediatecause_third);

    //     if (Risk_category_IIARCF == 'SAFETY') {
    //         // SAFETY
    //         var IIARCF_safety_first_dropdown = $('#IIARCF_safety_first_dropdown').val();
    //         IIARCF_safety_first_dropdown = (IIARCF_safety_first_dropdown == null || IIARCF_safety_first_dropdown == '') ? "N/A" : IIARCF_safety_first_dropdown;
    //         console.log('IIARCF_safety_first_dropdown', IIARCF_safety_first_dropdown);

    //         var IIARCF_safety_Severity = $('#IIARCF_safety_Severity').val();
    //         IIARCF_safety_Severity = (IIARCF_safety_Severity == null || IIARCF_safety_Severity == '') ? "N/A" : IIARCF_safety_Severity;
    //         console.log('IIARCF_safety_Severity', IIARCF_safety_Severity);

    //         var IIARCF_safety_Likelihood = $('#IIARCF_safety_Likelihood').val();
    //         IIARCF_safety_Likelihood = (IIARCF_safety_Likelihood == null || IIARCF_safety_Likelihood == '') ? "N/A" : IIARCF_safety_Likelihood;
    //         console.log('IIARCF_safety_Likelihood', IIARCF_safety_Likelihood);

    //         var IIARCF_safety_Result = $('#IIARCF_safety_Result').val();
    //         IIARCF_safety_Result = (IIARCF_safety_Result == '' || IIARCF_safety_Result == null) ? "N/A" : IIARCF_safety_Result;
    //         console.log('IIARCF_safety_Result', IIARCF_safety_Result);

    //         var IIARCF_safety_NameOfThePerson = $('#IIARCF_safety_NameOfThePerson').val();
    //         IIARCF_safety_NameOfThePerson = (IIARCF_safety_NameOfThePerson == '' || IIARCF_safety_NameOfThePerson == null) ? "N/A" : IIARCF_safety_NameOfThePerson;
    //         console.log('IIARCF_safety_NameOfThePerson', IIARCF_safety_NameOfThePerson);

    //         var IIARCF_safety_TypeOfInjury = $('#IIARCF_safety_TypeOfInjury').val();
    //         IIARCF_safety_TypeOfInjury = (IIARCF_safety_TypeOfInjury == '' || IIARCF_safety_TypeOfInjury == null) ? "N/A" : IIARCF_safety_TypeOfInjury;
    //         console.log('IIARCF_safety_TypeOfInjury', IIARCF_safety_TypeOfInjury);

    //         var IIARCF_safety_AssociatedCost = $('#IIARCF_safety_AssociatedCost').val();
    //         IIARCF_safety_AssociatedCost = (IIARCF_safety_AssociatedCost == '' || IIARCF_safety_AssociatedCost == null) ? "N/A" : IIARCF_safety_AssociatedCost;
    //         console.log('IIARCF_safety_AssociatedCost', IIARCF_safety_AssociatedCost);

    //         var selected_currency_safety = $('#selected_currency_safety').val();
    //         selected_currency_safety = (selected_currency_safety == '' || selected_currency_safety == null) ? "N/A" : selected_currency_safety;
    //         console.log('selected_currency_safety', selected_currency_safety);

    //         var IIARCF_safety_localCurrency = $('#IIARCF_safety_localCurrency').val();
    //         IIARCF_safety_localCurrency = (IIARCF_safety_localCurrency == '' || IIARCF_safety_localCurrency == null) ? "N/A" : IIARCF_safety_localCurrency;
    //         console.log('IIARCF_safety_localCurrency', IIARCF_safety_localCurrency);

    //         // save data for this step
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             type: 'POST',
    //             url: "/saveRootCauseFindings",
    //             dataType: 'json',
    //             data: {
    //                 'user_id': user_id,
    //                 'report_id': report_id,
    //                 'saved_status': saved_status,
    //                 'Event_Details_IIARCF': Event_Details_IIARCF,
    //                 'IIARCF_safety_first_dropdown': IIARCF_safety_first_dropdown,
    //                 'IIARCF_safety_Severity': IIARCF_safety_Severity,
    //                 'IIARCF_safety_Likelihood': IIARCF_safety_Likelihood,
    //                 'IIARCF_safety_Result': IIARCF_safety_Result,
    //                 'IIARCF_safety_NameOfThePerson': IIARCF_safety_NameOfThePerson,
    //                 'IIARCF_safety_TypeOfInjury': IIARCF_safety_TypeOfInjury,
    //                 'IIARCF_safety_AssociatedCost': IIARCF_safety_AssociatedCost,
    //                 'selected_currency_safety': selected_currency_safety,
    //                 'IIARCF_safety_localCurrency': IIARCF_safety_localCurrency,
    //                 'immediatecause': immediatecause,
    //                 'immediatecause_second': immediatecause_second,
    //                 'immediatecause_third': immediatecause_third,
    //                 'Risk_category_IIARCF': Risk_category_IIARCF
    //             },
    //             success: function(result) {
    //                 var data = result;
    //                 console.log('data::', data);

    //             }
    //         });
    //     } else if (Risk_category_IIARCF == 'HEALTH') {
    //         // HEALTH
    //         var IIARCF_HEALTH_first_dropdown = $('#IIARCF_HEALTH_first_dropdown').val();
    //         IIARCF_HEALTH_first_dropdown = (IIARCF_HEALTH_first_dropdown == '' || IIARCF_HEALTH_first_dropdown == null) ? "N/A" : IIARCF_HEALTH_first_dropdown;
    //         console.log('IIARCF_HEALTH_first_dropdown', IIARCF_HEALTH_first_dropdown);

    //         var IIARCF_HEALTH_Severity = $('#IIARCF_HEALTH_Severity').val();
    //         IIARCF_HEALTH_Severity = (IIARCF_HEALTH_Severity == '' || IIARCF_HEALTH_Severity == null) ? "N/A" : IIARCF_HEALTH_Severity;
    //         console.log('IIARCF_HEALTH_Severity', IIARCF_HEALTH_Severity);

    //         var IIARCF_HEALTH_Likelihood = $('#IIARCF_HEALTH_Likelihood').val();
    //         IIARCF_HEALTH_Likelihood = (IIARCF_HEALTH_Likelihood == '' || IIARCF_HEALTH_Likelihood == null) ? "N/A" : IIARCF_HEALTH_Likelihood;
    //         console.log('IIARCF_HEALTH_Likelihood', IIARCF_HEALTH_Likelihood);

    //         var IIARCF_HEALTH_Result = $('#IIARCF_HEALTH_Result').val();
    //         IIARCF_HEALTH_Result = (IIARCF_HEALTH_Result == '' || IIARCF_HEALTH_Result == null) ? "N/A" : IIARCF_HEALTH_Result;
    //         console.log('IIARCF_HEALTH_Result', IIARCF_HEALTH_Result);

    //         var IIARCF_HEALTH_NameOfThePerson = $('#IIARCF_HEALTH_NameOfThePerson').val();
    //         IIARCF_HEALTH_NameOfThePerson = (IIARCF_HEALTH_NameOfThePerson == '' || IIARCF_HEALTH_NameOfThePerson == null) ? "N/A" : IIARCF_HEALTH_NameOfThePerson;
    //         console.log('IIARCF_HEALTH_NameOfThePerson', IIARCF_HEALTH_NameOfThePerson);

    //         var IIARCF_HEALTH_TypeOfInjury = $('#IIARCF_HEALTH_TypeOfInjury').val();
    //         IIARCF_HEALTH_TypeOfInjury = (IIARCF_HEALTH_TypeOfInjury == '' || IIARCF_HEALTH_TypeOfInjury == null) ? "N/A" : IIARCF_HEALTH_TypeOfInjury;
    //         console.log('IIARCF_HEALTH_TypeOfInjury', IIARCF_HEALTH_TypeOfInjury);

    //         var IIARCF_HEALTH_AssociatedCost = $('#IIARCF_HEALTH_AssociatedCost').val();
    //         IIARCF_HEALTH_AssociatedCost = (IIARCF_HEALTH_AssociatedCost == '' || IIARCF_HEALTH_AssociatedCost == null) ? "N/A" : IIARCF_HEALTH_AssociatedCost;
    //         console.log('IIARCF_HEALTH_AssociatedCost', IIARCF_HEALTH_AssociatedCost);

    //         var selected_currency_health = $('#selected_currency_health').val();
    //         selected_currency_health = (selected_currency_health == '' || selected_currency_health == null) ? "N/A" : selected_currency_health;
    //         console.log('selected_currency_health', selected_currency_health);

    //         var IIARCF_HEALTH_localCurrency = $('#IIARCF_HEALTH_localCurrency').val();
    //         IIARCF_HEALTH_localCurrency = (IIARCF_HEALTH_localCurrency == '' || IIARCF_HEALTH_localCurrency == null) ? "N/A" : IIARCF_HEALTH_localCurrency;
    //         console.log('IIARCF_HEALTH_localCurrency', IIARCF_HEALTH_localCurrency);

    //         // save data for this step
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             type: 'POST',
    //             url: "/saveRootCauseFindings",
    //             dataType: 'json',
    //             data: {
    //                 'user_id': user_id,
    //                 'report_id': report_id,
    //                 'saved_status': saved_status,
    //                 'IIARCF_HEALTH_first_dropdown': IIARCF_HEALTH_first_dropdown,
    //                 'IIARCF_HEALTH_Severity': IIARCF_HEALTH_Severity,
    //                 'IIARCF_HEALTH_Likelihood': IIARCF_HEALTH_Likelihood,
    //                 'IIARCF_HEALTH_Result': IIARCF_HEALTH_Result,
    //                 'IIARCF_HEALTH_NameOfThePerson': IIARCF_HEALTH_NameOfThePerson,
    //                 'IIARCF_HEALTH_TypeOfInjury': IIARCF_HEALTH_TypeOfInjury,
    //                 'IIARCF_HEALTH_AssociatedCost': IIARCF_HEALTH_AssociatedCost,
    //                 'selected_currency_health': selected_currency_health,
    //                 'IIARCF_HEALTH_localCurrency': IIARCF_HEALTH_localCurrency,
    //                 'immediatecause': immediatecause,
    //                 'immediatecause_second': immediatecause_second,
    //                 'immediatecause_third': immediatecause_third,
    //                 'Risk_category_IIARCF': Risk_category_IIARCF
    //             },
    //             success: function(result) {
    //                 var data = result;
    //                 console.log('data::', data);

    //             }
    //         });
    //     } else if (Risk_category_IIARCF == 'ENVIRONMENT') {
    //         // ENVIRONMENT
    //         var IIARCF_ENVIRONMENT_first_dropdown = $('#IIARCF_ENVIRONMENT_first_dropdown').val();
    //         IIARCF_ENVIRONMENT_first_dropdown = (IIARCF_ENVIRONMENT_first_dropdown == '' || IIARCF_ENVIRONMENT_first_dropdown == null) ? "N/A" : IIARCF_ENVIRONMENT_first_dropdown;
    //         console.log('IIARCF_ENVIRONMENT_first_dropdown', IIARCF_ENVIRONMENT_first_dropdown);

    //         var IIARCF_ENVIRONMENT_Severity = $('#IIARCF_ENVIRONMENT_Severity').val();
    //         IIARCF_ENVIRONMENT_Severity = (IIARCF_ENVIRONMENT_Severity == '' || IIARCF_ENVIRONMENT_Severity == null) ? "N/A" : IIARCF_ENVIRONMENT_Severity;
    //         console.log('IIARCF_ENVIRONMENT_Severity', IIARCF_ENVIRONMENT_Severity);

    //         var IIARCF_ENVIRONMENT_Likelihood = $('#IIARCF_ENVIRONMENT_Likelihood').val();
    //         IIARCF_ENVIRONMENT_Likelihood = (IIARCF_ENVIRONMENT_Likelihood == '' || IIARCF_ENVIRONMENT_Likelihood == null) ? "N/A" : IIARCF_ENVIRONMENT_Likelihood;
    //         console.log('IIARCF_ENVIRONMENT_Likelihood', IIARCF_ENVIRONMENT_Likelihood);

    //         var IIARCF_ENVIRONMENT_Result = $('#IIARCF_ENVIRONMENT_Result').val();
    //         IIARCF_ENVIRONMENT_Result = (IIARCF_ENVIRONMENT_Result == '' || IIARCF_ENVIRONMENT_Result == null) ? "N/A" : IIARCF_ENVIRONMENT_Result;
    //         console.log('IIARCF_ENVIRONMENT_Result', IIARCF_ENVIRONMENT_Result);

    //         var IIARCF_ENVIRONMENT_TypeOfPollution = $('#IIARCF_ENVIRONMENT_TypeOfPollution').val();
    //         IIARCF_ENVIRONMENT_TypeOfPollution = (IIARCF_ENVIRONMENT_TypeOfPollution == '' || IIARCF_ENVIRONMENT_TypeOfPollution == null) ? "N/A" : IIARCF_ENVIRONMENT_TypeOfPollution;
    //         console.log('IIARCF_ENVIRONMENT_TypeOfPollution', IIARCF_ENVIRONMENT_TypeOfPollution);

    //         var IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater = $('#IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater').val();
    //         IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater = (IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater == '' || IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater == null) ? "N/A" : IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater;
    //         console.log('IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater', IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater);

    //         var IIARCF_ENVIRONMENT_AssociatedCost = $('#IIARCF_ENVIRONMENT_AssociatedCost').val();
    //         IIARCF_ENVIRONMENT_AssociatedCost = (IIARCF_ENVIRONMENT_AssociatedCost == '' || IIARCF_ENVIRONMENT_AssociatedCost == null) ? "N/A" : IIARCF_ENVIRONMENT_AssociatedCost;
    //         console.log('IIARCF_ENVIRONMENT_AssociatedCost', IIARCF_ENVIRONMENT_AssociatedCost);

    //         var selected_currency_environment = $('#selected_currency_environment').val();
    //         selected_currency_environment = (selected_currency_environment == '' || selected_currency_environment == null) ? "N/A" : selected_currency_environment;
    //         console.log('selected_currency_environment', selected_currency_environment);

    //         var IIARCF_ENVIRONMENT_localCurrency = $('#IIARCF_ENVIRONMENT_localCurrency').val();
    //         IIARCF_ENVIRONMENT_localCurrency = (IIARCF_ENVIRONMENT_localCurrency == '' || IIARCF_ENVIRONMENT_localCurrency == null) ? "N/A" : IIARCF_ENVIRONMENT_localCurrency;
    //         console.log('IIARCF_ENVIRONMENT_localCurrency', IIARCF_ENVIRONMENT_localCurrency);

    //         var IIARCF_ENVIRONMENT_ContainedSpill = $('#IIARCF_ENVIRONMENT_ContainedSpill').val();
    //         IIARCF_ENVIRONMENT_ContainedSpill = (IIARCF_ENVIRONMENT_ContainedSpill == '' || IIARCF_ENVIRONMENT_ContainedSpill == null) ? "N/A" : IIARCF_ENVIRONMENT_ContainedSpill;
    //         console.log('IIARCF_ENVIRONMENT_ContainedSpill', IIARCF_ENVIRONMENT_ContainedSpill);

    //         var IIARCF_ENVIRONMENT_TotalSpilledQuantity = $('#IIARCF_ENVIRONMENT_TotalSpilledQuantity').val();
    //         IIARCF_ENVIRONMENT_TotalSpilledQuantity = (IIARCF_ENVIRONMENT_TotalSpilledQuantity == '' || IIARCF_ENVIRONMENT_TotalSpilledQuantity == null) ? "N/A" : IIARCF_ENVIRONMENT_TotalSpilledQuantity;
    //         console.log('IIARCF_ENVIRONMENT_TotalSpilledQuantity', IIARCF_ENVIRONMENT_TotalSpilledQuantity);

    //         var IIARCF_ENVIRONMENT_SpilledInWater = $('#IIARCF_ENVIRONMENT_SpilledInWater').val();
    //         IIARCF_ENVIRONMENT_SpilledInWater = (IIARCF_ENVIRONMENT_SpilledInWater == '' || IIARCF_ENVIRONMENT_SpilledInWater == null) ? "N/A" : IIARCF_ENVIRONMENT_SpilledInWater;
    //         console.log('IIARCF_ENVIRONMENT_SpilledInWater', IIARCF_ENVIRONMENT_SpilledInWater);

    //         var IIARCF_ENVIRONMENT_SpilledAshore = $('#IIARCF_ENVIRONMENT_SpilledAshore').val();
    //         IIARCF_ENVIRONMENT_SpilledAshore = (IIARCF_ENVIRONMENT_SpilledAshore == '' || IIARCF_ENVIRONMENT_SpilledAshore == null) ? "N/A" : IIARCF_ENVIRONMENT_SpilledAshore;
    //         console.log('IIARCF_ENVIRONMENT_SpilledAshore', IIARCF_ENVIRONMENT_SpilledAshore);

    //         // save data for this step
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             type: 'POST',
    //             url: "/saveRootCauseFindings",
    //             dataType: 'json',
    //             data: {
    //                 'user_id': user_id,
    //                 'report_id': report_id,
    //                 'saved_status': saved_status,
    //                 'IIARCF_ENVIRONMENT_first_dropdown': IIARCF_ENVIRONMENT_first_dropdown,
    //                 'IIARCF_ENVIRONMENT_Severity': IIARCF_ENVIRONMENT_Severity,
    //                 'IIARCF_ENVIRONMENT_Likelihood': IIARCF_ENVIRONMENT_Likelihood,
    //                 'IIARCF_ENVIRONMENT_Result': IIARCF_ENVIRONMENT_Result,
    //                 'IIARCF_ENVIRONMENT_TypeOfPollution': IIARCF_ENVIRONMENT_TypeOfPollution,
    //                 'IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater': IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater,
    //                 'IIARCF_ENVIRONMENT_AssociatedCost': IIARCF_ENVIRONMENT_AssociatedCost,
    //                 'selected_currency_environment': selected_currency_environment,
    //                 'IIARCF_ENVIRONMENT_localCurrency': IIARCF_ENVIRONMENT_localCurrency,
    //                 'IIARCF_ENVIRONMENT_ContainedSpill': IIARCF_ENVIRONMENT_ContainedSpill,
    //                 'IIARCF_ENVIRONMENT_TotalSpilledQuantity': IIARCF_ENVIRONMENT_TotalSpilledQuantity,
    //                 'IIARCF_ENVIRONMENT_SpilledInWater': IIARCF_ENVIRONMENT_SpilledInWater,
    //                 'IIARCF_ENVIRONMENT_SpilledAshore': IIARCF_ENVIRONMENT_SpilledAshore,
    //                 'immediatecause': immediatecause,
    //                 'immediatecause_second': immediatecause_second,
    //                 'immediatecause_third': immediatecause_third,
    //                 'Risk_category_IIARCF': Risk_category_IIARCF

    //             },
    //             success: function(result) {
    //                 var data = result;
    //                 console.log('data::', data);

    //             }
    //         });
    //     } else if (Risk_category_IIARCF == 'OPERATIONAL IMPACT') {
    //         // OPERATIONAL IMPACT
    //         var IIARCF_OPERATIONAL_IMPACT_Vessel = $('#IIARCF_OPERATIONAL_IMPACT_Vessel').val();
    //         IIARCF_OPERATIONAL_IMPACT_Vessel = (IIARCF_OPERATIONAL_IMPACT_Vessel == '' || IIARCF_OPERATIONAL_IMPACT_Vessel == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_Vessel;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_Vessel', IIARCF_OPERATIONAL_IMPACT_Vessel);

    //         var IIARCF_OPERATIONAL_IMPACT_Cargo = $('#IIARCF_OPERATIONAL_IMPACT_Cargo').val();
    //         IIARCF_OPERATIONAL_IMPACT_Cargo = (IIARCF_OPERATIONAL_IMPACT_Cargo == '' || IIARCF_OPERATIONAL_IMPACT_Cargo == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_Cargo;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_Cargo', IIARCF_OPERATIONAL_IMPACT_Cargo);

    //         var IIARCF_OPERATIONAL_IMPACT_Third_Party = $('#IIARCF_OPERATIONAL_IMPACT_Third_Party').val();
    //         IIARCF_OPERATIONAL_IMPACT_Third_Party = (IIARCF_OPERATIONAL_IMPACT_Third_Party == '' || IIARCF_OPERATIONAL_IMPACT_Third_Party == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_Third_Party;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_Third_Party', IIARCF_OPERATIONAL_IMPACT_Third_Party);

    //         var IIARCF_OPERATIONAL_IMPACT_first_dropdown = $('#IIARCF_OPERATIONAL_IMPACT_first_dropdown').val();
    //         IIARCF_OPERATIONAL_IMPACT_first_dropdown = (IIARCF_OPERATIONAL_IMPACT_first_dropdown == '' || IIARCF_OPERATIONAL_IMPACT_first_dropdown == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_first_dropdown;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_first_dropdown', IIARCF_OPERATIONAL_IMPACT_first_dropdown);

    //         var IIARCF_OPERATIONAL_IMPACT_Severity = $('#IIARCF_OPERATIONAL_IMPACT_Severity').val();
    //         IIARCF_OPERATIONAL_IMPACT_Severity = (IIARCF_OPERATIONAL_IMPACT_Severity == '' || IIARCF_OPERATIONAL_IMPACT_Severity == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_Severity;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_Severity', IIARCF_OPERATIONAL_IMPACT_Severity);

    //         var IIARCF_OPERATIONAL_IMPACT_Likelihood = $('#IIARCF_OPERATIONAL_IMPACT_Likelihood').val();
    //         IIARCF_OPERATIONAL_IMPACT_Likelihood = (IIARCF_OPERATIONAL_IMPACT_Likelihood == '' || IIARCF_OPERATIONAL_IMPACT_Likelihood == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_Likelihood;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_Likelihood', IIARCF_OPERATIONAL_IMPACT_Likelihood);

    //         var IIARCF_OPERATIONAL_IMPACT_Result = $('#IIARCF_OPERATIONAL_IMPACT_Result').val();
    //         IIARCF_OPERATIONAL_IMPACT_Result = (IIARCF_OPERATIONAL_IMPACT_Result == '' || IIARCF_OPERATIONAL_IMPACT_Result == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_Result;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_Result', IIARCF_OPERATIONAL_IMPACT_Result);

    //         var IIARCF_OPERATIONAL_IMPACT_Damage_description = $('#IIARCF_OPERATIONAL_IMPACT_Damage_description').val();
    //         IIARCF_OPERATIONAL_IMPACT_Damage_description = (IIARCF_OPERATIONAL_IMPACT_Damage_description == '' || IIARCF_OPERATIONAL_IMPACT_Damage_description == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_Damage_description;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_Damage_description', IIARCF_OPERATIONAL_IMPACT_Damage_description);

    //         var IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any = $('#IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any').val();
    //         IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any = (IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any == '' || IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any', IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any);

    //         var IIARCF_OPERATIONAL_IMPACT_AssociatedCost = $('#IIARCF_OPERATIONAL_IMPACT_AssociatedCost').val();
    //         IIARCF_OPERATIONAL_IMPACT_AssociatedCost = (IIARCF_OPERATIONAL_IMPACT_AssociatedCost == '' || IIARCF_OPERATIONAL_IMPACT_AssociatedCost == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_AssociatedCost;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_AssociatedCost', IIARCF_OPERATIONAL_IMPACT_AssociatedCost);

    //         var selected_currency_operational_impact = $('#selected_currency_operational_impact').val();
    //         selected_currency_operational_impact = (selected_currency_operational_impact == '' || selected_currency_operational_impact == null) ? "N/A" : selected_currency_operational_impact;
    //         console.log('selected_currency_operational_impact', selected_currency_operational_impact);

    //         var IIARCF_OPERATIONAL_IMPACT_localCurrency = $('#IIARCF_OPERATIONAL_IMPACT_localCurrency').val();
    //         IIARCF_OPERATIONAL_IMPACT_localCurrency = (IIARCF_OPERATIONAL_IMPACT_localCurrency == '' || IIARCF_OPERATIONAL_IMPACT_localCurrency == null) ? "N/A" : IIARCF_OPERATIONAL_IMPACT_localCurrency;
    //         console.log('IIARCF_OPERATIONAL_IMPACT_localCurrency', IIARCF_OPERATIONAL_IMPACT_localCurrency);

    //         // save data for this step
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             type: 'POST',
    //             url: "/saveRootCauseFindings",
    //             dataType: 'json',
    //             data: {
    //                 'user_id': user_id,
    //                 'report_id': report_id,
    //                 'saved_status': saved_status,
    //                 'IIARCF_OPERATIONAL_IMPACT_Vessel': IIARCF_OPERATIONAL_IMPACT_Vessel,
    //                 'IIARCF_OPERATIONAL_IMPACT_Cargo': IIARCF_OPERATIONAL_IMPACT_Cargo,
    //                 'IIARCF_OPERATIONAL_IMPACT_Third_Party': IIARCF_OPERATIONAL_IMPACT_Third_Party,
    //                 'IIARCF_OPERATIONAL_IMPACT_first_dropdown': IIARCF_OPERATIONAL_IMPACT_first_dropdown,
    //                 'IIARCF_OPERATIONAL_IMPACT_Severity': IIARCF_OPERATIONAL_IMPACT_Severity,
    //                 'IIARCF_OPERATIONAL_IMPACT_Likelihood': IIARCF_OPERATIONAL_IMPACT_Likelihood,
    //                 'IIARCF_OPERATIONAL_IMPACT_Result': IIARCF_OPERATIONAL_IMPACT_Result,
    //                 'IIARCF_OPERATIONAL_IMPACT_Damage_description': IIARCF_OPERATIONAL_IMPACT_Damage_description,
    //                 'IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any': IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any,
    //                 'IIARCF_OPERATIONAL_IMPACT_AssociatedCost': IIARCF_OPERATIONAL_IMPACT_AssociatedCost,
    //                 'selected_currency_operational_impact': selected_currency_operational_impact,
    //                 'IIARCF_OPERATIONAL_IMPACT_localCurrency': IIARCF_OPERATIONAL_IMPACT_localCurrency,
    //                 'immediatecause': immediatecause,
    //                 'immediatecause_second': immediatecause_second,
    //                 'immediatecause_third': immediatecause_third,
    //                 'Risk_category_IIARCF': Risk_category_IIARCF
    //             },
    //             success: function(result) {
    //                 var data = result;
    //                 console.log('data::', data);

    //             }
    //         });

    //     } else if (Risk_category_IIARCF == 'MEDIA') {
    //         // MEDIA
    //         var IIARCF_MEDIA_first_dropdown = $('#IIARCF_MEDIA_first_dropdown').val();
    //         IIARCF_MEDIA_first_dropdown = (IIARCF_MEDIA_first_dropdown == '' || IIARCF_MEDIA_first_dropdown == null) ? "N/A" : IIARCF_MEDIA_first_dropdown;
    //         console.log('IIARCF_MEDIA_first_dropdown', IIARCF_MEDIA_first_dropdown);

    //         var IIARCF_MEDIA_Severity = $('#IIARCF_MEDIA_Severity').val();
    //         IIARCF_MEDIA_Severity = (IIARCF_MEDIA_Severity == '' || IIARCF_MEDIA_Severity == null) ? "N/A" : IIARCF_MEDIA_Severity;
    //         console.log('IIARCF_MEDIA_Severity', IIARCF_MEDIA_Severity);

    //         var IIARCF_MEDIA_Likelihood = $('#IIARCF_MEDIA_Likelihood').val();
    //         IIARCF_MEDIA_Likelihood = (IIARCF_MEDIA_Likelihood == '' || IIARCF_MEDIA_Likelihood == null) ? "N/A" : IIARCF_MEDIA_Likelihood;
    //         console.log('IIARCF_MEDIA_Likelihood', IIARCF_MEDIA_Likelihood);

    //         var IIARCF_MEDIA_Result = $('#IIARCF_MEDIA_Result').val();
    //         IIARCF_MEDIA_Result = (IIARCF_MEDIA_Result == '' || IIARCF_MEDIA_Result == null) ? "N/A" : IIARCF_MEDIA_Result;
    //         console.log('IIARCF_MEDIA_Result', IIARCF_MEDIA_Result);

    //         var IIARCF_MEDIA_describtion = $('#IIARCF_MEDIA_describtion').val();
    //         IIARCF_MEDIA_describtion = (IIARCF_MEDIA_describtion == '' || IIARCF_MEDIA_describtion == null) ? "N/A" : IIARCF_MEDIA_describtion;
    //         console.log('IIARCF_MEDIA_describtion', IIARCF_MEDIA_describtion);

    //         var IIARCF_MEDIA_AssociatedCost = $('#IIARCF_MEDIA_AssociatedCost').val();
    //         IIARCF_MEDIA_AssociatedCost = (IIARCF_MEDIA_AssociatedCost == '' || IIARCF_MEDIA_AssociatedCost == null) ? "N/A" : IIARCF_MEDIA_AssociatedCost;
    //         console.log('IIARCF_MEDIA_AssociatedCost', IIARCF_MEDIA_AssociatedCost);

    //         var selected_currency_media = $('#selected_currency_media').val();
    //         selected_currency_media = (selected_currency_media == '' || selected_currency_media == null) ? "N/A" : selected_currency_media;
    //         console.log('selected_currency_media', selected_currency_media);

    //         var IIARCF_MEDIA_localCurrency = $('#IIARCF_MEDIA_localCurrency').val();
    //         IIARCF_MEDIA_localCurrency = (IIARCF_MEDIA_localCurrency == '' || IIARCF_MEDIA_localCurrency == null) ? "N/A" : IIARCF_MEDIA_localCurrency;
    //         console.log('IIARCF_MEDIA_localCurrency', IIARCF_MEDIA_localCurrency);

    //         var IIARCF_MEDIA_type = $('#IIARCF_MEDIA_type').val();
    //         IIARCF_MEDIA_type = (IIARCF_MEDIA_type == '' || IIARCF_MEDIA_type == null) ? "N/A" : IIARCF_MEDIA_type;
    //         console.log('IIARCF_MEDIA_type', IIARCF_MEDIA_type);

    //         // save data for this step
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             type: 'POST',
    //             url: "/saveRootCauseFindings",
    //             dataType: 'json',
    //             data: {
    //                 'user_id': user_id,
    //                 'report_id': report_id,
    //                 'saved_status': saved_status,
    //                 'IIARCF_MEDIA_first_dropdown': IIARCF_MEDIA_first_dropdown,
    //                 'IIARCF_MEDIA_Severity': IIARCF_MEDIA_Severity,
    //                 'IIARCF_MEDIA_Likelihood': IIARCF_MEDIA_Likelihood,
    //                 'IIARCF_MEDIA_Result': IIARCF_MEDIA_Result,
    //                 'IIARCF_MEDIA_describtion': IIARCF_MEDIA_describtion,
    //                 'IIARCF_MEDIA_AssociatedCost': IIARCF_MEDIA_AssociatedCost,
    //                 'selected_currency_media': selected_currency_media,
    //                 'IIARCF_MEDIA_localCurrency': IIARCF_MEDIA_localCurrency,
    //                 'IIARCF_MEDIA_type': IIARCF_MEDIA_type,
    //                 'immediatecause': immediatecause,
    //                 'immediatecause_second': immediatecause_second,
    //                 'immediatecause_third': immediatecause_third,
    //                 'Risk_category_IIARCF': Risk_category_IIARCF
    //             },
    //             success: function(result) {
    //                 var data = result;
    //                 console.log('data::', data);

    //             }
    //         });
    //     }

    // });






    // step:- SEE 5 WHY
    // $('.five_why#nextBtn').on('click', function() {
    //     console.log('SEE 5 WHY');
    //     var incident_for_five_why = $('#incident_for_five_why').val();
    //     incident_for_five_why = (incident_for_five_why == '') ? "N/A" : incident_for_five_why;
    //     console.log('incident_for_five_why', incident_for_five_why);

    //     var first_why_for_five_why = $('#first_why_for_five_why').val();
    //     first_why_for_five_why = (first_why_for_five_why == '') ? "N/A" : first_why_for_five_why;
    //     console.log('first_why_for_five_why', first_why_for_five_why);

    //     var second_why_for_five_why = $('#second_why_for_five_why').val();
    //     second_why_for_five_why = (second_why_for_five_why == '') ? "N/A" : second_why_for_five_why;
    //     console.log('second_why_for_five_why', second_why_for_five_why);

    //     var third_why_for_five_why = $('#third_why_for_five_why').val();
    //     third_why_for_five_why = (third_why_for_five_why == '') ? "N/A" : third_why_for_five_why;
    //     console.log('third_why_for_five_why', third_why_for_five_why);

    //     var fourth_why_for_five_why = $('#fourth_why_for_five_why').val();
    //     fourth_why_for_five_why = (fourth_why_for_five_why == '') ? "N/A" : fourth_why_for_five_why;
    //     console.log('fourth_why_for_five_why', fourth_why_for_five_why);

    //     var fifth_why_for_five_why = $('#fifth_why_for_five_why').val();
    //     fifth_why_for_five_why = (fifth_why_for_five_why == '') ? "N/A" : fifth_why_for_five_why;
    //     console.log('fifth_why_for_five_why', fifth_why_for_five_why);

    //     var rootcause_for_five_why = $('#rootcause_for_five_why').val();
    //     rootcause_for_five_why = (rootcause_for_five_why == '') ? "N/A" : rootcause_for_five_why;
    //     console.log('rootcause_for_five_why', rootcause_for_five_why);

    //     var rootcauses = $('#rootcauses').val();
    //     rootcauses = (rootcauses.length == 0) ? "N/A" : rootcauses;
    //     console.log('rootcauses', rootcauses);

    //     var dd3 = $('#dd3').val();
    //     dd3 = (dd3.length == 0) ? "N/A" : dd3;
    //     console.log('dd3', dd3);

    //     var ddd3 = $('#ddd3').val();
    //     ddd3 = (ddd3.length == 0) ? "N/A" : ddd3;
    //     console.log('ddd3', ddd3);

    //     var preventiveactions = $('#preventiveactions').val();
    //     preventiveactions = (preventiveactions.length == 0) ? "N/A" : preventiveactions;
    //     console.log('preventiveactions', preventiveactions);

    //     var dd4 = $('#dd4').val();
    //     dd4 = (dd4.length == 0) ? "N/A" : dd4;
    //     console.log('dd4', dd4);

    //     var five_why_comments = $('#five_why_comments').val();
    //     five_why_comments = (five_why_comments == '' || five_why_comments == null) ? "N/A" : five_why_comments;
    //     console.log('five_why_comments', five_why_comments);

    //     var five_why_Risk_assesment_evaluated = $('#five_why_Risk_assesment_evaluated').val();
    //     five_why_Risk_assesment_evaluated = (five_why_Risk_assesment_evaluated == '' || five_why_Risk_assesment_evaluated == null) ? "N/A" : five_why_Risk_assesment_evaluated;
    //     console.log('five_why_Risk_assesment_evaluated', five_why_Risk_assesment_evaluated);

    //     // ADD MORE ACTIONS---DISPLAY
    //     var five_why_followup_action_describtion = $('textarea[name="five_why_followup_action_describtion[]"]').length;
    //     for (let i = 0; i < five_why_followup_action_describtion; i++) {
    //         var tmp = $(`#five_why_followup_action_describtion_${i+1}`).val();
    //         tmp = (tmp == '' || tmp == null) ? "N/A" : tmp;
    //         console.log('five_why_followup_action_describtion', tmp);
    //     }

    //     var five_why_followup_action_pic = $('input[name="five_why_followup_action_pic[]"]').length;
    //     for (let i = 0; i < five_why_followup_action_pic; i++) {
    //         var tmp = $(`#five_why_followup_action_pic_${i+1}`).val();
    //         tmp = (tmp == '' || tmp == null) ? "N/A" : tmp;
    //         console.log('five_why_followup_action_pic', tmp);
    //     }

    //     var five_why_followup_action_department = $('input[name="five_why_followup_action_department[]"]').length;
    //     for (let i = 0; i < five_why_followup_action_department; i++) {
    //         var tmp = $(`#five_why_followup_action_department_${i+1}`).val();
    //         tmp = (tmp == '' || tmp == null) ? "N/A" : tmp;
    //         console.log('five_why_followup_action_department', tmp);
    //     }
    //     var five_why_followup_action_target_date = $('input[name="five_why_followup_action_target_date[]"]').length;
    //     for (let i = 0; i < five_why_followup_action_target_date; i++) {
    //         var tmp = $(`#five_why_followup_action_target_date_${i+1}`).val();
    //         tmp = (tmp == '' || tmp == null) ? "N/A" : tmp;
    //         console.log('five_why_followup_action_target_date', tmp);
    //     }

    //     var five_why_followup_action_completed_date = $('input[name="five_why_followup_action_completed_date[]"]').length;
    //     for (let i = 0; i < five_why_followup_action_completed_date; i++) {
    //         var tmp = $(`#five_why_followup_action_completed_date_${i+1}`).val();
    //         tmp = (tmp == '' || tmp == null) ? "N/A" : tmp;
    //         console.log('five_why_followup_action_completed_date', tmp);
    //     }

    //     var five_why_followup_action_evidence_uploaded = $('select[name="five_why_followup_action_evidence_uploaded[]"]').length;
    //     for (let i = 0; i < five_why_followup_action_evidence_uploaded; i++) {
    //         var tmp = $(`#five_why_followup_action_evidence_uploaded_${i+1}`).val();
    //         tmp = (tmp == '' || tmp == null) ? "N/A" : tmp;
    //         console.log('five_why_followup_action_evidence_uploaded', tmp);
    //     }

    //     var evidence_file = $('input[name="evidence_file[]"]').length;
    //     for (let i = 0; i < evidence_file; i++) {
    //         var tmp = $(`#evdnc_file_${i+1}`).val();
    //         tmp = (tmp == '' || tmp == null) ? "N/A" : tmp;
    //         console.log('evidence_file', tmp);
    //     }
    //     var five_why_followup_action_cost = $('input[name="five_why_followup_action_cost[]"]').length;
    //     for (let i = 0; i < five_why_followup_action_cost; i++) {
    //         var tmp = $(`#five_why_followup_action_cost_${i+1}`).val();
    //         tmp = (tmp == '' || tmp == null) ? "N/A" : tmp;
    //         console.log('five_why_followup_action_cost', tmp);
    //     }

    //     var five_why_followup_action_comments = $('input[name="five_why_followup_action_comments[]"]').length;
    //     for (let i = 0; i < five_why_followup_action_comments; i++) {
    //         var tmp = $(`#five_why_followup_action_comments_${i+1}`).val();
    //         tmp = (tmp == '' || tmp == null) ? "N/A" : tmp;
    //         console.log('five_why_followup_action_comments', tmp);
    //     }
    // })

});
