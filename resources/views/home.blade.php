<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <title>{{ config('app.name', 'Yohkaa') }}</title>

    <!-- Styles -->
    @include('includes.inc-scripts')

    <link href="{{ asset('css/root.css') }}" rel="stylesheet">
  </head>
  <body>
  <div class="intro-image">
    <div class="container">
      <div id="header">
        @include('layouts.home-header')
      </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2 text-center ">
        		<br/>
              <form class="form" action="/search" method="get">
                <div class="input-group">
                   <input name="q" type="text" class="form-control input-lg" placeholder="{{ trans('common.search_placeholder')}}">
                   <span class="input-group-btn">
                     <button class="btn btn-default btn-lg" type="button"><i class="fa fa-search fa-lg"></i></button>
                   </span>
                 </div><!-- /input-group -->
              </form>
        	</div>
        </div>
    </div>
  </div>
  @include('layouts.footer')

</body>
</html>
