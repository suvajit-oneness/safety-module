@extends('layouts.app')

@section('template_title')
	Department
@endsection
@section('template_linked_css')
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
  
@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2>Add New Department</h2>
            <br>
            <form method="post" action="/department" class="form" id="department_form">

            	<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                
                <div class="row container">
                    <div class="col-3">
                        <label>Name</label>       
                    </div>
                    <div class="col-9">
                        <input class="form-control" required type="text" name=name id="name" placeholder="Enter Department Name">
                    </div>
                </div>               
                
                <div class="row mt-3">
                	<div class="col-md-12" style="text-align:center;">
                		<button class="btn btn-primary" type="submit" name="submit" title="Click to submit">
                            Submit
                        </button>	   			
                	</div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('footer_scripts')   
    <script src="/js/jquery/jquery.form.js"></script>
    <script type="text/javascript" src="/js/dataTables/dataTables.min.js"></script>
@endsection