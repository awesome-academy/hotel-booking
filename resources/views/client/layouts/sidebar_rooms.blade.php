<div class="col-lg-3"><!-- Sidebar -->
    <div class="quick-reservation-container">
        <div class="quick-reservation clearfix">
            <div class="reserve-form-area">
                <form action="{{ route('client.rooms.index') }}" method="get">
                    <label>{{ trans('messages.Check_in_day') }}</label>
                    <input type="text" id="dpd1" name="check_in" data-date-format="mm/dd/yyyy"
                           class="date-selector" placeholder="&#xf073;" autocomplete="off"/>
                    <label>{{ trans('messages.Check_out_day') }}</label>
                    <input type="text" id="dpd2" name="check_out" data-date-format="mm/dd/yyyy"
                           class="date-selector" placeholder="&#xf073;" autocomplete="off"/>
                    <label>{{ trans('messages.Coming soon') }}</label>
                    <select name="location" class="pretty-select">
                        @foreach ($locations_for_nav as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    <div class="button-style-1">
                        <button><i class="fa fa-search"></i>{{ trans('messages.Search') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
