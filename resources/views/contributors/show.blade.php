
@extends('layouts.app')

@section ('content')
<div class="container">

  <div class="row">
    <div class="col-md-12">
      @include('includes.messages')
        <div class="col-md-12">
          <h1>{{ $contributor->user->name }}</h1>
          <hr>
        </div>
      <div class="col-md-4 contributor-info">
        <div class="row">
          <div class="col-md-12">

          </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="col-md-4">
                      <img src="/uploads/avatar/{{ $contributor->avatar }}" class="img-responsive avatar" width="100" height="100">
                  </div>
                  <div class="col-md-8">
                      {{html_entity_decode($contributor->bio)}}
                  </div>
                </div>
                <div class="panel-footer">
                  @lang('forms.joined_at') <b>{{ Carbon\Carbon::parse($contributor->created_at)->diffForHumans()}}</b>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="list-group" >
                <a href="#" class="btn btn-default btn-block">
                  <h4 class="list-group-item-heading">@lang('single.contact_me')</h4>
                  <p class="list-group-item-text">@lang('single.hire_me_desc')</p>
                </a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <a href="#" class="btn btn-default"><i class="fab fa-twitter fa-large"></i></a>
            <a href="#" class="btn btn-default"><i class="fab fa-facebook"></i></a>
            <a href="#" class="btn btn-default"><i class="fab fa-instagram"></i></a>
            <a href="#" class="btn btn-default"><i class="fab fa-snapchat"></i></a>
            <a href="#" class="btn btn-default"><i class="fab fa-twitter"></i></a>
          </div>
        </div>


      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
            @include('artworks.thumbs-list' ,  array('number_of_columns' => 'col-md-4'))
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
