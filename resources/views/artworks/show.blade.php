
@extends('layouts.app')

@section ('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4>{{$artwork->name}}</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      @include('includes.messages')

      <div class="col-md-6 single-image-preview">
        <img src="{{$artwork->medium_url()}}" class="img-responsive img-thumbnail">
      </div>
      <div class="col-md-6">
          <div class="list-group" >
            @if(Auth::check() && Auth::user()->can('customer') && Auth::user()->artworkExists($artwork->id))
              <a href="/artworks/download/{{$artwork->id}}" class="btn btn-success download">
                <h4 class="list-group-item-heading">@lang('single.download')</h4>
                <p class="list-group-item-text">@lang('single.download_desc_with_credit')</p>
              </a>
            @elseif(Auth::check() && Auth::user()->can('customer') &&Auth::user()->credit && Auth::user()->credit->current_credit > 0)
              <a href="/artworks/add-to-mydownloads/{{$artwork->id}}" class="btn btn-primary download">
                <h4 class="list-group-item-heading">@lang('single.added_to_mydownloads')</h4>
                <p class="list-group-item-text">@lang('single.added_to_mydownloads_desc')</p>
              </a>
            @else
            <a href="/customers/checkout/2" class="btn btn-primary download">
              <h4 class="list-group-item-heading">@lang('single.download')</h4>
              <p class="list-group-item-text">{{trans('single.download_desc',  ['price' => $artwork->lowestSinglePrice])}}</p>
            </a>
            <a href="/customers/subscribe/multiple" class="btn btn-default download">
              <h4 class="list-group-item-heading">@lang('single.buy')</h4>
              <p class="list-group-item-text">{{trans('single.buy_desc' , ['price' => $artwork->lowestMultiplePrice])}}</p>
            </a>
            @endif
          </div>

          <hr>
          <div class="card mb-3">

          </div>
          <h5><b>@lang('single.credit'): </b><a href="/contributors/{{$artwork->contributor->id}}">{{$artwork->contributor->user->name}}</a></h5>
          <h5>{{$artwork->description}}</h6>
          <hr>
          <!--<h5>@lang('forms.taken_at'): <small>{{$artwork->taken_at}}</small></h5>
          <h5>@lang('forms.taken_in'): <small>{{$artwork->taken_in}}</small></h5>-->
          <h5>@lang('forms.created_at'): <small>{{$artwork->created_at}}</small></h5>
          <h5>@lang('forms.filesize'): <small>{{$artwork->filesize}}</small></h5>
          <h5>@lang('forms.mimetype'): <small>{{$artwork->mimetype}}</small></h5>
          @foreach($artwork->tags as $tag)
            <a href="/search/?q={{$tag}}" class="label label-primary">{{$tag}}</a>
          @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
