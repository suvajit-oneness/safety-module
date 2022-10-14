@extends('layouts.app')


{{--  Global Variables  --}}
<script>
        var is_ship = `{{$is_ship}}`;
        var creator_id = `{{$creator_id}}`;
</script>

@section('template_title')
    Incident Reporting
@endsection

@section('template_linked_css')
    <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/css/common.css') }}">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <style>
        .garage-title {
            clear: both;
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            font-size: 0.9rem !important;

        }

        .show_less {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .readLessPara {
            content: "Read Less";
        }

        td {
            vertical-align: bottom;
        }

        .btn {
            border-radius: 10px;
        }


        /* data table */
        table.dataTable tbody tr {
            background-color: #f9f9f9;
        }

        /* data table */
        /* tootip css */

        .containertooltip {
            /* Used to position the arrow */
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Show the arrow and content and restore pointer events when hovering the trigger element */
        .containertooltip:hover .container__arrow,
        .containertooltip:hover .container__content {
            opacity: 1;
            pointer-events: initial;
        }

        .container__arrow {
            /* Invisible by default */
            opacity: 0;

            /* To prevent accidental interactions with other elements  */
            pointer-events: none;

            /* Border */
            border: 8px solid transparent;
            border-top-color: black;

            /* Position */
            bottom: -35%;
            left: 50%;
            position: absolute;
            transform: translate(-50%, 8px);

            /* Zero size */
            height: 0;
            width: 0;

            /* Displayed on top of other element */
            z-index: 10;
        }

        .container__content {
            /* Invisible by default */
            opacity: 0;

            /* To prevent accidental interactions with other elements  */
            pointer-events: none;

            /* Background color, must be the same as the border color of arrow */
            background-color: black;
            border-radius: 2px;

            /* Position */
            bottom: -175%;
            left: 50%;
            position: absolute;
            transform: translate(-50%, -8px);

            /* Displayed on top of other element */
            z-index: 10;
        }

        /* numorphisom button */
        .navbar {
            background-color: #ffffff !important;
            margin-bottom: 20px !important;
            background: #ffffff;
            box-shadow: 5px 5px 10px #a7a7a7,
                -5px -5px 10px #ffffff;
        }


        #NMR_list_length>label:nth-child(1)>select:nth-child(1) {
            margin-left: 10px;
            margin-right: 10px;
            border-radius: 10px !important;
            background: #e0e0e0 !important;
            box-shadow: -5px 5px 5px #868686,
                5px -5px 5px #ffffff !important;
            border: 1px solid yellow;
        }

        /* numorphisom button */


        /* modal */
        .modal-content {
            border-radius: 10px;
            background: #ffffff;

        }

        /* tool-tip */
        .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

    </style>
    <style>
        .wrapper2 {
            width: 100%;
            border: none 0px RED;
            overflow-x: scroll;
            overflow-y: scroll;
        }

        .wrapper1 {
            width: 100%;
            border: none 0px RED;
            overflow-x: scroll;
        }

        .wrapper1 {
            height: 20px;
        }

        .wrapper2 {
            height: 80vh;
        }

        .div1 {
            width: 100%;
            height: 20px;
        }

        .div2 {
            width: 100%;
            height: 400px;
            overflow: auto;
        }

    </style>
@endsection

@section('content')
    @php
    $stringLimit = config('constants.TABLE_STRING_SIZE');
    @endphp
    <div class="container-fluid">
        <div class="card " style="background-color: #ffffff">
            <div class="card-body">
            <h1 align="center">Incident Reporting</h1>
                <div class="row  ml-2">
                    <div class="col-md-11">
                        <a href="{{ route('incident_create') }}" class="btn btn-primary   ml-auto"> <i
                                class="fas fa-plus-circle mr-3"></i> Report an incident</a>
                    </div>


                    <div class="col-md-1  float-right">
                        {{-- Print Button all --}}
                        {{-- <a href="" id="allpdf" class="btn btn-primary  h2"><i class="fas fa-print"></i> Print All</a> --}}

                    </div>
                    <!-- <div class="col-md-4 ">
                            <input class="btn " style="border: 1px solid green" type="search" id="search"> <button id="searchbtn" class="btn btn-success ml-2"> <i class="fas fa-search mr-2"></i> Search</button>
                        </div> -->
                </div>
                <div class='float-right'>

                    <input placeholder="Search By ID" class="btn " style="border: 1px solid green" type="search" id="search"> <button
                        id="searchbtn" class="btn btn-success ml-2"> <i class="fas fa-search mr-2"></i> Search</button>
                </div>


                {{--  <img src="/getFile?path=\cskva_1\incident_reporting\cskva-incident_report-3\risk_evidence_file\Adiyogi.jpeg" height="500" width="500">  --}}

                <div class="row  w-100" style='height: 100vh'>
                    <div class="col-lg-12 ">


                        <table id="NMR_list" class="display w-100 div2 " style="width:100%; background-color:white;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Status</th>
                                    <th>Incident</th>
                                    <th>Crew Injury</th>
                                    {{-- <th>Vessel Details</th> --}}
                                    <th>Event Information</th>
                                    {{-- <th>Type of Loss</th> --}}
                                    <th>Incident in Brief</th>
                                    <th>Event Log</th>
                                    <th> Incident Investigation And Root Cause Findings </th>
                                    <th> 5 Why </th>
                                    <th> Created At </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                            </tbody>
                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    {{-- read more script --}}
    <script type="text/javascript" src="/js/dataTables/dataTables.min.js"></script>

    <script>
        var is_admin = '{{ Auth::user()->isAdmin() }}';
        var u_id = {{ Auth::user()->id }};
    </script>
    {{-- bootstrap data table --}}
    <script>
        $(document).ready(function() {

            // fields
            columns = [{
                    "data": "id"
                },
                {
                    "data": "status"
                },
                {
                    "data": "Incident"
                },
                {
                    "data": "Crew_Injury"
                },
                // {
                //     "data": "Vessel_Details"
                // },
                {
                    "data": "Event_information"
                },
                // { "data": "type_of_loss" },
                {
                    "data": "incident_berief"
                },
                {
                    "data": "Event_log"
                },
                {
                    "data": "incident_investigation_root_cause"
                },
                {
                    "data": "five_why"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "action"
                },
            ];


            //    Search
            // $('#searchbtn').click(() => {

            //     if ($.fn.DataTable.isDataTable('#NMR_list')) {
            //         $('#NMR_list').DataTable().destroy();
            //     }

            //     let srch = $('#search').val()

            //     // Data table Search
            //     $('#NMR_list').DataTable({
            //         "order": [
            //             [0, "desc"]
            //         ],
            //         "processing": true,
            //         "serverSide": true,
            //         "dom": "Blrtip",
            //         'ajax': {
            //             "url": "/api/getincident",
            //             "dataType": "json",
            //             "type": "POST",
            //             "data": {
            //                 _token: "{{ csrf_token() }}",
            //                 'adm': is_admin,
            //                 'uid': u_id,
            //                 'srch': srch
            //             }
            //         },
            //         "columns": columns,

            //     });
            // })

            $('#searchbtn').click(() => {

                if ($.fn.DataTable.isDataTable('#NMR_list')) {
                    $('#NMR_list').DataTable().destroy();
                }

                let srch = $('#search').val()
                console.log(srch);
                // Data table Search
                $('#NMR_list').DataTable({
                    "order": [
                        [0, "desc"]
                    ],
                    // "aaSorting": []
                    "processing": true,
                    "serverSide": true,
                    "dom": "Blrtip",
                    'ajax': {
                        "url": "/api/getincident",
                        "dataType": "json",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            'adm': is_admin,
                            'uid': u_id,
                            'srch': srch,
                            'is_ship': is_ship,
                            'creator_id':creator_id
                        }
                    },
                    "columns": columns,

                });
            })



            // Data table
            $('#NMR_list').DataTable({
                "order": [
                    [0, "desc"]
                ],
                // "aaSorting": [],
                "processing": true,
                "serverSide": true,
                "dom": "Blrtip",
                'ajax': {
                    "url": "/api/getincident",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        'adm': is_admin,
                        'uid': u_id,
                        'is_ship': is_ship,
                        'creator_id':creator_id
                    }
                },
                "columns": columns,
            });



            setTimeout(() => {
                let id_arr = id_array();
                $("#allpdf").attr("href", '/incident-pdf-all/' + id_arr);
            }, 3000);

            $("#NMR_list_length > label:nth-child(1) > select:nth-child(1)").change(function() {
                setTimeout(() => {
                    console.log(id_array())
                }, 3000);
            })

            // update modal data
            $("#save_modal").click(() => {
                console.log('Hey');
                let immediate_action = $('#immediate_action_to_be_taken').val();
                console.log($('#immediate_action_to_be_taken').val());
            });
        });

        // my helper function
        const id_array = () => {
            let idarr = [];
            for (let i = 0; i < $(".sorting_1").length; i++) {
                idarr.push($(".sorting_1")[i].innerText);
            }
            return idarr;
        }
    </script>



    <script type="text/javascript">
        function toggleReadMoreLess(contentid, butnid) {
            document.getElementById(contentid).classList.toggle("show_less")

            var readMoreLessElem = document.getElementById(butnid)
            //console.log(readMoreLessElem.innerHTML)
            if (readMoreLessElem.innerHTML.trim() == "Read More")
                readMoreLessElem.innerHTML = "Read Less"
            else
                readMoreLessElem.innerHTML = "Read More"
        }
        function updateModalData(id){
            console.log($('#immediate_action_to_be_taken_'+id).val());
            let immediate_action = $('#immediate_action_to_be_taken_'+id).val();
            // console.log({id});
            $.ajax({
                url: "/api/updateModalData",
                type: "POST",
                data:{"myData":immediate_action,"id":id},
                success:function(data){
                    console.log(data)
                    toastr.success('Updated Successfully !!');
                    location.reload();
                }
            });
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(".wrapper1").scroll(function() {
                console.log("test1");
                $(".wrapper2")
                    .scrollLeft($(".wrapper1").scrollLeft());
            });

            $(".wrapper2").scroll(function() {
                console.log("test2");
                $(".wrapper1")
                    .scrollLeft($(".wrapper2").scrollLeft());
            });

        });
    </script>
    <script>
        /*  function filterApplied() {

                    let statuspicker = $('#statuspicker').val();
                    console.log(statuspicker);
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/api/getincident",
                        data: {
                            _token: "{{ csrf_token() }}",
                            statuspicker: statuspicker
                        },
                        dataType: "application/json",
                        success: function(response) {
                            console.log("Filter succesfull");
                            console.log('response:', response);
                        }
                    });
                }  */

        $(' #statusbtn').click(() => {

            if ($.fn.DataTable.isDataTable('#NMR_list')) {
                $('#NMR_list').DataTable().destroy();
            }

            let statuspicker = $('#statuspicker').val()
            console.log(statuspicker);
            // Data table Search
            $('#NMR_list').DataTable({
                "order": [
                    [0, "desc"]
                ],
                "processing": true,
                "serverSide": true,
                "dom": "Blrtip",
                'ajax': {
                    "url": "/api/getincident",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        'adm': is_admin,
                        'uid': u_id,
                        'statuspicker': statuspicker,
                        'is_ship': is_ship,
                        'creator_id':creator_id
                    }

                },
                "columns": columns,

            });
        })
    </script>
@endsection

