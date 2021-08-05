@extends('layouts.app')

@section('title', $topic->title)

@section('content')
<div class="container-fluid">
    <div class="row pt-1">
        <div class="col-12 pb-2 pl-3 ml-0 col-xs-12 pb-xs-2 pl-xs-3 ml-xs-0 col-sm-9 pb-sm-2 pl-sm-3 ml-sm-5 col-md-10 pb-md-2 pl-md-3 ml-md-5 col-lg-8 pb-lg-2 pl-lg-3 ml-lg-5 col-xl-9 pb-xl-2 pl-xl-3 ml-xl-5">
            <div class="row bg-white p-3 border rounded">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div>
                        <h3><strong>{{$topic->title}}</strong></h3>
                    </div>
                    <div>
                        @foreach ($categories as $category)
                            @if($category->id == $topic->categories_id)
                                <h5><small>By <a href="/profiles/{{$topic->user->id}}" class="text-decoration-none"> {{$topic->user->name}}</a>, {{$topic->created_at->diffForHumans()}}, in <a href="/categories/{{$category->id}}" class="text-decoration-none"> {{$category->title}}</a></small></h5>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="d-flex mt-3 justify-content-center">
                    {!! $replies->links('pagination::bootstrap-4') !!}
                </div>
            </div>
            @foreach ($replies as $reply)
                <div class="row">
                    <div class="col-12 pl-4 pt-4 pr-4 pb-4 col-xs-12 pl-xs-4 pt-xs-4 pr-xs-4 pb-xs-4 col-md-2 pl-md-4 pt-md-4 pr-md-4 pb-md-4 col-sm-12 pl-sm-4 pt-sm-4 pr-sm-4 pb-sm-4 col-lg-2 pl-lg-4 pt-lg-4 pr-lg-4 pb-lg-4 col-xl-2 pl-xl-4 pt-xl-4 pr-xl-4 pb-xl-4 text-center">
                        <div>
                            @if(isset($reply->user->profile->image))
                                <img src = "/images/{{$reply->user->profile->image}}" alt ="" height = "130" width="130" class="border border-light rounded">
                            @else
                                <img src = "/images/default.png" alt ="" height = "130" width="130" class="border border-light rounded">
                            @endif
                        </div>
                        <div>
                            <div class="pl-2 pt-3">
                                <h5><strong><a href="/profiles/{{$reply->user->id}}" class="text-decoration-none"> {{$reply->user->name}}</strong></a></h5>
                            </div>
                            @if($reply->user->isAdmin == 1)
                                <div class="pl-2">
                                    <h6 class="bg-success text-white">Admin</h6>
                                </div>
                            @elseif($reply->user->isAdmin == 0)
                                <div class="pl-2">
                                    <h6 class="bg-primary text-white">User</h6>
                                </div>
                            @endif
                            <div class="pl-2">
                                <h6>{{$reply->user->profile->location}}</h6>
                            </div>
                            <div class="pl-2">
                                <h6>{{$reply->user->profile->specialization}}</h6>
                            </div>
                            <div class="pl-2">
                                <h6>{{$reply->user->profile->occupation}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-9 ml-0 ml-xs-0 ml-sm-0 ml-md-5 ml-lg-0 ml-xl-0 col-lg-10 col-xl-10 mt-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6>{{$reply->created_at->toFormattedDateString()}}</h5>
                            </div>
                            <div class="card-body overflow-auto">
                                <h6>{!!$reply->description!!}</h5>
                            </div>
                            <div class="card-footer text-right">
                                @if(Auth::check())
                                    <script> user_id = {{Auth::user()->id}} </script>
                                    @if($reply->liked($user->id))
                                        <div id="like">
                                            @if(($reply->id != $topic->firstReply()->id) and ($reply->user_id == $user->id))
                                                <a href="{{ route('userDeleteReply', $reply->id) }}" class="btn btn-danger text-right mr-2">Delete Reply</a>
                                            @elseif(($reply->id == $topic->firstReply()->id) and ($reply->user_id == $user->id))
                                                <a href="{{ route('userDeleteTopic', $reply->topic_id) }}" class="btn btn-danger mr-2">Delete Topic</a>
                                            @endif
                                            <i id = "likeReply" class="fas fa-thumbs-up fa-lg likeReply" name="{{$reply->id}}" style="color:blue"></i>
                                            <span class="countReply">{{$reply->likeCount}} Likes</span>
                                        </div>
                                    @elseif(!$reply->liked($user->id))
                                        <div id="like">
                                            @if(($reply->id != $topic->firstReply()->id) and ($reply->user_id == $user->id))
                                                <a href="{{ route('userDeleteReply', $reply->id) }}" class="btn btn-danger text-right mr-2">Delete Reply</a>
                                            @elseif(($reply->id == $topic->firstReply()->id) and ($reply->user_id == $user->id))
                                                <a href="{{ route('userDeleteTopic', $reply->topic_id) }}" class="btn btn-danger mr-2">Delete Topic</a>
                                            @endif
                                            <i id = "likeReply" class="fas fa-thumbs-up fa-lg likeReply" name="{{$reply->id}}" style="color:black"></i>
                                            <span class="countReply">{{$reply->likeCount}} Likes</span>
                                        </div>
                                    @endif
                                @else
                                    <div id="like">
                                        <i id = "likeReply" class="fas fa-thumbs-up fa-lg likeReply" name="{{$reply->id}}" style="color:black"></i>
                                        <span class="countReply">{{$reply->likeCount}} Likes</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div>
                @if(Auth::check())
                    <form method="POST" action="{{ route('replies.store') }}">

                        @csrf

                        <div class="row pt-1 mr-1">
                            <div class = "col-12 pl-3 pr-3 pt-3 pb-0 bg-white border rounded">
                                <div class="row p-4">
                                    <div class="col-1">
                                        @if(isset($user->profile->image))
                                            <img src = "/images/{{$user->profile->image}}" alt ="" height = "75" width="75">
                                        @else
                                            <img src = "/images/default.png" alt ="" height = "75" width="75">
                                        @endif
                                    </div>
                                    <div class="form-group col-11">
                                        <input id="topic_id" class="form-control" type="hidden" value="{{$topic->id}}" name="topic_id">
                                        <input id="categories_id" class="form-control" type="hidden" value="{{$topic->categories_id}}" name="categories_id">
                                        <input id="title" type="hidden" class="form-control" value="{{$topic->title}}" name="title">
                                        <textarea id="description" type="text" rows="3" style="resize: none;" class="description form-control @error('description') is-invalid @enderror" name="description"></textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12 mb-0">
                                        <button class="btn btn-success btn-md float-right" type="submit">Post Reply</button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
        <div class="col-12 ml-0 col-xs-12 ml-xs-0 col-sm-9 ml-sm-5 col-md-10 ml-md-5 col-lg-2 ml-lg-5 col-xl-2 ml-xl-5">
            <div class="row mt-2">
                <div class="col-12">
                    <div class="row p-3 bg-info text-white">
                        <h5>Categories</h5>
                    </div>
                    <div class="row p-3 bg-white text-info border mb-2">
                        @foreach ($categories as $showCategory)
                            <div class="col-12 p-1">
                                <h6><a href="/categories/{{$showCategory->id}}" class="text-decoration-none" >{{$showCategory->title}}</a> {{$showCategory->topics->count()}}</h6>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row p-3 bg-info text-white border">
                <h5>Recent Topics</h5>
            </div>
            @foreach ($latestTopics as $latestTopic)
                <div class="row">
                    <div class="col-2 p-2 bg-white border-top border-bottom border-left">
                        @if(isset($latestTopic->user))
                            @if(isset($latestTopic->user->profile->image))
                                <img src = "/images/{{$latestTopic->user->profile->image}}" alt ="" height = "30" width="30" class="border border-light rounded">
                            @else
                                <img src = "/images/default.png" alt ="" height = "30" width="30" class="border border-light rounded">
                            @endif
                        @else
                            <h5>{{''}}</strong></h5>
                        @endif
                    </div>
                    <div class="col-10 pt-2 pl-2 pr-2 bg-white border-top border-bottom">
                        <div class = "text-info">
                            <strong><a href="/topics/{{$latestTopic->id}}" class="text-decoration-none">{{$latestTopic->title}}</a></strong>
                        </div>
                        <div>
                            By <a href="/profiles/{{$latestTopic->user->id}}" class="text-decoration-none">{{$latestTopic->user->name}}</a>, {{$latestTopic->created_at->diffForHumans()}}
                        </div>
                        <div>
                            @foreach ($categories as $category)
                                @if($category->id == $latestTopic->categories_id)
                                    <a href="/categories/{{$category->id}}" class="text-decoration-none">{{$category->title}}</a> 
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div> 
            @endforeach
        </div>
    </div>
    <script src="{{ asset('js/likeFunction.js') }}" ></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description', {
        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    </script>
    @stack('js')
</div>
@endsection
