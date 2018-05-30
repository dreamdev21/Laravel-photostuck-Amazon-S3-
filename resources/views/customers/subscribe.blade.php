
@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>@lang('checkout.subscribe_title')</h2>
            @include('includes.messages')

              @foreach($packages as $package)
              <div class="price_card text-center col-md-4">
                <div class="card-header">
                  {{$package->name_en}}
                </div>
                <div class="card-body">
                  <b class="color-up">{{$package->price_per_image()}} @lang('checkout.sar')</b> @lang('checkout.per_image')
                  <hr>
                  <h3><b class="color-up">{{$package->price}} @lang('checkout.sar')</b></h3>
                  <h5 class="card-title">{{$package->number_of_downloads}} @lang('checkout.images')</h5>
                  <p class="card-text">{{$package->desc_en}}</p>
                  <a href="/customers/checkout/{{$package->id}}" class="btn btn-default">@lang('checkout.choose_package')</a>
                </div>
                <div class="card-footer text-muted">
                  @if($package->isUnlimited())
                    @lang('checkout.unlimited')
                  @else
                    @lang('checkout.valid_for') {{$package->validity}} @lang('checkout.days')
                  @endif
                </div>
              </div>
              @endforeach
        </div>
    </div>
</div>
@endsection
