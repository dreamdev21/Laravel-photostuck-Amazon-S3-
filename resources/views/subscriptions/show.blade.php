
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>@lang('dashboard.subscription_details')</h2>
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
                      <label class="control-label">@lang('checkout.country')</label>: {{$subscription->user->country}}
                  </div>

                  <div class="form-group">
                      <label class="control-label">@lang('checkout.city')</label>: {{$subscription->user->city}}
                  </div>

                  <div class="form-group">
                      <label class="control-label">@lang('lists.payment_method')</label>: {{$subscription->payment_method}}
                  </div>
                  <div class="form-group">
                    <label class="control-label">@lang('lists.status')</label>:

                    @if($subscription->status == 0)
                    <span class="label label-warning">@lang('lists.pending')</span>
                    @elseif($subscription->status == 1)
                    <span class="label label-success">@lang('lists.approved')</span>
                    @elseif($subscription->status ==2)
                    <span class="label label-danger">@lang('lists.canclled')</span>
                    @endif
                  </div>
                </div>
                <div class="card-footer text-muted">

                </div>
                </form>

              </div>

            <div class="card col-md-3">
              <div class="card-header">
                @lang('lists.actions')
              </div>
              <div class="card-body">
                <a href="/subscriptions/mark-as-paid/{{$subscription->id}}" onclick="confirmPayment(this);" class="btn btn-success btn-block"><li class="fa fa-money"></li> @lang('dashboard.mark_as_paid')</a>
                <a href="/subscriptions/cancel/{{$subscription->id}}" onclick="confirmCancel(this);" class="btn btn-danger btn-block"><li class="fa fa-ban"></li> @lang('dashboard.cancel')</a>
              </div>
              <div class="card-footer">
                make sure yes
              </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
function confirmCancel(element){
  var currentUrl = $(element).attr('href');
  event.preventDefault();
  swal({
    title: "Are you sure?",
    text: "You will be to undo this action.!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, cancel this order!",
    closeOnConfirm: false
  },
  function(){
    window.location.href = currentUrl;
  });
}

function confirmPayment(element){
  var currentUrl = $(element).attr('href');
  event.preventDefault();
  swal({
    title: "Are you sure?",
    text: "Make sure payment is done for this order!",
    type: "info",
    showCancelButton: true,
    confirmButtonColor: "#26a65b",
    confirmButtonText: "Confirm",
    closeOnConfirm: false
  },
  function(){
    window.location.href = currentUrl;
      /*swal("Deleted!", "Your imaginary file has been deleted.", "success");*/
  });
}

</script>
