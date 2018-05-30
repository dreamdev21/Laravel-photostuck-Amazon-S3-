
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>@lang('checkout.checkout_message_title')</h2>
            @include('includes.messages')

            <div class="price_card text-center col-md-3">
              <div class="card-header">
                @lang('checkout.total')
              </div>
              <div class="card-body">
                <h4>{{$subscription->package->name_en}}</h4>
                <hr>
                <h3><b class="color-up">{{$subscription->package->price}} @lang('checkout.sar')</b></h3>
                <h5 class="card-title">{{$subscription->package->number_of_downloads}} @lang('checkout.images')</h5>
                <h6>@lang('checkout.valid_for')
                  @if($subscription->package->isUnlimited())
                  @lang('checkout.unlimited')
                  @else
                    @lang('checkout.valid_for') {{$subscription->package->validity}} @lang('checkout.days')
                  @endif
              </h6>
                <p class="card-text">{{$subscription->package->desc_en}}</p>

              </div>
              <div class="card-footer text-muted">
                @lang('checkout.total') : {{$subscription->package->price}} @lang('checkout.sar')
              </div>
            </div>
            <div class="price_card col-md-6">
              <!-- if user is logged in show already  -->
                <div class="card-header">
                  @lang('checkout.basic_info')
                </div>
                <div class="card-body">
                  <div class="form-group">
                      <label class="control-label">@lang('checkout.name')</label>: {{$subscription->user->name}}
                  </div>

                  <div class="form-group">
                      <label class="control-label">@lang('checkout.mobile')</label>: {{$subscription->user->mobile}}
                  </div>

                  <div class="form-group">
                      <label class="control-label">@lang('checkout.email')</label>: {{$subscription->user->email}}
                  </div>
                  <div class="form-group">
                      <label class="control-label">@lang('checkout.city')</label>: {{$subscription->user->city}}
                  </div>

                  <div class="form-group">
                      <label class="control-label">@lang('checkout.payment_method')</label>: {{$subscription->payment_method}}
                  </div>
                </div>
                <div class="card-footer text-muted">
                  <a href="/home" class="btn btn-default">@lang('checkout.continue_browsing')</a>
                  <a href="/dashboard" class="btn btn-primary pull-right">@lang('dashboard.dashboard')</a>

                </div>
                </form>

              </div>

            <div class="card col-md-3">
              <div class="card-header">
                @lang('checkout.our_promise')
              </div>
              <div class="card-body">
                @lang('checkout.our_promise_body')
              </div>
              <div class="card-footer">
                @lang('checkout.our_promise_footer')
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
