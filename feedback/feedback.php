<? session_start();?>

<div class="ajax-form-popup" id="ajax-form">
	<h3>Хотите уточнить стоимость интересующей Вас услуги? Пишите, мы ответим <span>обратным письмом!</span></h3>
	
	<div class="ajax-form-wrap" id="ajax-form-wrap">
		
        <div id="ajax-form-cont">
	       
       		<div id="ajax-form-error" class="popup-error"></div>
        	<div class="flex-child child-1">
          	<? $val_name = 'name'; ?>
        	<div class="ajax-form-row">
            	<input type="text" class="af-<?=$val_name?> r5 send-field req" id="af-field-<?=$val_name?>" af-title="Имя" placeholder="Ваше имя" name="<?=$val_name?>"  value="" />
                <div class="ajax-form-row-error" id="af-field-error-<?=$val_name?>"></div>
            </div>
			
          
             <? $val_name = 'phone'; ?>
        	<div class="ajax-form-row">
           		<input type="text" class="af-<?=$val_name?> r5 send-field req" id="af-field-<?=$val_name?>" af-title="Телефон" placeholder="Контактный телефон" name="<?=$val_name?>" value="" />
                 <div class="ajax-form-row-error" id="af-field-error-<?=$val_name?>"></div>
            </div>
        </div>
			<div class="flex-child child-2">
            <? $val_name = 'message'; ?>
        	<div class="ajax-form-row next-column">
           		<p class="field-title">Ваш вопрос:</p>
            	<textarea class="af-<?=$val_name?> r5 send-field req" id="af-field-<?=$val_name?>" af-title="Сообщение" name="<?=$val_name?>"> </textarea>
                 <div class="ajax-form-row-error" id="af-field-error-<?=$val_name?>"></div>
            </div>
            
        
            <div class="ajax-form-row">
            	<input type="button" class="af-button  anim r5" id="" name="" value="Отправить" onClick="af_send_popup_vopros()" /><div class="cl"></div>
            </div>
            </div>
      </div>
      
      
    </div>
</div>

<script>
function af_send_popup_vopros(){
	var af_data = {};	
	var af_titles = {};	
	
	$('.af-button').addClass('inprocess').attr('value', '');

	$('.send-field').each(function(indx, element) {
	//	alert();
		//console.log($(element).attr('name')+'='+$(element).val());
		 af_data[$(element).attr('name')] = $(element).val();
		 af_titles[$(element).attr('name')] = $(element).attr('af-title'); 

	});
								
	var ref_data ={};
	ref_data['title'] = $('title').html();
				$.ajax({ 
					url: '/feedback_popup_vopros/ajax.php',
					type: 'POST',
					dataType: 'json',
					data: ({af_data:af_data, af_titles:af_titles, ref_data:ref_data}),
					success:  
						function(data, textStatus, jqXHR){
							$('.af-button').removeClass('inprocess').attr('value', 'Отправить');
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
   									//console.log('obj[' + i + '] = ' + eventObject[i]);
									$('#af-field-error-'+i).html(data.error_fields[i]);
								}
								if(data.error != false){
									$('#ajax-form-error').html(data.error).addClass('show');
								}
								/*
								$('#af-process').fadeOut('fast', function(){
									$('#af-button').fadeIn('fast');
								});
								*/
							}
						},
					error: 
						function(){
		//				alert('Возникла ошибка');
						}
				});	

}

</script>
