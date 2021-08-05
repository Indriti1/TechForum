@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-1 ml-0 ml-xs-0 ml-sm-0 ml-md-0 ml-lg-0 ml-xl-0">
            @if(!isset($user->profile->image))
                <img src = "/images/default.png" alt ="" height = "140" width="140" class="border border-light rounded">
            @else
                <img src = "/images/{{$user->profile->image}}" alt ="" height = "140" width="140" class="border border-light rounded">
            @endif
        </div>
        <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-4 col-xl-3 ml-0 ml-xs-0 ml-sm-2 ml-md-5 ml-lg-2 ml-xl-2">
            <div class = "card">
                <div class = "pt-3 card-header bg-info text-white"><h4>{{$user->name}}</h4></div>
                <div class = "pt-4 d-flex card-body">
                    <div class = "pr-4 pt-1 border-right"><h6><strong>Joined:</strong> {{$user->created_at->toFormattedDateString()}}</h6></div>
                    <div class = "pl-4 pr-4 pt-1 border-right"><h6><strong>Topics:</strong> {{$topics->count()}}</h6></div>
                    <div class = "pl-4 pt-1"><h6><strong>Replies:</strong> {{$replies->count()}}</h6></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 ml-0 ml-xs-0 ml-sm-2 ml-md-2 ml-lg-2 ml-xl-2">
            <div class = "card">
                <div class = "pt-3 card-header bg-info text-white"><h4>Profile Info</h4></div>
                <div class = "pt-4 d-flex card-body">
                    <div class = "pr-1 pt-1 pr-xs-1 pt-xs-1 pr-sm-4 pt-sm-1 pr-md-4 pt-md-1 pr-lg-4 pt-lg-1 pr-xl-4 pt-xl-1 border-right"><h6><strong>Location:</strong> {{$user->profile->location ?? ''}}</h6></div>
                    <div class = "pl-1 pr-1 pt-1 pl-xs-1 pr-xs-1 pt-xs-1 pl-sm-4 pr-sm-4 pt-sm-1 pl-md-4 pr-md-4 pt-md-1 pl-lg-4 pr-lg-4 pt-lg-1 pl-xl-4 pr-xl-4 pt-xl-1 border-right"><h6><strong>Occupation:</strong> {{$user->profile->occupation ?? ''}}</h6></div>
                    <div class = "pl-1 pt-1 pl-xs-1 pt-xs-1 pl-sm-4 pt-sm-1 pl-md-4 pt-md-1 pl-lg-4 pt-lg-1 pl-xl-4 pt-xl-1"><h6><strong>Specialization:</strong> {{$user->profile->specialization ?? ''}}</h6></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pt-5 justify-content-center">
        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11 col-xl-9 p-3 bg-info text-white border rounded-top">
            <div>
                <h4>About Me</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11 col-xl-9 p-3 bg-white border rounded-bottom" style="height: 150px;">
            <div>
                <h6>{{$user->profile->about}}</h6>
            </div>
        </div>
    </div>
    
    
    <div class="row pt-5 justify-content-center">
        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11 col-xl-9 p-3 bg-info text-white border">
            <div>
                <h4>{{$user->name}}'s Latest Topics</h4>
            </div>
        </div>
    </div>
    
    @foreach($topics as $topic)
        <div class="row justify-content-center">
            <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7 p-3 bg-white border-top border-bottom border-left">
                <div>
                    <h6><a href="/profiles/{{$user->id}}" class="text-decoration-none">{{$user->name}}</a> created new topic: <strong><a href="/topics/{{$topic->id}}" class="text-decoration-none">{{$topic->title}}</a></strong></h6>
                </div>
                <div class="pt-0">
                    <h6>{{\Carbon\Carbon::parse($topic->created_at)->diffForHumans()}}</h6>
                </div>
            </div>
            <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-4 col-xl-2 pt-3 bg-white border-top border-bottom border-right d-flex">
                <div>
                    @if(isset($user->id))
                        @if(isset($user->profile->image))
                            <img src = "/images/{{$user->profile->image}}" alt ="" height = "40" width="40" class="border border-light rounded">
                        @else
                            <img src = "/images/default.png" alt ="" height = "40" width="40" class="border border-light rounded">
                        @endif
                    @endif
                </div>
                <div class="d-flex pl-3 pt-0 pb-0 d-flex flex-column">
                    <div>
                        <h6>From <a href="/profiles/{{$user->id}}" class="text-decoration-none">{{$user->name}}</a></h6>
                    </div>
                    <div>
                        <h6>{{\Carbon\Carbon::parse($topic->created_at)->diffForHumans()}}</h6>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="row pt-5 justify-content-center">
        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11 col-xl-9 p-3 bg-info text-white border">
            <div>
                <h4>{{$user->name}}'s Latest Replies</h4>
            </div>
        </div>
    </div>
    
    @foreach ($replies as $reply)
        <div class="row justify-content-center">
            <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7 p-3 bg-white border-top border-bottom border-left">
                <div>
                    <h6><a href="/profiles/{{$user->id}}" class="text-decoration-none">{{$user->name}}</a> replied to topic: <strong><a href="/topics/{{$reply->id}}" class="text-decoration-none">{{$reply->title}}</a></strong></h6>
                </div>
                <div class="pt-0">
                    <h6>{{\Carbon\Carbon::parse($reply->created_at)->diffForHumans()}}</h6>
                </div>
            </div>
            <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-4 col-xl-2 pt-3 bg-white border-top border-bottom border-right d-flex">
                <div>
                    @if(isset($user->id))
                        @if(isset($user->profile->image))
                            <img src = "/images/{{$user->profile->image}}" alt ="" height = "40" width="40" class="border border-light rounded">
                        @else
                            <img src = "/images/default.png" alt ="" height = "40" width="40" class="border border-light rounded">
                        @endif
                    @endif
                </div>
                <div class="d-flex pl-3 pt-0 pb-0 d-flex flex-column">
                    <div>
                        <h6>From <a href="/profiles/{{$user->id}}" class="text-decoration-none">{{$user->name}}</a></h6>
                    </div>
                    <div>
                        <h6>{{\Carbon\Carbon::parse($reply->created_at)->diffForHumans()}}</h6>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
