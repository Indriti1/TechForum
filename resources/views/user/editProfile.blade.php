@extends('layouts.app')



@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mt-4">
        <div class="col-12 col-sm-12 col-md-11 col-lg-10 col-xl-9">
            <div class="card">
                <div class="card-header bg-info text-white"><h4><strong>Update Profile</h4></strong></div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('profiles.update') }}" id="form">
                        @csrf

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-5">
                                    <div class="form-group row ml-0 mr-0 ml-xs-3 mr-xs-3 ml-sm-3 mr-sm-3 ml-md-3 mr-md-3 ml-lg-3 mr-lg-3 ml-xl-3 mr-xl-3">
                                        <div class="ml-3">
                                            @if(isset($user->profile->image))
                                                <img class = "img-thumbnail" src="/images/{{$user->profile->image}}" id="default" width="200" height="200" name="image">
                                            @else
                                                <img class = "img-thumbnail" src="/images/default.png" id="default" width="200" height="200" name="image">
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" autofocus>
                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-7 mt-3">
                                    <div class="form-group row ml-0 mr-0 ml-xs-3 mr-xs-3 ml-sm-3 mr-sm-3 ml-md-3 mr-md-3 ml-lg-3 mr-lg-3 ml-xl-3 mr-xl-3">
                                        <label for="location" class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-form-label"><h5>Location</h5></label>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-8">
                                            <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{old('location') ?? $user->profile->location}}" autofocus>
                                            @error('location')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row ml-0 mr-0 ml-xs-3 mr-xs-3 ml-sm-3 mr-sm-3 ml-md-3 mr-md-3 ml-lg-3 mr-lg-3 ml-xl-3 mr-xl-3">
                                        <label for="occupation" class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-form-label"><h5>Occupation</h5></label>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-8">
                                            <input id="occupation" type="text" class="form-control @error('occupation') is-invalid @enderror" name="occupation" value="{{old('occupation') ?? $user->profile->occupation}}" autofocus>
                                            @error('occupation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row ml-0 mr-0 ml-xs-3 mr-xs-3 ml-sm-3 mr-sm-3 ml-md-3 mr-md-3 ml-lg-3 mr-lg-3 ml-xl-3 mr-xl-3">
                                        <label for="specialization" class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-form-label"><h5>Specialization</h5></label>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-8">
                                            <input id="specialization" type="text" class="form-control @error('specialization') is-invalid @enderror" value="{{old('specialization') ?? $user->profile->specialization}}" name="specialization" autofocus>
                                            @error('specialization')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="form-group row ml-0 mr-0 ml-xs-3 mr-xs-3 ml-sm-3 mr-sm-3 ml-md-3 mr-md-3 ml-lg-3 mr-lg-3 ml-xl-3 mr-xl-3">
                            <label for="about" class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-form-label"><h5>About Me</h5></label>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <textarea id="about" type="text" rows="13" style="resize: none;" class="about form-control @error('about') is-invalid @enderror" name="about" autofocus>{{$user->profile->about}}</textarea>
                                @error('about')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <div class="col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7 mt-2 offset-1 offset-sm-5 offset-md-5 offset-lg-5 offset-xl-5 mt-2">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function filePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#form + img').remove();
                    $('#default').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#image").change(function () {
            filePreview(this);
        });
    </script>
</div>
@endsection