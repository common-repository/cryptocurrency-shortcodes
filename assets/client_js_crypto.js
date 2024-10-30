
(function($) {
    $(document).ready(function () {

        console.log('testing something...');
        if( $('body').hasClass('rynerg_crypto_shortcode_carousel_active') ){
            rynerg_rgcs_carousel();

        }
        
    });

    function rynerg_rgcs_carousel(){

        max_countdown = $('.rgcs_shortcode_carousel_container').attr('max_countdown');
        c_speed = $('.rgcs_shortcode_carousel_container').attr('c_speed');
        c_data_per_slide = $('.rgcs_shortcode_carousel_container').attr('c_data_per_slide');

        jQuery.ajax({
            type : "post", dataType : "json", url : myAjax.ajaxurl,
            data : { action : "rynerg_rgcs_carousel" , max_countdown: max_countdown, c_speed: c_speed, c_data_per_slide: c_data_per_slide},
            success: function(res) {
                console.log('ajax working...');
                $('.rgcs_shortcode_carousel_container').html(res['s']);
                console.log('response: ' +res);
                setTimeout(function(){ rsg_carousel_start(res['c_speed'], res['c_num']); }, 1000);
                
            },
            error: function(){
                console.log('ajax failed!');
            }
        });
    }

    function rsg_carousel_start(c_speed, c_num){
        $('.rynerg_rgcs_get_sample_shortcode_carousel').css('visibility','visible');
        $('.rgcs_shortcode_carousel_container').slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed:0,
            speed: c_speed,
            cssEase: 'linear',
            slidesToShow: c_num,
            slidesToScroll: 1,
            arrows: false,
            centerMode: false,
            pauseOnHover:true,
            responsive:[
            {
                breakpoint: 1800,
                settings:{
                    slidesToShow:5
                }
            },
            {
                breakpoint: 1550,
                settings:{
                    slidesToShow:4
                }
            },
            {
                breakpoint: 1250,
                settings:{
                    slidesToShow:3
                }
            },
            {
                breakpoint: 950,
                settings:{
                    slidesToShow:2
                }
            },
            {
                breakpoint: 460,
                settings:{
                    slidesToShow:1
                }
            },
            ]
        }).css('visibility','visible');
    }

    

}(jQuery));