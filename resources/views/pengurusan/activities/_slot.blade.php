<div class="form-group">
    <div class="col-12">
        <table id="example" class="responsive table table-bordered table-sm">
            <tr class="cell-success">
                <th colspan="3">PILIHAN SLOT TARIKH/MASA</th>
            </tr>
            <tr>
                <td>
                    <div class="form-row">
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                {{ Form::label('start_at', 'Tarikh/Masa Mula') }}
                                {{ Form::text('start_at', isset($activity->start_at) ? $activity->start_at->format('d-m-Y') : null ,['class' => 'form-control
                                '.Html::isInvalid($errors,'start_at')]) }}
                                {!! Html::hasError($errors,'start_at') !!}
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group">
                                {{ Form::label('end_at', 'Tarikh/Masa Tamat') }}
                                {{ Form::text('end_at', isset($activity->end_at) ? $activity->end_at->format('d-m-Y') : null ,['class' => 'form-control '.Html::isInvalid($errors,'end_at')]) }}
                                {!! Html::hasError($errors,'end_at') !!}
                            </div>
                        </div>
                    </div>
                    <!-- radio -->
                    <div id="slot-radio" class="form-group">
                        <div class="custom-control custom-radio">
                            <input {{ isset($activity->lokasi) && $activity->tempoh_id == 2 ? 'checked' : '' }} class="custom-control-input custom-control-input-teal" value="2" type="radio"
                            id="slot_pagi" name="tempoh_id">
                            <label for="slot_pagi" class="custom-control-label h6">Slot Pagi (7 pagi - 1 tengah hari)</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input {{ isset($activity->lokasi) && $activity->tempoh_id == 3 ? 'checked' : '' }} class="custom-control-input custom-control-input-teal" value="3" type="radio"
                            id="slot_petang" name="tempoh_id">
                            <label for="slot_petang" class="custom-control-label h6">Slot Petang (2 petang - 6 petang)</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input {{ isset($activity->lokasi) && $activity->tempoh_id == 1 ? 'checked' : '' }} class="custom-control-input custom-control-input-teal" value="1" type="radio"
                            id="slot_sehari" name="tempoh_id">
                            <label for="slot_sehari" class="custom-control-label h6">Slot Sehari (7 pagi - 6 petang)</label>
                            {!! Html::hasError($errors,'tempoh_id') !!}
                        </div>
                        <div class="errorSlotRadio"></div>
                        <div class="errorSlotRadioMsg"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>