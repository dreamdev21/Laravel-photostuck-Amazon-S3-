
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('forms.contribute_title')</div>
                <div class="panel-body">
                    @include('includes.messages')
                    <form class="form" action="{{ url('/contributors/update') }}" method="post">
                      {!! csrf_field() !!}
                      @include('contributors.fields')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
