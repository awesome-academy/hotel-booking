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
                                {{ __('messages.contact_table') }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            <table id="contact-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{{ __('messages.Subject') }}</th>
                                        <th>{{ __('messages.Email') }}</th>
                                        <th>{{ __('messages.Loca_name') }}</th>
                                        <th>{{ __('messages.Province_name') }}</th>
                                        <th>{{ __('messages.Time') }}</th>
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
<div id="ShowContact" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('messages.Show Contact') }}</h4>
            </div>
            <div class="modal-body" >
                <div class="form-group">
                    <label for="">{{ __('messages.Name') }}</label>
                    <p id="nameContact"></p>
                </div>
                <div class="form-group">
                    <label for="">{{ __('messages.Subject') }}</label>
                    <p id="subjectContact"></p>
                </div>
                <div class="form-group">
                    <label for="">{{ __('messages.Body') }}</label>
                    <p id="bodyContact"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" id="hiddnasset" value="{{ asset('') }}">
<input type="hidden" name="" id="hiddenroute" value="{!! route('admin.contact.Datatable') !!}">
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('') }}bower_components/bower/admin/custom/js/contact.js"></script>
@endsection
