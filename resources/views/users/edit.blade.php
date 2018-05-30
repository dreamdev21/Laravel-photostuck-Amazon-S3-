
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('forms.users_title')</div>
                <div class="panel-body">
                    @include('includes.messages')
                    <form class="form" action="/users/update" method="post">
                      {!! csrf_field() !!}
                      <input type="hidden" name="id" value="{{$user->id}}">
                      @include('users.fields')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
