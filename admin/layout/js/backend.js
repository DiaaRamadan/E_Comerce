$(function(){


	'use strict';
	//trigger the select box

	  $(function() {

    //Calls the selectBoxIt method on your HTML select box and updates the showEffect option
    $("select").selectBoxIt({ showEffect: "fadeIn" ,
    	autoWidth: false

	});

  });

	//Hide placeholder on form focus


	$('[placeholder]').focus(function(){

		$(this).attr('data-text', $(this).attr('placeholder'))
		$(this).attr('placeholder', '');
	}).blur(function(){
		$(this).attr('placeholder',$(this).attr('data-text'));
	});

	//Add * in required fields

	$('input').each(function(){

		if($(this).attr('required')==='required'){

			$(this).after('<span class="astrisk">*</span>');

		}
	});

	//convert password into string

	var passfield=$('.password');

	$('.show-pass').hover(function(){
		passfield.attr('type','text');


	},function(){

		passfield.attr('type','password');

	});

	$('.confirm').click(function(){

		return confirm('Are You Sure?')
	});

	// catagory view option

	$('.cat h3').click(function() {

		$(this).next('.full-view').fadeToggle(200);
	});

	$('.options span').click(function(){

		$(this).addClass('active').siblings('span').removeClass('active');


		if($(this).data('view')==='full'){

			$('.cat .full-view').fadeIn(200);

		}else{
			$('.cat .full-view').fadeOut(200);
		}
	});


	$('.toggle-info').click(function(){

		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(500);

		if($(this).hasClass('selected')){

			$(this).html('<i class="fa fa-minus"></i>')

		}else{
			$(this).html('<i class="fa fa-plus"></i>')

		}
	});
});