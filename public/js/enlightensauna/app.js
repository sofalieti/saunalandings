$(document).ready(function () {
    /*var windowHeight = $(window).height();
    $(document).on('scroll', function () {
        $('.section').each(function () {
            var section= $(this),
                sectionHeight = parseInt($(section).height()),
                sectionTop = parseInt($(section).offset().top);
            
            //if ($(document).scrollTop() + windowHeight >= height) {
            //    console.log($(self).attr('id'));
            //}
            if($(document).scrollTop() > sectionTop - 150 && $(document).scrollTop() <= (sectionTop + sectionHeight)){
                var a = $('.navbar .nav-link[href="#' + $(section).attr('id') + '"]');
                if(!$(a).hasClass('active')){
                    $('.navbar .nav-link').removeClass('active');
                    $(a).addClass('active');
                }
            }
        });
    });
    $('.navbar .nav-link').click(function(){
        var id = $(this).attr('href');
        $([document.documentElement, document.body]).animate({
            scrollTop: $(id).offset().top - 100
        }, 500);
        return false;
    });*/
});