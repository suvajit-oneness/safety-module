@extends('layouts.app')

@section('template_title')
    Near Miss Report
@endsection

@section('template_linked_css')
    <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/css/common.css') }}">
    <link rel="stylesheet" href="/css/custom/nearMiss/style.css">
@endsection

@section('content')
    @php
      $stringLimit = config('constants.TABLE_STRING_SIZE');
    @endphp
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h1 align="center">Near Miss Accident Reporting</h1>

                <div class="row mb-3 ml-2">
                    <div class="col-md-10">
                        <a href="{{ route('Near_Miss_create') }}">
                        <button class="btn btn-danger"><span class="mr-3"><i class="fa fa-plus-circle"></i></span> Add New Near Miss Report</button>
                        </a>
                    </div>
                    <div class=" col-md-2 " align ="right">
                        <button class="btn btn-primary" id="btnExport"><span><i class="fa fa-file-text-o"></i></span> Export To Excel</button>
                    </div>
                </div>

                <div class="float-right">
                    <input class="btn" style="border: 1px solid black" type="search" id="search"> <button id="searchbtn" class="btn btn-primary">Search</button>
                </div>

                <div class="row w-100 scroll-class" id="scroll-id">
                    <div class="col-lg-12  wrapper2 scroll-class" >

                        <table id="NMR_list" class="display w-100 div2" style="width:100%; background-color:white;">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>ID</th>
                                    <th>Date of NM</th>
                                    <!-- <th>Description</th>
                                    <th>Incident Type</th>
                                    <th> Corrective Action </th> -->
                                    <th>Description & Incident Type & Corrective Action</th>
                                    <th> Immediate Cause </th>
                                    <th>Root causes </th>
                                    <th>Preventive actions</th>
                                    <!-- <th>Closed</th>
                                    <th> Office Comments </th>
                                    <th> Lesson learnt </th> -->
                                 <th>Closed & Office Comments & Lesson Learnt</th>
                                    <th id="removeit"> Action </th>
                                </tr>
                            </thead>
                            <tbody class="text-center"></tbody>
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
     <script src="/js/custom/nearMiss/index.js"></script>
     <script type="text/javascript" src="/js/custom/RiskAssessment/table2excel.js"></script>

    <script>
        var idu = '{{Auth::user()->id}}'
        var is_admin = '{{Auth::user()->isAdmin()}}';
        var u_id = {{Auth::user()->id}};
        if(is_admin ){
        is_admin = is_admin; 
        }
        if( idu){
         u_id = idu;
        }
        var creator_id = {!!json_encode(session('creator_id'))!!};
        var is_ship = {!!json_encode(session('is_ship'))!!};
    </script>

   <script>
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

    <script type="text/javascript">
    $(function () {
      $("#btnExport").click(function () {
        $('#NMR_list td a').remove();
        $('#removeit').remove();
        $('.removeit').remove();
        $("#NMR_list").table2excel({
          exclude: ".noExport",
          filename: "NearMissReport.xls"
        });
        
      });
    });
    </script>

@endsection
