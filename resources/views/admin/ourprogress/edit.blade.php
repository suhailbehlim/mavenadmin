 @extends('layouts.masters')

@section('title', 'Our Progress')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Our Progress</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

             
              <li class="breadcrumb-item active">Edit Our Progress</li>
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

              <form method="post" action="{{ route('admin.update-progress') }}" enctype="multipart/form-data">
                @csrf

            
        
              <div class="form-group">
                <label for="title">title</label>
            
                  <input name="title" id="title" class="form-control custom-select" type="text" value="{{ $testoInfo->title}}" placeholder="Enter title" autocomplete="type"  autofocus>
   
              </div>
              <div class="form-group">
                <label for="subtitle">subtitle</label>
            
                  <input name="subtitle" id="subtitle" class="form-control custom-select" type="text" value="{{ $testoInfo->subtitle}}" placeholder="Enter subtitle" autocomplete="type"  autofocus>
   
              </div>
             
             

              <div class="form-group">
                <label for="inputName">Image</label>
                <input type="file" name="image"  id="image" class="form-control">
                 <img src="{{$testoInfo->image }}" width="100">
              </div>
             
               <div class="form-group">
                  <label for="faq">FAQ <span class="estricCls">*</span></label>
                      <div  class="field_wrapper" >
                          @if(isset($testoInfo->faq))
                          @php($answer = unserialize($testoInfo->faq)['answer'])
                          @foreach(unserialize($testoInfo->faq)['question'] as $key => $item)
                          <div class="row ">
                                            <div class="col-md-12">
                                                <div class="controls">
                                                   
                                                    <input type="text" name="question[]" class="form-control" placeholder="Question"
                                                           required
                                                            value="{{$item}}">
                                                </div>
                                            </div>
                      <div class="col-md-12 mt-3">
                                                <div class="controls">
                                                    
                                                          
                                                               <textarea name="answer[]" class="answer form-control ckeditor" required>{{$answer[$key]}}</textarea>
                                                </div>
                                            </div>
                      @if($key >0)
                      <div class="col-md-2"><div class="controls"><button class="remove_button"> Remove</button></div> </div>
                      @endif
                      </div>  
                      @endforeach
                      @else
                         <div class="row ">
                                            <div class="col-md-12">
                                                <div class="controls">
                                                   
                                                    <input type="text" name="question[]" class="form-control" placeholder="Question"
                                                           required>
                                                </div>
                                            </div>
                      <div class="col-md-12 mt-3" >
                                                <div class="controls">
                                                   
                                                           <textarea name="answer[]" class="answer form-control ckeditor" placeholder="answer" required></textarea>
                                                </div>
                                            </div>
                    
                      </div>
                      
                      @endif
                      </div>
                       <div class="controls">
                        <button type="button" class="btn btn-success  btn-sm addButtonprogress mt-3" onclick="addeditorprogress()">+ Add</button>
                       
                        </div>
                         @error('question')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
                 @error('answer')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
 </div>

  <div class="form-group">
                <label for="student_count">Student Count</label>
            
                  <input name="student_count" id="student_count" class="form-control custom-select" type="number" value="{{ $testoInfo->student_count}}" placeholder="Enter Student Count" autocomplete="type"  autofocus>
   
              </div>
               <div class="form-group">
                <label for="courses_count">Courses Count</label>
            
                  <input name="courses_count" id="courses_count" class="form-control custom-select" type="number" value="{{ $testoInfo->courses_count}}" placeholder="Enter Courses Count" autocomplete="type"  autofocus>
   
              </div>
               <div class="form-group">
                <label for="years_count">Years Count</label>
            
                  <input name="years_count" id="years_count" class="form-control custom-select" type="number" value="{{ $testoInfo->years_count}}" placeholder="Enter Years Count" autocomplete="type"  autofocus>
   
              </div>
               <div class="form-group">
                <label for="instructors_count">Instructors Count</label>
            
                  <input name="instructors_count" id="instructors_count" class="form-control custom-select" type="number" value="{{ $testoInfo->instructors_count}}" placeholder="Enter Instructors Count" autocomplete="type"  autofocus>
   
              </div>
               <div class="form-group">
                <label for="satisfaction_count">Satisfaction Count</label>
            
                  <input name="satisfaction_count" id="satisfaction_count" class="form-control custom-select" type="number" value="{{ $testoInfo->satisfaction_count}}" placeholder="Enter Satisfaction Count" autocomplete="type"  autofocus>
   
              </div>
              <div class="form-group">
                <label for="hrs_of_video">Hrs of Video</label>
            
                  <input name="hrs_of_video" id="hrs_of_video" class="form-control custom-select" type="number" value="{{ $testoInfo->hrs_of_video}}" placeholder="Enter Hrs of Video" autocomplete="type"  autofocus>
   
              </div>
             
              <div class="form-group">
               <input type="submit" name="Save" class="btn btn-success">
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