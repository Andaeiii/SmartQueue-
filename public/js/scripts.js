//the applications javascript file...

	function buildLgas(obj){
		$('#lgadiv').stop().fadeTo('fast', 0.3);
		urstring = '/state/'+ Number($(obj).val()) +'/lgas';
		$.ajax({
			type:'get',
			url:urstring,
			success:function(msg){
				$('#lgadiv > #seloptn').html(msg);
				$('#lgadiv').stop().fadeTo('fast', 1);
			}
		});
	}