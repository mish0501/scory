@extends('layouts.default')

@section('title')
  <i class="fa fa-cogs"></i>
  Редактиране на роля
@endsection

@section('content')
<div class='box-content'>
  {!! Form::model($role, [
    'route' => ['admin.settings.roles.update', $role->id],
    'class' => 'form form-horizontal',
    'autocomplete' => 'off'
  ]) !!}
    <div class='form-group'>
      <label class='col-md-2 control-label' for='display_name'>Името на правото</label>
      <div class='col-md-5'>
        <input class='form-control' name='display_name' id="display_name" type='text' placeholder="Името на правото" value="{{ (Request::old('display_name')) ? Request::old('display_name') : $role->display_name}}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='name'>Името на правото в системата</label>
      <div class='col-md-5'>
        <input class='form-control' name='name' id="name"  type='text' placeholder="Името на правото в системата" value="{{ (Request::old('name')) ? Request::old('name') : $role->name}}">
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='description'>Описание</label>
      <div class='col-md-5'>
        <textarea class="form-control" id="description" name="description" placeholder="Описание" rows="3">{{ (Request::old('description')) ? Request::old('description') : $role->description}}</textarea>
      </div>
    </div>
    <div class='form-group'>
      <label class='col-md-2 control-label' for='description'>Права</label>
      <div class='col-md-5'>
        <select class="form-control" name="permissions[]" id="permsSelect" multiple="multiple">
          @foreach ($permissions as $permission)
            <?php
              $selected='';

              if (Request::old('permissions')) {
                if (Request::old('permissions') == $permission->id) {
                  $selected= 'selected="selected"';
                }
              } else {
                foreach ($rolePerms as $rolePerm) {
                  if ($rolePerm->id == $permission->id) {
                    $selected= 'selected="selected"';
                  }
                }

              }
            ?>
            <option {{ $selected }} value='{{$permission->id}}'>{{ $permission->display_name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class='form-actions form-actions-padding-sm'>
      <div class='row'>
        <div class='col-md-10 col-md-offset-2'>
          <button class='btn btn-primary' type='submit'>
            <i class='fa fa-save'></i>
            Запази
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('style')
  <link rel="stylesheet" href="/admin/assets/stylesheets/plugins/multi-select/multi-select.css" charset="utf-8">
@endsection

@section('javascript')
  <script src="/admin/assets/javascripts/plugins/quicksearch/jquery.quicksearch.js" charset="utf-8"></script>
  <script src="/admin/assets/javascripts/plugins/multi-select/multi-select.js" charset="utf-8"></script>

  <script type="text/javascript">

    $(document).ready(function() {
      var PermsSelect = $('select#permsSelect');

      PermsSelect.multiSelect({
        keepOrder: true,
        selectableHeader: "<input type='text' id='selectableHeader' class='search-input form-control' style='margin-bottom:5px' autocomplete='off' placeholder='Потърси право'>",
        selectionHeader: "<input type='text' id='selectionHeader' class='search-input form-control' style='margin-bottom:5px' autocomplete='off' placeholder='Потърси право'>",
        afterInit: function(ms){
          var that = this,
              $selectableSearch = that.$selectableUl.prev(),
              $selectionSearch = that.$selectionUl.prev(),
              selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
              selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

          that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
          .on('keydown', function(e){
            if (e.which === 40){
              that.$selectableUl.focus();
              return false;
            }
          });

          that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
          .on('keydown', function(e){
            if (e.which == 40){
              that.$selectionUl.focus();
              return false;
            }
          });
        },
        afterSelect: function(){
          this.qs1.cache();
          this.qs2.cache();
        },
        afterDeselect: function(){
          this.qs1.cache();
          this.qs2.cache();
        }
      });
    });
  </script>
@endsection
