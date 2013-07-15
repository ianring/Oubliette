$(document).ready( function(){
	$(".cb-enable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
	});
	$(".cb-disable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);
	});
	
	$('#whitelist_add_form').submit(function(){
		var ip = $('#whitelist_add_input').val();
		$.ajax({
			'url':'ajax_controller.php',
			'type':'post',
			'data':{
				'action':'whitelist_add',
				'ip':ip
			},
			'dataType':'json'
		}).done(function(response){
			if (response){
				var cb = $('<div class="listitem"><span class="close icon-remove-circle"></span>' + ip + '</div>');
				$('#whitelist').append(cb);
				closebutt(cb);
			} else {
				alert('that ip is already in the whitelist');
			}
			$('#whitelist_add_input').val('');
		});
		return false;
	});
	
	$('#blacklist_add_form').submit(function(){
		var ip = $('#blacklist_add_input').val();
		$.ajax({
			'url':'ajax_controller.php',
			'type':'post',
			'data':{
				'action':'blacklist_add',
				'ip':ip
			},
			'dataType':'json'
		}).done(function(response){
			if (response){
				var cb = $('<div class="listitem"><span class="close icon-remove-circle"></span>' + ip + '</div>');
				$('#blacklist').append(cb);
				closebutt(cb);
			} else {
				alert('that ip is already in the blacklist');
			}
			$('#blacklist_add_input').val('');
		});
		return false;
	});
	
	$('#greylist_add_form').submit(function(){
		var ip = $('#greylist_add_input').val();
		$.ajax({
			'url':'ajax_controller.php',
			'type':'post',
			'data':{
				'action':'greylist_add',
				'ip':ip
			},
			'dataType':'json'
		}).done(function(response){
			if (response){
				var cb = $('<div class="listitem"><span class="close icon-remove-circle"></span>' + ip + '</div>');
				$('#greylist').append(cb);
				closebutt(cb);
			} else {
				alert('that ip is already in the greylist');
			}
			$('#greylist_add_input').val('');
		});
		return false;
	});
	
	
	closebutt( $('.listitem .close') );
	function closebutt(elem){
		elem.click(function(){
			$self = $(this);
			
			list = '';
			list = $self.parents('#greylist').length>0 ? 'greylist':list;
			list = $self.parents('#whitelist').length>0 ? 'whitelist':list;
			list = $self.parents('#blacklist').length>0 ? 'blacklist':list;
			
			ip = $self.closest('.listitem').text();
			
			$.ajax({
				'url':'ajax_controller.php',
				'type':'post',
				'data':{
					'action':list+'_remove',
					'ip':ip
				},
				'dataType':'json'
			}).done(function(response){
				if (response){
					$self.closest('.listitem').remove();
				}
			});
		});
	}
	
	
	$('#rate_seconds,#rate_visits,#grey_time_limit').blur(function(){
		$key = $(this).attr('id');
		$val = $(this).val();
		
		$.ajax({
			'url':'ajax_controller.php',
			'type':'post',
			'data':{
				'action':'update_config',
				'key':$key,
				'value':$val
			},
			'dataType':'json'
		});
	});
	
	$('#white_wild,#black_wild').click(function(){
		$key = $(this).attr('id');
		$val = $(this).prop('checked');
		$.ajax({
			'url':'ajax_controller.php',
			'type':'post',
			'data':{
				'action':'update_config',
				'key':$key,
				'value':$val
			},
			'dataType':'json'
		});
	});
	
	
	$('.cb-enable').click(function(){
		$key = $(this).closest('.field').data('key');
		$val = true;
		$.ajax({
			'url':'ajax_controller.php',
			'type':'post',
			'data':{
				'action':'update_config',
				'key':$key,
				'value':$val
			},
			'dataType':'json'
		});
	});
	
	$('.cb-disable').click(function(){
		$key = $(this).closest('.field').data('key');
		$val = false;
		$.ajax({
			'url':'ajax_controller.php',
			'type':'post',
			'data':{
				'action':'update_config',
				'key':$key,
				'value':$val
			},
			'dataType':'json'
		});
	});
	
	
});