@extends('layouts.app')

@section('title', $category->title)

@section('content')
<div class="container-fluid">
    <div class="row ml-xs-0 ml-0 ml-sm-0 ml-md-3 ml-lg-4 ml-xl-5">
        <div class="col-11 col-xs-12 col-sm-12 col-md-11 col-lg-8 col-xl-9">
            <div class="row p-3 bg-info text-white border">
                <div class="col-12 col-xs-12 col-sm-4 col-md-6 col-lg-6 col-xl-9 pt-3 pl-1 pb-1 pr-1">
                    <h5><strong>{{$category->title}} Topics</strong></h5>
                </div>
                <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-3 col-xl-2 pr-2 pt-1">
                    <form name="sortTopicsForm" id="sortTopicsForm">
                        <div class="form-group">
                            <select class="form-control form-control-md" name="sortTopics" id="sortTopics">
                                <option value="" style="display: none;">Select</option>
                                <option value="recentTopics" @if(isset($_GET['sortTopics']) && $_GET['sortTopics'] == "recentTopics") selected="" @endif>Recent Topics</option>
                                <option value="oldestTopics" @if(isset($_GET['sortTopics']) && $_GET['sortTopics'] == "oldestTopics") selected="" @endif>Oldest Topics</option>
                                <option value="titleA-Z" @if(isset($_GET['sortTopics']) && $_GET['sortTopics'] == "titleA-Z") selected="" @endif>Title A-Z</option>
                                <option value="titleZ-A" @if(isset($_GET['sortTopics']) && $_GET['sortTopics'] == "titleZ-A") selected="" @endif>Title Z-A</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-3 col-xl-1 pr-1 pt-1">
                    <a class="btn btn-success" href="{{ route('topics.create') }}" role="button">Post Topic</a>
                </div>
            </div>
            <div class="row">
                <div class="d-flex mt-3 justify-content-center">
                    {!! $topics->appends($_GET)->links('pagination::bootstrap-4') !!}
                </div>
            </div>
            @foreach ($topics as $topic)
                <div class="row">
                    <div class="col-5 col-sm-6 col-md-7 col-lg-7 col-xl-8 p-xs-1 p-1 p-sm-2 p-lg-3 p-xl-3 bg-white border-top border-bottom border-left">
                        <div>
                            <h6><strong><a href="/topics/{{$topic->id}}">{{$topic->title}}</a></strong></h6>
                        </div>
                        <div>
                            <h6>By <a href="/profiles/{{$topic->user->id}}"> {{$topic->user->name}}</a>, {{$topic->created_at->diffForHumans()}}</h6>
                        </div>
                    </div>
                    <div class="col-7 col-sm-6 col-md-5 col-lg-5 col-xl-4 pl-0 pl-xs-0 pl-sm-0 pl-md-1 pl-lg-2 pl-xl-3 pt-4 bg-white border-top border-bottom border-right d-flex">
                        <div>
                            <h5 class="count">{{$topic->firstReply()->likeCount}}  <i id = "like" class="fas fa-thumbs-up fa-md" name="like" style="color:#5bc0de"></i></h5>  
                        </div>
                        <div class="pl-3 pr-1 pr-xs-1 pr-sm-1 pr-md-3 pr-lg-4 pr-xl-5">
                            <h5>{{$topic->replies_count - 1}}  <i id = "reply" class="fas fa-comments fa-md" name="reply" style="color:#5bc0de"></i></h5> 
                        </div>
                        <div class="pl-1 pl-xs-1 pl-sm-1 pl-md-3 pl-lg-4 pl-xl-5">
                            @if(isset($topic->user))
                                @if(isset($topic->user->profile->image))
                                    <img src = "/images/{{$topic->user->profile->image}}" alt ="" height = "30" width="30" class="border border-light rounded">
                                @else
                                    <img src = "/images/default.png" alt ="" height = "30" width="30" class="border border-light rounded">
                                @endif
                            @else
                            <h5>{{''}}</strong></h5>
                        @endif 
                        </div>
                        <div class="d-flex pl-3 pt-0 pb-0 d-flex flex-column">
                            <div>
                                <h6><a href="/profiles/{{$topic->user->id}}"> {{$topic->user->name}}</a></h6>
                            </div>
                            <div>
                                <h6>{{$topic->created_at->diffForHumans()}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-11 col-xs-12 col-sm-12 col-md-11 col-lg-3 col-xl-2 ml-0 ml-sm-0 ml-md-0 ml-lg-4 ml-xl-5 mt-2 mt-xs-2 mt-sm-2 mt-md-2 mt-lg-0 mt-xl-0">
            <form name="searchForm" id="searchForm" action="/search" method="get">
                <div class="row form-group mb-3 pb-1">
                    <div class="col-8 col-lg-7 input-group pl-0 pr-1">
                        <input class="form-control @error('search') is-invalid @enderror" type="text" name="search" id="search" placeholder="Search">
                        @error('search')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-4 col-lg-5 input-group select-input pl-0 pr-0">
                        <select class="form-control" id="searchBy" name="searchBy">
                            <option value="" style="display: none;">Select</option>
                            <option value="title" selected>Titles</option>
                            <option value="user">Users</option>
                        </select>
                    </div>
                </div>
            </form> 
            <div class="row p-2 mt-3 pt-2 bg-info text-white border mb-2">
                <div class="col-12 text-center p-2">
                    <h5><strong>{{$category->title}} Statistics</strong></h5>
                </div>
                <div class="col-4 text-center">
                    <i class="fas fa-comment-alt fa-lg"> </i> 
                    <h6>Topics</h6>
                    <h6>{{$topicsCount}}</h6>
                </div>
                <div class="col-4 text-center">
                    <i class="fas fa-comments fa-lg"> </i> 
                    <h6>Replies</h6>
                    <h6>{{$repliesCount}}</h6>
                </div>
                <div class="col-4 text-center">
                    <i class="fas fa-users fa-lg"> </i>
                    <h6>Users</h6>
                    <h6>{{$usersCount}}</h6>
                </div>
            </div>
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
                    <div class="col-10 pt-2 pl-2 pr-2 bg-white border-top border-bottom border-right">
                        <div class = "text-info">
                            <a href="/topics/{{$latestTopic->id}}"><strong>{{$latestTopic->title}}</strong></a>
                        </div>
                        <div>
                            By <a href="/profiles/{{$latestTopic->user->id}}">{{$latestTopic->user->name}}</a>, {{$latestTopic->created_at->diffForHumans()}}
                        </div>
                        <div>
                            @foreach ($categories as $aCategory)
                                @if($aCategory->id == $latestTopic->categories_id)
                                    {{$aCategory->title}} 
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div> 
            @endforeach
        </div>
    </div>
    <script src="{{ asset('js/sort.js') }}"></script>
    <script src="{{ asset('js/searchEnter.js') }}"></script>
    @stack('js')
</div>
@endsection
