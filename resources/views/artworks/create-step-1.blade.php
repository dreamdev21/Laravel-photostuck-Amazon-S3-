
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('forms.upload_artwork_title_step1')</div>
                <div class="panel-body">
                    @include('includes.messages')
                    <div class="alert alert-info" role="alert">
                      @lang('messages.upload_only_limit')
                    </div>
                    <form class="form" action="/artworks/store" method="post"
                      enctype="multipart/form-data">
                      {!! csrf_field() !!}
                      @include('artworks.fields-step-1')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
