
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('forms.change_password')</div>
                <div class="panel-body">
                    @include('includes.messages')
                    <form class="form" action="/change-password" method="post">
                      {!! csrf_field() !!}
                      <div class="form-group">
                        <label for="old_password">@lang('forms.old_password')</label>
                        <input type="password" name="old_password" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="password">@lang('forms.new_password')</label>
                        <input type="password" name="password" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="password_confirmation">@lang('forms.confirm_password')</label>
                        <input type="password" name="password_confirmation" class="form-control">
                      </div>
                      <div class="form-group">
                        <button type="submit" name="button" class="btn btn-primary pull-right">@lang('forms.change_password')</button>
                      </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
