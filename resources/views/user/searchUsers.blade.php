@extends('layouts.app')

@section('title', 'Showing users for \''.$search.'\'')

@section('content')
<div class="container-fluid">
    <div class="row ml-0 mr-0 ml-xs-4 mr-xs-4 ml-sm-4 mr-sm-4 ml-md-4 mr-md-4 ml-lg-4 mr-lg-4 ml-xl-4 mr-xl-4">
        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-10">
            @if($userCount == 0)
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
                        <form name="searchForm" id="searchForm" action="/search" method="get">
                            <div class="form-group">
                                <div class="row input-group">
                                    <div class="col-6 col-xs-6 col-sm-5 col-md-6 col-lg-6 col-xl-7 pr-2 pl-0">
                                        <input class="form-control" type="text" name="search" id="search" placeholder="Search">
                                    </div>
                                    <div class="col-4 col-xs-4 col-sm-5 col-md-4 col-lg-4 col-xl-2 pr-2 pl-0">
                                        <select class="form-control" id="searchBy" name="searchBy">
                                            <option value="" style="display: none;">Select</option>
                                            <option value="title" @if(isset($_GET['searchBy']) && $_GET['searchBy'] == "title") selected="" @endif>Search By Titles</option>
                                            <option value="user" @if(isset($_GET['searchBy']) && $_GET['searchBy'] == "user") selected="" @endif>Search By Users</option>
                                        </select>
                                    </div>
                                    <div class="col-2 col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 pr-2 pl-0">
                                        <button type="button" class="btn btn-primary" id="searchBtn" name="searchBtn">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
                <div class="row pb-1 pt-1">
                    <div class="text-primary">
                        <h3>No results found. Try again</h3>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
                        <form name="searchForm" id="searchForm" action="/search" method="get">
                            <div class="form-group">
                                <div class="row input-group">
                                    <div class="col-6 col-xs-6 col-sm-5 col-md-6 col-lg-6 col-xl-7 pr-2 pr-2 pl-0">
                                        <input class="form-control" type="text" name="search" id="search" placeholder="Search">
                                    </div>
                                    <div class="col-4 col-xs-4 col-sm-5 col-md-4 col-lg-4 col-xl-2 pr-2 pl-0">
                                        <select class="form-control" id="searchBy" name="searchBy">
                                            <option value="" style="display: none;">Select</option>
                                            <option value="title" @if(isset($_GET['searchBy']) && $_GET['searchBy'] == "title") selected="" @endif>Search By Titles</option>
                                            <option value="user" @if(isset($_GET['searchBy']) && $_GET['searchBy'] == "user") selected="" @endif>Search By Users</option>
                                        </select>
                                    </div>
                                    <div class="col-2 col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 pr-2 pl-0">
                                        <button type="button" class="btn btn-primary" id="searchBtn" name="searchBtn">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
                <div class="row pb-1 pt-1">
                    <div class="text-primary">
                        <h3>There is/are {{$userCount}} User results for <strong>{{$search}}</strong></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex mt-2 justify-content-center">
                        {!! $users->appends($_GET)->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
                @foreach ($users as $user)
                    <div class="row pb-1 pt-1 mr-xs-0 mr-sm-0 mr-md-5 mr-lg-5 mr-xl-5">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="row d-flex align-items-center bg-white border">
                                <div>
                                    @if(isset($user->profile->image))
                                        <img src = "/images/{{$user->profile->image}}" alt ="" height = "50" width="50" class="border border-light rounded">
                                    @else
                                        <img src = "/images/default.png" alt ="" height = "50" width="50" class="border border-light rounded">
                                    @endif
                                </div>
                                <div class="pl-1 pr-1 mr-1 pl-xs-1 pr-xs-1 mr-xs-1 pl-sm-1 pr-sm-1 mr-sm-1 pl-md-4 pr-md-4 mr-md-5 pl-lg-4 pr-lg-4 mr-lg-5 pl-xl-4 pr-xl-4 mr-xl-5 pt-1 text-info">
                                    <a class="text-decoration-none" href="/profiles/{{$user->id}}"><h4>{{$user->name}}</h4></a>
                                </div>
                                <div>
                                    <div class = "pl-1 pr-1 mr-1 ml-1 pl-xs-1 pr-xs-1 mr-xs-1 ml-xs-1 pl-sm-1 pr-sm-1 mr-sm-1 ml-sm-1 pl-md-4 pr-md-4 mr-md-5 ml-md-5 pl-lg-4 pr-lg-4 mr-lg-5 ml-lg-5 pl-xl-4 pr-xl-4 mr-xl-5 ml-xl-5"><h6><strong>User Created:</strong> {{$user->created_at->diffForHumans()}}</h6></div>
                                </div>
                                <div class = "d-flex ml-0 ml-xs-0 ml-sm-0 ml-md-3 ml-lg-4 ml-xl-5">
                                    <div class = "pr-1 pr-xs-1 pr-sm-1 pr-md-4 pr-lg-4 pr-xl-4 border-right"><h6><strong>Location:</strong> {{$user->profile->location ?? ''}}</h6></div>
                                    <div class = "pr-1 pr-xs-1 pr-sm-1 pr-md-4 pr-lg-4 pr-xl-4 pl-1 pl-xs-1 pl-sm-1 pl-md-4 pl-lg-4 pl-xl-4 border-right"><h6><strong>Occupation:</strong> {{$user->profile->occupation ?? ''}}</h6></div>
                                    <div class = "pl-1 pl-xs-1 pl-sm-1 pl-md-4 pl-lg-4 pl-xl-4"><h6><strong>Specialization:</strong> {{$user->profile->specialization ?? ''}}</h6></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-12 col-xs-12 col-sm-12 col-md-11 col-lg-3 col-xl-2">
            <div class="row mt-2 mb-1">
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
                <div class="row border">
                    <div class="col-2 p-2 bg-white">
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
                    <div class="col-10 pt-2 pl-0 pr-0 bg-white border-top border-bottom">
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
    <script src="{{ asset('js/searchButton.js') }}"></script>
        @stack('js')
</div>
@endsection