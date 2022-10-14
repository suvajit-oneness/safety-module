$(document).ready(function() {

    // fields
    columns = [
        { "data": "status" },
        { "data": "id" },
        { "data": "date" },
        // { "data": "describtion" },
        // { "data": "incident_type" },
        // { "data": "corrective_action" },
        { "data": "itca"},
        { "data": "immediate_cause" },
        { "data": "Root_causes" },
        { "data": "preventive_actions" },
        // { "data": "closed" },
        // { "data": "office_comments" },
        // { "data": "lesson_earnt" },
        { "data": "ocll"},
        { "data": "action" },
    ];


    // Search
    $('#searchbtn').click(()=>{

        if (  $.fn.DataTable.isDataTable( '#NMR_list' ) ) {
            $('#NMR_list').DataTable().destroy();
        }

        let searchValue = $('#search').val();
        console.log(searchValue);

        // Data table Search
        $('#NMR_list').DataTable({
            "order": [[  0, "desc" ]],
            "processing": true,
            "serverSide": true,
            "dom":"Blrtip",
            'ajax': {
                "url": "/api/getneardata",
                "dataType": "json",
                "type": "POST",

                "data": { _token: "{{csrf_token()}}", 'adm': is_admin, 'uid': u_id, 'searchValue': searchValue, 'is_ship': is_ship, 'creator_id':creator_id}
            },
            "columns": columns,

        });
    })

    // Data table
    $('#NMR_list').DataTable({
        "order": [[  0, "desc" ]],
        "processing": true,
        "serverSide": true,
        "dom":"Blrtip",
        'ajax': {
            "url": "/api/getneardata",
            "dataType": "json",
            "type": "POST",
            "data": { _token: "{{csrf_token()}}", 'adm': is_admin, 'uid': u_id, 'is_ship': is_ship, 'creator_id': creator_id }
        },
        "columns": columns,
    });

    setTimeout(() => {
        let id_arr = id_array();
        $("#allpdf").attr("href", '/near-pdf-all/'+id_arr);
    }, 3000);

    $("#NMR_list_length > label:nth-child(1) > select:nth-child(1)").change(function(){
        setTimeout(() => {
            console.log(id_array())
        }, 3000);
    })

    $(".wrapper1").scroll(function(){
        // console.log("test1");
        $(".wrapper2").scrollLeft($(".wrapper1").scrollLeft());
    });

    $(".wrapper2").scroll(function(){
        // console.log("test2");
        $(".wrapper1").scrollLeft($(".wrapper2").scrollLeft());
    });

} );
