<label for="field_{{$field->id}}">{{$field->name}} {!! $field->required ? "<span class='form-required-star'>*</span>" : "" !!}</label>
<select id="field_{{$field->id}}" name="form[{{$field->custom_form->id}}][{{$field->id}}]" class="form-control" {{ $field->required ? "required" : "" }}>
    <option value="">---</option>
    @foreach($field->select_and_radio_values_obj() as $value => $text_value)
    <option value="{{$value}}">{{$text_value}}</option>
    @endforeach
</select>