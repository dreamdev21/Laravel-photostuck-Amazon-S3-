<div class="row">
    <div class="col-md-12">
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    @if(session('errors'))
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $oneerror)
            <li>{{ $oneerror }}</li>
        @endforeach
    </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning" role="alert">
      {{ session('warning') }}
    </div>
    @endif
    @if(session('flash_message'))
    <div class="alert alert-info" role="alert">
      {{ session('flash_message') }}
    </div>
    @endif
  </div>
</div>
