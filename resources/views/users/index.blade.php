
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('lists.customers_list_title')</div>
                <div class="panel-body table-responsive">
                    @include('includes.messages')
                    <table id="ps_table" class="table display">
                        <thead>
                            <tr>
                              <th>@lang('lists.id')</th>
                              <th>@lang('lists.name')</th>
                              <th>@lang('lists.email')</th>
                              <th>@lang('lists.mobile')</th>
                              <th>@lang('lists.role')</th>
                              <th>@lang('lists.country')</th>
                              <th>@lang('lists.city')</th>
                              <th>@lang('lists.joined_at')</th>
                              <th>@lang('lists.actions')</th>
                            </tr>
                        </thead>

                        <tbody>
                          @foreach($users as $user)
                          <tr>
                            <td>{{$user->id }}</td>
                            <td><a href="/users/{{$user->id}}">{{$user->name}}</a></td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->mobile}}</td>
                            <td>{{$user->role}}</td>
                            <td>{{$user->country}}</td>
                            <td>{{$user->city}}</td>
                            <td>{{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                            <td>
                                <div class="dropdown">
                                 <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                   @lang('lists.actions')
                                   <span class="caret"></span>
                                 </button>
                                 <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                   <li role="presentation"><a role="menuitem" tabindex="-1" href="#">First</a></li>
                                   <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="/users/{{ $user->id }}/edit" >
                                       Edit</a>
                                   </li>
                                   <li role="presentation">
                                     <a role="menuitem" tabindex="-1" onclick="javascript:confirmDelete(this);" href="/users/delete/{{ $user->id }}">Delete</a>
                                   </li>
                                 </ul>
                               </div>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.table-script')

@endsection
