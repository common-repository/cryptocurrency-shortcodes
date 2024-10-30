
(function($) {
    var body = $("html, body");
    var rg__sel__cur__ = $('.rynerG_crypto_selected_currencies');
    var rg__span = rg__sel__cur__.find('span');
    var cont = '';

    $('.prevent_default').click(function(e){
        e.preventDefault();
        return false;
    });



    // UPDATED
    var rgcs_holder = '';
    var rgcs_arr_holder = '';
    var rgcs_container = $('.rynerg_cs_container');
    var rgcs_tab_btn = rgcs_container.find('.rgcs_tab_btn');
    var rgcs_tab_contents = rgcs_container.find('.rgcs__tab_contents');
    var rgcs_loading = 'true';

    rgcs_tab_btn.click(function(){
        if(rgcs_loading == 'true'){

        }else{
            var retrieve_me = $(this).attr('retreive_me');
            if( $(this).hasClass('active') ){
                return false;
            }else{
                rgcs_tab_btn.removeClass('active');
                $(this).addClass('active');
                rgcs_tab_contents.find('.rgcs__tab_content').slideUp();
                rgcs_tab_contents.find('.'+retrieve_me).slideDown();
            }    
        }
        
    });

    // SELECT HERE
    $('.rgcs_tab_select .rgcs_select_search_btn').click(function(){        
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $('.rgcs_tab_select .rgcs_select_options').slideUp();
        }else{
            $(this).addClass('active');
            $('.rgcs_tab_select .rgcs_select_options').slideDown();
        }
    });

    $('.rynerg_cs_container .rgcs_select_options p').click(function(){
        if($(this).hasClass('rgcs_selected')){
            $(this).removeClass('rgcs_selected');     
        }else{
            $(this).addClass('rgcs_selected');            
        }
        rgcs_holder = 'specific';
    });    

    // SELECT ALL HERE
    function rgcs_save_selected_option_all(stat){
        if(stat == true){
            rgcs_holder = 'select_all';
            $('.rgcs_selected_container').slideUp();
            $('.rgcs_selected_container.rgcs_selected_items_all').slideDown();            

            $('.rynerg_cs_container .rgcs_select_options p').addClass('rgcs_selected');
            count = $('.rynerg_cs_container .rgcs_select_options p.rgcs_selected').length;
            $('.rgcs_selected_items_all .rgcs_selected_items_all span').text('Total of '+count+' currencies selected.');
        }else{
            // rgcs_arr_holder = '';
            $('.rgcs_selected_container.rgcs_selected_items').slideDown();
            $('.rgcs_selected_container.rgcs_selected_items_all').slideUp();
            $('.rynerg_cs_container .rgcs_select_options p').removeClass('rgcs_selected');
        }        
    };



    // RESET ALL HERE
    function rgcs_save_selected_option_reset(stat){        

        if(stat == true){
            rgcs_holder = 'remove_all';
            $('.rgcs_selected_container').slideUp();
            $('.rgcs_selected_container.rgcs_selected_items_reset').slideDown();
            $('.rynerg_cs_container .rgcs_select_options p').removeClass('rgcs_selected');
            rgcs_arr_holder = 'remove_all';
        }else{
            // rgcs_arr_holder = '';
            $('.rgcs_selected_container.rgcs_selected_items').slideDown();
            $('.rgcs_selected_container.rgcs_selected_items_reset').slideUp();
        }      
    };
    

    // SEARCH HERE
    $('.rynerg_cs_container .rgcs_search_currency').keyup(function(){
        var search = $(this).val();
        search = search.toString().toLowerCase();
        $('.rynerg_cs_container .rgcs_select_options p').hide();
        $('.rynerg_cs_container .rgcs_select_options p').each(function(){
            var name = $(this).attr('name');
            name = name.toString().toLowerCase();
            if( name.indexOf(search) > -1 ){
                $(this).show();
            }
        });
    });

    // SAVE BUTTONS HERE 
    $('.rgcs_save_btn').click(function(){        
        var action = $(this).attr('data-action');
        var stat = $(this).hasClass('rgcs_cancel');

        if(action == 'save_selected_number'){

            rgcs_save_selected_numbers();

        }else if(action == 'save_selected_option'){

            rgcs_update_selected_option();

        }else if(action == 'save_selected_option_all'){

            if(stat){
                $(this).removeClass('rgcs_cancel');
            }else{
                $('.rgcs_save_btn').removeClass('rgcs_cancel');
                $(this).addClass('rgcs_cancel');
            }
            stat = $(this).hasClass('rgcs_cancel');
            rgcs_save_selected_option_all(stat);

        }else if(action == 'save_selected_option_reset'){

            if(stat){
                $(this).removeClass('rgcs_cancel');
            }else{
                $('.rgcs_save_btn').removeClass('rgcs_cancel');
                $(this).addClass('rgcs_cancel');
            }
            stat = $(this).hasClass('rgcs_cancel');            
            rgcs_save_selected_option_reset(stat);

        }else if( action == 'view_selected_option' ){
            rgcs_view_sample_shortcodes();
        }
    });

    // SAVE SELECTED NUMBER
    function rgcs_save_selected_numbers(){
        $('.rgcs_tab_general .rgcs_pre_loader').show();
        var val = $('.rgcs_tab_general .rgcs_selected_num_max').val();
        var ret = $('.rgcs_refresh_rate_select.selected').attr('data_type');

        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : { action : "rynerg_rgcs_numbers_save_selected", val : val , ret : ret },
            success: function(response) {
                $('.rgcs_tab_general .rgcs_selected_num_max').val(response['result']);
                console.log(response['ret']);
                if( response['ret'] == 'activated' ){
                    $('.rgcs_selected_num_max').keyup(function(){
                        if( $('.rgcs_selected_num_max').val() > 30 ){
                            $('.rgcs_selected_num_max').val('30');
                        }
                    });
                }

                $('.rgcs_select_options').fadeIn(function(){
                    $(this).delay(0100).fadeOut();
                });
                $('.rgcs_tab_general .rgcs_pre_loader').hide();
                $('.rgcs_tab_general .rgcs_saved_notif').fadeIn(function(){
                    $(this).delay(1000).fadeOut();
                });
            }
        });
    };

    // UPDATE SELECTED OPTIONS UPON SAVE
    function rgcs_update_selected_option(){
        

        // rgcs_holder = 'select_specific';
        var rgcs_arr = new Array();
        $('.rynerg_cs_container .rgcs_select_options p').each(function(){
            if($(this).hasClass('rgcs_selected')){
                rgcs_arr.push($(this).attr('value'));
            }
        });

        if(rgcs_holder == ''){
            rgcs_arr_holder = 'reload_me';
        }
        else if(rgcs_holder == 'remove_all' || rgcs_arr.length == 0 ){
            rgcs_arr_holder = 'remove_all';
        }
        else{
            rgcs_arr_holder = rgcs_arr.toString();
        }
        
        rgcs_save_selected_options();
    };

    // SAVE SELECTED OPTION
    function rgcs_save_selected_options(){
        if(rgcs_arr_holder == ''){
            rgcs_arr_holder == 'remove_all';
        }         
        $('.rgcs_tab_select .rgcs_pre_loader').show();
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : { action : "rynerg_rgcs_select_currencies", rgcs_arr_holder : rgcs_arr_holder },
            success: function(response) {                

                if( response['return_count'] != 0 ){
                    $('.rgcs_selected_items_selected .rgcs_nothing_selected').hide();
                    $('.rgcs_selected_items_selected .rgcs_display_selected').html( response['return_selected_items'] ).show();
                    rgcs_arr_holder = response['rgcs_arr_holder'];
                    
                }else{
                    $('.rgcs_selected_items_selected .rgcs_nothing_selected').show();
                    $('.rgcs_selected_items_selected .rgcs_display_selected').hide();
                    rgcs_arr_holder = 'reload_me';

                }

                $('.rgcs_save_btn').removeClass('rgcs_cancel');
                rgcs_save_selected_option_all(false);
                rgcs_save_selected_option_reset(false);

                $('.rgcs_tab_select .rgcs_pre_loader').hide();
                $('.rgcs_tab_select .rgcs_saved_notif').fadeIn(function(){
                    $(this).delay(0600).fadeOut();
                });

                
                rgcs_refresh_everything(response['num_retrieve']);

            }
        });
    };

    // REFRESH EVERYTHING
    function rgcs_refresh_everything(num_retrieve){

        // UPDATE OPTIONS
        $('.rynerg_cs_container .rgcs_select_options p').each(function(){
            var class_item = parseInt($(this).attr('item_num'));
            num_retrieve = parseInt(num_retrieve);
            if (class_item > num_retrieve){
                $(this).remove();
            }
        });
        
        if(rgcs_arr_holder != 'reload_me'){
            var ret_option = rgcs_arr_holder.split(',');            
            ret_option.map(function(content){
                // console.log(content);
                content = content.toString();
                $('.rynerg_cs_container .rgcs_select_options p.'+content).addClass('rgcs_selected');
            });            
        }

        // REMOVE SPECIFIC COINS HERE
        $('.rgcs_selected_items_selected .rgcs_display_selected span').click(function(){           
            $('.rynerg_cs_container .rgcs_select_options p.'+$(this).attr('value')).removeClass('rgcs_selected');
            $(this).remove();            
        });
    };

    function rgcs_view_sample_shortcodes(){
        var rgcs_sample_shortcode = $('.rgcs_view_selected_option_shortcode').val();
        rgcs_sample_shortcode = rgcs_sample_shortcode.toString().toLowerCase();                
        if( rgcs_sample_shortcode.indexOf("list") > -1 ){            
            rgcs_return_sample_shortcodes('list',rgcs_sample_shortcode);            
            return false;
        } else if( rgcs_sample_shortcode.indexOf("carousel") > -1 ){            
            rgcs_return_sample_shortcodes('carousel',rgcs_sample_shortcode);
            return false;
        }else{
            rgcs_return_sample_shortcodes('list',rgcs_sample_shortcode);
            return false;
        }
        
    };
    function rgcs_return_sample_shortcodes(type, rgcs_sample_shortcode){
        $('.rgcs_tab_select .rgcs_pre_loader').show();
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : { action : "rynerg_rgcs_view_sample_shortcodes", type : type, rgcs_sample_shortcode: rgcs_sample_shortcode },
            success: function(response) {                            
                $('.rgcs_tab_select .rgcs_pre_loader').hide();                                
                if( response['content_stat'] == 'empty' ){
                    $('.rgcs_view_selected_items_as_shortcode').html('<p class="rgcs_error_notif_relative"><span>'+response['content_type']+' Shortcode:</span> Please select atleast one(1) item to display.</p>');
                }else{
                     $('.rgcs_view_selected_items_as_shortcode').html(response['content']);
                }
            }
        });
    };

    $('.rgcs_refresh_rate_select').click(function(){
        refresh_type = $(this).attr('data_type');

        if( $(this).hasClass('selected') ){
            $(this).removeClass('selected');
            if( refresh_type == 'deactivate' ){
                $('.rgcs_refresh_rate_activated').addClass('selected');
            }else{
                $('.rgcs_refresh_rate_deactivated').addClass('selected');
            }
        }else{
            $(this).addClass('selected');
            if( refresh_type == 'deactivate' ){
                $('.rgcs_refresh_rate_activated').removeClass('selected');
            }else{
                $('.rgcs_refresh_rate_deactivated').removeClass('selected');
            }
        }
    });

    $(window).load(function(){

        rgcs_arr_holder = 'reload_me';        
        rgcs_loading = 'false';
        rgcs_holder == '';
        rgcs_update_selected_option();
        

    });

}(jQuery));