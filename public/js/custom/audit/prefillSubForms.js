$(()=>{

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
                    console.log(element)

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



    // Calling Pre-fill .....
    PrefillFRM();
    //  on click of non-confirmity form-submit .....
    // $("#increaserow-nc").click(()=>{
    //     PrefillFRM();
    // })

    //  on click of OBSERVATION form-submit .....
    // $("#obs-increaserow").click(()=>{
    //     PrefillFRM();
    // })

    //  on click of PSC  form-submit .....
    // $("#psc-increaserow").click(()=>{
    //     PrefillFRM();
    // })

    //  on change of PSC  form-submit .....
    $("#type_of_audit").change(()=>{
        console.log("changed !")
        PrefillFRM();
    })

})
