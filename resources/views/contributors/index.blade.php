
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('lists.contributors_list_title')</div>
                <div class="panel-body table-responsive">
                    @include('includes.messages')
                    <table id="ps_table" class="table display">
                        <thead>
                            <tr>
                              <th>@lang('lists.id')</th>
                              <th>@lang('lists.image')</th>
                              <th>@lang('lists.name')</th>
                              <th>@lang('lists.address')</th>
                              <th>@lang('lists.balance')</th>
                              <th>@lang('lists.email')</th>
                              <th>@lang('lists.status')</th>
                              <th>@lang('lists.document')</th>
                              <th>@lang('lists.actions')</th>
                            </tr>
                        </thead>

                        <tbody>
                          @foreach($contributors as $contributor)
                          <tr>
                            <td>{{ $contributor->id }}</td>
                            <td>
                              <img src="/uploads/avatar/{{ $contributor->avatar}}"
                                   style="float:left; margin-right:10px; width:50px; height:50px; ">
                            </td>
                            <td>{{ $contributor->user->name }}</td>
                            <td>{{$contributor->user->email}}</td>
                            <td>{{$contributor->balance}}</td>
                            <td>{{$contributor->address}}</td>
                            <td>
                              @if($contributor->status == 0)
                              <span class="label label-warning">@lang('lists.pending')</span>
                              @elseif($contributor->status == 1)
                              <span class="label label-success">@lang('lists.approved')</span>
                              @elseif($contributor->status ==2)
                              <span class="label label-danger">@lang('lists.rejected')</span>
                              @endif
                               |
                              <a href="/contributors/approve/{{ $contributor->id }}" class="btn btn-success btn-xs">
                                <i class="fa fa-thumbs-o-up"></i></a>
                              <a href="/contributors/reject/{{ $contributor->id }}" class="btn btn-danger btn-xs">
                                <i class="fa fa-remove"></i></a>
                              <a href="/contributors/pending/{{ $contributor->id }}" class="btn btn-warning btn-xs">
                                <i class="fa fa-eye"></i></a>
                            </td>
                            <td>
                              <a href="/uploads/docs/{{$contributor->document}}" class="btn btn-primary btn-xs">
                                <i class="fa fa-download"> Download</i>
                              </a>
                            </td>
                            <td>
                              <a href="/contributors/edit/{{ $contributor->id }}" class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil-square-o"></i></a>

                              <a onclick="javascript:confirm(this);" href="/contributors/delete/{{ $contributor->id }}" class="btn btn-danger btn-xs">
                                <i class="fa fa-trash-o"></i></a>
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
