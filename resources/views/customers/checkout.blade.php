
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>@lang('checkout.checkout_title')</h2>
            @include('includes.messages')

            <div class="price_card text-center col-md-3">
              <div class="card-header">
                @lang('checkout.total')
              </div>
              <div class="card-body">
                <h4>{{$package->name_en}}</h4>
                <hr>
                <h3><b class="color-up">{{$package->price}} @lang('checkout.sar')</b></h3>
                <h5 class="card-title">{{$package->number_of_downloads}} @lang('checkout.images')</h5>
                <h6>@lang('checkout.valid_for')
                  @if($package->isUnlimited())
                  @lang('checkout.unlimited')
                  @else
                    @lang('checkout.valid_for') {{$package->validity}} @lang('checkout.days')
                  @endif
              </h6>
                <p class="card-text">{{$package->desc_en}}</p>

              </div>
              <div class="card-footer text-muted">
                @lang('checkout.total') : {{$package->price}} @lang('checkout.sar')
              </div>
            </div>
            <div class="price_card col-md-6">

            <form class="form" action="{{ url('/customers/checkout') }}" method="post">
              {!! csrf_field() !!}
              <input type="hidden" name="package_id" value="{{$package->id}}">
              <input type="hidden" name="user_id" value="{{$user->id}}">

              <!-- if user is logged in show already  -->
                <div class="card-header">
                  @lang('checkout.basic_info')
                </div>
                <div class="card-body">
                  @if(Auth::check())
                  <span>Logged in</span>
                  @else
                  <span>If you already have an account, please <a href="/login">Login</a></span>
                  @endif
                  <hr>
                  <div class="form-group">
                      <label class="control-label">@lang('checkout.name')</label>
                      <input type="text" class="form-control" name="name" value="{{ old('name', $user->name)}}">
                  </div>

                  <div class="form-group">
                      <label class="control-label">@lang('checkout.mobile')</label>
                      <input type="text" class="form-control"  name="mobile" value="{{ old('mobile', $user->mobile)}}">
                  </div>

                  <div class="form-group">
                      <label class="control-label">@lang('checkout.email')</label>
                      <input type="text" class="form-control" name="email" value="{{ old('email', $user->email)}}">
                  </div>

                  <div class="form-group">
                      <label class="control-label">@lang('checkout.city')</label>
                      <input id="typeahead" type="text" class="form-control" name="city" value="{{ old('city', $user->city)}}" >
                  </div>

                  <div class="form-group">
                    <div class="list-group" >
                      <input id="payment_method" type="hidden" name="payment_method" value="bank">
                      <a id="bank" href="javascript:changePaymentMethodValue('bank',this)" class="active list-group-item text-center" data-toggle="list" role="tab">
                        <i class="fa fa-credit-card-alt fa-2x"></i>
                        <h4 class="list-group-item-heading">@lang('checkout.bank_payment')</h4>
                        <p class="list-group-item-text">@lang('checkout.bank_payment_desc')</p>
                      </a>
                      <a id="paytabs" href="javascript:changePaymentMethodValue('paytabs',this)" class="list-group-item text-center " data-toggle="list" role="tab">
                        <i class="fa fa-bank fa-2x"></i>
                        <h4 class="list-group-item-heading">@lang('checkout.paytabs')</h4>
                        <p class="list-group-item-text">@lang('checkout.paytabs_desc')</p>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-muted">
                  <a href="#" class="btn btn-default">@lang('checkout.cancel')</a>
                  <button type="submit" name="button" class="btn btn-primary pull-right">@lang('checkout.confirm')</button>
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

<script type="text/javascript">
  function changePaymentMethodValue(value){
    $('#bank').removeClass('active') ;
    $('#paytabs').removeClass('active') ;
    if(value == 'paytabs'){
      $('#paytabs').addClass('active') ;
    }else{
      $('#bank').addClass('active') ;
    }

    jQuery('#payment_method').val(value);
  }

  $(document).ready(function() {
    $("input[id=typeahead]").each(function() {
      console.log(this);
      applyTypeahead(this);
    });
  });
  function applyTypeahead(element){
    $(element).typeahead({
        minLength: 3,
        source:  function (query, process) {
            return $.ajax({
                url: "http://gd.geobytes.com/AutoCompleteCity?callback=?&q=" + $(element).val(),
                jsonp: "callback",
                dataType: "jsonp",
                data: {
                    //q: "select title,abstract,url from search.news where query",
                    format: "json"
                },
                success: function( response ) {
                    if(response == '%s'){
                      return null;
                    }
                    return process(response);
                }
            });
        }
    });
  }
</script>

@endsection
