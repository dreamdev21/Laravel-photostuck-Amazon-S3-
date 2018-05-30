<style>
.kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
}
.kv-avatar .file-input {
    display: table-cell;
    max-width: 220px;
}
.kv-reqd {
    color: red;
    font-family: monospace;
    font-weight: normal;
}
</style>
<div class="row">
  <div class="col-md-4">

    <div class="form-group">
      <div class="kv-avatar center-block text-center" style="width:200px">
                <input id="avatar" name="avatar" type="file" class="file-loading" required>
                <div class="help-block"><small>Select file < 1500 KB</small></div>
            </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="form-group">
        <label>@lang('forms.name') : <small>{{Auth::user()->name}}</small></label>
    </div>
    <div class="form-group">
        <label for="email">@lang('forms.email') : <small>{{Auth::user()->email}}</small></label>
    </div>
    <div class="form-group">
        <label for="mobile">@lang('forms.mobile') : <small>{{Auth::user()->mobile}}</small></label>
    </div>
    <div class="form-group">
        <label for="address">@lang('forms.address')</label>
        <input type="text" name="address" class="form-control" value="{{ old('address')}}">
    </div>
    <div class="form-group">
        <label for="bio">@lang('forms.bio')</label>
        <textarea name="bio" class="form-control" rows="8" cols="80" class="form-control">{{ old('bio')}}</textarea>
    </div>

    <div class="form-group">
        <label for="address">@lang('forms.upload_document')</label>
        <input type="file" name="document" class="file">
    </div>
  </div>

</div>

<div class="form-group">
    <hr>
    <button type="submit" class="btn btn-primary pull-right btn-block">
      @lang('forms.submit')
    </button>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {

  $("#avatar").fileinput({
      overwriteInitial: true,
      maxFileSize: 1500,
      showClose: false,
      showCaption: false,
      browseLabel: '',
      removeLabel: '',
      browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
      removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
      removeTitle: 'Cancel or reset changes',
      elErrorContainer: '#kv-avatar-errors-1',
      msgErrorClass: 'alert alert-block alert-danger',
      defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar" style="width:160px">',
      layoutTemplates: {main2: '{preview} {remove} {browse}'},
      allowedFileExtensions: ["jpg", "png", "gif"]
  });
});


</script>

</script>
