@extends('layouts.app')

@section('title', 'Welcome to Tech Forum')

@section('content')
<div class="container-fluid">
    <div class="row pt-1">
        <div class="col-12 col-sm-12 col-md-6 col-xl-7 col-lg-7 pt-xs-3 pt-sm-3 pt-md-4 pt-lg-4 pt-xl-4 pt-2 pb-2 pl-3 pr-3 ml-0 ml-sm-0 ml-md-4 ml-lg-4 ml-xl-5 bg-info text-white">
            <div>
                <h3>Welcome to TechForum</h3>
            </div>
        </div>
        <div class = "col-12 col-sm-12 col-md-5 col-xl-2 col-lg-4 pt-4 d-flex card-body bg-info text-white">
            <div class = "pr-4 pt-1 border-right"><h5><i class="fas fa-comment-alt fa-lg"> </i> {{$allTopics}}</h5></div>
            <div class = "pl-4 pr-4 pt-1 border-right"><h5><i class="fas fa-comments fa-lg"> </i> {{$allReplies}}</h5></div>
            <div class = "pl-4 pt-1"><h5><i class="fas fa-users fa-lg"> </i> {{$allUsers}}</h5></div>
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-xl-2 col-lg-6 pt-3 mr-0 ml-0 ml-sm-0 ml-xs-2 ml-md-3 ml-lg-5">
            <form name="searchForm" id="searchForm" action="/search" method="get">
                <div class="row form-group">
                    <div class="col-8 col-sm-8 col-md-8 col-xl-8 col-lg-8 input-group pr-1">
                        <input class="form-control @error('search') is-invalid @enderror" type="text" name="search" id="search" placeholder="Search">
                        @error('search')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-xl-4 col-lg-4 input-group select-input pl-0">
                        <select class="form-control" id="searchBy" name="searchBy">
                            <option value="" style="display: none;">Select</option>
                            <option value="title" selected>Titles</option>
                            <option value="user">Users</option>
                        </select>
                    </div>
                </div>
            </form>  
        </div>
    </div>
    <div class="row pt-3 mt-3">
        <div class="col-12 col-sm-12 col-md-11 col-xl-9 col-lg-8 ml-sm-0 ml-md-4 ml-xl-5 ml-0">
            <div class="row p-xs-2 p-sm-2 p-md-2 p-xl-3 p-lg-3 p-2 bg-info text-white border">
                <h5><strong>Forum Categories</strong></h5>
            </div>
            @foreach ($categories as $category)
                <div class="row">
                    <div class="col-5 col-sm-6 col-md-8 col-xl-9 col-lg-8 p-xs-3 p-sm-3 p-md-3 p-xl-3 p-1 bg-{{$category->id%2==0 ? 'white': 'muted'}} border-left border-top border-bottom">
                        <div>
                            <h5><a href="/categories/{{$category->id}}" class="text-decoration-none"><strong>{{$category->title}}</strong></a></h5>
                        </div>
                    <div>
                        <h6>{{$category->description}}</strong></h6>
                    </div>
                </div>
                <div class="col-2 col-sm-2 col-md-1 col-xl-1 col-lg-1 p-xs-3 p-sm-3 p-md-3 p-xl-3 p-1 bg-{{$category->id%2==0 ? 'white': 'muted'}} border-top border-bottom d-flex align-items-center">
                    <div>
                        <h6>{{$category->topics()->count()}} Topics</strong></h6>
                    </div>
                </div>
                <div class="col-5 col-sm-4 col-md-3 col-xl-2 col-lg-3 pt-xs-3 pt-sm-3 pt-md-4 pt-xl-4 pt-2 bg-{{$category->id%2==0 ? 'white': 'muted'}} border-top border-bottom border-right d-flex">
                    <div>
                        @if(isset($category->topics()->latest()->first()->user))
                            @if(isset($category->topics()->latest()->first()->user->profile->image))
                                <img src = "images/{{$category->topics()->latest()->first()->user->profile->image}}" alt ="" height = "30" width="30" class="border border-light rounded">
                            @else
                                <img src = "/images/default.png" alt ="" height = "30" width="30" class="border border-light rounded">
                            @endif
                        @else
                            <h6>{{''}}</strong></h6>
                        @endif 
                    </div>
                    <div class="d-flex pl-3 pt-0 pb-0 d-flex flex-column">
                        <div>
                            @if(isset($category->topics()->latest()->first()->user))
                                <h6>
                                    <a href="/profiles/{{$category->topics()->latest()->first()->user->id}}" class="text-decoration-none">
                                        {{$category->topics()->latest()->first()->user->name ?? ''}}
                                    </a>
                                </h6>
                            @else
                                <h6>{{''}}</strong></h6>
                            @endif
                        </div>
                        <div>
                            @if(isset($category->topics()->latest()->first()->created_at))
                                <h6>{{$category->topics()->latest()->first()->created_at->diffForHumans()}}</h6>
                            @else
                                <h6>{{''}}</strong></h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-12 col-sm-12 col-md-11 col-xl-2 col-lg-3 ml-0 ml-sm-0 ml-md-4 ml-xs-4 ml-xl-5">
            <div class="row p-3 bg-info text-white border">
                <h5><strong>Recent Topics</strong></h5>
            </div>
            @foreach ($latestTopics as $latestTopic)
                <div class="row">
                    <div class="col-2 col-sm-2 col-md-2 col-xl-2 col-lg-2 p-2 bg-white border-top border-bottom border-left">
                        <div>
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
                    </div>
                    <div class="col-10 col-sm-10 col-md-10 col-xl-10 col-lg-10 pt-2 pl-2 pr-2 bg-white border-top border-bottom">
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
            <div class="row p-3 mt-3 bg-info text-white border">
                <h5><strong>Latest User Joined</strong></h5>
            </div>
            <div class="row bg-white border border-left border-right border-bottom">
                <div class ="col-5 col-sm-5 col-md-5 col-xl-5 col-lg-5 p-4">
                    @if(isset($latestUser->profile->image))
                        <img src = "/images/{{$latestUser->profile->image}}" alt ="" height = "60" width="60" class="border border-light rounded">
                    @else
                        <img src = "/images/default.png" alt ="" height = "60" width="60" class="border border-light rounded">
                    @endif
                </div>
                <div class="col-5 col-sm-5 col-md-5 col-xl-5 col-lg-5 pt-4 pl-0 pr-0 bg-white">
                    <div class = "text-info pt-2">
                        <strong><h5><a href="/profiles/{{$latestUser->id}}" class="text-decoration-none">{{$latestUser->name}}</a></h5></strong>
                    </div>
                    <div>
                        <h6>{{$latestUser->created_at->diffForHumans()}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/searchEnter.js') }}"></script>
        @stack('js')
    </div>
@endsection