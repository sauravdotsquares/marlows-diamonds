@extends('layouts.admin.app')

@section('content')

<section class="content">
<div class="container-fluid">
<div class="row">
		@if (session('status'))
		<div class="col-md-12">
            <h6 class="alert alert-success">{{ session('status') }}</h6>
        </div>
        @endif
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header"><h5 class="float-left">Menu</h5>
                   <div class="float-right">
                        <button id="btnOutput" type="button" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
                <div class="card-body">
                    <ul id="myEditor" class="sortableLists list-group">
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white">Edit item</div>
                <div class="card-body">
                    <form id="frmEdit" class="form-horizontal">
                        <div class="form-group">
                            <label for="text">Text</label>
                            <div class="input-group">
                                <input required="required" type="text" class="form-control item-menu" name="text" id="text" placeholder="Text">
                                <div class="input-group-append">
                                    <button type="button" id="myEditor_icon" class="btn btn-outline-secondary"></button>
                                </div>
                            </div>
                            <input type="hidden" name="icon" class="item-menu">
                        </div>
                        <div class="form-group">
                            <label for="href">URL</label>
                            <input required="required" type="text" class="form-control item-menu" id="href" name="href" placeholder="URL">
                        </div>
                        <div class="form-group">
                            <label for="target">Target</label>
                            <select name="target" id="target" class="form-control item-menu">
                                <option value="_self">Self</option>
                                <option value="_blank">Blank</option>
                                <option value="_top">Top</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Tooltip</label>
                            <input type="text" name="title" class="form-control item-menu" id="title" placeholder="Tooltip">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
                    <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
                </div>
            </div>
        </div>
        <form action="{{url('admin/menus/save')}}" id="menu_form" method="post">
        	{{ csrf_field() }}
        	<input type="hidden" name="out" id="out" value="">

        </form>
    </div>
</div>
</section>
@endsection

@section('js')
    <script src="{{ asset('admin/dist/js/jquery-menu-editor.js')}}"></script>
	<script src="{{ asset('admin/dist/bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js')}}"></script>
	<script src="{{ asset('admin/dist/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js')}}"></script>

	<script>
	jQuery(document).ready(function () {
	      /* =============== DEMO =============== */
	      // menu items
	      //var arrayjson = [{"href":"http://home.com","icon":"fas fa-home","text":"Home", "target": "_top", "title": "My Home"},{"icon":"fas fa-chart-bar","text":"Opcion2"},{"icon":"fas fa-bell","text":"Opcion3"},{"icon":"fas fa-crop","text":"Opcion4"},{"icon":"fas fa-flask","text":"Opcion5"},{"icon":"fas fa-map-marker","text":"Opcion6"},{"icon":"fas fa-search","text":"Opcion7","children":[{"icon":"fas fa-plug","text":"Opcion7-1","children":[{"icon":"fas fa-filter","text":"Opcion7-1-1"}]}]}];
          var arrayjson = {!! $data !!};
	      // icon picker options
	      var iconPickerOptions = {searchText: "Buscar...", labelHeader: "{0}/{1}"};
	      // sortable list options
	      var sortableListOptions = {
	          placeholderCss: {'background-color': "#cccccc"}
	      };

	      var editor = new MenuEditor('myEditor', {listOptions: sortableListOptions, iconPicker: iconPickerOptions});
	      editor.setForm($('#frmEdit'));
	      editor.setUpdateButton($('#btnUpdate'));
	      //$('#btnReload').on('click', function () {
	          editor.setData(arrayjson);
	      //});

	      $('#btnOutput').on('click', function () {
	          var str = editor.getString();
	          $("#out").val(str);
	          //setTimeout(function () {
                 $('#menu_form').submit();
              // }, 2500);

	      });

            $("#btnUpdate").click(function(){
                $('.text-error').html('');
                $('.url-error').html('');
                if($('#text').val() == '' ){
                    $('#text').parent('.input-group').after('<lable class="text-error" style="color:red;">Text field is required</label>');
                    return false;
                }else if($('#href').val() == ''){
                    $('#href').after('<lable class="url-error" style="color:red;">URL field is required</label>');
                    return false;
                }else{
                    editor.update();
                }
            });

            $('#btnAdd').click(function(){
                $('.text-error').html('');
                $('.url-error').html('');
                if($('#text').val() == '' ){
                    $('#text').parent('.input-group').after('<lable class="text-error" style="color:red;">Text field is required</label>');
                    return false;
                }else if($('#href').val() == ''){
                    $('#href').after('<lable class="url-error" style="color:red;">URL field is required</label>');
                    return false;
                }else{
                    editor.add();
                }
            });
	      /* ====================================== */

	      /** PAGE ELEMENTS **/
	      $('[data-toggle="tooltip"]').tooltip();
	      $.getJSON( "https://api.github.com/repos/davicotico/jQuery-Menu-Editor", function( data ) {
	          $('#btnStars').html(data.stargazers_count);
	          $('#btnForks').html(data.forks_count);
	      });
	  });
	</script>
@stop
