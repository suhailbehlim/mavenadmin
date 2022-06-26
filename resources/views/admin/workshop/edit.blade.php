@extends('layouts.masters')

@section('title', 'VLSI WorkShop')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>VLSI WorkShop Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item active">VLSI WorkShop Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-body">
            	<form method="post" action="{{ route('admin.workshopUpdate') }}" enctype="multipart/form-data">
            		@csrf

                <div class="form-group">
					<label for="inputName">Page Title<span class="estricCls">*</span></label>
					<input type="text" name="title"  id="slug" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title" value="{{$data->title}}"  autocomplete="title" required autofocus>

					@error('title')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>
				
				
				<div class="row">
					<div class="col-md-6">
						<h3 class="card-title" style="width: 100%;color: #007bff;font-weight: bold;">First Section</h3>
						<div class="form-group">
							<label for="inputName">Black Title<span class="estricCls">*</span></label>
							<input type="text" name="first_black_title"  id="first_black_title" class="form-control"  autocomplete="title" value="{{$data->first_black_title}}" required autofocus>
						</div>
						<div class="form-group">
							<label for="inputName">Green Title<span class="estricCls">*</span></label>
							<input type="text" name="first_green_title"  id="first_green_title" class="form-control"  autocomplete="title" value="{{$data->first_green_title}}" required autofocus>
						</div>
						<div class="form-group">
							<label for="inputName">ICON<span class="estricCls">*</span></label>
							<input type="file" name="first_icon" value="" id="first_icon" class="form-control" autocomplete="pdf" autofocus>
							@if( $data->first_icon !='')
								<img src="{{ URL::to('/public') }}/system/global/{{ $data->first_icon }}" width="100">
							@else 
								NA
							@endif
						</div>
						<div class="form-group">
							<label for="inputName">Content<span class="estricCls">*</span></label>
							<textarea type="text" name="first_content"  id="first_content" class="form-control ckeditor"  autocomplete="description" required autofocus >{{$data->first_content}}</textarea>
						</div>
						<div class="form-group">
								<table class="table table-bordered table-hover" id="tab_logic">
									<thead>
										<tr >
											<th class="text-center">
												#
											</th>
											<th class="text-center">
												Content
											</th>
										</tr>
									</thead>
									<tbody>
										@if($data->learn_content)
										@foreach(json_decode($data->learn_content) as $key=>$lcont)
										<tr id='addr{{$key}}'>
											<td>
											<?php echo $key+1; ?>
											</td>
											<td>
											<input type="text" name='data[{{$key}}][learn_content]' value="{{$lcont->learn_content}}" class="form-control"/>
											</td>
										</tr>
										@endforeach
										@endif
										
									</tbody>
								</table>
						</div>
						<a id="add_row" class="btn btn-default pull-left">Add Row</a><a id='delete_row' class="pull-right btn btn-default">Delete Row</a><br><br>
						<div class="form-group">
							<label for="inputName">Image<span class="estricCls">*</span></label>
							<input type="file" name="first_image" value="" id="first_image" class="form-control" autocomplete="pdf" autofocus>
							@if( $data->first_image !='')
								<img src="{{ URL::to('/public') }}/system/global/{{ $data->first_image }}" width="100">
							@else 
								NA
							@endif
						</div>
					</div>
					
					<div class="col-md-6">
					  <h3 class="card-title" style="width: 100%;color: #007bff;font-weight: bold;">Second Section</h3>
					  <div class="form-group">
							<label for="inputName">Black Title<span class="estricCls">*</span></label>
							<input type="text" name="second_black_title"  id="second_black_title" class="form-control"  autocomplete="title" value="{{$data->second_black_title}}" required autofocus>
						</div>
						<div class="form-group">
							<label for="inputName">Green Title<span class="estricCls">*</span></label>
							<input type="text" name="second_green_title"  id="second_green_title" class="form-control"  autocomplete="title" value="{{$data->second_green_title}}" required autofocus>
						</div>
						<div class="form-group">
							<label for="inputName">ICON<span class="estricCls">*</span></label>
							<input type="file" name="second_icon" value="" id="second_icon" class="form-control" autocomplete="pdf" autofocus>
							@if( $data->second_icon !='')
								<img src="{{ URL::to('/public') }}/system/global/{{ $data->second_icon }}" width="100">
							@else 
								NA
							@endif
						</div>
						<div class="form-group">
							<label for="inputName">Content<span class="estricCls">*</span></label>
							<textarea type="text" name="second_content"  id="second_content" class="form-control ckeditor"  autocomplete="description" required autofocus >{{$data->second_content}}</textarea>
						</div>
						<div class="form-group">
								<table class="table table-bordered table-hover" id="tab_logic2">
									<thead>
										<tr >
											<th class="text-center">
												#
											</th>
											<th class="text-center">
												Content
											</th>
										</tr>
									</thead>
									<tbody>
										@if($data->learn_content2)
										@foreach(json_decode($data->learn_content2) as $key=>$lcont)
										<tr id='addr2{{$key}}'>
											<td>
											<?php echo $key+1; ?>
											</td>
											<td>
											<input type="text" name='data2[{{$key}}][learn_content2]' value="{{$lcont->learn_content2}}" class="form-control"/>
											</td>
										</tr>
										@endforeach
										@endif
									</tbody>
								</table>
						</div>
						
						<a id="add_row2" class="btn btn-default pull-left">Add Row</a><a id='delete_row2' class="pull-right btn btn-default">Delete Row</a><br><br>
						<div class="form-group">
							<label for="inputName">Image<span class="estricCls">*</span></label>
							<input type="file" name="second_image" value="" id="second_image" class="form-control" autocomplete="pdf" autofocus>
							@if( $data->second_image !='')
								<img src="{{ URL::to('/public') }}/system/global/{{ $data->second_image }}" width="100">
							@else 
								NA
							@endif
						</div>
					</div>
				</div>
              <div class="form-group">
			  <input type="hidden" name="id" value="" id="id">
               <input type="submit" name="Update" class="btn btn-success">
              </div>
			</form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
       
      </div>


    </section>
    <!-- /.content -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
var i=1;
$("#add_row").click(function(){
	$('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='data["+i+"][learn_content]' type='text' class='form-control input-md'  /></td>");
	$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
	i++; 
});
;
$("#delete_row").click(function(){
	 if(i>1){
		 $("#addr"+(i-1)).html('');
		 i--;
	 }
});
var j=1
$("#add_row2").click(function(){
	$('#addr2'+j).html("<td>"+ (j+1) +"</td><td><input name='data2["+j+"][learn_content2]' type='text' class='form-control input-md'  /></td>");
	$('#tab_logic2').append('<tr id="addr2'+(j+1)+'"></tr>');
	j++; 
});
$("#delete_row2").click(function(){
	 if(j>1){
		 $("#addr2"+(j-1)).html('');
		 j--;
	 }
});
</script>
@stop