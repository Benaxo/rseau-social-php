$(document).ready(function() {
	// Envoyer la requête de connexion avec AJAX
	$('#connexion-form').submit(function(event) {
		event.preventDefault(); // Empêcher l'envoi du formulaire par défaut

		var formdata = $('#connexion-form').serialize(); // Récupérer les données du formulaire

		$.ajax({
			type: 'POST',
			url: 'connexion.php',
			data: formdata,
			dataType: 'json',
			success: function(response) {
				// Afficher le message de la réponse de la page PHP dans la div #message
				$('#message').html(response.message);
			}
		});
	});
});

$(document).ready(function() {
  $('#inscription-form').submit(function(event) {
      event.preventDefault(); // Empêche le formulaire d'être envoyé

      // Envoi des données du formulaire à la page PHP via AJAX
      $.ajax({
          url: 'inscription.php',
          type: 'post',
          data: $('#inscription-form').serialize(),
          dataType: 'json',
          success: function(response) {
              // Affichage des erreurs
              if(response.errors) {
                  $('#inscription-errors').html('');
                  $.each(response.errors, function(index, error) {
                      $('#inscription-errors').append('<div class="alert alert-danger">' + error + '</div>');
                  });
              }
              // Si l'inscription est réussie, redirection vers la page de connexion
              else {
                  window.location.href = "home.php";
              }
          }
      });
  });
});