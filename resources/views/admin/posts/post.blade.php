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
                                {{ __('messages.posts_table') }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            @if(count($check_unique) >0 )
                            <button class="btn btn-info btn-sm addPost" data-toggle="modal" data-target="#addPost" title="{{ __('messages.Add Post') }}"><i class="fas fa-plus"></i> {{ __('messages.Add') }}</button>
                            @endif
                            <table id="post-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.Title') }}</th>
                                        <th>{{ __('messages.Image') }}</th>
                                        <th>{{ __('messages.Desciption') }}</th>
                                        <th>{{ __('messages.Category name') }}</th>
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
<div id="addPost" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('messages.Add Post') }}</h4>
            </div>
            <div class="modal-body" >
                <div class="m-content">
                    <form class="m-form m-form--fit m-form--label-align-right">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Title') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="text" class="form-control m-input" id="title"  placeholder="{{ __('messages.Title') }}">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Image') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="file" name="file" id="profile-img">
                                    <img src="" id="profile-img-tag" width="100px" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Category') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="select">
                                        <select id="selectCate">
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Description') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <textarea rows="4" class="form-control" id="description"></textarea>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Content') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="summernote1"></div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 ml-lg-auto">
                                        <button type="reset" class="btn btn-brand add_posts">{{ __('messages.Submit') }}</button>
                                        <button type="reset" class="btn btn-secondary">{{ __('messages.Cancel') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" id="hiddenPost">
<div id="EditPost" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('messages.Edit Post') }}</h4>
            </div>
            <div class="modal-body" >
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="m-content">
                    <form class="m-form m-form--fit m-form--label-align-right">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Title') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="text" class="form-control m-input" id="title2"  placeholder="{{ __('messages.Title') }}">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Image') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="file" name="file" id="profile-img-1">
                                    <img src="" id="profile-img-tag-1"  />
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Category') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="select">
                                        <select id="selectCate2">
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Description') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <textarea rows="4" class="form-control" id="description2"></textarea>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Content') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="summernote2"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.Close') }}</button>
                <button type="submit" class="btn btn-primary update_posts">{{ __('messages.Submit') }}</button> 
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" id="hiddenTrans">
<div id="TransPost" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('messages.Translate Post') }}</h4>
            </div>
            <div class="modal-body" >
                <div class="m-content">
                    <form class="m-form m-form--fit m-form--label-align-right">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.List Language') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    @if(isset($languages))
                                    <div class="select">
                                        <select id="selectLang1">
                                        @foreach($languages as $language)
                                            <option value="{{ $language->id }}">{{ $language->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Title') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="text" class="form-control m-input" id="title1"  placeholder="{{ __('messages.Title') }}">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Description') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <textarea rows="4" class="form-control" id="description1"></textarea>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Content') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="summernote3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 ml-lg-auto">
                                        <button type="reset" class="btn btn-brand tran_posts">{{ __('messages.Submit') }}</button>
                                        <button type="reset" class="btn btn-secondary">{{ __('messages.Cancel') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="ShowPost" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('messages.Add Post') }}</h4>
            </div>
            <div class="modal-body" >
                <div class="m-content">
                    <form class="m-form m-form--fit m-form--label-align-right">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Title') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <p type="text" id="title3"></p>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Image') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <img src="" id="profile-img-tag-2" width="100px" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Category') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <p id="category"></p>
                                </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Description') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <p id="description3"></p>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-12 col-sm-12">{{ __('messages.Content') }}</label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="summernote4"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" id="hiddnasset" value="{{ asset('') }}">
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('') }}bower_components/bower/admin/custom/js/post.js">
</script>
<script type="text/javascript">
    $(document).on('click','#deletePost',function(e){
        e.preventDefault();
        var id = $(this).attr('post_id');
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
                url: $("#hiddnasset").val()+"admin/post/" + id,
                success: function(response) {
                    $('#post-table').DataTable().ajax.reload(null, false);
                }
            });    
        });
    });   
</script>
@endsection
