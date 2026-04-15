<?php $i = 1;?>
@foreach($field->select_and_radio_values_obj() as $value => $text_value)
<?php $i++?>
<div class="form-check">
    <input class="form-check-input" type="radio" name="form[{{$field->custom_form->id}}][{{$field->id}}]" id="field_{{$field->id}}_{{$i}}" value="{{$value}}" {{ $field->required ? "required" : "" }}>
    <label class="form-check-label" for="field_{{$field->id}}_{{$i}}">
      {{$text_value}}
    </label>
</div>
@endforeach