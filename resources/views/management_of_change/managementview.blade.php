@extends('layouts.app')

@section('template_title')
    Management of Change
@endsection

@section('template_linked_css')
  <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('/css/common.css') }}">
  <style>
    .modal-backdrop{
        
        display: none !important;
    }
    .show_less
    {
      overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .readLessPara
    {
        content: "Read Less";
    }
    .scroll-class{
        transform: rotateX(180deg) !important;
        -webkit-transform:rotateX(180deg) !important;
    }
    .wrapper1{
        height:20px;
        width:100%;
        border: none;
        overflow-x: scroll; 
        overflow-y:hidden
    }
    .scrolldiv{
        height:20px;
        width:1000px
    }
    /* #app > main > div.container-fluid > div > div > div.row.w-100.scroll-class > div
    {
         transform: rotateX(180deg) !important;
        -webkit-transform:rotateX(180deg) !important;
    } */
    #scroll-id
    {
        /* color:red !important;
        background-color:red !important; */
        transform: rotateX(180deg) !important;
        -webkit-transform:rotateX(180deg) !important;

    }

            /* width */
            .scroll-class::-webkit-scrollbar 
            {
                position:absolute !important;
                top:100px;
            width: 10px;
            height:10px;
            transform: rotateX(180deg) !important;
                    -webkit-transform:rotateX(180deg) !important;
            }


            /* Track */
            .scroll-class::-webkit-scrollbar-track 
            {
            background: #f1f1f1;
            transform: rotateX(180deg) !important;
                    -webkit-transform:rotateX(180deg) !important;
            }

            /* Handle */
            .scroll-class::-webkit-scrollbar-thumb 
            {
            background: #888;
            transform: rotateX(180deg) !important;
                    -webkit-transform:rotateX(180deg) !important;
            }

            /* Handle on hover */
            .scroll-class::-webkit-scrollbar-thumb:hover 
            {
            background: #555;
            transform: rotateX(180deg) !important;
                    -webkit-transform:rotateX(180deg) !important;
            }
</style>
<style>
    .wrapper2{width: 100%; border: none 0px RED;
        overflow-x: scroll; overflow-y:scroll;}
    .wrapper1{width: 100%; border: none 0px RED;
        overflow-x: scroll;}

     .wrapper1{height: 20px; }
     .wrapper2{height: 80vh; }
     .div1 {width:100%; height: 20px; }
     .div2 {width:100%; height: 400px;
      overflow: auto;}
</style>
{{-- <style>
    #NMR_list_paginate
    {
        display: none !important;
    }
   
</style> --}}

@endsection

@section('content')
@php
  $stringLimit = config('constants.TABLE_STRING_SIZE');
@endphp
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
                <h1 align="center">Management Of Change</h1>
                <div class="row mb-3 ml-2">
                    <div class="col-md-6">
                        
                        <a href="/moc/create"><button type="button" class="btn btn-danger">
                            <span class="mr-3"><i class="fa fa-plus-circle mr-2"></i>Add New </span>
                          </button></a>
                        {{-- <div class="mt-3">                     
                            <button class="btn btn-primary" id="btnExport"><span><i class="fa fa-file-text-o"></i></span> Export To Excel</button>                    
                        </div> --}}
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                              <div class="modal-content">
                          
                                <!-- Modal Header -->
                                <div class="modal-header">
                                  <h4 class="modal-title">Please select Risk Assesment</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                          
                                <!-- Modal body -->
                                <div class="modal-body">
                                          <select name="" id="riskassesment_dropdown" class="form-control">
                                            <option disabled selected hidden>Risk Assesment</option>
                                            @foreach ($risk_assesment_id as $item)
                                                @if($item->id)
                                                    <option value="{{ $item->id }}" id='ra_id'>{{ $item->id }}</option>
                                                @endif
                                            @endforeach  
                                          </select>
                                </div>
                          
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <a href="/userRiskAssesment">
                                        <button type = "button" class = "btn btn-primary">Create RA</button>
                                    </a>
                                      <a href="#">
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">  
                                               <span class="mr-3"><i class="fa fa-plus-circle mr-2"></i>Add New </span>
                                            </button>       
                                       </a>
                                       <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                          
                              </div>
                            </div>
                          </div>
                    </div>
                  
                    {{--<!-- <div class="col-md-6 text-right">
                        {{-- Print Button all 
                        <a href="" id="allpdf" class="btn btn-primary mt-3 h2"><i class="fas fa-print"></i> Print All</a>

                    </div> -->--}}
                </div>
             
                <div class="float-right">
                    <input class="btn" style="border: 1px solid black" type="search" id="search"> <button id="searchbtn" class="btn btn-primary">Search</button>
                </div>
                <div class="row w-100 scroll-class" id="scroll-id">
                <div class="col-lg-12  wrapper2 scroll-class" >


                        <table id="MOC_list" class="display w-100 div2" style="width:100%; background-color:white;">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Vessel Name</th>
                                    <th>Name & Rank/Position</th>
                                    <th> Type of change Requested </th>
                                    <th> Control Number</th>
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
     var idu = null;
     var is_admin = false;
     if({!! json_encode(Auth::user()) !!}){
        idu = {!! json_encode(Auth::user()->id) !!};
        var is_admin = {!! json_encode(Auth::user()->isAdmin()) !!};
     }          
     var u_id = idu;
     var creator_id = {!!json_encode(session('creator_id'))!!};
     var is_ship = {!!json_encode(session('is_ship'))!!};
</script>
 
 
   <script>
      
    {{-- bootstrap data table --}}
       $(document).ready(function() {


        columns = [
                     { "data" : "status"},
                     { "data": "id" },
                     { "data": "date" },
                     { "data": "Vessel Name" },
                     { "data": "Name & Rank/Position" },
                     { "data": "Type of change Requested" },
                     { "data": "Control Number" },
                     { "data": "action"},
                  ];

               


            //    Search
                $('#searchbtn').click(()=>{
                    console.log($('#search').val());
                    if (  $.fn.DataTable.isDataTable( '#MOC_list' ) ) {
                        $('#MOC_list').DataTable().destroy();
                    }

                    let srch = $('#search').val()

                    // Data table Search
                    $('#MOC_list').DataTable({
                        "order": [[  0, "desc" ]],
                        "processing": true,
                        "serverSide": true,
                        "dom":"Blrtip",
                        'ajax': {
                                "url": "/api/getMocData",
                                "dataType": "json",
                                "type": "POST",
                                "data":{ _token: "{{csrf_token()}}" , 'adm':is_admin , 'uid':u_id,'srch':srch}
                        },
                        "columns": columns,

                    });
                })




                // Data table
                $('#MOC_list').DataTable({
                    "order": [[  0, "desc" ]],
                    "processing": true,
                    "serverSide": true,
                    "dom":"Blrtip",
                    'ajax': {
                            "url": "/api/getMocData",
                            "dataType": "json",
                            "type": "POST",
                            "data":{ _token: "{{csrf_token()}}" , 'adm':is_admin , 'uid':u_id, 'creator_id':creator_id,'is_ship':is_ship}
                    },
                    "columns": columns,
                });



                // setTimeout(() => {    let id_arr = id_array();  $("#allpdf").attr("href", '/near-pdf-all/'+id_arr);  }, 3000);

                // $("#NMR_list_length > label:nth-child(1) > select:nth-child(1)").change(function(){ setTimeout(() => {  console.log(id_array())  }, 3000);  })


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
    <script type="text/javascript" src="/js/custom/RiskAssessment/table2excel.js"></script>
    <script type="text/javascript">
    $(function () {
      $("#btnExport").click(function () {
        $('#NMR_list td a').remove();
        $("#NMR_list").table2excel({
          exclude: ".noExport",
          filename: "NearMissReport.xls"
        });
        
      });
    });
    </script>
     <script type="text/javascript">
        $(document).ready(function(){
              
                $(".wrapper1").scroll(function(){
                     console.log("test1");
                    $(".wrapper2")
                        .scrollLeft($(".wrapper1").scrollLeft());
                });
                
                $(".wrapper2").scroll(function(){
                    console.log("test2");
                    $(".wrapper1")
                        .scrollLeft($(".wrapper2").scrollLeft());
                });
        
        });
    </script>
@endsection
 