jQuery(document).ready(function($){
	var ourSubmit = document.getElementById('ourSubmit');
	
	var ourFormdataProcess = function(formdata, action){
		
		$.ajax({
			url:data_container.ajaxurl,
			type:'POST',
			data:{
				action: action,
				data: formdata,
				security:data_container.security,
				honeypot:document.getElementById('honeypot').value
			},
			success:function(response){
				
					$("p.mdgggg").html(response);
					
				
			},
			error:function(){
				alert('Form was not submitted successfully');
			}
			
			
		});
		
	};
	
	ourSubmit.addEventListener('click', function(event){
		event.preventDefault();
			var formdata = {
				'name':document.getElementById('name').value,
				'email':document.getElementById('email').value,
				'option':document.getElementById('option').value,
				'content':document.getElementById('pstcontent').value
				
			};
			
		ourFormdataProcess(formdata, 'our_action_function');
	});
	
	
	
	
	
	
});