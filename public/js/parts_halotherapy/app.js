$(document).ready(function(){
    $(".gallery-block .owl-carousel").owlCarousel({
        items: 5,
        margin: 30,
        nav: true,
        dots: false,
        navText: [
            '<i class="fas fa-chevron-left"></i>',
            '<i class="fas fa-chevron-right"></i>',
        ],
        responsive: {
            0: {
                items: 1,
                margin: 0,
            },
            768: {
                items: 4,
                margin: 15,
            },
            992: {
                items: 5,
            }
        }
    });
    
    $('.faq-block .question').click(function(){
        if($(this).closest('.item').hasClass('open')){
            $(this).closest('.item').removeClass('open');
        }else{
            $(this).closest('.item').addClass('open')
        }
    });
    
    $("select[name=country]").change(function(){
        let country_code = $('option:selected', this).attr('data-country-code');
        $(this).closest("form").find('select[name=state] option[data-country-code]').addClass('d-none');
        if(country_code != undefined){       
            $(this).closest("form").find('select[name=state] option[data-country-code=' + country_code + ']').removeClass('d-none');
        }
    });
    
    $('.pay-form').ajaxForm({ 
        beforeSubmit: function(formData, form, options){
            $(form).find('input[type=submit]').attr('disabled', true);
            $(form).find('.error-item').remove();
            $(form).find('.error-field').removeClass('error-field');
            $(form).find('.form-error').html('');
            $(form).find('.form-success').html('');
        },
        success: function(response, status, xhr, form){
            $(form).find('input[type=submit]').attr('disabled', false);
            if(response.errors != undefined){
                $.each(response.errors, function(field_id, error){
                    if(field_id == 'recapthca_error'){
                        $(form).find('.recaptcha-block').append('<span class="error-item d-block text-right">' + error + '</span>');
                    }else{
                        $(form).find('[name=' + field_id + ']').before('<span class="error-item">' + error + '</span>');
                        $(form).find('[name=' + field_id + ']').addClass('error-field');
                    }
                });
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(form).find(".error-item").offset().top
                }, 300);
            }else{
                $(form).find('.form-success').html('<div class="alert alert-success" role="alert">' + response.msg + '</div>');
                $(form).resetForm();
                $("form[name='pay_form']").submit();
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
});