
/* Gestion de la soumission de formulaire d'ajout de documents*/
$('form[name="candidaturesbundle_document"]').on('submit', function(evt){
    var fd = new FormData(this);
    //start send the post request
    $.ajax($(this).attr("action"),{
        data: fd,
        type: "POST",
        success: function(json){ 
            $('#listeDocuments').append('<li>'+JSON.parse(json).document+'</li>');
            $('#popupAddDoc').modal('hide');
        },
        error: function(){ alert('error'); },
        mimeType:"multipart/form-data",
        processData: false,
        contentType: false,
    });
    evt.preventDefault();
});



/**
* Chargement de dynamique de contenu dans les fenêtres modales: clic sur lien Ajouter entreprise
**/
$('a[data-target="#popupEntse"]').on('click', function(evt){
    var title = $(this).data('title');
    $('#popupEntse .modal-body').load($(this).data('href'), function(){
        // Modification du titre de la modale
        $('#popupEntse .modal-title').html(title);
        // Ajout d'un écouteur d'évènement sur le bouton d'update du formlaire ajouté
        /* Gestion de la soumission de formulaire d'ajout d'entreprise*/
        $('form[name="candidaturesbundle_entreprise"]').on('submit', function(evt){
            var fd = new FormData(this);
            //start send the post request
            $.ajax($(this).attr("action"),{
                data: fd,
                type: "POST",
                success: function(json){ 
                    // Ajout de l'option créée au champ select d'entreprise
                    var option = JSON.parse(json).option;
                    var regex = new RegExp( /^<option\s+value=[\"\']\s*([\d]+)\s*[\"\']/ ); // pour récupérer l'id de l'entreprise créée
                    var idEntse = option.match(regex)[1];
                    $('#candidaturesbundle_candidature_entreprise')
                        .prepend(option)
                        .val(idEntse)
                        ;
                    $('#popupEntse').modal('hide');
                },
                error: function(){ alert('error'); },
                mimeType:"multipart/form-data",
                processData: false,
                contentType: false,
            });
            evt.preventDefault();
        });
    });
});


/**
* Chargement de dynamique de contenu dans les fenêtres modales: clic sur lien Ajouter entreprise
**/
$('a[data-target="#popupContact"]').on('click', function(evt){
    var title = $(this).data('title');
    $('#popupContact .modal-body').load($(this).data('href'), function(){
        // Modification du titre de la modale
        $('#popupContact .modal-title').html(title);
        // Ajout d'un écouteur d'évènement sur le bouton d'update du formlaire ajouté
        /* Gestion de la soumission de formulaire d'ajout d'entreprise*/
        $('form[name="candidaturesbundle_contact"]').on('submit', function(evt){
            //start send the post request
            $.ajax($(this).attr("action"),{
                data: $(this).serialize(),
                type: "POST",
                success: function(json){ 
                    // Contact créé. On ferme la modale
                    $('#popupContact').modal('hide');
                },
                error: function(){ alert('error'); }
            });
            evt.preventDefault();
        });
    });
});


