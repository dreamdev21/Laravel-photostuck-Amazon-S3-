
@extends('layouts.app')

@section ('content')
<div class="container">
  @include('includes.messages')

    <div class="row">
      <div class="col-md-12">
        <a class="btn btn-sm btn-primary pull-right {{ Auth::user()->contributor()->status != 1 ? 'disabled' : ''}}"
          href="/upload-artwork" type="button">@lang('dashboard.upload')</a>
      </div>
    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('dashboard.portfolio')</div>
                <div class="panel-body table-responsive">
                    @if(empty($artworks) || count($artworks) == 0)
                    <i>@lang('messages.empty_stock')</i>
                    @else
                    @foreach($artworks as $artwork)
                    <div class="col-md-3">
                      <div class="col-md-12">
                        <div class="card">
                          <a href="/artworks/{{$artwork->slug}}">
                            <img class="thumb img-responsive img-thumbnail"  src="{{$artwork->thumb_url()}}"  alt="{{$artwork->name}}">
                          </a>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="btn-group">
                          <a class="btn btn-default btn-xs" href="/artworks/edit/{{$artwork->id}}">
                            <i class="fa fa-pencil-square-o"></i> Edit</a>
                          <a onclick="javascript:confirmThis(this);" class="btn btn-danger btn-xs" href="/artworks/delete/{{$artwork->id}}">
                            <i class="fa fa-trash-o"></i> Delete</a>
                        </div>

                        @if($artwork->status == 0)
                        <span class="pull-right label label-warning">@lang('lists.pending')</span>
                        @elseif($artwork->status == 1)
                        <span class="pull-right label label-success">@lang('lists.approved')</span>
                        @elseif($artwork->status ==2)
                        <span class="pull-right label label-danger">@lang('lists.rejected')</span>
                        @endif
                      </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  function confirmThis(element){
    var url = $(element).attr('href');
    event.preventDefault();
    confirmDelete(url);
  }
</script>
@endsection
