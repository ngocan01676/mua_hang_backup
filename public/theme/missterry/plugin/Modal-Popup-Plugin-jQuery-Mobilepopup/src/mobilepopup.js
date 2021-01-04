/*
    ver 1.6
    $.mobilepopup jQuery plugin
    2017 Alexey Dudka
*/

(function($) {

	var defaults = {   
        ajax: '',
        html: '',
        targetblock: '',
        content: {
            header: '',
            content: '',
            footer: ''
        },

        type: 'standart', //'confirm'
        confirmcontent: {
            header: "Confirm your action",
            content: "Are you sure you want to continue?",
            buttonoktext: "Yes",
            buttonnotext: "Cancel"
        },

        width: '',
        height: '',

        submitformbutton: '.submit-mobilepopup-form',
        popupform: '.mobilepopup-form',

        closeonoverflowclick: true,
        shakeonoverflowclick: true,
        fullscreeninmobile: true,

        closehtml: '<a href="" class="button-close close"></a>',
        loadinghtml: '<div class="loader-wrap"><div class="loader"><span></span><span></span><span></span></div></div>',
        customclass: '',

        onloaded : function(el){
            return true;
        },
        onclosed : function(el){
            return true;
        },
        onconfirmed : function(el){
            return true;
        },
        onformsubmited : function(data,el){ 
            return true;
        }
    }; 

    var options = defaults,
    	popupblock_class = "mobilepopup",
    	popupoverflow_class = "mobilepopup-overflow",
        popupouter_class = "mobilepopup-outer",
    	popupinner_class = "mobilepopup-inner",
        confirmokformbutton = ".confirmok-mobilepopup-form",
        confirmnoformbutton = ".confirmno-mobilepopup-form",
        _window = $(window),
        shakeonoverflowclicktimeout = 0,
    	popupblock = popupoverflow = popupouter = popupinner = "";

	var methods = {
	    init : function(args) { 
            var opt = {};
	    	options = $.extend(opt, defaults, args);
	    	currenttopposition = $("body").scrollTop();
	      	append_html_to_body();
            set_popup_outer_sizes();
	    	get_popup_content();
	    	popupblock.addClass("open");
	    	$("body").addClass("mobilepopup-opened");
            addremovemobilefullscreen();
	    },
	    reload: function(args) {
            if(options.type=="standart"&&$.trim(options.targetblock)!=""){
                $(options.targetblock).html(popupinner.find(">*"));
            }
            options = $.extend(options, args);
            popupblock.attr("class",popupblock_class+" "+options.customclass+" open loading");
            set_popup_outer_sizes();
	    	get_popup_content();
            addremovemobilefullscreen();
	    },
        resize: function(args) {
            options = $.extend(options, args);
            set_popup_outer_sizes();
        },
	    close : function( ) {
	    	popupblock.removeClass("open");
	    	$("body").removeClass("mobilepopup-opened");
            if(options.type=="standart"&&$.trim(options.targetblock)!=""){
                $(options.targetblock).html(popupinner.find(">*"));
            }else{
                popupinner.html("");
            }
            options.onclosed(popupblock);
	    }
	};

	var append_html_to_body = function(){
    	if($("."+popupblock_class).length==0){
    		$("body").append("<div class='"+popupblock_class+" "+options.customclass+" loading'><div class='"+popupoverflow_class+"'></div><div class='"+popupouter_class+"'><div class='"+popupinner_class+"'></div>"+options.closehtml+options.loadinghtml+"</div></div>");
    		popupblock = $("."+popupblock_class);
		    popupoverflow = $("."+popupoverflow_class);
            popupinner = $("."+popupinner_class);
		    popupouter = $("."+popupouter_class);
            init_actions();
    	}
    }

    var addremovemobilefullscreen = function(){
        if(!options.fullscreeninmobile){
            popupouter.addClass("disable-mobile-fullscreen");
        }else{
            popupouter.removeClass("disable-mobile-fullscreen");
        }
    }

    var set_popup_outer_sizes = function(){
        var sizes = "";
        if($.trim(options.width)!=""){
            sizes += "width:"+options.width+";";
        }
        if($.trim(options.height)!=""){
            sizes += "height:"+options.height+";";
        }
        popupouter.attr("style",sizes);
        set_poppup_max_sizes();
    }

    var get_popup_content = function(){
        switch(options.type){
            case "standart":
                if($.trim(options.ajax)!=""){
                    $.post(options.ajax,function(data){
                        popupinner.html(data);
                        popupblock.removeClass("loading");
                        options.onloaded(popupblock);
                    });
                }else{
                    if($.trim(options.html)!=""||$.trim(options.targetblock)!=""){
                        popupinner.html($.trim(options.html)!="" ? options.html : $(options.targetblock).find(">*"));
                        popupblock.removeClass("loading");
                        options.onloaded(popupblock);
                    }else{
                        if($.trim(options.content.content)!=""||$.trim(options.content.header)!=""||$.trim(options.content.footer)!=""){
                            popupinner.html("<div class='header'>"+options.content.header+"</div><div class='content'>"+options.content.content+"</div><div class='footer'>"+options.content.footer+"</div>");
                            popupblock.removeClass("loading");
                            options.onloaded(popupblock);
                        }
                    }
                } 
                break;
            case "confirm":
                popupinner.html("<div class='header'>"+options.confirmcontent.header+"</div><div class='content'>"+options.confirmcontent.content+"</div><div class='footer'><a href='' class='button confirmok-mobilepopup-form'>"+options.confirmcontent.buttonoktext+"</a><a href='' class='button button-gray confirmno-mobilepopup-form'>"+options.confirmcontent.buttonnotext+"</a></div>");
                popupblock.removeClass("loading");
                options.onloaded(popupblock);
                break;
        }
    	
    }

    var set_poppup_max_sizes = function(){
        popupouter.css({"max-width":(_window.innerWidth()-20)+"px","max-height":(_window.innerHeight()-20)+"px"});
    }

    var init_actions = function(){
    	popupoverflow.on("click",function(){
            if(options.closeonoverflowclick){
		        methods.close();
            }else{
                if(options.shakeonoverflowclick&&!popupouter.hasClass("shake-popup")){
                    popupouter.addClass("shake-popup");
                    clearTimeout(shakeonoverflowclicktimeout);
                    shakeonoverflowclicktimeout = setTimeout(function(){
                        popupouter.removeClass("shake-popup");
                    },500);
                }
            }
    		return false;
    	});
    	popupblock.on("click",".close,"+confirmnoformbutton,function(){
    		methods.close();
    		return false;
    	});
        popupblock.on("click",confirmokformbutton,function(){
            options.onconfirmed(popupblock);
            methods.close();
            return false;
        });
        popupblock.on("click",options.submitformbutton,function(){
            var form = popupblock.find(options.popupform);
            if(form.length>0){
                popupblock.addClass("loading");
                $.post(form.attr("action")+"?"+form.serialize(),function(data){
                    options.onformsubmited(data,popupblock);
                    popupblock.removeClass("loading");
                });
            }
            return false;
        });
        _window.on('orientationchange resize', function() {
            set_poppup_max_sizes();
        });
    }

	$.mobilepopup = function(method, options){
		if ( methods[method] ) {
      		return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    	} else if ( typeof method === 'object' || ! method ) {
      		return methods.init.apply( this, arguments );
    	} else {
      		$.error( 'Method ' +  method + ' not found for mobilepopup' );
    	} 
	}
})(jQuery);