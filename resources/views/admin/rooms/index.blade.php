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
                                    {{ __('messages.Room_table') }} - {{ $location->name }}
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
                                                <div class="col-md-4">
                                                    <div class="m-input-icon m-input-icon--left">
                                                        <form method="get"
                                                              action="{{ route('admin.rooms.index', $location->id) }}">
                                                            <input type="text" class="form-control m-input"
                                                                   name="keyword"
                                                                   placeholder="{{ __('messages.Search') }}">
                                                        </form>
                                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                                            <span><i class="la la-search"></i></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                            @if (session('locale') == $base_lang_id || !session('locale'))
                                                <a href="{{ route('admin.rooms.create', $location->id) }}"
                                                   class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                                    <span><i class="la la-plus"></i>{{ __('messages.Create_room') }}</span>
                                                </a>
                                            @endif
                                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('messages.Feature_image') }}</th>
                                        <th>{{ __('messages.Room_name') }}</th>
                                        <th>{{ __('messages.Price') }}</th>
                                        <th>{{ __('messages.Rating') }}</th>
                                        <th>{{ __('messages.Original') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php ($i = 1)
                                    @foreach($rooms as $room)
                                        <?php
                                        if (session('locale')) {
                                            if (isset($_GET['keyword'])) {
                                                $roomDetail = $room->roomDetails()->where('name', 'LIKE', '%' . $_GET['keyword'] . '%')->where('lang_id', session('locale'))->first();
                                            } else {
                                                $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
                                            }
                                        } else {
                                            if (isset($_GET['keyword'])) {
                                                $roomDetail = $room->roomDetails()->where('name', 'LIKE', '%' . $_GET['keyword'] . '%')->where('lang_id', $base_lang_id)->first();
                                            } else {
                                                $roomDetail = $room->roomDetails()->where('lang_id', $base_lang_id)->first();
                                            }
                                        }
                                        ?>
                                        @if ($roomDetail != null)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>
                                                    <img src="{{ asset(config('upload.rooms')) }}/{{ $room->image }}"
                                                         class="image_table"></td>
                                                <td>{{ $roomDetail->name }}</td>
                                                <td class="price">{{ $roomDetail->price }} {{ __('messages.currency') }}</td>
                                                <td>{{ $room->rating }} {{ __('messages.star') }}</td>
                                                <td>
                                                    @if ($roomDetail->lang_parent_id == 0)
                                                        {{ __('messages.Original') }}
                                                    @elseif ($roomDetail->lang_parent_id != 0)
                                                        @php($parent = $room->roomDetails()->find($roomDetail->lang_parent_id))
                                                        @if(!is_null($parent))
                                                            <a href="{{ route('admin.rooms.showOriginal', [$location->id, $parent->id]) }}">{{ $parent->name }}</a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.rooms.edit', [$location->id, $roomDetail->id]) }}"
                                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                                       title="{{ __('messages.Edit') }}"><i class="la la-edit"></i></a>
                                                    @if ($roomDetail->lang_parent_id == 0)
                                                        <a href="{{ route('admin.rooms.translate', [$location->id, $roomDetail->id]) }}"
                                                           class="m-portlet__nav-link btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                                           title="{{ __('messages.Create_translate') }}"><i
                                                                    class="la la-plus"></i></a>
                                                        <button data-toggle="modal"
                                                                data-target="#modal_prop_{{ $room->id }}"
                                                                class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill"
                                                                title="{{ __('messages.Create_translate') }}"><i
                                                                    class="la la-magic"></i></button>
                                                        <div class="modal fade" id="modal_prop_{{ $room->id }}"
                                                             tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="exampleModalLabel"></h5>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body row">
                                                                        <div class="col-6">
                                                                            <div class="m-scrollable m-scroller ps"
                                                                                 data-scrollbar-shown="true"
                                                                                 data-scrollable="true"
                                                                                 data-height="150">
                                                                                <ul class="list-props-{{ $room->id }}">
                                                                                    <?php
                                                                                    $room_properties = $room->properties()->get();
                                                                                    $room_prop_id = [];
                                                                                    $i = 0;
                                                                                    ?>
                                                                                    @foreach ($room_properties as $room_property)
                                                                                        <li class="list-prop-item-{{ $room->id }}-{{ $room_property->id }}">
                                                                                            <span class="list-prop-item">{{ $room_property->name }}</span>
                                                                                            <button data-room="{{ $room->id }}"
                                                                                                    id="{{ $room_property->id }}"
                                                                                                    addUrl="{{ route('admin.rooms.addProperties', $location->id) }}"
                                                                                                    deleteUrl="{{ route('admin.rooms.deleteProperties', $location->id) }}"
                                                                                                    class="btn m-btn m-btn--hover-danger m-btn--icon btn-delete-prop">
                                                                                                <i class="la la-trash"></i>
                                                                                            </button>
                                                                                        </li>
                                                                                        <?php
                                                                                        $room_prop_id[$i] = $room_property->id;
                                                                                        $i++;
                                                                                        ?>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="m-scrollable m-scroller ps"
                                                                                 data-scrollbar-shown="true"
                                                                                 data-scrollable="true"
                                                                                 data-height="150">
                                                                                <form>
                                                                                    <ul class="list-not-use-prop-{{ $room->id }}">
                                                                                        <?php
                                                                                        $properties_not_use = $properties->getNotUse($room_prop_id, $base_lang_id);
                                                                                        ?>
                                                                                        @foreach ($properties_not_use as $property)
                                                                                            <li class="item-{{$room->id}}-{{$property->id}}">
                                                                                                <span class="add-property-item">{{ $property->name }}</span>
                                                                                                <button data-room="{{ $room->id }}"
                                                                                                        id="{{ $property->id }}"
                                                                                                        addUrl="{{ route('admin.rooms.addProperties', $location->id) }}"
                                                                                                        deleteUrl="{{ route('admin.rooms.deleteProperties', $location->id) }}"
                                                                                                        class="btn m-btn m-btn--hover-success m-btn--icon btn-add-prop">
                                                                                                    <i class="la la-plus"></i>
                                                                                                </button>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <a href="{{ route('admin.rooms.translate', [$location->id, $roomDetail->lang_parent_id]) }}"
                                                           class="m-portlet__nav-link btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                                           title="{{ __('messages.Create_translate') }}"><i
                                                                    class="la la-plus"></i></a>
                                                    @endif
                                                    <a href="javascript:;"
                                                       linkurl="{{ route('admin.rooms.delete', [$location->id, $roomDetail->id]) }}"
                                                       class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-delete-link"
                                                       title="{{ __('messages.Delete') }}">
                                                        <i class="la la-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php($i++)
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $rooms->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('bower_components/bower/admin/custom/js/room.js') }}"></script>
@endsection
