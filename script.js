$(document).ready(function(e) {
	setTimeout (function(){dedeContinue();}, 7000);
		

	//Перемещаем блок за мышкой
    var currentMousePos = { x: -1, y: -1 };
    $(document).on('mousemove', function(e) {
		var px = e.pageX - (document.getElementById('mmm').offsetWidth / 2); 
		var py = e.pageY - (document.getElementById('mmm').offsetHeight / 2) ; 
		
		$('.mouse').css({ 'transform' : 'matrix(1, 0, 0, 1, '+ px   +', '+ py +')' });
		
		if( checkMpos(e.pageX, e.pageY) == 'left'){
			$('.gra1').css({'opacity' : 1, 'height' : '100%', 'width' : '100%'});
			$('.gra2').css({'opacity' : 0, 'height' : '0%', 'width' : '0%'});
		}
		if( checkMpos(e.pageX, e.pageY) == 'right'){
			$('.gra1').css({'opacity' : 0, 'height' : '0%', 'width' : '0%'});
			$('.gra2').css({'opacity' : 1,'height' : '100%', 'width' : '100%'});
		}
    });
});

function dedeContinue(){
	$('.start-logo').fadeOut(600, function(){
		showBlocks();
	});
}

function showBlocks(){
	
	if($(window).innerWidth() < 760){
	
	setTimeout (function(){
		$('.header-logo-wrap').addClass('slideOn');
		}, 300);
	
	setTimeout (function(){
		$('.section-text').addClass('slideOn');
		}, 800);
	
	setTimeout (function(){
		$('.text-block').addClass('slideOn');
		}, 800);
			
	setTimeout (function(){
		$('.section-form').addClass('slideOn');
		}, 1300);
	
	setTimeout (function(){
		$('.section-social').addClass('slideOn');
		}, 1300);
		
	setTimeout (function(){
		$('.section-logos').addClass('slideOn');
		}, 1300);
	}
	
	if($(window).innerWidth() >= 760 && $(window).innerWidth() < 1024){
	setTimeout (function(){
		$('.header-logo-wrap').addClass('slideOn');
		}, 1000);
		
	
	setTimeout (function(){
		$('.section-text').addClass('slideOn');
		}, 500);
	
	setTimeout (function(){
		$('.text-block').addClass('slideOn');
		}, 1000);
			
	setTimeout (function(){
		$('.section-form').addClass('slideOn');
		}, 500);
	
	setTimeout (function(){
		$('.section-social').addClass('slideOn');
		}, 500);
		
	setTimeout (function(){
		$('.section-logos').addClass('slideOn');
		}, 500);
	}
	if($(window).innerWidth() >= 1024 && $(window).innerWidth() < 1160){
	setTimeout (function(){
		$('.header-logo-wrap').addClass('slideOn');
		}, 1000);
		
	
	setTimeout (function(){
		$('.section-text').addClass('slideOn');
		}, 500);
	
	setTimeout (function(){
		$('.text-block').addClass('slideOn');
		}, 1000);
			
	setTimeout (function(){
		$('.section-form').addClass('slideOn');
		}, 500);
	
	setTimeout (function(){
		$('.section-social').addClass('slideOn');
		}, 500);
		
	setTimeout (function(){
		$('.section-logos').addClass('slideOn');
		}, 500);
	}
	
	if($(window).innerWidth() >= 1160){
	setTimeout (function(){
		$('.header-logo-wrap').addClass('slideOn');
		}, 500);
			
	setTimeout (function(){
		$('.section-form').addClass('slideOn');
		}, 300);
	
	setTimeout (function(){
		$('.section-social').addClass('slideOn');
		}, 500);
		
	setTimeout (function(){
		$('.section-logos').addClass('slideOn');
		}, 1500);
	
	setTimeout (function(){
		$('.section-text').addClass('slideOn');
		}, 1000);	
	setTimeout (function(){
	  $('.atext.s1').addClass('slideOn');
		}, 1000);
	setTimeout (function(){
	  $('.atext.s2').addClass('slideOn');
		}, 1200);
	setTimeout (function(){
	  $('.atext.s3').addClass('slideOn');
		}, 1700);
	setTimeout (function(){
	  $('.atext.s4').addClass('slideOn');
		}, 2200);
	}
}

function checkMpos(mPosX, mPosY){
	/*
	x = (mPosX - bottomX) * (topY - bottomY) - (mPosY - bottomY) * (topX - bottomX)
	- Если x = 0 - значит, точка С лежит на прямой АБ.
	- Если X < 0 - значит, точка С лежит справа от прямой.
	- Если x > 0 - значит, точка С лежит слева от прямой.
	*/
	var topDotY = 60;
	var bottomDotY = 40;
	var topY = 0;
	var topX = $(document).innerWidth() * topDotY / 100;
	var bottomY = $(document).innerHeight();
	var bottomX = $(document).innerWidth() * bottomDotY / 100;
	if( ((mPosX - bottomX) * (topY - bottomY) - (mPosY - bottomY) * (topX - bottomX)) > 0 ) return 'left';
	if( ((mPosX - bottomX) * (topY - bottomY) - (mPosY - bottomY) * (topX - bottomX)) < 0 ) return 'right';
}

function af_send(){
	var af_data = {};	
	var af_titles = {};	
	
	$('.af-button').addClass('inprocess').attr('value', '');
	$('.send-field').each(function(indx, element) {

		 af_data[$(element).attr('name')] = $(element).val();
		 af_titles[$(element).attr('name')] = $(element).attr('af-title'); 
	});
								
	var ref_data ={};
	ref_data['title'] = $('title').html();
				$.ajax({ 
					url: '/feedback/ajax.php',
					type: 'POST',
					dataType: 'json',
					data: ({af_data:af_data, af_titles:af_titles, ref_data:ref_data}),
					success:  
						function(data, textStatus, jqXHR){
							$('.af-button').removeClass('inprocess').attr('value', 'Be Awesome');
							$('.ajax-form-row-error').html('');
							if(data.result == true){
								if(data.send == true){
									$('#ajax-form-cont').fadeOut('slow', function(){
										$('#ajax-form-cont').html('<div class="ajax-form-success">'+data.success+'</div>');
										$('#ajax-form-cont').fadeIn('slow');
									});
								}else{
									$('#ajax-form-cont').fadeOut('slow', function(){
										$('#ajax-form-cont').html('<div class="ajax-form-fail">'+data.error+'</div>');
										$('#ajax-form-cont').fadeIn('slow');
									});
								}
							}else{
								for(var i in data.error_fields){
									$('#af-field-error-'+i).html('<div class="error-text">'+data.error_fields[i]+'</div>');
								}
								if(data.error != false){
									$('#ajax-form-error').html(data.error).addClass('show');
								}
							}
						},
					error: 
						function(){
						}
				});	

}