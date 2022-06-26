@extends('layouts.masters')

@section('title', 'Courses')

@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{$active_link}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.') }}">Dashboard</a></li>

              <li class="breadcrumb-item"><a href="{{ route('admin.courses') }}">Course List</a></li>
              <li class="breadcrumb-item active">{{$active_link}}</li>
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
            <div class="card-header" style="justify-content: space-between;display: flex;">
              <h3 class="card-title">Details</h3>
<a href="{{ route('admin.courses-description-action',['type'=>'features','id'=>$courseID]) }}"><button class="btn btn-success">Add Feature</button></a>
<a href="{{ route('admin.courses-description-action',['type'=>'Admission Process','id'=>$courseID]) }}"><button class="btn btn-default">Admission Process</button></a>
<a href="{{ route('admin.courses-description-action',['type'=>'Scholarship Scheme','id'=>$courseID]) }}"><button class="btn btn-danger">Scholarship Scheme</button></a>
<a href="{{ route('admin.courses-description-action',['type'=>'Batch Calendar','id'=>$courseID]) }}"><button class="btn btn-info">Batch Calendar</button></a>
<a href="{{ route('admin.courses-description-action',['type'=>'Winning Difference','id'=>$courseID]) }}"><button class="btn btn-secondary">Winning Difference</button></a>
<a href="{{ route('admin.courses-description-action',['type'=>'faq','id'=>$courseID]) }}"><button class="btn btn-danger">FAQ</button></a>
              
            </div>
            <div class="card-body">

            	<form method="post" action="{{ route('admin.storedescription') }}" enctype="multipart/form-data">
            		@csrf
                    <input type="hidden" name="courseID" value="{{$courseID}}">
				<div class="form-group">
                <label for="courseFeatures">course Features<span class="estricCls">*</span></label>
                <textarea name="courseFeatures"  id="courseFeatures" class="ckeditor form-control @error('courseFeatures') is-invalid @enderror" autofocus>@if(isset($CourseDescription->courseFeatures)) {{$CourseDescription->courseFeatures}}@else {{ old('courseFeatures') }}@endif</textarea>
                @error('courseFeatures')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

              <div class="form-group">
                <label for="whatWeLearn">what We Learn <span class="estricCls">*</span></label>
                <textarea name="whatWeLearn"  id="whatWeLearn" class=" ckeditor form-control @error('whatWeLearn') is-invalid @enderror" autofocus>@if(isset($CourseDescription->whatWeLearn)) {{$CourseDescription->whatWeLearn}}@else {{ old('whatWeLearn') }}@endif</textarea>
                @error('whatWeLearn')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="whatWeLearnImage">Section Image <span class="estricCls">*</span></label>
                <input type="file"  name="whatWeLearnImage">
                @if(isset($CourseDescription->whatWeLearnImage))
                  <img src="{{ URL::to('/public') }}/system/courses/whatWeLearnImage/<?php echo $CourseDescription->whatWeLearnImage; ?>" width="100">
                  @endif
                @error('whatWeLearnImage')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

              <div class="form-group">
                <label for="courseDetails">course Details<span class="estricCls">*</span></label>
                <textarea name="courseDetails"  id="courseDetails" class="ckeditor form-control @error('courseDetails') is-invalid @enderror" autofocus>@if(isset($CourseDescription->courseDetails)) {{$CourseDescription->courseDetails}}@else {{ old('courseDetails') }}@endif</textarea>
                @error('courseDetails')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
			   <div class="form-group">
                <label for="courseDetailsImage">Section Image <span class="estricCls">*</span></label>
                <input type="file"  name="courseDetailsImage">
                @if(isset($CourseDescription->courseDetailsImage))
                 <img src="{{ URL::to('/public') }}/system/courses/courseDetailsImage/<?php echo $CourseDescription->courseDetailsImage; ?>" width="100">
                 @endif
                @error('courseDetailsImage')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
               <div class="form-group">
                  <label for="courseDetailsFaq">Circulam <span class="estricCls">*</span></label>
                      <div  class="field_wrapper" >
                          @if(isset($CourseDescription->courseDetailsFaq))
                          @php($answer = unserialize($CourseDescription->courseDetailsFaq)['courseDetailsFaqanswer'])
                          @foreach(unserialize($CourseDescription->courseDetailsFaq)['courseDetailsFaqquestion'] as $key => $item)
                          <div class="row ">
                                            <div class="col-md-12">
                                                <div class="controls">
                                                   
                                                    <input type="text" name="courseDetailsFaqquestion[]" class="form-control" placeholder="Question"
                                                           
                                                            value="{{$item}}">
                                                </div>
                                            </div>
                      <div class="col-md-12">
                                                <div class="controls">
                                                    
                                                          
                                                               <textarea name="courseDetailsFaqanswer[]" class="answer form-control ckeditor" >{{$answer[$key]}}</textarea>
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
                                                   
                                                    <input type="text" name="courseDetailsFaqquestion[]" class="form-control" placeholder="Question"
                                                           >
                                                </div>
                                            </div>
                      <div class="col-md-12">
                                                <div class="controls">
                                                   
                                                           <textarea name="courseDetailsFaqanswer[]" class="answer form-control ckeditor" ></textarea>
                                                </div>
                                            </div>
                    
                      </div>
                      
                      @endif
                      </div>
                       <div class="controls">
                        <button type="button" class="btn btn-success  btn-sm add_button mt-3" onclick="addeditor()">+ Add</button>
                       
                        </div>
                         @error('courseDetailsFaqquestion')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
                 @error('courseDetailsFaqanswer')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
 </div>
		
   <div class="form-group">
                <label for="courseDetailsFaq">course features list<span class="estricCls">*</span></label>
                <textarea name="course_features_list"  id="course_features_list" class="ckeditor form-control @error('course_features_list') is-invalid @enderror" autofocus>@if(isset($CourseDescription->course_features_list)) {{$CourseDescription->course_features_list}}@else {{ old('course_features_list') }}@endif</textarea>
                @error('course_features_list')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="admission_process_type">Admission Process Type<span class="estricCls">*</span></label>
                <input name="admission_process_type"  id="admission_process_type" class="form-control @error('admission_process_type') is-invalid @enderror" value="@if(isset($CourseDescription->admission_process_type)) {{$CourseDescription->admission_process_type}}@else {{ old('admission_process_type') }}@endif" autofocus>
                @error('admission_process_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="admission_process_subtitle">Admission Process Subtitle<span class="estricCls">*</span></label>
                <textarea name="admission_process_subtitle"  id="admission_process_subtitle" class="ckeditor form-control @error('admission_process_subtitle') is-invalid @enderror" autofocus>@if(isset($CourseDescription->admission_process_subtitle)) {{$CourseDescription->admission_process_subtitle}}@else {{ old('admission_process_subtitle') }}@endif</textarea>
                @error('admission_process_subtitle')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                <label for="fees">fees <span class="estricCls">*</span></label>
                <textarea name="fees"  id="fees" class="ckeditor form-control @error('fees') is-invalid @enderror" autofocus>@if(isset($CourseDescription->fees )) {{$CourseDescription->fees }}@else {{ old('fees') }}@endif</textarea>
                @error('fees')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
              <div class="form-group">
                  <label for="faq">FAQ <span class="estricCls">*</span></label>
                      <div  class="field_wrapper" >
                          @if(isset($CourseDescription->faq))
                          @php($answer = unserialize($CourseDescription->faq)['answer'])
                          @foreach(unserialize($CourseDescription->faq)['question'] as $key => $item)
                          <div class="row ">
                                            <div class="col-md-12">
                                                <div class="controls">
                                                   
                                                    <input type="text" name="question[]" class="form-control" placeholder="Question"
                                                           
                                                            value="{{$item}}">
                                                </div>
                                            </div>
                      <div class="col-md-12 mt-3">
                                                <div class="controls">
                                                    
                                                          
                                                               <textarea name="answer[]" class="answer form-control ckeditor" >{{$answer[$key]}}</textarea>
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
                                                           >
                                                </div>
                                            </div>
                      <div class="col-md-12 mt-3" >
                                                <div class="controls">
                                                   
                                                           <textarea name="answer[]" class="answer form-control ckeditor" placeholder="answer" ></textarea>
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
                <label for="scholarship">scholarship<span class="estricCls">*</span></label>
                <textarea name="scholarship"  id="scholarship" class="ckeditor form-control @error('scholarship') is-invalid @enderror" autofocus>@if(isset($CourseDescription->scholarship)) {{$CourseDescription->scholarship}}@else {{ old('scholarship') }}@endif</textarea>
                @error('scholarship')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>

<div class="form-group">
                <label for="placement">Placement<span class="estricCls">*</span></label>
                <textarea name="placement"  id="placement" class="ckeditor form-control @error('placement') is-invalid @enderror" autofocus>@if(isset($CourseDescription->placement)) {{$CourseDescription->placement}}@else {{ old('placement') }}@endif</textarea>
                @error('placement')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
              </div>
                <div class="form-group">
                <label for="placementImage">Section Image <span class="estricCls">*</span></label>
                <input type="file"  name="placementImage">
                 @if(isset($CourseDescription->placementImage))
                   <img src="{{ URL::to('/public') }}/system/courses/placementImage/<?php echo $CourseDescription->placementImage; ?>" width="100">
                   @endif
                @error('placementImage')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
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
<style>
    .row{
        margin-top: 20px;
    }
</style>
@stop