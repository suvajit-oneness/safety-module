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
        <h2 class="font-weight-light text-center">Add Ranks</h2>



                {{-- Ad Ranks --}}
                <form method="POST" action="{{ url('/crew_ranks/store') }}" class="mx-5">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">Rank</label>
                      <input type="text" class="form-control" name="rank" id="rank"  placeholder="Enter Rank">
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                  </form>




    </div>
</div>
@endsection


@section('footer_scripts')



@endsection
