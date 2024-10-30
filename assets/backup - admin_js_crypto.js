
(function($) {
	var body = $("html, body");
    var rg__sel__cur__ = $('.rynerG_crypto_selected_currencies');
    var rg__span = rg__sel__cur__.find('span');
    var cont = '';

    $('.prevent_default').click(function(e){
        e.preventDefault();
        return false;
    });
    $('.save_selected .prevent_default').click(function(){
        $('.rg-select-currencies select').click();
    });

    $('.rynerG_crypto_selected__all button').click(function(){
        $('.rynerG_crypto_selected__all').slideUp().removeClass('active');;
        $('.rynerG_crypto_selected_currencies').slideDown();
    });

    $('.rynerG_crypto_selected__remove button').click(function(){
        $('.rynerG_crypto_selected__remove').slideUp().removeClass('active');
        $('.rynerG_crypto_selected_currencies').slideDown();
    });
    
    
    $('.rg-select-currencies select').change(function(){
    	var id = $(this).val();
    	var selected = $(this).find('option.'+id);
        var title = '<div class="rg-title"><i class="fa fa-hand-point-right"></i> &emsp; Selected Currencies </div><br>';
    	if( id == 'all'){
            cont = 'select';
    		$('.rg-select-currencies select .select_currencies_container option').addClass('im_selected');
            var numbers = $('.rg-select-currencies select .select_currencies_container').attr('data-content');
            $('.rynerG_crypto_selected__all').slideDown().addClass('active');
            $('.rynerG_crypto_selected__remove').slideUp().removeClass('active');
            $('.rg-select-currencies select').val('none');
            $('.rynerG_crypto_selected_currencies').slideUp();
            $('.rg-selected-currencies_ .rg-title').addClass('opened');
            return false;
    	}else if(id == 'remove_all'){
            cont = 'remove_all';
            $('.rynerG_crypto_selected__remove').slideDown().addClass('active');
            $('.rynerG_crypto_selected__all').slideUp().removeClass('active');
            $('.rg-select-currencies select').val('none');
            $('.rynerG_crypto_selected_currencies').slideUp();
            $('.rg-selected-currencies_ .rg-title').addClass('opened');
            return false;
        }else if(id == 'none'){
            cont = 'none';
            return false;
        }else{
            cont = 'select';
            $('.rynerG_crypto_selected__remove').slideUp();
            $('.rynerG_crypto_selected__all').slideUp();
            if( selected.hasClass('im_selected') == false ){
                selected.addClass('im_selected');
                var name = selected.attr('name');
                var cap = selected.attr('market_cap');
                var supply = selected.attr('supply');
                var price = selected.attr('price');
                var tags = '';
                if( selected.attr('tags') != '' ){
                    tags = '<br><br><strong>'+selected.attr('tags')+'</strong>';    
                }
                
                var percent_change_24h = selected.attr('percent_change_24h');
                var per = percent_change_24h.replace("-","");
                if( percent_change_24h > 0)
                    {var i = 'Increased by %'+per;}
                else
                    {var i = 'Decreased by %'+per;}
                var additional = 'Market Cap: '+cap+'<br> Supply: '+supply+'<br>Price: '+price+'<br>'+i+tags;
                var bg = "background-image:url(https://s2.coinmarketcap.com/static/img/coins/16x16/"+id+".png); background-repeat: no-repeat; background-size: 20px; background-position: left;";

                var numbers = $('.rynerG_crypto_selected_currencies span').length + 1;

                $('.rynerG_crypto_selected_currencies').append('<span value="'+id+'" id="'+id+'" style="'+bg+'"> &emsp;'+ name +'&emsp;&#10006; <div class="rg-add-selected" style="text-align:left;">'+additional+'</div> </span>');
                $('.rg-selected-currencies_ .rg-title i').text('('+numbers+')');

                rg__sel__cur__.find('span').click(function(){ remove_selected( $(this).attr('id') ); });
            }else{
                remove_selected(id);
            }    
        }      

        if( $('.rg-selected-currencies_ .rg-title').hasClass('opened') == false ){
            $('.rg-selected-currencies_ .rg-title').addClass('opened');
            rg__sel__cur__.slideDown();
        }else{
            rg__sel__cur__.fadeIn();
        }
        rg__sel__cur__.find('span').click(function(){ remove_selected( $(this).attr('id') ); });
    	
    });

    $('.rg-select-currencies .save_selected').click(function(){
        var arr = '';
        var rem_alls = $('.rynerG_crypto_selected__remove').hasClass('active');
        var alls = $('.rynerG_crypto_selected__all').hasClass('active');
        if( $('.rg-select-currencies select').val() == 'none' && (rem_alls == false && alls == false)){
            if( $('.rynerG_crypto_selected_currencies span').length == 0 ){
                arr = 'remove_all';
                $('.rg-select-currencies select option').removeClass('im_selected');    
            }else{
                return false;
            }
        }
        if( cont == 'none' ){
            arr = 'onload';
        }else if( cont == 'all' ){
            arr = 'all';
        }else if( cont == 'remove_all' ){
            arr = 'remove_all';
            $('.rg-select-currencies select option').removeClass('im_selected');
        }else if( cont == 'select'){
            if( $('.rynerG_crypto_selected_currencies span').length == 0 ){
                arr = 'remove_all';
                $('.rg-select-currencies select option').removeClass('im_selected');
            }else{
                arr = new Array();
                $('.rg-select-currencies select option').each(function(){
                    if($(this).hasClass('im_selected')){
                        arr.push($(this).attr('value'));
                    }
                });
                arr = arr.toString();    
            }
            
        }
        $('.rg-select-currencies select').val('none');
        $('.rg-selected-currencies_ .rg-pre-loader').show();
        rynerG_crypto_save_selected_currencies(arr);
    });

    function remove_selected(id){

    	$('.rg-select-currencies select').find('option.'+id).removeClass('im_selected');        
        $('.rynerG_crypto_selected_currencies span#'+id).remove();        
        $('.rg-selected-currencies_ .rg-title').addClass('opened');
        var numbers = $('.rynerG_crypto_selected_currencies span').length ;
        $('.rg-selected-currencies_ .rg-title i').text('('+numbers+')');

    };    
    function rynerg_crypto_selected_currencies(){
        var th = $('.rg-selected-currencies_ .rg-title');
        if( th.hasClass('opened') ){
            th.removeClass('opened');
            $('.rynerG_crypto_selected_currencies').slideUp();
        }else{
            th.addClass('opened');
            $('.rynerG_crypto_selected_currencies').slideDown();
        }
    }


    function rynerG_crypto_save_selected_currencies(arr){
        cont = '';
        if(arr == 'onload'){
            $('.rg-selected-currencies_ .rg-pre-loader').show();
        }
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : { action : "rynerG_crypto_select_currencies", arr : arr },
            success: function(response) {
                var num_list = response['list_num'];
                $('.rg-selected-currencies_ .rg-pre-loader').hide();
                rg__sel__cur__.html(response['result']);
                rg__sel__cur__.find('span').click(function(){ remove_selected( $(this).attr('id') ); });
                if( response['type'] == 'basic' ){
                    $('.rg-saved-notif').fadeIn(function(){
                        $(this).delay(1000).fadeOut();
                    });    
                }
                $('.rg-selected-currencies_ .rg-title i').text('('+num_list+')');
                $('.rg-select-currencies .select_currencies_container').attr('label','CURRENCIES ('+response['num']+')').html(response['select']);

                if( $('.rg-selected-currencies_ .rg-title').hasClass('opened') ){
                    $('.rg-selected-currencies_ .rg-title').removeClass('opened');
                    $('.rynerG_crypto_selected_currencies').slideUp();
                }
                $('.rynerG_crypto_selected__remove, .rynerG_crypto_selected__all').slideUp().removeClass('active');
            }
        });
    }
    $('.rg-selected-currencies_ .rg-title').click(function(){
                    rynerg_crypto_selected_currencies();
                });
    $('.rg-select-numbers .save_selected').click(function(){
        $('.rg-selected-currencies_ .rg-pre-loader').show();
        var val = $('.rg-select-numbers input').val();
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : { action : "rynerG_crypto_numbers_save_selected", val : val },
            success: function(response) {
                $('.rg-select-numbers input').val(response['result']);
                if( response['remove'] == 'true' ){
                    rynerG_crypto_save_selected_currencies('remove_all');
                }else{
                    rynerG_crypto_save_selected_currencies('num_reload');    
                }
                
                
            }
        });
    });
    rynerG_crypto_save_selected_currencies('onload');
    
    if( rg__span.length == 0){
        rg__sel__cur__.html('<p> No Currencies Selected </p>');
    }

    $('.rg__tabs .rg-title').click(function(){
        var tab = $('.rg__tabs');
        var title = $(this);
        var ret = $(this).attr('retrieve_me');
        var content = tab.find('.'+ret);

        if(title.hasClass('opening')){
            title.removeClass('opening');
            content.slideUp();
        }else{
            title.addClass('opening');
            content.slideDown();
        }                
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
    });
    function rgcs_append_selected_option(){
        rgcs_holder = 'select_specific';
        var rgcs_arr = new Array();
        $('.rynerg_cs_container .rgcs_select_options p').each(function(){
            if($(this).hasClass('rgcs_selected')){
                rgcs_arr.push($(this).attr('value'));
            }
        });
    };

    // SELECT ALL HERE
    function rgcs_save_selected_option_all(stat){
        if(stat == true){
            rgcs_holder = 'select_all';
            $('.rgcs_selected_container').slideUp();
            $('.rgcs_selected_container.rgcs_selected_items_all').slideDown();

            var rgcs_arr = new Array();

            $('.rynerg_cs_container .rgcs_select_options p').each(function(){
                rgcs_arr.push($(this).attr('value'));
            });
            $('.rgcs_selected_items_all .rgcs_selected_items_all span').text('Total of '+rgcs_arr.length+' currencies selected.');
            rgcs_arr_holder = rgcs_arr.toString();
            
        }else{
            rgcs_arr_holder = '';
            $('.rgcs_selected_container.rgcs_selected_items').slideDown();
            $('.rgcs_selected_container.rgcs_selected_items_all').slideUp();
        }        
    };

    // RESET ALL HERE
    function rgcs_save_selected_option_reset(stat){        

        if(stat == true){
            rgcs_holder = 'remove_all';
            $('.rgcs_selected_container').slideUp();
            $('.rgcs_selected_container.rgcs_selected_items_reset').slideDown();

            rgcs_arr_holder = 'remove_all';
        }else{
            rgcs_arr_holder = '';
            $('.rgcs_selected_container.rgcs_selected_items').slideDown();
            $('.rgcs_selected_container.rgcs_selected_items_reset').slideUp();
        }      
    };
    // REMOVE SPECIFIC CURRENCY HERE
    $('.rgcs_selected_items_selected .rgcs_display_selected span').click(function(){
        rgcs_arr_holder = rgcs_arr_holder;
    });

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
            rgcs_save_selected_options();
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

        }
    });

    // SAVE SELECTED NUMBER AND RATE
    function rgcs_save_selected_numbers(){
        $('.rgcs_tab_general .rgcs_pre_loader').show();
        var val = $('.rgcs_tab_general .rgcs_selected_num_max').val();

        if( $('.rgcs_refresh_rate_deactivated').hasClass('selected') ){
            ret = 'deactivated';
        }else{
            ret = 'activated';
        }


        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : { action : "rynerg_rgcs_numbers_save_selected", val : val,ret:ret },
            success: function(response) {
                $('.rgcs_tab_general .rgcs_selected_num_max').val(response['result']);
                if( response['remove'] == 'true' ){
                    rynerG_crypto_save_selected_currencies('remove_all');
                }else{
                    rynerG_crypto_save_selected_currencies('num_reload');    
                }

                $('.rgcs_refresh_rate_selection').html(response['rate_html']);
                
                $('.rgcs_tab_general .rgcs_pre_loader').hide();
                $('.rgcs_tab_general .rgcs_saved_notif').fadeIn(function(){
                    $(this).delay(1000).fadeOut();
                });
            }
        });
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
                    $('.rgcs_samples').html(response['return_select_options']);
                }else{
                    $('.rgcs_selected_items_selected .rgcs_nothing_selected').show();
                    $('.rgcs_selected_items_selected .rgcs_display_selected').hide();
                }
                
                rgcs_save_selected_option_all(false);
                rgcs_save_selected_option_reset(false);
                $('.rgcs_tab_select .rgcs_pre_loader').hide();
                $('.rgcs_tab_select .rgcs_saved_notif').fadeIn(function(){
                    $(this).delay(1000).fadeOut();
                });
                rgcs_arr_holder = response['rgcs_arr_holder'];
            }
        });
    };
    
    // SELECT REFRESH RATE
    

    $(window).load(function(){
        rgcs_arr_holder = 'reload_me';
        rgcs_save_selected_options();
        rgcs_loading = 'false';
    });

}(jQuery));