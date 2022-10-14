@extends('layouts.app')

@section('template_title')
    Inspection & Audit
@endsection
@section('template_linked_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
{{--<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/roundSlider/1.3.2/roundslider.css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
<link rel="stylesheet" href="{{ asset('/css/common.css') }}">

<style>
        body{
        background-color: white;
        }
        .numo-btn{
            border-radius: 10px !important;
            background: #e0e0e0 !important;
            box-shadow:  -5px 5px 5px #868686,
                        5px -5px 5px #ffffff !important;
        }
        .numo-btn:hover{
            border-radius: 10px !important;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            box-shadow:  -6px 6px 11px #8f8f8f,
                        6px -6px 11px #ffffff !important;
        }
        button.text-dark{display:none !important;}
</style>
@endsection

@section('content')
    <div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h1 align="center">Inspection & Audit</h1>
                    <div class="row mb-3 ml-2">
                        <div class="col-md-12">
                            <a href="/inspection-audit/create">
                            <button class="btn btn-danger"><span><i class="fa fa-plus-circle"></i></span> Add New Audit</button>
                            </a>
                        </div>
                    </div>

                <div class="col-lg-12  table-responsive">


                        <table  id="IA_list" class="display w-100" style="width:100%; background-color:white; height: 71vh;">
                            <thead>
                                <tr>
                                    <th>status</th>
                                    <th>ID</th>
                                    <th>Report Date</th>
                                    <th>Location</th>
                                    <th>Type Of Audit</th>
                                    <th>Report</th>
                                    <th>Name of the Auditor</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                            </tbody>
                        </table>



                </div>

        </div>
    </div>
    </div>



@endsection

@section('footer_scripts') 

<script>
        var is_ship = `{{$is_ship}}`;
        var creator_id = `{{$creator_id}}`;
</script>

{{-- read more script --}}
 <script type="text/javascript" src="/js/dataTables/dataTables.min.js"></script>

<script>
     var is_admin = '{{Auth::user()->isAdmin()}}';
     var u_id = {{Auth::user()->id}};
</script>
    {{-- bootstrap data table --}}
   <script>
       $(document).ready(function() {

                // fields
                columns = [
                    { "data": "status" },
                    {"data": "id"},
                    {"data": "report_date"},
                    {"data": "location"},
                    {"data": "type_of_audit"},
                    {"data": "report"},
                    {"data": "name_of_auditor"},
                    {"data": "action"},
                ];


            //    Search
                $('#searchbtn').click(()=>{

                    if (  $.fn.DataTable.isDataTable( '#IA_list' ) ) {
                        $('#IA_list').DataTable().destroy();
                    }

                    let srch = $('#search').val()
                    var session_email = `{{session('email')}}`
                    
                    // Data table Search
                    $('#IA_list').DataTable({
                        "order": [[  0, "desc" ]],
                        "processing": true,
                        "serverSide": true,
                        "dom":"Blrtip",
                        'ajax': {
                                "url": "/api/getinspect",
                                "dataType": "json",
                                "type": "POST",
                                "data":{ _token: "{{csrf_token()}}" , 'adm':is_admin , 'uid':u_id,'srch':srch,'session_email':session_email ,'is_ship': is_ship,'creator_id':creator_id}
                        },
                        "columns": columns,

                    });
                })



                var session_email = `{{session('email')}}`
                var is_admin = `{{Auth::user()->isAdmin()}}`
                // Data table
                $('#IA_list').DataTable({
                   
                    "order": [[  0, "desc" ]],
                    "processing": true,
                    "serverSide": true,
                    "dom":"Blrtip",
                    'ajax': {
                            "url": "/api/getinspect",
                            "dataType": "json",
                            "type": "POST",
                            "data":{ _token: "{{csrf_token()}}" , 'adm':is_admin , 'uid':u_id,'session_email':session_email,'is_admin':is_admin,'is_ship': is_ship,'creator_id':creator_id}
                    },
                    "columns": columns,
                });



                setTimeout(() => {    let id_arr = id_array();  $("#allpdf").attr("href", '/incident-pdf-all/'+id_arr);  }, 3000);

                $("#IA_list_length > label:nth-child(1) > select:nth-child(1)").change(function(){ setTimeout(() => {  console.log(id_array())  }, 3000);  })


    } );

    // my helper function
    const id_array = () =>
    {
        let idarr = [];
        for(let i=0; i< $(".sorting_1").length ; i++ ){ idarr.push( $(".sorting_1")[i].innerText); }
        return idarr;
    }
   </script>



    <script type="text/javascript">

		function toggleReadMoreLess( contentid , butnid)
		{
			document.getElementById(contentid).classList.toggle("show_less")

			var readMoreLessElem = document.getElementById(butnid)
			//console.log(readMoreLessElem.innerHTML)
			if(readMoreLessElem.innerHTML.trim()=="Read More")
				readMoreLessElem.innerHTML="Read Less"
			else
				readMoreLessElem.innerHTML="Read More"
		}
	</script>


@endsection
