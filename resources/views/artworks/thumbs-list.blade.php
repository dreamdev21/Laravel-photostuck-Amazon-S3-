@if(empty($artworks) || count($artworks) == 0)
<i>@lang('messages.empty_stock')</i>
@else
@foreach($artworks as $artwork)
<div class="{{$number_of_columns}} artwork-thumb">
  <div class="card" >

    <div class="col-md-12">
      <a href="/artworks/{{$artwork->slug}}">
        <img class="thumb img-responsive img-thumbnail"  src="{{$artwork->thumb_url()}}"  alt="{{$artwork->name}}">
      </a>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <span class="artwork-name">{{$artwork->name}}</span>
        </div>
      </div>
      <div class="row">
        <div  class="col-md-12">
          <span class="artwork-meta">{{$artwork->taken_in}}</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
@endif
