@extends('layouts.app')

@section('title', 'Create New Topic')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mt-0 mt-xs-0 mt-sm-0 mt-md-4 mt-lg-4 mt-xl-4">
        <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-9">
            <div class="card">
                <div class="card-header bg-info text-white"><h4><strong>New Topic</h4></strong></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('topics.store') }}">
                        @csrf

                        <div class="form-group row ml-0 mr-0 ml-sm-3 mr-sm-3 ml-md-3 mr-md-3 ml-lg-3 mr-lg-3 ml-xl-3 mr-xl-3">
                            <label for="category" class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 col-form-label"><h5>Category</h5></label>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <select id="category"class="form-control" name="category" autofocus>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row ml-0 mr-0 ml-sm-3 mr-sm-3 ml-md-3 mr-md-3 ml-lg-3 mr-lg-3 ml-xl-3 mr-xl-3">
                            <label for="title" class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 col-form-label"><h5>Topic Title</h5></label>
                            <div class="col-12 col-sm-12 col-md-12">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" autofocus>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row ml-0 mr-0 ml-sm-3 mr-sm-3 ml-md-3 mr-md-3 ml-lg-3 mr-lg-3 ml-xl-3 mr-xl-3">
                            <label for="description" class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label"><h5>Description</h5></label>
                            <div class="col-md-12">
                                <textarea id="description" type="text" rows="13" style="resize: none;" class="description form-control @error('description') is-invalid @enderror" name="description" autofocus></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <div class="col-6 col-sm-7 col-md-7 col-lg-7 col-xl-7 mt-2 offset-1 offset-sm-5 offset-md-5 offset-lg-5 offset-xl-5">
                                <button type="submit" class="btn btn-primary">Create Topic</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('description', {
    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});
</script>
@endsection