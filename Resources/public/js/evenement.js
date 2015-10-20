// Récupère le div qui contient la collection de tags
var $collectionHolder = $('#popupEvt div[data-prototype]');

// ajoute un lien « add a tag »
var $addDocumentLink = $('<a class="btn btn-sm btn-success" href="#" class="add_document_link"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>');
var $newLinkDiv = $('<div class="addDoc"></div>').append($addDocumentLink);

jQuery(document).ready(function() {

    /**
    * Chargement de dynamique de contenu dans les fenêtres modales: clic sur lien éditer évènement
    **/
    $('a[data-target="#popupEvt"]').on('click', function(evt){
        var title = $(this).data('title');
        $('#popupEvt .modal-body').load($(this).data('href'), function(){
            // Modification du titre de la modale
            $('#popupEvt .modal-title').html(title);
            // Ajout d'un écouteur d'évènement sur le bouton d'update du formlaire ajouté
            addEventUpdateListener($('#popupEvt form[name="candidaturesbundle_evenement"]'));

            // Boutons d'ajout / suppression de documents
            $collectionHolder = $('#popupEvt div[data-prototype]');
            // ajoute un lien de suppression à tous les éléments li de
            // formulaires de tag existants
            $collectionHolder.children('div').each(function() {
                addDocumentFormDeleteLink($(this));
            });
            // ajoute l'ancre « ajouter un tag » et div 
            $collectionHolder.append($newLinkDiv);

            $addDocumentLink.on('click', function(e) {
                // empêche le lien de créer un « # » dans l'URL
                e.preventDefault();

                // ajoute un nouveau formulaire tag
                addDocumentForm($collectionHolder, $newLinkDiv);
            });

        });
    });
});

/* Gestion de la soumission de formulaire d'ajout et de modification d'évènement */
function addEventUpdateListener(form){

    form.on('submit', function(evt){
        var fd = new FormData(this);
        //start send the post request
        $.ajax($(this).attr("action"),{
            data: fd,
            type: "POST",
            success: function(json){ 
                // 2 actions différentes: ajout ou modification
                // Ajout = le template récupéré a un id inconnu dans le DOM
                
                var ligneEvt = JSON.parse(json).evenement;
                var regex = new RegExp( /^<tr\s+id=[\"\']([\w\d\_\-]+)[\"\']/ ); // capture <tr id="..." et met l'id dans un groupe
                var id = ligneEvt.match(regex)[1];
                $ligneExistante = $('#'+id);

                if ( $ligneExistante.length == 1 ){
                    // La ligne existe déjà = c'est une modification
                    $ligneExistante.replaceWith(ligneEvt);
                } else {
                    // La ligne n'existe pas = c'est un ajout
                    $('#tableEvenements tbody').append(ligneEvt);
                }

                $('#popupEvt').modal('hide');
                // Pour que les nouvelles popove fonctionnent
                $('[data-toggle="popover"]').popover()

            },
            error: function(){ alert('error'); },
            mimeType:"multipart/form-data",
            processData: false,
            contentType: false,
        });
        evt.preventDefault();
    });//It is silly. But you should not write 'json' or any thing as the fourth parameter. It should be undefined. I'll explain it futher down
}

function addDocumentForm(collectionHolder, $newLinkDiv) {
    // Récupère l'élément ayant l'attribut data-prototype comme expliqué plus tôt
    var prototype = collectionHolder.attr('data-prototype');

    // Remplace '__name__' dans le HTML du prototype par un nombre basé sur
    // la longueur de la collection courante
    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    // Affiche le formulaire dans la page dans un li, avant le lien "ajouter un tag"
    var $newFormDiv = $('<div></div>').append(newForm);
    $newLinkDiv.before($newFormDiv);

    // ajoute un lien de suppression au nouveau formulaire
    addDocumentFormDeleteLink($newFormDiv);
}

function addDocumentFormDeleteLink($documentFormDiv) {
    var $removeFormA = $('<a class="btn btn-danger btn-sm pull-right" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>');
    $documentFormDiv.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // supprime l'élément li pour le formulaire de tag
        $documentFormDiv.remove();
    });
}
