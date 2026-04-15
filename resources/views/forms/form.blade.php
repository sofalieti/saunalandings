@if(isset($form_id))
    <?php $form = \App\CustomForm::where(['id' => $form_id, 'active' => 1])->first();?>
    @if($form)
        @if($form->form_fields)
        <form action="{{route_with_state('send_form', [])}}" method="post" enctype="multipart/form-data" class="custom-form custom-form-{{$form->id}} {{$form->css_class}}">
            {{ csrf_field() }}
            <div class='form-title'>{{$form->title}}</div>
            <div class="custom-form-error"></div>
            <div class="custom-form-success"></div>
            @if(!empty($form->header_text))
            <div class='form-header-text'>{{$form->header_text}}</div>
            @endif
            <div class='form-block'>
                <div class='row'>
                    <div class="subject col-12 form-group">
                        <input type="text" name="subject_msg_4" class="form-control" value="" autocomplete="new-password"/>
                    </div>
                    @foreach($form->form_fields as $field)
                    <div class='{{!empty($field->css_class) ? $field->css_class : 'col-md-12'}}'>
                        <div class='form-group'>
                            @include("forms.fields.{$field->type}", ['field' => $field])
                        </div>
                    </div>
                    @endforeach
                    @if($form->use_captcha)
                    <div class="col-md-12 text-right recaptcha-block">
                        <div id="recaptcha_{{$form->id}}" class="g-recaptcha" data-sitekey="6LcgS1gUAAAAAIn8Ix2w2Bg2OeAZJ-F-_9c_XmBe"></div>
                        <div style="clear: both"></div>
                    </div>
                    @endif
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary" value="{{empty($form->button_text) ? "Send" : $form->button_text}}"/>
                    </div>
                </div>
            </div>
            @if(!empty($form->footer_text))
            <div class='form-footer-text'>{{$form->footer_text}}</div>
            @endif
        </form>
        @else
        <div class="alert alert-danger" role="alert">
            Form fields not found
        </div>
        @endif
    @else
    <div class="alert alert-danger" role="alert">
        Form not found
    </div>
    @endif
@else
<div class="alert alert-danger" role="alert">
    Form not found
</div>
@endif