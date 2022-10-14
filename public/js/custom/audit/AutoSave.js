$(() => {

    // VARIABLE NITIALIZER
    var count = 0;

    // AUTO-SAVER
    var AutoSaver = {
        StepOneDataSave: () => {
            let FirstStepData = new FormData();
            FirstStepData.append('ID', master_id)
            FirstStepData.append('email', session_email)
            FirstStepData.append('Step', 1)
            FirstStepData.append('Vessel', $("#Vessel_Name_id").val())
            FirstStepData.append('NC_Report', $(`div.tab:nth-child(5) > div:nth-child(3) > div:nth-child(2) > input:nth-child(2)`).val())
            FirstStepData.append('Location', $(`#audit_location`).val())
            FirstStepData.append('Type_of_Audit', $(`#type_of_audit`).val())
            FirstStepData.append('Date', $(`#audit_date`).val())
            FirstStepData.append('Name_of_the_Auditor', $('#nc_auditor').val())
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/api/auto-save-audit",
                method: "POST",
                contentType: false,
                processData: false,
                data: FirstStepData,
                dataType: 'JSON',
            });
        },
        GetInputArrayValues: (obj) => {
            let vals = {};
            for (var i = 0; i < obj.length; i++) {
                vals[i] = obj[i].value
            }
            return vals;
        }
    }

    // JQUERY => SAVING FIRST STEP NEXT BUTTON ON CLICK
    $(".investigation_tab").click(() => {
        AutoSaver.StepOneDataSave();
        console.log('---Step 1 data was auto saved ---');
    });




    // JQUERY => Non-Confirmity FORM AUTO-SAVE
    $('#increaserow-nc').click(function () {

        var formData_nc = new FormData();
        // main form data ......
        formData_nc.append('Step', 2);
        formData_nc.append('edit', $('#editID_NC').val());
        formData_nc.append('master_frm_id', $(`div.tab:nth-child(5) > div:nth-child(3) > div:nth-child(2) > input:nth-child(2)`).val())
        formData_nc.append('Type', 'Non Confirmity');
        formData_nc.append('master_id', master_id);
        formData_nc.append('major_nc', $('#major_nc_1').is(':checked'));
        formData_nc.append('nc', $('#type_of_nc_2').is(':checked'));
        formData_nc.append('description', $('#nc_description').val());
        formData_nc.append('ism', $('#nc_ism_clause').val());
        formData_nc.append('due_date', $('#audit_non_confirmity').val());
        formData_nc.append('sign_master_text', $('#nc_signed_by_master_text').val());
        formData_nc.append('sign_master', $('#nc_signed_by_master')[0].files[0]);
        formData_nc.append('sign_auditor_text', $('#nc_signed_by_auditor_text').val());
        formData_nc.append('sign_auditor', $('#nc_signed_by_auditor')[0].files[0]);

        formData_nc.append('root_cause', `${$("#rootcauses").val()}|${$("#dd3").val()}|${$("#ddd3").val()}`);

        formData_nc.append('corrective_action', JSON.stringify(AutoSaver.GetInputArrayValues(document.getElementsByName('nc_corrective_action[]'))));
        formData_nc.append('c_complete_date', $('#nc_corrective_action_complete_date').val());
        for (let i = 0; i < $('#nc_corrective_action_evidence')[0].files.length; i++) {
            formData_nc.append('c_upload_evidence[]', $('#nc_corrective_action_evidence')[0].files[i]);
        }
        formData_nc.append('preventive_action', `${$("#preventiveactions").val()}|${$("#dd4").val()}`);
        formData_nc.append('p_complete_date', $('#nc_preventive_action_complete_date').val());
        for (let i = 0; i < $('#nc_preventive_action_evidence')[0].files.length; i++) {
            formData_nc.append('p_upload_evidence[]', $('#nc_preventive_action_evidence')[0].files[i]);
        }
        formData_nc.append('signed', $('#nc_preventive_action_complete_signed').val());
        formData_nc.append('upload_sign', $("#nc_preventive_action_sign_imagebox")[0].files[0]);
        formData_nc.append('accepted', $('#nc_preventive_action_complete_accepted').val());
        formData_nc.append('upload_accepted', $("#nc_preventive_action_accepted_imagebox")[0].files[0]);
        formData_nc.append('comments', $('#nc_comments').val());
        formData_nc.append('comfirm_by_dpa', $('#confirmed_by_dpa').val());
        formData_nc.append('date', $('#nc_confirm_date').val());
        formData_nc.append('verification_required', $('#nc_verification').val());

        // value for other blank .....
        formData_nc.append('psc_upload', 'N/A');
        formData_nc.append('ref', 'N/A');
        formData_nc.append('code', 'N/A');
        formData_nc.append('count', ++count);


        // API CALL FOR SAVING NON-CONFIRMITY FORM
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/api/auto-save-audit",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData_nc,
            dataType: 'JSON',
            success: (result) => {
                // Prefiller.PrefillSecondStep(result)
                PrefillFRM();
                toastr.success('Non Confirmity Submitted Successfully !!');
            }
        });
    });


    //  JQUERY => Observation FORM AUTO-SAVE
    $('#obs-increaserow').click(function () {

        var formData_obs = new FormData();
        formData_obs.append('Step', 2)
        formData_obs.append('edit', $('#editID_OBS').val());
        formData_obs.append('master_frm_id', $(`div.tab:nth-child(5) > div:nth-child(3) > div:nth-child(2) > input:nth-child(2)`).val())
        formData_obs.append('Type', 'Observation')
        formData_obs.append('master_id', master_id);
        formData_obs.append('major_nc', false);
        formData_obs.append('nc', false);
        formData_obs.append('description', $('#obs_description').val());
        formData_obs.append('ism', $('#obs_ism_clause').val());
        formData_obs.append('due_date', $('#observation_date').val());
        formData_obs.append('sign_master_text', $('#obs_signed_by_master_text').val());
        formData_obs.append('sign_master', $('#obs_signed_by_master')[0].files[0]);
        formData_obs.append('sign_auditor_text', $('#obs_signed_by_auditor_text').val());
        formData_obs.append('sign_auditor', $('#obs_signed_by_auditor')[0].files[0]);
        formData_obs.append('root_cause', `${$("#obs_rootcauses").val()}|${$("#obs_dd3").val()}|${$("#d_obs_dd3").val()}`);
        formData_obs.append('corrective_action', JSON.stringify(AutoSaver.GetInputArrayValues(document.getElementsByName('nc_corrective_action[]'))));

        formData_obs.append('c_complete_date', $('#obs_corrective_action_complete_date').val());
        for (let i = 0; i < $('#obs_corrective_action_evidence')[0].files.length; i++) {
            formData_obs.append('c_upload_evidence[]', $('#obs_corrective_action_evidence')[0].files[i]);
        }
        formData_obs.append('preventive_action', `${$("#obs_preventiveactions").val()}|${$("#obs_dd4").val()}`);
        formData_obs.append('p_complete_date', $('#obs_preventive_action_complete_date').val());
        for (let i = 0; i < $('#obs_preventive_action_evidence')[0].files.length; i++) {
            formData_obs.append('p_upload_evidence[]', $('#obs_preventive_action_evidence')[0].files[i]);
        }
        formData_obs.append('signed', $('#obs_preventive_action_complete_signed').val());
        formData_obs.append('upload_sign', $("#obs_preventive_action_sign_imagebox")[0].files[0]);
        formData_obs.append('accepted', $('#obs_preventive_action_complete_accepted').val());
        formData_obs.append('upload_accepted', $("#obs_preventive_action_accepted_imagebox")[0].files[0]);
        formData_obs.append('comments', $('#obs_comments').val());
        formData_obs.append('comfirm_by_dpa', $('#confirmed_by_dpa_obs').val());
        formData_obs.append('date', $('#obs_confirm_date').val());
        formData_obs.append('verification_required', $('#verification_obs').val());

        formData_obs.append('psc_upload', 'N/A');
        formData_obs.append('ref', 'N/A');
        formData_obs.append('code', 'N/A');
        formData_obs.append('count', ++count);


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/api/auto-save-audit",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData_obs,
            dataType: 'JSON',
            success: (result) => {
                // Prefiller.PrefillSecondStep(result)
                PrefillFRM();
                toastr.success('Observation Submitted Successfully !!');
            }
        });
    });



    // JQUERY => PSC FORM AUTO-SAVE
    $('#psc-increaserow').click(function () {

        console.log(master_id)
        var formData_psc = new FormData();
        formData_psc.append('Step', 2)
        formData_psc.append('edit', $('#editID_PSC').val());
        formData_psc.append('Type', 'PSC')
        formData_psc.append('master_frm_id', $(`div.tab:nth-child(5) > div:nth-child(3) > div:nth-child(2) > input:nth-child(2)`).val())
        formData_psc.append('master_id', master_id);
        formData_psc.append('major_nc', false);
        formData_psc.append('nc', false);
        formData_psc.append('description', $('#description_psc').val());
        for (let i = 0; i < $('#upload_document_psc')[0].files.length; i++) {
            formData_psc.append('upload_document[]', $('#upload_document_psc')[0].files[i]);
        }
        formData_psc.append('ref', $('#Ref_psc').val());
        formData_psc.append('code', $('#code_psc').val());
        formData_psc.append('root_cause', `${$("#psc_rootcauses").val()}|${$("#psc_dd3").val()}|${$("#d_psc_dd3").val()}`);
        formData_psc.append('corrective_action', JSON.stringify(AutoSaver.GetInputArrayValues(document.getElementsByName('nc_corrective_action[]'))));
        formData_psc.append('c_complete_date', $('#corrective_action_complete_date_psc').val(), );
        for (let i = 0; i < $('#corrective_action_evidence_psc')[0].files.length; i++) {
            formData_psc.append('c_upload_evidence[]', $('#corrective_action_evidence_psc')[0].files[i]);
        }
        formData_psc.append('preventive_action', `${$("#psc_preventiveactions").val()}|${$("#psc_dd4").val()}|${$("#d_obs_dd3").val()}`);
        formData_psc.append('p_complete_date', $('#preventive_action_complete_date_psc').val());
        for (let i = 0; i < $('#preventive_action_evidence_psc')[0].files.length; i++) {
            formData_psc.append('p_upload_evidence[]', $('#preventive_action_evidence_psc')[0].files[i]);
        }

        formData_psc.append('ism', 'N/A');
        formData_psc.append('due_date', 'N/A');
        formData_psc.append('sign_master_text', 'N/A');
        formData_psc.append('sign_master', 'N/A');
        formData_psc.append('sign_auditor_text', 'N/A');
        formData_psc.append('sign_auditor', 'N/A');
        formData_psc.append('option', 'N/A');
        formData_psc.append('signed', 'N/A');
        formData_psc.append('upload_sign', 'N/A');
        formData_psc.append('accepted', 'N/A');
        formData_psc.append('upload_accepted', 'N/A');
        formData_psc.append('comments', 'N/A');
        formData_psc.append('comfirm_by_dpa', 'N/A');
        formData_psc.append('date', 'N/A');
        formData_psc.append('verification_required', 'N/A');
        formData_psc.append('psc_upload', 'N/A');
        formData_psc.append('count', ++count);



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/api/auto-save-audit",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData_psc,
            dataType: 'JSON',
            success: (result) => {
                // Prefiller.PrefillSecondStep(result)
                PrefillFRM();
                toastr.success('PSC Submitted Successfully !!');
            }
        });

    });





    // Function to pre-fill .....
    const PrefillFRM = ()=>{
        var frmPrefill = new FormData();
        frmPrefill.append('id', master_id)
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/api/prefill-audit-edit",
            method: "POST",
            contentType: false,
            processData: false,
            data: frmPrefill,
            success: (result) => {
                console.log("===> hi ",result);
                $("#noc-table-id").html("");
                $("#psc_table_id").html("");
                result.forEach(element => {
                    if (element.type_of_report != "PSC") {
                        console.log('Not PSC')
                        $("#noc-table-id").append(`
                                        <tr id="${element.id}">
                                            <td>${element.type_of_report}</td>
                                            <td>${element.type_of_nc}</td>
                                            <td>${element.type_of_nc}</td>
                                            <td>${element.description}</td>
                                            <td>${element.due_date}</td>
                                            <td>${` <button onclick="editForm('${element.id}','${element.type_of_report}')" class="btn btn-primary text-light mb-5">Edit</button> <br> <button onclick="DeleteForm('${element.id}')" class="btn btn-danger text-light">Delete</button>`}</td>
                                        </tr>
                        `);
                    } else {
                        console.log('PSC')
                        $("#psc_table_id").append(` <tr id="${element.id}">
                                                    <td>${element.type_of_report}</td>
                                                    <td>${element.description}</td>
                                                    <td>${element.psc_ref}</td>
                                                    <td>${element.psc_code}</td>
                                                    <td>${`<button onclick="editForm('${element.id}','${element.type_of_report}')" class="btn btn-primary text-light mb-5">Edit</button> <br> <button onclick="DeleteForm('${element.id}')" class="btn btn-danger text-light">Delete</button>`}</td>
                                                    </tr>
                        `);
                    }
                });
            }
        });
    }



})
