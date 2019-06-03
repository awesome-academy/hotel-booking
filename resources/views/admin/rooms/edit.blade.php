@extends('admin.layouts.master')
@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{ $location->name }} - {{ $roomDetail->name }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <form method="post"
                                      action="{{ route('admin.rooms.update', [$location->id, $roomDetail->id]) }}"
                                      enctype="multipart/form-data">
                                    <input type="hidden" id="old_list_room_number" name="old_list_room_number"
                                           value="{{ $room->list_room_number }}">
                                    @csrf
                                    <div class="form-group m-form__group m--margin-top-10">
                                        <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                            {{ __('messages.must_fill_*') }}
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--brand" role="tablist">
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link @if (!session('image_active')) {{'active'}} @endif"
                                               data-toggle="tab" href="#m_tabs_info" role="tab">
                                                <i class="la la-info-circle"></i> Thông tin</a>
                                        </li>
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link @if (session('image_active')) {{'active'}} @endif"
                                               data-toggle="tab" href="#m_tabs_images" role="tab">
                                                <i class="la la-image"></i> Ảnh</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane @if (!session('image_active')) {{'active'}} @endif"
                                             id="m_tabs_info" role="tabpanel">
                                            <div class="form-group m-form__group">
                                                <label>{{ __('messages.Feature_image') }}</label>
                                                <br>
                                                <img id="is_image"
                                                     src="{{ asset(config('upload.rooms')) }}/{{ $room->image }}"
                                                     class="admin-image-500">
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="select_image"
                                                           name="image"
                                                           accept="image/*">
                                                    <label class="custom-file-label"
                                                           for="selectImage">{{ __('messages.Select_image') }}</label>
                                                </div>
                                                @if ($errors->has('image'))
                                                    <p class="text-danger">{{$errors->first('image')}}</p>
                                                @endif
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>{{ __('messages.Room_name') }} <b
                                                            class="text-danger">*</b></label>
                                                <input type="text" class="form-control m-input" name="name"
                                                       placeholder="{{ __('messages.Enter_room_name') }}"
                                                       value="{{ old('name', $roomDetail->name) }}">
                                                @if ($errors->has('name'))
                                                    <b class="text-danger">{{ $errors->first('name') }}</b>
                                                @endif
                                                @if (session('name_used'))
                                                    <b class="text-danger">{{ __('messages.Name_used') }}</b>
                                                @endif
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>{{ __('messages.List_room_number') }} <b
                                                            class="text-danger">*</b></label>
                                                <br>
                                                <div class="form-group m-form__group">
                                                    <div>
                                                        <div class="col-lg-10">
                                                            @php($i = 0)
                                                            @foreach($list_room_number as $item)
                                                                <div data-repeater-item="{{ $item }}"
                                                                     class="row m--margin-bottom-10-desktop"
                                                                     id="room-number-{{ $item }}">
                                                                    <div class="col-md-3">
                                                                        <p>{{ $item }}</p>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <a href="javascript:;"
                                                                           data-repeater-delete="{{ $item }}"
                                                                           class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill btn-list-room-number-delete">
                                                                            <i class="la la-trash-o"></i>{{ __('messages.Delete') }}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                @php($i++)
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m_repeater_edit">
                                                    <div class="form-group  m-form__group row m_repeater_edit">
                                                        <div data-repeater-list="" class="col-lg-10">
                                                            <div data-repeater-item
                                                                 class="form-group m-form__group row align-items-center">
                                                                <div class="col-md-3">
                                                                    <div class="m-form__group m-form__group--inline">
                                                                        <div class="m-form__control">
                                                                            <input type="text" name="list_room_number[]"
                                                                                   class="form-control m-input">
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-md-none m--margin-bottom-10"></div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div data-repeater-delete=""
                                                                         class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
                                                                        <i class="la la-trash-o"></i>{{ __('messages.Delete') }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-form__group form-group row">
                                                        <div class="col-lg-4">
                                                            <div data-repeater-create=""
                                                                 class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                                                                <i class="la la-plus"></i>{{ __('messages.Add') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($errors->has('list_room_number.*'))
                                                    <b class="text-danger">{{ $errors->first('list_room_number.*') }}</b>
                                                @endif
                                                @if (session('room_number_used'))
                                                    <b class="text-danger">{{ __('messages.Room_number_used') }}</b>
                                                @endif
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>{{ __('messages.Price') }}</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input type="text" class="form-control m-input" name="price"
                                                               placeholder="{{ __('messages.Enter_price') }}"
                                                               value="{{ old('price', $roomDetail->price) }}">
                                                    </div>
                                                    @if ($errors->has('price'))
                                                        <b class="text-danger">{{ $errors->first('price') }}</b>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="">{{ __('messages.Sale_price') }}</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input type="text" class="form-control m-input"
                                                               name="sale_price"
                                                               placeholder="{{ __('messages.Enter_sale_price') }}"
                                                               value="{{ old('sale_price', $roomDetail->sale_price) }}">
                                                    </div>
                                                    @if ($errors->has('sale_price'))
                                                        <b class="text-danger">{{ $errors->first('sale_price') }}</b>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>{{ __('messages.Sale_start_at') }}</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input type="text" class="form-control m-input my-datepicker"
                                                               value="{{ old('sale_start_at', $room->sale_start_at) }}"
                                                               name="sale_start_at" autocomplete="off">
                                                    </div>
                                                    @if ($errors->has('sale_start_at'))
                                                        <b class="text-danger">{{ $errors->first('sale_start_at') }}</b>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="">{{ __('messages.Sale_price') }}</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input type="text" class="form-control m-input my-datepicker"
                                                               value="{{ old('sale_end_at', $room->sale_end_at) }}"
                                                               name="sale_end_at" autocomplete="off">
                                                    </div>
                                                    @if ($errors->has('sale_end_at'))
                                                        <b class="text-danger">{{ $errors->first('sale_end_at') }}</b>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>{{ __('messages.Short_description') }} <b
                                                            class="text-danger">*</b></label>
                                                <textarea class="form-control" name="short_description"
                                                          rows="10">{{ old('short_description', $roomDetail->short_description) }}</textarea>
                                                @if ($errors->has('short_description'))
                                                    <b class="text-danger">{{ $errors->first('short_description') }}</b>
                                                @endif
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>{{ __('messages.Description') }} <b
                                                            class="text-danger">*</b></label>
                                                <textarea class="form-control" name="description"
                                                          id="description">{{ old('description', $roomDetail->description) }}</textarea>
                                                @if ($errors->has('description'))
                                                    <b class="text-danger">{{ $errors->first('description') }}</b>
                                                @endif
                                            </div>
                                            <input type="hidden" name="old_image" value="{{ $room->image }}">
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <div class="form-group m-form__group">
                                                <button class="btn btn-primary">{{ __('messages.Edit') }}</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane @if (session('image_active')) {{'active'}} @endif"
                                             id="m_tabs_images" role="tabpanel">
                                            <div class="form-group m-form__group">
                                                <button type="button" class="btn btn-primary btn-upload"
                                                        data-toggle="modal" data-target="#m_modal_4"
                                                        deleteUrl="{{ route('admin.rooms.destroyImage') }}">Thêm ảnh
                                                </button>
                                            </div>
                                            <div class="row">
                                                @foreach ($images as $image)
                                                    <div class="col-md-3 admin-image-grid">
                                                        <img src="{{ asset(config('upload.images')) }}/{{ $image->name }}"
                                                             class="img-fluid admin-image-gallery">
                                                        <a href="{{ route('admin.rooms.deleteImage', $image->id) }}"
                                                           class="btn btn-danger btn-img">Xóa
                                                            ảnh</a>
                                                    </div>
                                                @endforeach
                                                <div class="modal fade show" id="m_modal_4" tabindex="-1"
                                                     role="dialog" aria-labelledby="exampleModalLabel">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Thêm
                                                                    ảnh</h5>
                                                                <a href="">x</a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="m-dropzone dropzone m-dropzone--success dz-clickable"
                                                                     action="{{ route('admin.rooms.uploadImage', [$room->id]) }}"
                                                                     id="m-dropzone-three">
                                                                    @csrf
                                                                    <div class="m-dropzone__msg dz-message needsclick">
                                                                        <h3 class="m-dropzone__msg-title">Thả ảnh
                                                                            vào để tải lên (Ảnh sẽ tự động
                                                                            upload)</h3>
                                                                        <span class="m-dropzone__msg-desc">Chỉ chấp nhận ảnh định dạng jpg, jpeg, png. Dung lượng tối đa là 2MB</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
        </div>
    </div>
    <input type="hidden" id="room_number_delete" value="">
    <input type="hidden" id="url-delete" value="{{ route('admin.rooms.deleteRoomNumber') }}">
    <input type="hidden" id="room_id" value="{{ $room->id }}">
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('bower_components/bower/js/uploadImage.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/bower/admin/custom/js/room.js') }}"></script>
@endsection
