jQuery(document).ready(function($){


	$(document).on("change","#select-ecole",function(e){
		e.preventDefault();
		var data = {
			'action': 'load_ecole',
			'ecole_id': $(this).val()
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			$("#response-form").html(response);
		});
	});

	$(document).on("submit", ".welcome_form", function (event) {
		console.log( "Handler for .submit() called." );
		event.preventDefault();
		$("input[type=submit]").attr('disabled', 'disabled');
		$("input[type=submit]").hide();
		$("#loaderWelcome").show();
		var $this = $(this);

		$.ajax({
			url : $this.attr('target'),
			type : "post",
			data : $this.serialize(),
			cache : false,
			dataType : 'json',
			success : function(json){
				if (json.erreurs.length > 0){
					console.log('erreur');
					$('input').css('border', 'none');
					$('select').css('border', 'none');
					var tableau_champs_erreur=json.erreurs;
					console.log(json.erreurs);
					$.each(tableau_champs_erreur, function( index, value ) {
						$('#champ_'+value).css('border', 'solid 1px #ef473c');
					});
					$("#loaderWelcome").show();
					$("input[type=submit]").show();
					$("input[type=submit]").removeAttr('disabled');
					alert('Merci de renseigner tous les champs obligatoires');
				}else{
					console.log('pas d-erreur');
					if (json.success){
						console.log('success true');
						var mail = $('[name="email"]', $this).val();
						var mail_hex = SHA256_hash(mail);
						console.log(mail_hex);
						dataLayer.push({'event': 'conversion-brochure', 'email' : mail_hex});
						if(json.message != null) {
							$('.formulaire_welcome').html(json.message);
						}else{
							var data = {
								'action': 'load_brochure',
								'ecole_id': $("#select-ecole").val()
							};
							jQuery.post(ajax_object.ajax_url, data, function(response) {
								if(response != 0) {
									$('.formulaire_welcome').html(response);
								}else{
									$('.formulaire_welcome').html("<p>Merci pour votre demande d'information</p>");
								}
							});
						}


					}else{
						console.log(json)
						console.log('error');
					}
				}
			}
		});
	});

});