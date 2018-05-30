
@extends('layouts.app')

@section ('content')
<div class="container">

    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('dashboard.downloads')</div>
                <div class="panel-body table-responsive">
                    @include('includes.messages')
                      @if(empty($downloads) || count($downloads) == 0)
                    <i>@lang('dashboard.empty')</i>
                    @else
                    @foreach($downloads as $download)
                    <div class="col-md-4">
                      <div class="col-md-12">
                        <div class="card">
                          <a href="/artworks/{{$download->artwork->slug}}">
                            <img class="thumb img-responsive img-thumbnail"  src="{{$download->artwork->thumb_url()}}"  alt="{{$download->artwork->name}}">
                          </a>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <a class="btn btn-success btn-block" href="/artworks/download/{{$download->artwork->id}}">
                          <i class="fa fa-download"></i> Download</a>

                      </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
