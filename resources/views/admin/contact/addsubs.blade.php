 @extends('layouts.masters')

@section('title', 'Add Subscribers')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Subscribers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.subsindex') }}">Subscribers List</a></li>
              <li class="breadcrumb-item active">Add Subscribers</li>
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
            <div class="card-header">
              <h3 class="card-title">General Details</h3>

              
            </div>
            <div class="card-body">
					<form method="post" action="{{ route('admin.sendsubsdata') }}" enctype="multipart/form-data">
            		@csrf
				  <div class="card-body p-0 m-2">

					<div class="table-responsive">
					<table class="table table-striped" id="category-table">
					
					<tr>
						<td> 
						NAME
						</td>
						<td>
							<input type="text" name="name"  id="" class="form-control" placeholder="Enter NAME" required autofocus>
						</td>	
					</tr>
					<tr>
						<td> 
						Email
						</td>
						<td>
							<input type="text" name="email"  id="" class="form-control" placeholder="Enter EMAIL" required autofocus>
						</td>	
					</tr>
          </table>
				 <div class="form-group">
               <input type="submit" name="Save" class="btn btn-success">
              </div>
          </div>
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

@stop