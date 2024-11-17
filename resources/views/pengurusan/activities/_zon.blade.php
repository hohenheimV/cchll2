@php
$zone = config('zonaktiviti.zonutama');
$zones = config('zonaktiviti.zon');
@endphp
<div class="form-group">
    <div class="col-12">
        <table id="table-zon" class="table table-bordered table-sm">
            <tbody>
                <section>
                            <tr class="cell-success text-uppercase">
                                <th colspan="3">{!! $zone['a'] !!}</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle" style="width: 80px;" rowspan="3">ZON A</th>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_a_0" type="radio" id="zona_a_0" name="lokasi" 
                                        {{ isset($activity->lokasi) && $activity->lokasi == 'zona_a_0' ? 'checked' :
                                        '' }} >
                                        <label for="zona_a_0" class="custom-control-label">{!! $zones['zona']['a'][0]['label'] !!}</label>
                                    </div>
                                    <small class="ml-4 mt-0 form-text text-muted">{!! $zones['zona']['a'][0]['text'] !!}</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_a_1" type="radio" id="zona_a_1" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_a_1' ? 'checked' :
                                        '' }} >
                                        <label for="zona_a_1" class="custom-control-label">{!! $zones['zona']['a'][1]['label'] !!}</label>
                                    </div>
                                    <small class="ml-4 mt-0 form-text text-muted">{!! $zones['zona']['a'][1]['text'] !!}</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_a_2" type="radio" id="zona_a_2" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_a_2' ? 'checked' :
                                        '' }} >
                                        <label for="zona_a_2" class="custom-control-label">{!! $zones['zona']['a'][2]['label'] !!}</label>
                                    </div>
                                    <small class="ml-4 mt-0 form-text text-muted">{!! $zones['zona']['a'][2]['text'] !!}</small>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center align-middle" style="width: 80px;" rowspan="2">ZON B</th>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_b_0" type="radio" id="zona_b_0" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_b_0' ? 'checked' :
                                        '' }} >
                                        <label for="zona_b_0" class="custom-control-label">{!! $zones['zona']['b'][0]['label'] !!}</label>
                                    </div>
                                    <small class="ml-4 mt-0 form-text text-muted">{!! $zones['zona']['b'][0]['text'] !!}</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_b_1" type="radio" id="zona_b_1" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_b_1' ? 'checked' :
                                        '' }} >
                                        <label for="zona_b_1" class="custom-control-label">{!! $zones['zona']['b'][1]['label'] !!}</label>
                                    </div>
                                    <small class="ml-4 mt-0 form-text text-muted">{!! $zones['zona']['b'][1]['text'] !!}</small>
                                </td>
                            </tr>
                            <tr class="border">
                                <th class="text-center align-middle" style="width: 80px;" rowspan="7">ZON C</th>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_c_0" type="radio" id="zona_c_0" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_c_0' ? 'checked' :
                                        '' }} >
                                        <label for="zona_c_0" class="custom-control-label">{!! $zones['zona']['c'][0]['label'] !!}</label>
                                    </div>
                                    <small class="ml-4 mt-0 form-text text-muted">{!! $zones['zona']['c'][0]['text'] !!}</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_c_1" type="radio" id="zona_c_1" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_c_1' ? 'checked' :
                                        '' }} >
                                        <label for="zona_c_1" class="custom-control-label">{!! $zones['zona']['c'][1]['label'] !!}</label>
                                    </div>
                                    <small class="ml-4 mt-0 form-text text-muted">{!! $zones['zona']['c'][1]['text'] !!}</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_c_2" type="radio" id="zona_c_2" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_c_2' ? 'checked' :
                                        '' }} >
                                        <label for="zona_c_2" class="custom-control-label">{!! $zones['zona']['c'][2]['label'] !!}</label>
                                    </div>
                                    <small class="ml-4 mt-0 form-text text-muted">{!! $zones['zona']['c'][2]['text'] !!}</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_c_3" type="radio" id="zona_c_3" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_c_3' ? 'checked' :
                                        '' }} >
                                        <label for="zona_c_3" class="custom-control-label">{!! $zones['zona']['c'][3]['label'] !!}</label>
                                    </div>
                                    <small class="ml-4 mt-0 form-text text-muted">{!! $zones['zona']['c'][3]['text'] !!}</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_c_4" type="radio" id="zona_c_4" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_c_4' ? 'checked' :
                                        '' }} >
                                        <label for="zona_c_4" class="custom-control-label">{!! $zones['zona']['c'][4]['label'] !!}</label>
                                    </div>
                                </td>
                            </tr>
                                <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_c_5" type="radio" id="zona_c_5" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_c_5' ? 'checked' :
                                        '' }} >
                                        <label for="zona_c_5" class="custom-control-label">{!! $zones['zona']['c'][5]['label'] !!}</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zona_c_6" type="radio" id="zona_c_6" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zona_c_6' ? 'checked' :
                                        '' }} >
                                        <label for="zona_c_6" class="custom-control-label">{!! $zones['zona']['c'][6]['label'] !!}</label>
                                    </div>
                                </td>
                            </tr>
                        </section>
                        <section>
                            <tr class="cell-success text-uppercase">
                                <th colspan="3">{!! $zone['c'] !!}</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle" style="width: 80px;" rowspan="6"></th>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zonc_a_0" type="radio" id="zonc_a_0" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zonc_a_0' ? 'checked' :
                                        '' }} >
                                        <label for="zonc_a_0" class="custom-control-label">{!! $zones['zonc']['a'][0]['label'] !!}</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zonc_a_1" type="radio" id="zonc_a_1" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zonc_a_1' ? 'checked' :
                                        '' }} >
                                        <label for="zonc_a_1" class="custom-control-label">{!! $zones['zonc']['a'][1]['label'] !!}</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zonc_a_2" type="radio" id="zonc_a_2" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zonc_a_2' ? 'checked' :
                                        '' }} >
                                        <label for="zonc_a_2" class="custom-control-label">{!! $zones['zonc']['a'][2]['label'] !!}</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zonc_a_3" type="radio" id="zonc_a_3" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zonc_a_3' ? 'checked' :
                                        '' }} >
                                        <label for="zonc_a_3" class="custom-control-label">{!! $zones['zonc']['a'][3]['label'] !!}</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zonc_a_4" type="radio" id="zonc_a_4" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zonc_a_4' ? 'checked' :
                                        '' }} >
                                        <label for="zonc_a_4" class="custom-control-label">{!! $zones['zonc']['a'][4]['label'] !!}</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-teal" value="zonc_a_5" type="radio" id="zonc_a_5" name="lokasi"
                                         {{ isset($activity->lokasi) && $activity->lokasi == 'zonc_a_5' ? 'checked' :
                                        '' }} >
                                        <label for="zonc_a_5" class="custom-control-label">{!! $zones['zonc']['a'][5]['label'] !!}</label>
                                    </div>
                                </td>
                            </tr>
                        </section>
            </tbody>
        </table>
        <div class="errorSlotLokasi"></div>
    </div>
</div>
