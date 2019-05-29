@extends('admin.layouts.master')
@section('content')
    <div class="m-content">
        <div class="row">
            @if (session('locale') == $base_lang_id || !session('locale'))
                <div class="col-xl-4">
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{ __('messages.Create_property') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-section">
                                <form method="post" action="{{ route('admin.properties.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>{{ __('messages.Name') }}</label>
                                        <input type="text" name="name" class="form-control m-input">
                                    </div>
                                    @if ($errors->has('name'))
                                        <b class="text-danger">{{ $errors->first('name') }}</b>
                                    @endif
                                    <div class="form-group">
                                        <button type="submit"
                                                class="btn-primary btn">{{ __('messages.Create') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-xl-8">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{ __('messages.Properties_table') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8 order-2 order-xl-1">
                                            <div class="form-group m-form__group row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="m-input-icon m-input-icon--left">
                                                        <form method="get"
                                                              action="{{ route('admin.properties.index') }}">
                                                            <input type="text" class="form-control m-input"
                                                                   name="keyword"
                                                                   placeholder="{{ __('messages.Search') }}">
                                                        </form>
                                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                                            <i class="la la-search search-item"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('messages.Name') }}</th>
                                        <th>{{ __('messages.Original') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php ($i = 1)
                                    @foreach ($properties as $property)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td class="name-property-{{ $property->id }}"> {{ $property->name }}</td>
                                            <td>
                                                @if ($property->lang_parent_id == 0)
                                                    {{ __('messages.Original') }}
                                                @else
                                                    @php ($original = $parent->find($property->lang_parent_id))
                                                    {{ $original->name }}
                                                @endif
                                            </td>
                                            <td>
                                                <button data-toggle="modal"
                                                        data-target="#m_modal_edit_{{ $property->id }}"
                                                        class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                                        title="{{ __('messages.Edit') }}"><i class="la la-edit"></i>
                                                </button>
                                                @if ($property->lang_parent_id == 0)
                                                    <a href="{{ route('admin.properties.translate', $property->id) }}"
                                                       class="m-portlet__nav-link btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                                       title="{{ __('messages.Create_translate') }}">
                                                        <i class="la la-plus"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.properties.translate', $property->lang_parent_id) }}"
                                                       class="m-portlet__nav-link btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                                       title="{{ __('messages.Create_translate') }}">
                                                        <i class="la la-plus"></i>
                                                    </a>
                                                @endif
                                                <a href="javascript:;"
                                                   linkurl="{{ route('admin.properties.delete', $property->id) }}"
                                                   class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-delete-link"
                                                   title="{{ __('messages.Delete') }}"><i class="la la-trash"></i></a>
                                            </td>
                                        </tr>
                                        @php ($i++)
                                        <div class="modal fade show" id="m_modal_edit_{{ $property->id }}" tabindex="-1"
                                             role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="exampleModalLabel">{{ __('messages.Edit') }}
                                                            - {{ $property->name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <label class="form-control-label">{{ __('messages.Name') }}</label>
                                                                <input type="text" id="name-{{ $property->id }}"
                                                                       name="name" class="form-control"
                                                                       value="{{ old('name', $property->name) }}">
                                                            </div>
                                                            <input type="hidden" name="id" id="id-{{ $property->id }}"
                                                                   value="{{ $property->id }}">
                                                            <input type="hidden" name="url" id="url-{{ $property->id }}"
                                                                   value="{{ route('admin.properties.update', $property->id) }}">
                                                            <div class="form-group">
                                                                <button id="{{ $property->id }}"
                                                                        class="btn btn-primary btn-submit-edit">{{ __('messages.Edit') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $properties->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('bower_components/bower/admin/custom/js/properties.js') }}"></script>
@endsection
