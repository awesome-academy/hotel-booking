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
                                {{ __('messages.commentroom_table') }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            <table id="commentroom_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{{ __('messages.Email') }}</th>
                                        <th>{{ __('messages.Body') }}</th>
                                        <th>{{ __('messages.Room') }}</th>
                                        <th>{{ __('messages.Rating') }}</th>
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
<input type="hidden" name="" id="hiddnasset" value="{{ asset('') }}">
<input type="hidden" name="" id="hiddenroute" value="{!! route('admin.comment.Datatable', $object) !!}">
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/custom/js/comment.js') }}"></script>
@endsection
