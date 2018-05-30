
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('lists.artworks_list_title')</div>
                <div class="panel-body table-responsive">
                  @include('includes.messages')

                  @if(empty($artworks) || count($artworks) == 0)
                  <i>@lang('messages.empty_stock')</i>
                  @else
                  @foreach($artworks as $artwork)
                  <div class="col-md-3">
                    <div class="col-md-12">
                      <div class="card">
                        <a href="/artworks/{{$artwork->id}}">
                          <img class="thumb img-responsive img-thumbnail"  src="{{$artwork->thumb_url()}}"  alt="{{$artwork->name}}">
                        </a>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="col-md-6">
                        @lang('lists.by') {{ $artwork->contributor->user->name }}
                      </div>
                      <div class="col-md-6">
                        @if($artwork->status == 0)
                        <span class="pull-right label label-warning">@lang('lists.pending')</span>
                        @elseif($artwork->status == 1)
                        <span class="pull-right label label-success">@lang('lists.approved')</span>
                        @elseif($artwork->status ==2)
                        <span class="pull-right label label-danger">@lang('lists.rejected')</span>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-12">

                      <div class="col-md-12">
                        <div class="dropdown " >
                         <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                           <span class="fa fa-gear"></span>
                           <span class="caret"></span>
                         </button>
                         <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" >
                           <li role="presentation"><a role="menuitem" tabindex="-1" href="/artworks/approve/{{ $artwork->id }}">Approve</a></li>
                           <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="/artworks/reject/{{ $artwork->id }}" >Reject</a>
                           </li>
                           <li role="presentation">
                             <a role="menuitem" tabindex="-1" href="/artworks/hold/{{ $artwork->id }}">Hold</a>
                           </li>
                           <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="/artworks/edit/{{$artwork->id}}" >Edit</a>
                           </li>
                           <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="/artworks/delete/{{$artwork->id}}"
                              onclick="javascript:confirmDelete(this);" class="badge label-danger">Delete</a>
                           </li>
                         </ul>
                       </div>
                      </div>

                    </div>
                  </div>
                  @endforeach
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.table-script')

@endsection
