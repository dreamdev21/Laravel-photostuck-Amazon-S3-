
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
        <label>@lang('forms.name') : <small>{{$user->name}}</small></label>
        <input type="hidden" name="name" value="{{$user->name}}">
    </div>
    <div class="form-group">
        <label for="email">@lang('forms.email') : <small>{{$user->email}}</small></label>
        <input type="hidden" name="email" value="{{$user->email}}">

    </div>
    <div class="form-group">
        <label for="mobile">@lang('forms.mobile') : <small>{{$user->mobile}}</small></label>
        <input type="hidden" name="mobile" value="{{$user->mobile}}">
    </div>
    <div class="form-group">
        <label for="role">@lang('forms.role') : <small>{{$user->role}}</small></label>
        <input type="hidden" name="role" value="{{$user->role}}">
    </div>

    <div class="form-group">
        <label for="country">@lang('forms.country')</label>
        <input type="text" name="country" class="form-control" value="{{ $user->country or old('country')}}">
    </div>

    <div class="form-group">
        <label for="city">@lang('forms.city')</label>
        <input type="text" name="city" class="form-control" value="{{ $user->city or old('city')}}">
    </div>
  </div>

</div>

<div class="form-group">
    <hr>
    <a href="/users" class="btn btn-default">Cancel</a>
    <button type="submit" class="btn btn-primary pull-right">
      @lang('forms.submit')
    </button>
</div>
