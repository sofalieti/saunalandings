$(function() {
    // Apply mask immediately to all existing phone fields.
    function initPhoneMask(context) {
        $(context || document).find('.phone-mask, .phone-mask-block .form-control').each(function() {
            if (!$(this).data('masked')) {
                $(this).inputmask("+1-999-999-9999", { placeholder: "+1-___-___-____" });
                $(this).data('masked', true);
            }
        });
    }
    initPhoneMask();

    // Also init when a modal opens (lazy-loaded forms).
    $(document).on('show.bs.modal', function(e) {
        initPhoneMask(e.target);
    });
    $('.custom-form').ajaxForm({ 
        beforeSubmit: function(formData, form, options){
            $(form).find('input[type=submit]').attr('disabled', true);
            $(form).find('.error-item').remove();
            $(form).find('.error-field').removeClass('error-field');
            $(form).find('.custom-form-error').html('');
            $(form).find('.custom-form-success').html('');
        },
        success: function(response, status, xhr, form){
            $(form).find('input[type=submit]').attr('disabled', false);
            if(response.errors != undefined){
                $.each(response.errors, function(field_id, error){
                    if(field_id == 'recapthca_error'){
                        $(form).find('.recaptcha-block').append('<span class="error-item">' + error + '</span>');
                    }else{
                        $('#field_' + field_id).before('<span class="error-item">' + error + '</span>');
                        $('#field_' + field_id).addClass('error-field');
                    }
                });
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(form).find(".error-item").offset().top
                }, 300);
            }else if(response.error != undefined){
                $(form).find('.custom-form-error').html('<div class="alert alert-danger" role="alert">' + response.error + '</div>');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(form).offset().top
                }, 300);
            }else{
                $(form).find('.custom-form-error').html('<div class="alert alert-success" role="alert">' + response.msg + '</div>');
                $(form).resetForm();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(form).offset().top
                }, 300);
            }
            if($('.g-recaptcha').length){
                $.each(recaptcha, function(key, obj){
                    grecaptcha.reset(obj);
                });
            }
        }
    }); 
    
    $('.open-sub-menu').click(function(){
        if(!$(this).hasClass('opened')){
            $(this).addClass('opened');
            $(this).html('<i class="fas fa-chevron-down"></i>');
            $(this).next('.dropdown-menu').css('display', 'block');
        }else{
            $(this).removeClass('opened');
            $(this).html('<i class="fas fa-chevron-right"></i>');
            $(this).next('.dropdown-menu').css('display', 'none');
        }
    });
});