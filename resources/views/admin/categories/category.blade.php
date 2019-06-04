@extends('admin.layouts.master')
@section('content')
<div class="m-content">
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{ __('messages.categories_table') }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            @if(count($check_unique) > 0)
                            <button class="btn btn-info btn-sm addLanguage" data-toggle="modal" data-target="#addCategory" title="{{ __('messages.Add Category') }}"><i class="fas fa-plus"></i> {{ __('messages.Add') }}</button>
                            @endif
                            <table id="category-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{{ __('messages.Name') }}</th>
                                        <th>{{ __('messages.Cate_Parent') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="addCategory" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('messages.Add Language') }}</h4>
            </div>
            <div class="modal-body" >
                <form>
                    <input type="hidden" id="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="">{{ __('messages.Name') }}</label>
                        <input type="text" class="form-control" id="name_cate" placeholder="{{ __('messages.Category name') }}">
                    </div>
                    <div class="form-group">
                        @if(count($categories) > 0)
                        <label for="">{{ __('messages.Cate_Parent') }}</label><br>
                        <input type="checkbox" name="" class="checkCate"> <span>{{ __('messages.CheckCate') }}</span>
                        <div>
                            <select id="selectCate" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.Close') }}</button>
                <button type="submit" class="btn btn-primary add_categories">{{ __('messages.Submit') }}</button> 
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" id="hiddenCate">
<div id="EditCategory" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('messages.Edit Language') }}</h4>
            </div>
            <div class="modal-body" >
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="">{{ __('messages.Name') }}</label>
                    <input type="text" class="form-control" id="name_cate_1" placeholder="{{ __('messages.Category name') }}">
                </div>
                <div class="selectEdit">
                    <input type="checkbox" name="" class="checkCate1"> <span>{{ __('messages.CheckCate') }}</span>
                    <select id="selectCate1" class="form-control">

                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.Close') }}</button>
                <button type="submit" class="btn btn-primary update_categories">{{ __('messages.Submit') }}</button> 
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" id="hiddenTrans">
<div id="TransCate" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('messages.Translate Category') }}</h4>
            </div>
            <div class="modal-body" >
                <form>
                    <input type="hidden" id="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="">{{ __('messages.Name') }}</label>
                        <input type="text" class="form-control" id="name_cate_tran" placeholder="{{ __('messages.Category name') }}">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('messages.List Language') }}</label>
                        <div>
                            <select id="selectLangTran" class="form-control">
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.Close') }}</button>
                <button type="submit" class="btn btn-primary tran_categories">{{ __('messages.Submit') }}</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" id="hiddnasset" value="{{ asset('') }}">
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('') }}bower_components/bower/admin/custom/js/category.js">
</script>
<script type="text/javascript">
    $(document).on('click','#deleteCate',function(e){
        var id = $(this).attr('category_id');
        alert
        swal({
            title: "{{ __('messages.Are_you_sure') }}",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger waves-effect waves-light',
            confirmButtonText: "{{ __('messages.Delete') }}",
            cancelButtonText: "{{ __('messages.Cancel') }}",
            closeOnConfirm: true,
            closeOnCancel: true
        })
        .then( function(e) {
            e.value && $.ajax({
                type: 'get',
                url: $("#hiddnasset").val()+"admin/category/" + id,
                success: function(response) {
                    $('#category-table').DataTable().ajax.reload(null, false);
                }
            });    
        });
    });   
</script>
@endsection
