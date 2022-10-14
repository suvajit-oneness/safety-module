/* Global variables */
var corrective_increasetext_NC_num_count = 1;
var corrective_increasetext_OBSERVATION_num_count = 1;
var corrective_increasetext_PSC_num_count = 1;
var PSC = {};
var NC = {};
var OBS = {};
/* Global variables end */

$(document).ready(function () {
    // date picker initialize
    $("#datepicker-13").datepicker();
    $("#datepicker_12").datepicker();
    $("#datepicker-13").datepicker("show");
    $("#datepicker_12").datepicker("show");
    $("#audit_date").datepicker({ maxDate: new Date() });
    $("#audit_due_date").datepicker();
    $("#audit_non_confirmity").datepicker();
    $("#corrective_action_complete_date").datepicker();
    $("#preventive_action_complete_date").datepicker();
    $("#observation_date").datepicker();
    $("#nc_corrective_action_complete_date").datepicker();
    $("#nc_confirm_date").datepicker();
    $("#obs_corrective_action_complete_date").datepicker();
    $("#obs_preventive_action_complete_date").datepicker();
    $("#obs_preventive_action_complete_date").datepicker();
    $("#nc_preventive_action_complete_date").datepicker();
    $("#audit_date_completed").datepicker();
    $("#preventive_action_complete_date_psc").datepicker();
    $("#corrective_action_complete_date_psc").datepicker();
    $("#obs_confirm_date").datepicker();

    $("#audit_type_other").css({
        display: "none"
    });

    /* CALLING PREFILLER TO PREFILL FIRST STEP ..... */
    Prefiller.FetchFirstStep(master_id);

    /* CALLING PREFILLER TO PREFILL SECOND STEP ..... */
    Prefiller.FetchSecondStep(master_id);

    /*NC/OBSERVATION/PSC data table render logic*/
    if (!data) {
        // non-confermity table row add code
        $("#increaserow-nc").click(() => {
            $("#noc-table-id").append(`
                        <tr>
                            <td>${$("#increaserow-nc").val()}</td>
                            <td>${$("#type_of_nc_1").is(":checked")}</td>
                            <td>${$("#type_of_nc_2").is(":checked")}</td>
                            <td>${$("#nc_description").val()}</td>
                            <td>${$("#nc_ism_clause").val()}</td>
                            <td>${$("#audit_non_confirmity").val()}</td
                            <td>${$("#signed_by_master").val()}</td>
                            <td>${$("#signed_by_auditor").val()}</td>
                            <td>${$("#nc_root_cause").val()}</td>
                            <td>${$("#nc_corrective_action").val()}</td>
                            <td>${$(
                                "#nc_corrective_action_complete_date"
                            ).val()}</td>
                            <td>${$(
                                "#nc_corrective_action_evidence"
                            ).val()}</td>
                            <td>${$("#nc_preventive_action").val()}</td>
                            <td>${$(
                                "#nc_preventive_action_complete_date"
                            ).val()}</td>
                            <td>${$(
                                "#nc_preventive_action_evidence"
                            ).val()}</td>
                            <td>${$(
                                "#nc_preventive_action_complete_signed"
                            ).val()}</td>
                            <td>${$(
                                "#nc_preventive_action_sign_imagebox"
                            ).val()}</td>
                            <td>${$(
                                "#nc_preventive_action_complete_accepted"
                            ).val()}</td>
                            <td>${$(
                                "#nc_preventive_action_accepted_imagebox"
                            ).val()}</td>
                            <td>${$("#nc_comments").val()}</td>
                            <td>${$("#confirmed_by_dpa").val()}</td>
                            <td>${$("#nc_confirm_date").val()}</td>
                            <td>${$("#nc_verification").is(":checked")}</td>
                        </tr>
                `);
        });
        // observation table row add code
        $("#obs-increaserow").click(function () {
            $("#noc-table-id").append(`
                                            <tr>
                                                        <td>${$(
                                                            "#obs-increaserow"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_auditor"
                                                        ).val()}</td>
                                                        <td>---</td>

                                                        <td>${$(
                                                            "#obs_description"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_ism_clause"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#observation_date"
                                                        ).val()}</td
                                                        <td>${$(
                                                            "#obs_signed_by_master"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_signed_by_auditor"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#nc_root_cause_obs"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#nc_corrective_action_obs"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_corrective_action_complete_date"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_corrective_action_evidence"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_preventive_action"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_preventive_action_complete_date"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_preventive_action_evidence"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_preventive_action_complete_signed"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_preventive_action_sign_imagebox"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_preventive_action_complete_accepted"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_preventive_action_sign_imagebox"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_comments"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#confirmed_by_dpa_obs"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#obs_confirm_date"
                                                        ).val()}</td>
                                                        <td>${$(
                                                            "#verification_obs"
                                                        ).is(":checked")}</td>

                                            </tr>
                                            `);
        });

        // PSC table row add code
        $("#psc-increaserow").click(() => {
            let upload_document_psc = $("#upload_document_psc")[0].files;

            $("#psc_table_id").append(` <tr>
                                                <td>${$(
                                                    "#psc-increaserow"
                                                ).val()}</td>
                                                <td>${$(
                                                    "#description_psc"
                                                ).val()}</td>
                                                <td>${$(
                                                    "#description_psc"
                                                ).val()}</td>
                                                <td>${$(
                                                    "#upload_document_psc"
                                                ).val()}</td>
                                                <td>${$("#Ref_psc").val()}</td>
                                                <td>${$("#code_psc").val()}</td>
                                                <td>${$(
                                                    "#root_cause_psc"
                                                ).val()}</td>
                                                <td>${$(
                                                    "#corrective_action_psc"
                                                ).val()}</td>
                                                <td>${$(
                                                    "#corrective_action_complete_date_psc"
                                                ).val()}</td>
                                                <td>${$(
                                                    "#corrective_action_evidence_psc"
                                                ).val()}</td>
                                                <td>${$(
                                                    "#preventive_action_psc"
                                                ).val()}</td>
                                                <td>${$(
                                                    "#preventive_action_complete_date_psc"
                                                ).val()}</td>
                                                <td>${$(
                                                    "#preventive_action_evidence_psc"
                                                ).val()}</td>
                                        </tr> `);
            //   ImgSave()
        });
    } else {
        // non-confermity table row add code
        $("#increaserow-nc").click(() => {});

        // observation table row add code
        $("#obs-increaserow").click(function () {});

        // PSC table row add code
        $("#psc-increaserow").click(() => {});
    }
});


/* Prefiller Oject use to Pre-fill Form */
const Prefiller = {

    /* First Step Fetch and Pre-fill ..... */
    FetchFirstStep: (id) => {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/prefill-audit",
            method: "POST",
            async: false,
            data: {
                step: 1,
                id: id
            },
            success: (result) => {
                Prefiller.PrefillFirstStep(result);
            },
        });
    },
    _PrefillFirstStep: (data) => {
        console.log("Prefill first step !")
        $("#audit_location").val(data.location);
        Prefiller.setSelectedValue(
            document.getElementById("type_of_audit"),
            data.type_of_audit
        );
        $("#audit_date").val(data.report_date);
        $("#nc_auditor").val(data.name_of_auditorr);

        /* RENDER FORM ACORDING TO DB FORM TYPE */
        console.log(data.type_of_audit)
        if (data.type_of_audit === "PSC") {
            $("#psc_id").show();
            $("#non_confirmity_id").hide();
            $("#observation_id").hide();
            // hiding data tables .....
            $("#NO_OBS_tab").hide();
            $("#PSC_tab").show();
        } else {
            $("#psc_id").hide();
            $("#non_confirmity_id").show();
            $("#observation_id").show();
            // hiding data tables .....
            $("#NO_OBS_tab").show();
            $("#PSC_tab").hide();
        }
    },
    get PrefillFirstStep() {
        return this._PrefillFirstStep;
    },
    set PrefillFirstStep(value) {
        this._PrefillFirstStep = value;
    },

    /* Second Step Fetch and Pre-fill ..... */
    FetchSecondStep: (id) => {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/prefill-audit",
            method: "POST",
            async: false,
            data: {
                step: 2,
                id: id
            },
        });
    },
    PrefillSecondStep: (data) => {
        if (data[0].type_of_report != "PSC") {
            $("#psc_id").hide();
            $("#non_confirmity_id").show();
            $("#observation_id").show();
            // hiding data tables .....
            $("#NO_OBS_tab").show();
            $("#PSC_tab").hide();
            if(document.getElementById(`${data[0].id}`)){document.getElementById(`${data[0].id}`).remove();}

            $("#noc-table-id").append(`
                            <tr id="${data[0].id}">
                                <td>${data[0].type_of_report}</td>
                                <td>${(data[0].type_of_nc == 'Major N/C')?data[0].type_of_nc:'N/A'}</td>
                                <td>${(data[0].type_of_nc == 'N/C')?data[0].type_of_nc:'N/A'}</td>
                                <td>${data[0].description}</td>
                                <td>${data[0].due_date}</td>
                                <td>${` <button onclick="editForm('${data[0].id}','${data[0].type_of_report}')" class="btn btn-primary text-light mb-5">Edit</button> <br> <button onclick="DeleteForm('${data[0].id}')" class="btn btn-danger text-light">Delete</button>`}</td>
                            </tr>
                `);
        } else {

            $("#psc_id").show();
            $("#non_confirmity_id").hide();
            $("#observation_id").hide();
            // hiding data tables .....
            $("#NO_OBS_tab").hide();
            $("#PSC_tab").show();
            if(document.getElementById(`${data[0].id}`)){document.getElementById(`${data[0].id}`).remove();};
            $("#psc_table_id").append(` <tr id="${data[0].id}">
                                        <td>${data[0].type_of_report}</td>
                                        <td>${data[0].description}</td>
                                        <td>${data[0].psc_ref}</td>
                                        <td>${data[0].psc_code}</td>
                                        <td>${`<button onclick="editForm('${data[0].id}','${data[0].type_of_report}')" class="btn btn-primary text-light mb-5">Edit</button> <br> <button onclick="DeleteForm('${data[0].id}')" class="btn btn-danger text-light">Delete</button>`}</td>
                                </tr> `);
        }
    },

    /* Select/Prefill option in dropdown ..... */
    setSelectedValue: (selectObj, valueToSet) => {
        for (var i = 0; i < selectObj.options.length; i++) {
            if (selectObj.options[i].text == valueToSet) {
                selectObj.options[i].selected = true;
                return;
            }
        }
    },


    /* Images & Multiselect interdependant dropdown prefilling and fetching ..... */
    Fetch_rootcauses: (id) => {

        var render_element = $('.root_causes_prefill');
        var root_causes;
        // FETCHING ROOT CAUSES
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/fetch-root_causes",
            method: "POST",
            async: false,
            data: {
                id: id
            },
            success: (result) => {
                render_element.empty();
                let contect_first = `<h5>Root Causes First</h5>`
                result.first.forEach((element,key) => {
                     contect_first += `<div> ${key + 1} . ${element.description} </div>`;
                });

                    render_element.append(contect_first);

                let content_second = `<h5>Root Causes Second</h5>`
                result.second.forEach((element,key) => {
                        content_second += `<div> ${key + 1} . ${element.description} </div>`;
                });
                render_element.append(content_second);

                let content_third = `<h5>Root Causes Third</h5>`
                result.third.forEach((element,key) => {
                        content_third += `<div> ${key + 1} . ${element.description} </div>`;
                });
                render_element.append(content_third);

            }
        });
        return root_causes;
    },
    Fetch_correctiveActions: (id) => {
        var corrective_action;
        var render_element = $('.corrective_actions_prefill');
        render_element.empty();
        // FETCHING ROOT CAUSES
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/fetch-corrective_actions",
            method: "POST",
            async: false,
            data: {
                id: id
            },
            success: (result) => {
                let contect_first = `<h5>Corrective Actions</h5>`
                result.forEach((element,key) => {
                     contect_first += `<div> ${key + 1} . ${(element.description == '')?'N/A': element.description} </div>`;

                    if($('#nc_corrective_action_complete_date').val().length !== 0 || $('#nc_corrective_action_complete_date').val() !== null || $('#nc_corrective_action_complete_date').val() !== 'null' )
                    {
                        $('#nc_corrective_action_complete_date').val(element.date_completed)
                    }
                    if($('#obs_corrective_action_complete_date').val().length !== 0 || $('#obs_corrective_action_complete_date').val() !== null || $('#obs_corrective_action_complete_date').val() !== 'null')
                    {
                        $('#obs_corrective_action_complete_date').val(element.date_completed)
                    }
                    if($('#corrective_action_complete_date_psc').val().length !== 0 || $('#corrective_action_complete_date_psc').val() !== null || $('#corrective_action_complete_date_psc').val() !== 'null')
                    {
                        $('#corrective_action_complete_date_psc').val(element.date_completed)
                    }
                });
                render_element.append(contect_first);
            }
        });
        return corrective_action;
    },
    Fetch_preventiveActions: (id) => {
        var render_element = $('.preventive_actions_prefill');
        render_element.empty();
        var preventive_actions;
        // FETCHING ROOT CAUSES
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/fetch-preventive_actions",
            method: "POST",
            async: false,
            data: {
                id: id
            },
            success: (result) => {
                let contect_first = `<h5>Preventive Action First</h5>`
                result.first.forEach((element,key) => {
                     contect_first += `<div> ${key + 1} . ${element.description} </div>`;
                     if($('#nc_preventive_action_complete_date').val().length != 0 || $('#nc_preventive_action_complete_date').val() != null || $('#nc_preventive_action_complete_date').val() != 'null'){$('#nc_preventive_action_complete_date').val(element.date_completed)}
                     if($('#obs_preventive_action_complete_date').val().length != 0 || $('#obs_preventive_action_complete_date').val() != null || $('#obs_preventive_action_complete_date').val() != 'null'){$('#obs_preventive_action_complete_date').val(element.date_completed)}
                     if($('#preventive_action_complete_date_psc').val().length != 0 || $('#preventive_action_complete_date_psc').val() != null || $('#preventive_action_complete_date_psc').val() != 'null'){$('#preventive_action_complete_date_psc').val(element.date_completed)}
                });
                render_element.append(contect_first);

                let content_second = `<h5>Preventive Action Second</h5>`
                result.second.forEach((element,key) => {
                        content_second += `<div> ${key + 1} . ${element.description} </div>`;
                });
                render_element.append(content_second);


            }
        });
        return preventive_actions;
    },
    Fetch_correctiveActionsFiles: (id) => {
        var corrective_action_files;
        var render_element = $('.corrective_action_img');
        render_element.empty();
        // FETCHING ROOT CAUSES
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/fetch-corrective_actions_evidence",
            method: "POST",
            async: false,
            data: {
                id: id
            },
            success: (result) =>{
                let corrective_action_img = `<div class='row'>`;
                result.forEach((element,key) => {
                    corrective_action_img += `<div class='col-4'> <img class='img-fluid my-4' src='/getFile?path=${element.url}' height='100' width='100' /> </div>`;
                });
                corrective_action_img += `</div>`;
                render_element.append(corrective_action_img);
            },
        });
        return corrective_action_files;
    },
    Fetch_preventiveActionsFiles: (id) => {

        var render_element = $('.preventive_evidence');
        render_element.empty();
        var preventive_action_files;
        // FETCHING ROOT CAUSES
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/fetch-preventive_actions_evidence",
            method: "POST",
            async: false,
            data: {
                id: id
            },
            success: (result) => {
                let preventive_img = `<div class='row'>`;
                result.forEach((element,key) => {
                    if(element.url !== null){
                        preventive_img += `<div class='col-4'> <img class='img-fluid my-4' src='/getFile?path=${element.url}' height='100' width='100' /> </div>`;
                    }
                    });
                preventive_img += `</div>`;
                render_element.append(preventive_img);
            }
        });
        return preventive_action_files;
    },
    Fetch_Files: (id) => {
        var render_element = $('#upload_document_psc_show');
        render_element.empty();
        var upload_evidence_return;
        // FETCHING ROOT CAUSES
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/fetch-send_evidence_psc",
            method: "POST",
            async: false,
            data: {
                id: id
            },
            success: (result) => {
                let psc_EVIDENCE = `<div class='row'>`;
                result.forEach((element,key) => {
                    psc_EVIDENCE += `<div class='col-4'> <img class='img-fluid my-4' src='/getFile?path=${element.url}' height='100' width='100' /> </div>`;
                });

                psc_EVIDENCE += `</div>`;

                render_element.append(psc_EVIDENCE);
            }
        });
        return upload_evidence_return;
    }
};

// HELPER FUNCTIONS 🤝🏻


/*
    Call When someone Open a Sub-form for Edit it takes
    id and type of that form and
    peroform Editing .....
*/
function editForm(id, type) {


    // Run if form is Non-Confirmity ...
    if (type == 'Non Confirmity') {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/GetFormDataByID",
            method: "POST",
            async: false,
            data: {
                id: id
            },
            success: (result) => {
                $("#nomConfirmityModal").modal("show");

                $('#editID_NC').val(id);
                $("#major_nc_1").val(`${result.frm_data.signed_by_auditor_name}`)
                if(result.frm_data.type_of_nc == 'Major N/C'){ document.getElementById('major_nc_1').checked = true; }
                if(result.frm_data.type_of_nc == 'N/C'){ document.getElementById('type_of_nc_2').checked = true; }
                $("#nc_signed_by_auditor_text").val(`${result.frm_data.signed_by_auditor_name}`)
                $('#nc_description').val(`${result.frm_data.description}`)
                $('#nc_ism_clause').val(`${result.frm_data.ism_clause}`)
                $('#audit_non_confirmity').val(`${result.frm_data.due_date}`)
                $('#nc_signed_by_master_text').val(`${result.frm_data.signed_by_auditee_name}`)
                $('#nc_signed_by_auditor_text').val(`${result.frm_data.signed_by_auditor_name}`)
                $('#nc_preventive_action_complete_signed').val(`${result.frm_data.signed_by_master_name}`)
                $('#nc_preventive_action_complete_accepted').val(`${result.frm_data.accepted_by_name}`)
                $('#nc_comments').val(`${result.frm_data.follow_up_comments}`)
                $('#confirmed_by_dpa').val(`${result.frm_data.is_confirmed_by_dpa}`)
                $('#nc_confirm_date').val(`${result.frm_data.form_date}`)
                $("#nc_signed_by_master").val(null);
                $("#nc_signed_by_auditor").val(null);
                $("#nc_corrective_action_evidence").val(null);
                $("#nc_preventive_action_evidence").val(null);
                $("#nc_preventive_action_sign_imagebox").val(null);
                $("#nc_preventive_action_accepted_imagebox").val(null);

                if(result.frm_data.is_verification_required === 'true'){
                    document.getElementById('nc_verification_checkbox').checked = true;
                    $("#nc_verification").val(result.frm_data.is_verification_required);
                    console.log("nc true",result.frm_data.is_verification_required)
                }else{
                    document.getElementById('nc_verification_checkbox').checked = false;
                    $("#nc_verification").val(result.frm_data.is_verification_required);
                    console.log("nc false",result.frm_data.is_verification_required)
                }


                /* prefill single images */
                if(result.frm_data.signed_by_auditee_url_name !== null){
                    $("#nc_signed_by_master_prefill").html( `<img class='ml-4 text-center my-3' src='/getFile?path=${result.frm_data.signed_by_auditee_url_name}' height='100' width='100'/>` );
                }
                if(result.frm_data.signed_by_auditor_url !== null){
                    $("#nc_signed_by_auditor_prefill").html(`<img class='ml-4 text-center my-3' src='/getFile?path=${result.frm_data.signed_by_auditor_url}' height='100' width='100'/>`);
                }
                if(result.frm_data.signed_by_master_url !== null){
                    $("#nc_preventive_action_sign_imagebox_prefill").html(`<img class='ml-4 text-center my-3' src='/getFile?path=${result.frm_data.signed_by_master_url}' height='100' width='100'/>`);
                }
                if(result.frm_data.accepted_by_url !== null){
                    $("#nc_preventive_action_accepted_imagebox_prefill").html(`<img class='ml-4 text-center my-3' src='/getFile?path=${result.frm_data.accepted_by_url}' height='100' width='100'/>`);
                }

                // refresh and fill blank the preventive action dropdown of PSC
                $('#preventiveactions').val('');
                $("#preventiveactions").multiselect('refresh');
                $('#preventiveactions').change();


                // refresh and fill blank the Root Causes dropdown of PSC
                $('#rootcauses').val('');
                $("#rootcauses").multiselect('refresh');
                $('#rootcauses').change();
            },
        });
    }
    // Run if form  is Observation ...
    if (type == 'Observation') {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/GetFormDataByID",
            method: "POST",
            async: false,
            data: {
                id: id
            },
            success: (result) => {
                $("#observationModal").modal("show");

                $('#editID_OBS').val(id);
                $('#obs_description').val(`${result.frm_data.description}`)
                $("#obs_signed_by_auditor_text").val(`${result.frm_data.signed_by_auditor_name}`)
                $('#obs_ism_clause').val(`${result.frm_data.ism_clause}`)
                $(`#observation_date`).val(`${result.frm_data.due_date}`)
                $('#obs_signed_by_master_text').val(`${result.frm_data.signed_by_auditee_name}`)
                $('#obs_signed_by_auditor_text').val(`${result.frm_data.signed_by_auditor_name}`)
                $('#obs_preventive_action_complete_signed').val(`${result.frm_data.signed_by_master_name}`)
                $('#obs_preventive_action_complete_accepted').val(`${result.frm_data.accepted_by_name}`)
                $('#obs_comments').val(`${result.frm_data.follow_up_comments}`)
                $('#confirmed_by_dpa').val(`${result.frm_data.is_confirmed_by_dpa}`)
                $('#obs_confirm_date').val(`${result.frm_data.form_date}`)

                $("#obs_signed_by_master").val(null);
                $("#obs_signed_by_auditor").val(null);
                $("#obs_corrective_action_evidence").val(null);
                $("#obs_preventive_action_evidence").val(null);
                $("#obs_preventive_action_sign_imagebox").val(null);
                $("#obs_preventive_action_accepted_imagebox").val(null);


                if(result.frm_data.is_verification_required === 'true' ){
                    document.getElementById('verification_obs_checkbox').checked = true;
                    $("#verification_obs").val(result.frm_data.is_verification_required);
                }else{
                    document.getElementById('verification_obs_checkbox').checked = false;
                    $("#verification_obs").val(result.frm_data.is_verification_required);
                }


                 /* prefill images */
                 if(result.frm_data.signed_by_auditee_url_name !== null){
                     $("#obs_signed_by_master_prefill").html(`<img class='ml-4 text-center my-3' src='/getFile?path=${result.frm_data.signed_by_auditee_url_name}' height='100' width='100'/>`  );
                 }
                 if(result.frm_data.signed_by_auditor_url !== null){
                    $("#obs_signed_by_auditor_prefill").html(`<img class='ml-4 text-center my-3' src='/getFile?path=${result.frm_data.signed_by_auditor_url}' height='100' width='100'/>` );
                }
                if(result.frm_data.signed_by_master_url !== null){
                    $("#obs_preventive_action_sign_imagebox_prefill").html(`<img class='ml-4 text-center my-3' src='/getFile?path=${result.frm_data.signed_by_master_url}' height='100' width='100'/>` );
                }
                if(result.frm_data.accepted_by_url !== null){
                    $("#obs_preventive_action_accepted_imagebox_prefill").html(`<img class='ml-4 text-center my-3' src='/getFile?path=${result.frm_data.accepted_by_url}' height='100' width='100'/>` );
                }

                // refresh and fill blank the preventive action dropdown of PSC
                $('#obs_preventiveactions').val('');
                $("#obs_preventiveactions").multiselect('refresh');
                $('#obs_preventiveactions').change();


                // refresh and fill blank the Root Causes dropdown of PSC
                $('#obs_rootcauses').val('');
                $("#obs_rootcauses").multiselect('refresh');
                $('#obs_rootcauses').change();


            },
        });
    }
    // Run if form is PSC ...
    if (type == 'PSC') {

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/GetFormDataByID",
            method: "POST",
            async: false,
            data: {
                id: id
            },
            success: (result) => {
                $("#pscModal").modal("show");

                $('#editID_PSC').val(id);
                $('#description_psc').val(`${result.frm_data.description}`)
                $("#Ref_psc").val(`${result.frm_data.psc_ref}`)
                $("#code_psc").val(`${result.frm_data.psc_code}`)

                // refresh and fill blank the preventive action dropdown of PSC
                $('#psc_preventiveactions').val('');
                $("#psc_preventiveactions").multiselect('refresh');
                $('#psc_preventiveactions').change();


                // refresh and fill blank the Root Causes dropdown of PSC
                $('#psc_rootcauses').val('');
                $("#psc_rootcauses").multiselect('refresh');
                $('#psc_rootcauses').change();


                // File feilds Empty .....
                document.getElementById('upload_document_psc').value = null;
                document.getElementById('corrective_action_evidence_psc').value = null;
                document.getElementById('preventive_action_evidence_psc').value = null;

            },
        });

    }



    // Fetching All Sub-tables data of form by perticular form id ...
    Prefiller.Fetch_rootcauses(id);
    Prefiller.Fetch_preventiveActions(id);
    Prefiller.Fetch_correctiveActions(id);
    Prefiller.Fetch_preventiveActionsFiles(id);
    Prefiller.Fetch_correctiveActionsFiles(id);
    Prefiller.Fetch_Files(id);

    /* Set Blank Corrective Action Input of all forms when clicks Edit ... */
    $("#corrective_action_increase_PSC , #corrective_action_increase_OBSERVATION , #corrective_action_increase_NC").html(`
                        <label for="nc_corrective_action">Corrective Action/s</label>
                        <div class="input-group">
                            <textarea class="form-control mr-2 mb-2" id="nc_corrective_action_1"
                                name="nc_corrective_action[]" rows="2"></textarea>
                            <button type="button" class="btn btn-primary ml-1 mb-2"
                                id='corrective_increasetext_NC' onclick="addmoreCA()">Add</button>
                        </div>
    `)

}


/*
    Call When someone Click Delete button on sub-foem table it takes
    id and peroform Delete .....
*/
function DeleteForm(id) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/api/deleteFormData",
        method: "POST",
        async: false,
        data: {
            id: id
        },
        success: (result) => (toastr.success('Form Deleted Successfully !!')),
    });
    document.getElementById(id).remove();
}


// get values from input element array .....
const GetInputArrayValues = (obj) => {
    let vals = {};
    for (var i = 0; i < obj.length; i++) {
        vals[i] = obj[i].value
    }
    return vals;
}


$(() => {

    // Change Form status draft to submitted on submit
    $("div.tab:nth-child(8) > div:nth-child(1) > button:nth-child(2)").click(function () {
        // Ajax Call for change status in backend
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/ChangeStatus",
            method: "POST",
            async: false,
            data: {
                //id: $("div.tab:nth-child(5) > div:nth-child(3) > div:nth-child(2) > input:nth-child(2)").val()
                id : $('#form_id').val()
            },
            success: (result) => {
                console.log("=====> ", result)
                toastr.success('Form Submitted Successfully !!');
            },
        });


        window.location.href = "/inspection-audit";
    })

    // Set blank Value on New fillup For NON-Confirmity  .....
    $("#non_confirmity_id > button:nth-child(1)").click(()=>{
                $('#editID_NC').val(null);
                document.getElementById('major_nc_1').checked = false;
                document.getElementById('type_of_nc_2').checked = false;
                $("#nc_signed_by_auditor_text").val('')
                $("#nc_corrective_action_complete_date").val('')
                $("#nc_preventive_action_complete_date").val('')
                $('#nc_description').val('')
                $('#nc_ism_clause').val('')
                $('#audit_non_confirmity').val('')
                $('#nc_signed_by_master_text').val('')
                $('#nc_signed_by_master_text').val('')
                $('#nc_preventive_action_complete_signed').val('')
                $('#nc_preventive_action_complete_accepted').val('')
                $('#nc_comments').val('')
                $('#confirmed_by_dpa').val('')
                $('#nc_confirm_date').val('')
                $('.preventive_evidence').empty()
                $('.preventive_actions_prefill').empty();
                $('.root_causes_prefill').empty();
                $('.corrective_actions_prefill').empty();
                $('.corrective_action_img').empty();
                $("#nc_verification_checkbox").prop("checked", false);
                $("#nc_verification").val(false);

                /* files empty */
                $("#nc_signed_by_master").val('');
                $("#nc_signed_by_auditor").val('');
                $("#nc_corrective_action_evidence").val('');
                $("#nc_preventive_action_evidence").val('');
                $("#nc_preventive_action_sign_imagebox").val('');
                $("#nc_preventive_action_accepted_imagebox").val('');
                $( "#nc_signed_by_master_prefill" ).html('');
                $( "#nc_signed_by_auditor_prefill" ).html('');
                $( "#nc_preventive_action_sign_imagebox_prefill" ).html('');
                $( "#nc_preventive_action_accepted_imagebox_prefill" ).html('');

                /* date completed empty */
                $("#nc_corrective_action_complete_date").val();
                $("#audit_non_confirmity").val();
                $("#nc_preventive_action_complete_date").val();
                $("#nc_confirm_date").val();



                $("#rootcauses option:selected").prop("selected", false);
                $("#rootcauses").multiselect('refresh');
                $("#rootcauses").trigger("change");



                $("#preventiveactions option:selected").prop("selected", false);
                $("#preventiveactions").multiselect('refresh');
                $("#preventiveactions").trigger("change");
                $('#dd4 option:selected').prop("selected", false);
                $('#dd4').multiselect('refresh');
                $('#dd4').trigger("change");

                $("#corrective_action_increase_PSC , #corrective_action_increase_OBSERVATION , #corrective_action_increase_NC").html(`
                        <label for="nc_corrective_action">Corrective Action/s</label>
                        <div class="input-group">
                            <textarea class="form-control mr-2 mb-2" id="nc_corrective_action_1"
                                name="nc_corrective_action[]" rows="2"></textarea>
                            <button type="button" class="btn btn-primary ml-1 mb-2"
                                id='corrective_increasetext_NC' onclick="addmoreCA()">Add</button>
                        </div>
                `)




    })

    // Set blank Value on New fillup Observation ......
    $("#observation_id > button:nth-child(1)").click(()=>{
            $('#editID_OBS').val(null);
            $("#obs_signed_by_auditor_text").val('')
            document.getElementById('major_nc_1').checked = false;
            document.getElementById('type_of_nc_2').checked = false;
            $("#obs_corrective_action_complete_date").val('')
            $("#obs_preventive_action_complete_date").val('')
            $('#obs_description').val('')
            $('#obs_ism_clause').val('')
            $(`#observation_date`).val('')
            $('#audit_non_confirmity').val('')
            $('#obs_signed_by_master_text').val('')
            $('#obs_signed_by_master_text').val('')
            $('#obs_preventive_action_complete_signed').val('')
            $('#obs_preventive_action_complete_accepted').val('')
            $('#obs_comments').val('')
            $('#confirmed_by_dpa_obs').val('')
            $('#obs_confirm_date').val('')
            $('.preventive_evidence').empty()
            $('.preventive_actions_prefill').empty();
            $('.root_causes_prefill').empty();
            $('.corrective_actions_prefill').empty();
            $('.corrective_action_img').empty();
            $("#verification_obs_checkbox").prop("checked", false)
            $("#verification_obs").val(false);

            /* files empty */
            $("#obs_signed_by_master").val('');
            $("#obs_signed_by_auditor").val('');
            $("#obs_corrective_action_evidence").val('');
            $("#obs_preventive_action_evidence").val('');
            $("#obs_preventive_action_sign_imagebox").val('');
            $("#obs_preventive_action_accepted_imagebox").val('');
            $( "#obs_signed_by_master_prefill" ).html( ''  );
            $( "#obs_signed_by_auditor_prefill" ).html( '');
            $( "#obs_preventive_action_sign_imagebox_prefill" ).html( '');
            $( "#obs_preventive_action_accepted_imagebox_prefill" ).html( '');


            /* date completed empty */
            $("#obs_corrective_action_complete_date").val();
            $("#audit_non_confirmity").val();
            $("#obs_preventive_action_complete_date").val();
            $("#obs_confirm_date").val();



            $("#obs_rootcauses option:selected").prop("selected", false);
            $("#obs_rootcauses").multiselect('refresh');
            $("#obs_rootcauses").trigger("change");

            $("#obs_preventiveactions option:selected").prop("selected", false);
            $("#obs_preventiveactions").multiselect('refresh');
            $("#obs_preventiveactions").trigger("change");

            $("#corrective_action_increase_PSC , #corrective_action_increase_OBSERVATION , #corrective_action_increase_NC").html(`
                    <label for="nc_corrective_action">Corrective Action/s</label>
                    <div class="input-group">
                        <textarea class="form-control mr-2 mb-2" id="nc_corrective_action_1"
                            name="nc_corrective_action[]" rows="2"></textarea>
                        <button type="button" class="btn btn-primary ml-1 mb-2"
                            id='corrective_increasetext_NC' onclick="addmoreCA()">Add</button>
                    </div>
            `)



    })

    // Set blank Value on New fillup PSC ......
    $("#psc_id > button:nth-child(1)").click(()=>{
                $('#editID_PSC').val(null);
                $('#description_psc').val('')
                document.getElementById('major_nc_1').checked = false;
                document.getElementById('type_of_nc_2').checked = false;
                $("#Ref_psc").val('')
                $("#code_psc").val('')
                $('.preventive_evidence').empty()
                $('.preventive_actions_prefill').empty();
                $('.root_causes_prefill').empty();
                $('.corrective_actions_prefill').empty();
                $('.corrective_action_img').empty();
                $('#corrective_action_complete_date_psc').val('');
                $('#preventive_action_complete_date_psc').val('');
                $('#upload_document_psc').val('');




                /* files empty */
                $("#nc_signed_by_master").val('');
                $("#nc_signed_by_auditor").val('');
                $("#nc_corrective_action_evidence").val('');
                $("#nc_preventive_action_evidence").val('');
                $("#nc_preventive_action_sign_imagebox").val('');
                $("#nc_preventive_action_accepted_imagebox").val('');
                $('#upload_document_psc').val();
                $('#upload_document_psc_show').html('');
                $('#corrective_action_evidence_psc').val('')
                $('#preventive_action_evidence_psc').val('')

                /* date completed empty */
                $("#corrective_action_complete_date_psc").val();
                $("#audit_non_confirmity").val();
                $("#preventive_action_complete_date_psc").val();
                $("#nc_confirm_date").val();



                $("#psc_rootcauses option:selected").prop("selected", false);
                $("#psc_rootcauses").multiselect('refresh');
                $("#psc_rootcauses").trigger("change");

                $('#psc_preventiveactions').val('');
                $("#psc_preventiveactions").multiselect('refresh');
                $('#psc_preventiveactions').change();

                // $("#psc_preventiveactions option:selected").prop("selected", false);
                // $("#psc_preventiveactions").multiselect('refresh');
                // $("#psc_preventiveactions").trigger("change");

                $("#corrective_action_increase_PSC , #corrective_action_increase_OBSERVATION , #corrective_action_increase_NC").html(`
                        <label for="nc_corrective_action">Corrective Action/s</label>
                        <div class="input-group">
                            <textarea class="form-control mr-2 mb-2" id="nc_corrective_action_1"
                                name="nc_corrective_action[]" rows="2"></textarea>
                            <button type="button" class="btn btn-primary ml-1 mb-2"
                                id='corrective_increasetext_NC' onclick="addmoreCA()">Add</button>
                        </div>
                `)




    })


    /* showing alert on filling Date Completed For blank corrective action or preventive action  ..... */
    // For Corrective Actions .....
    $('#nc_corrective_action_complete_date,#obs_corrective_action_complete_date,#corrective_action_complete_date_psc').change(function(){
        let is_blank = Check_Corrective_Action_Object_is_Blank();
        (is_blank)?toastr.error("Can't Update, Please Fillup Corrective Action/s !"):'';
    })
    // For Preventive Actions .....
    $('#nc_preventive_action_complete_date').change(function(){
        ($('#preventiveactions').val().length == 0)?toastr.error("Can't Update, Please Fillup Preventive Action/s !"):'';
    })
    $('#obs_preventive_action_complete_date').change(function(){
        ($('#obs_preventiveactions').val().length == 0)?toastr.error("Can't Update, Please Fillup Preventive Action/s !"):'';
    })
    $('#preventive_action_complete_date_psc').change(function(){
        ($('#psc_preventiveactions').val().length == 0)?toastr.error("Can't Update, Please Fillup Preventive Action/s !"):'';
    })


    // disable next button of first step if type of audit not selected .....
    if($("#type_of_audit").val() == null || $("#type_of_audit").val() == 'null'){
        $('.investigation_tab').hide()
    }else{
        $('.investigation_tab').show()
    }
    $("#type_of_audit").change(function(){
        // var id = $('#form_id').val();
        // $.ajax({
        //     headers: {
        //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //     },
        //     url: "/api/typeChangeDelete",
        //     method: "POST",
        //     contentType: false,
        //     processData: false,
        //     data: {'id':id},
        //     dataType: "JSON",

        // });
        if($("#type_of_audit").val() == null || $("#type_of_audit").val() == 'null'){
            $('.investigation_tab').hide()
        }else{
            $('.investigation_tab').show()
        }
    });


})


// Checking Corrective-Action Object is Blank or not
function Check_Corrective_Action_Object_is_Blank( value) {
    var  object =  GetInputArrayValues(document.getElementsByName('nc_corrective_action[]'))
    var value = '';
    // Convert `obj` to a  array.....
    const arr = Object.values(object);
    var i = 0;
    while (i < arr.length) {
      if (arr[i] === value) {
        arr.splice(i, 1);
      } else {
        ++i;
      }
    }
    return (arr.length == 0) ? true : false;
  }


