@extends('layouts.app')

@section('template_title')
    Vessel Report
@endsection

@section('template_linked_css')
  <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">


@endsection

@section('content')
<div class="container">
    <div class="card p-3 shadow mx-5 ">
        <h2 class="font-weight-light text-center">Crew Ranks</h2>


            <ul class="list-group my-5 mx-5">

                {{-- crew add button --}}
                <a href="/crew_ranks/add" class="btn btn-primary py-1 w-25 ml-auto my-3">Add Rank</a>

                {{-- Crew list --}}

                    @foreach ( $ranks as $r )
                        <li class="list-group-item">{{ $r->name }}</li>
                    @endforeach

                    {{-- <h2 class="text-center text-danger my-5">No Ranks Found !</h2> --}}


            </ul>


    </div>
</div>
@endsection


@section('footer_scripts')



@endsection
