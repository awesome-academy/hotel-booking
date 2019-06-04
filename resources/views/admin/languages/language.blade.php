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
                <div class="form-group">
                    <label for="">{{ __('messages.Short') }}</label>
                    <input type="text" class="form-control" id="short_lang" placeholder="{{ __('messages.Language name') }}">
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
                <div class="form-group">
                    <label for="">{{ __('messages.Short') }}</label>
                    <input type="text" class="form-control" id="short_lang_1" placeholder="{{ __('messages.Language name') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('messages.Close') }}</button>
                <button type="submit" class="btn btn-primary update_languages">{{ __('messages.Submit') }}</button> 
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" id="hiddenasset" value="{{ asset('') }}">
<input type="hidden" name="" id="hiddenroute" value="{!! route('admin.laguage.Datatable') !!}">
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/custom/js/language.js') }}">
</script>
@endsection
