
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('forms.upload_artwork_title_step2')</div>
                <div class="panel-body">
                    @include('includes.messages')
                    <form class="form" action="/artworks/update-batch" method="post">
                      {!! csrf_field() !!}
                      @include('artworks.fields-step-2')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
