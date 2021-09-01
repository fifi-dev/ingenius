jQuery(document).ready(function($){
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
						console.log(mail);
						var mail_hex = SHA256_hash(mail);
						console.log(mail_hex);
						  dataLayer.push({'event': 'conversion-brochure', 'email' : mail_hex});
						  $('.formulaire_welcome').html(json.message);
						  window.abtasty.send("transaction",{tid:mail_hex,ta:'Global Lead generation',tr:1,tc:'EUR',icn:1}),window.abtasty.send('transaction',{tid:mail_hex,ta:'Lead generation - DOCUMENTATION',tr:1,tc:"EUR",icn:1});
						  EA_push(
		                    'uid', mail_hex //mail hashé SHA-256//
		                    ,'ref', Date.now() //timestamp//
		                    ,'estimate','1' //valeur 1 immuable//
		                    ,'type','DOCUMENTATION'
		                    ,'path', window.location.pathname //URI (doit être unique à chaque page)//
		                    ,'pagegroup','FORMULAIRE'
		                    ,'ville-ecole','' //null si l’information n’est pas disponible//
		                    ,'ville-jpo','' //null si l’information n’est pas disponible//
		                    ,'campus',''//null si l’information n’est pas disponible//
		                    ,'niveau-entree',''//null si l’information n’est pas disponible//
		                    ,'annee-entree',''//null si l’information n’est pas disponible//
		                    ,'date-rentree',''//null si l’information n’est pas disponible//
		                    ,'choix-programme', ''//null si l’information n’est pas disponible//
		                    ,'source',''//null si l’information n’est pas disponible//
		                );

					}else{
						console.log(json)
						console.log('error');
					}
				}
			}
		});
	});

	/*
	$('[name="educationLevel"]').change(function(){
		if ($('[name="educationLevelType"]').length > 0){
			var educationLevel = $(this).val();
			$.ajax({
				url : "https://"+window.location.hostname+"/wp-content/plugins/Welcome_Plugin/ajax_welcome.php",
				type : "post",
				data : 'form_type=get_educationLevelType&educationLevel='+educationLevel+'&url_ws='+$('#url_ws').val(),
				cache : false,
				dataType : 'json',
				success : function(json){
					$('[name="educationLevelType"]').html(json.options);
				}
			});
		}else{
			console.log('pas trouvé');
		}
	});

	$('[name="educationLevelType"]').change(function(){
		if ($('[name="educationLevelSpeciality"]').length > 0){
			var educationLevelType = $(this).val();
			$.ajax({
				url : "https://"+window.location.hostname+"/wp-content/plugins/Welcome_Plugin/ajax_welcome.php",
				type : "post",
				data : 'form_type=get_educationLevelSpeciality&educationLevelType='+educationLevelType+'&url_ws='+$('#url_ws').val(),
				cache : false,
				dataType : 'json',
				success : function(json){
					$('[name="educationLevelSpeciality"]').html(json.options);
				}
			});
		}else{
			console.log('pas trouvé');
		}
	});*/
});
