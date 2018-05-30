
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('lists.subscriptions_list_title')</div>
                <div class="panel-body table-responsive">
                    @include('includes.messages')
                    <table id="ps_table" class="table display">
                        <thead>
                            <tr>
                              <th>@lang('lists.id')</th>
                              <th>@lang('lists.package')</th>
                              <th>@lang('lists.user')</th>
                              <th>@lang('lists.expiry_date')</th>
                              <th>@lang('lists.payment_method')</th>
                              <th>@lang('lists.payment_date')</th>
                              <th>@lang('lists.payment_amount')</th>
                              <th>@lang('lists.payment_reference')</th>
                              <th>@lang('lists.status')</th>
                              <th>@lang('lists.actions')</th>
                            </tr>
                        </thead>

                        <tbody>
                          @foreach($subscriptions as $subscription)
                          <tr>
                            <td>  <a href="/subscriptions/{{ $subscription->id }}">
                                {{ $subscription->id }}</a></td>
                            <td>
                              {{ $subscription->package->name_en }}
                            </td>
                            <td>
                              {{ $subscription->name_en }}
                            </td>
                            <td>{{$subscription->expiry_date }}</td>
                            <td>{{$subscription->payment_method}}</td>
                            <td>{{$subscription->payment_date }}</td>
                            <td>{{$subscription->payment_amount}}</td>
                            <td>{{$subscription->payment_reference}}</td>
                            <td>
                              @if($subscription->status == 0)
                              <span class="label label-warning">@lang('lists.pending')</span>
                              @elseif($subscription->status == 1)
                              <span class="label label-success">@lang('lists.approved')</span>
                              @elseif($subscription->status ==2)
                              <span class="label label-danger">@lang('lists.rejected')</span>
                              @endif
                            </td>

                            <td class="text-center">
                              <a href="/subscriptions/{{ $subscription->id }}" class="btn btn-primary btn-xs">
                                <i class="fa fa-eye fa-lg"></i></a>
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
