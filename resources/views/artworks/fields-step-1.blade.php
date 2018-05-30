
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
        <input id="file_area" type="file" name="files[]" multiple>
               <!--<input id="temp_file" type="file" name="file"
                      data-allowed-file-extensions='["jpeg", "jpg"]'>-->

    </div>
  </div>

</div>

<div class="form-group">
    <hr>
    <button type="submit" class="btn btn-primary pull-right btn-block">
      @lang('forms.next')
    </button>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
  var file_input = $("#file_area");
  file_input.fileinput({
      uploadExtraData: {
        '_token': '{{ csrf_token() }}'
      },
      uploadUrl: "/try-upload", // server upload action
      uploadAsync: true,
      maxFileCount: 5,
      showUpload: false,
      browseOnZoneClick: true,
      overwriteInitial: false,

  });
});

</script>
