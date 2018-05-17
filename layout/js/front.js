$(function(){

	'use strict';


	
	  $(function() {

    //Calls the selectBoxIt method on your HTML select box and updates the showEffect option
    $("select").selectBoxIt({ showEffect: "fadeIn" ,
    	autoWidth: false

	});

  });

	$('[placeholder]').focus(function(){

		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder',' ');

	}).blur(function(){
		$(this).attr('placeholder',$(this).attr('data-text'));

	
	});

	$('input').each(function(){
		if($(this).attr('required')){

			$(this).after("<span class='astrisk'>*</span>");
		}

	});

	//switch btween login and sign up
	$('.login-page h1 span').click(function(){

		if($(this).data('class')=='login'){
			$(this).addClass('lchoose').siblings().removeClass('schoose');

	}

		if($(this).data('class')=='signup'){
			$(this).addClass('schoose').siblings().removeClass('lchoose');

	}

		
		$('.login-page form').hide();
		$('.'+ $(this).data('class')).fadeIn(100);
	}) ;

	$('.show-signpass').hover(function(){

		$('.signpass').attr('type','text');
		$(this).addClass("fa fa-eye-slash" ).siblings().removeClass("fa fa-eye" );

	},function(){
		$('.signpass').attr('type','password');
		$('.show-signpass').removeClass("fa fa-eye-slash" ).addClass("fa fa-eye" );
	});


	//live preview ads

	$('.ads-form input').keyup(function(){

		if($(this).hasClass('live-name')){

			$('.live-preview .caption h3').text($(this).val());
		}else if($(this).hasClass('live-desc')){

			$('.live-preview .caption p').text($(this).val());
		}else if($(this).hasClass('live-price')){

			$('.live-preview .item-price').text('$' + $(this).val());
		}
	});

});
