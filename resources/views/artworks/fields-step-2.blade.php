
<div class="row">
  <div class="col-md-12">
      @foreach($artworks as $artwork)
      <div class="row">
        <div class="col-md-4">
          <input type="hidden" name="id[]" value="{{$artwork->id}}">
          <div class="form-group">
            <img class="img-responsive img-thumbnail" src="{{$artwork->thumb_url()}}" width="150px" height="150px">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="">@lang('forms.status'):</label>
            @if($artwork->status == 0)
            <span class="label label-warning">@lang('lists.pending')</span>
            @elseif($artwork->status == 1)
            <span class="label label-success">@lang('lists.approved')</span>
            @elseif($artwork->status ==2)
            <span class="label label-danger">@lang('lists.rejected')</span>
            @endif
          </div>
          <div class="form-group">
            <label>@lang('forms.created_at'):</label>
            <label>{{$artwork->created_at}}</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>@lang('forms.filesize'):</label>
            <label>{{$artwork->filesize}}</label>
          </div>
          <div class="form-group">
            <label>@lang('forms.mimetype'):</label>
            <label>{{$artwork->mimetype}}</label>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="name">@lang('forms.category')</label>
            <select  class="form-control" name="category_id[]" id="category" >
              @if(!$categories->isEmpty())
              <?php foreach($categories as $category): ?>
                <option value="{{$category->id}}" {{ $artwork->category_id == $category->id ? 'selected' : ''}}>
                  {{$category->en_name}}
                </option>
              <?php endforeach; ?>
              @endif
            </select>
          </div>
          <div class="form-group">
            <label for="name">@lang('forms.name')</label>
            <input type="text" class="form-control" name="name[]" value="{{$artwork->name}}">
          </div>
          <div class="form-group">
            <label for="taken_at">@lang('forms.taken_at')</label>
            <input type="text" class="form-control" name="taken_at[]" value="{{$artwork->taken_at}}">
          </div>
          <div class="form-group">
            <label for="taken_in">@lang('forms.taken_in')</label>
            <input autocomplete="off" id="typeahead" type="text" class="form-control" name="taken_in[]"
            value="{{$artwork->taken_in}}" placeholder="@lang('forms.type_city_name')">
          </div>

          <div class="form-group">
            <label for="description">@lang('forms.description')</label>
            <textarea class="form-control" name="description[]" rows="6" cols="40">{{$artwork->description}}</textarea>
          </div>
          <div class="form-group">
            <label for="tags">@lang('forms.tags')</label>
            <!--<input type="text" class="form-control" name="tags[][]" value="{{$artwork->tags}}">-->
            <select class="form-control"  multiple="multiple" name="tags[]" id="tags" value="{{$artwork->tags}}">
              @if(!$artwork->tags->isEmpty())
              <?php foreach($artwork->tags as $tag): ?>
                <option value="{{$tag}}" selected>
                  {{$tag}}
                </option>
              <?php endforeach; ?>
              @endif
            </select>

          </div>
        </div>
      </div>

      <hr>

    @endforeach
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
        <hr>
        <button type="submit" class="btn btn-primary pull-right btn-block">
          @lang('forms.confirm')
        </button>
    </div>
  </div>
</div>

<script type="text/javascript">
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

$("select[id=tags]").select2({
  tags: true
})
</script>
