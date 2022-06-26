@extends('layouts.masters')

@section('title', 'Tickets Reply')

@section('content')


@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
  
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          &nbsp;
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.posts_request') }}">Request</a></li>
            <li class="breadcrumb-item active">Tickets Reply</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
				<div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Ticket Conversation</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                            <label for="inputName">Query: </label>
                                @if($detail->query!='')
                                    {{$detail->query}}
                                @else 
                                    NA
                                @endif
                            </div>
							@if($replies)
							@foreach($replies as $reply)
							<div class="form-group">
                            <label for="inputName">@if($reply->from=='admin') You @else {{$username}} @endif: </label>
                                {{$reply->reply}}
                            </div>
							@endforeach
							@endif
                        </div>
                    </div>
				</div>

				<div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Send Reply</h3>
                        </div>
                        <div class="card-body">
							<form method="post" action="{{ route('admin.ticketReply', $detail->id) }}" enctype="multipart/form-data">
								@csrf
								<div class="form-group">
									<label for="inputStatus">Reply<span class="estricCls">*</span></label>
									<textarea name="reply" value="" id="reply" class="form-control @error('reply') is-invalid @enderror" placeholder="Enter reply" autocomplete="reply" required autofocus></textarea>
									@error('reply')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							  <div class="form-group">
								<input type="hidden" name="ticket_id" value="{{$detail->id}}">
								<input type="hidden" name="from" value="admin">
								<input type="hidden" name="user" value="user">
							   <input type="submit" name="Update" value="Reply" class="btn btn-success">
							  </div>

							</form>
                        </div>
                    </div>
				</div>

            </div>

      
        </section>
        <!-- /.content -->


@stop
