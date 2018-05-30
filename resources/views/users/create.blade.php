
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('forms.customer_title')</div>
                <div class="panel-body">
                    <div class="alert alert-info">
                      @lang('forms.customer_step1')
                    </div>
                    @include('includes.messages')
                    <form class="form" action="{{ url('/customers') }}" method="post"
                      enctype="multipart/form-data">
                      {!! csrf_field() !!}
                      @include('customers.fields')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
