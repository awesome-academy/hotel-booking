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
                                {{ __('messages.languages_table') }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            <button class="btn btn-info btn-sm addLanguage" data-toggle="modal" data-target="#addLanguage" title="{{ __('messages.Add Language') }}"><i class="fas fa-plus"></i> {{ __('messages.Add') }}</button>
                            <table id="language-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.Name') }}</th>
                                        <th>{{ __('messages.Frag') }}</th>
                                        <th>{{ __('messages.Short') }}</th>
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
<div id="addLanguage" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('messages.Add Language') }}</h4>
            </div>
            <div class="modal-body" >
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <input type="file" name="file" id="profile-img">
                <img src="" id="profile-img-tag" width="100px" />
                <div class="form-group">
                    <label for="">{{ __('messages.Name') }}</label>
                    <input type="text" class="form-control" id="name_lang" placeholder="{{ __('messages.Language name') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.Close') }}</button>
                <button type="submit" class="btn btn-primary add_languages">{{ __('messages.Submit') }}</button> 
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" id="hiddenlang">
<div id="EditLanguage" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('messages.Edit Language') }}</h4>
            </div>
            <div class="modal-body" >
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <input type="file" name="file" id="profile-img-1">
                <img src="" id="profile-img-tag-1" width="100px" />
                <div class="form-group">
                    <label for="">{{ __('messages.Name') }}</label>
                    <input type="text" class="form-control" id="name_lang_1" placeholder="{{ __('messages.Language name') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.Close') }}</button>
                <button type="submit" class="btn btn-primary update_languages">{{ __('messages.Submit') }}</button> 
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });     
    });

    $(function() {
        $('#language-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.laguage.Datatable') !!}',
            columns: [
            { data: 'name', name: 'name' },
            { data: 'frag', name: 'frag' },
            { data: 'short', name: 'short' },
            { data: 'action', name: 'action' },
            ]
        });
    });

    $('#profile-img-tag').attr('src', "");
    $('#profile-img-tag-1').attr('src', "");

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
                $('#profile-img-tag-1').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#profile-img").change(function() {
        readURL(this);
    });

    $("#profile-img-1").change(function() {
        readURL(this);
    });

    $('.add_languages').click(function(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('name', $('#name_lang').val());
        formData.append('file', $('#profile-img')[0].files[0]);
        $.ajax({
            type: 'post',
            processData: false,
            contentType: false,
            url: '{{ asset('') }}admin/lang',
            data: formData,
            success: function(response) {
                toastr.success(response.success);
                $('#language-table').DataTable().ajax.reload(null, false);
                $('#addLanguage').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown){
                if (jqXHR.responseJSON.errors.name !== undefined) {
                    toastr.error(jqXHR.responseJSON.errors.name[0]);
                }
                if (jqXHR.responseJSON.errors.file !== undefined) {
                    toastr.error(jqXHR.responseJSON.errors.file[0]);
                }
            }
        })
    });

    $(document).on('click', '#editLanguage', function(e) {
        e.preventDefault();
        var id = $(this).attr('language_id');
        $('#hiddenlang').attr('lang_id',id);
        $.ajax({
            type: 'get',
            url: '{{ asset("") }}admin/lang/'+id+'/edit',
            success: function(response){
                $('#name_lang_1').val(response.name);
                $('#profile-img-tag-1').attr('src','{{ asset("") }}'+response.frag);
            }
        })
    })
    $('.update_languages').click(function(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('name',$('#name_lang_1').val());
        formData.append('file',$('#profile-img-1')[0].files[0]);
        formData.append('id',$('#hiddenlang').attr('lang_id'));
        $.ajax({
            type: 'post',
            processData: false,
            contentType: false,
            url: '{{ asset('') }}admin/lang/update',
            data: formData,
            success: function(response) {
                toastr.success(response.success);
                $('#language-table').DataTable().ajax.reload(null, false);
                $('#EditLanguage').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.responseJSON.errors.name !== undefined) {
                    toastr.error(jqXHR.responseJSON.errors.name[0]);
                }
                if (jqXHR.responseJSON.errors.file !== undefined) {
                    toastr.error(jqXHR.responseJSON.errors.file[0]);
                }
            }
        })
    });
</script>
@endsection
