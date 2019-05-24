
$(document).ready(function() {

        // Début verif formulaire profil
        var control = 0;      
        $('.proForm').on('keyup', function(){
            var pseudo = $('#pseudo_profil').val();
            var nom = $('#nom_profil').val();
            var prenom = $('#prenom_profil').val();
            var phone = $('#telephone_profil').val();
            var email = $('#email_profil').val();
            var regex = /["<>&]/g;
            var isEmail =    /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/; 
            var isNumber = /^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/; // Nombre
            // Me retourne la valeur tapée dans le champs lorsqu'on quitte le champs
            
            if(pseudo.length >= 3 && pseudo.length <= 20 && !pseudo.match(regex)) {
                $('#pseudo_profil').removeClass('is-invalid');
                $('#pseudo_profil').addClass('is-valid');
                control = 1;
            } else {
                $('#pseudo_profil').removeClass('is-valid');
                $('#pseudo_profil').addClass('is-invalid');
                control = 0;
            }

            if(prenom.length >= 3 && prenom.length <= 20 && !prenom.match(regex)) {
                $('#prenom_profil').removeClass('is-invalid');
                $('#prenom_profil').addClass('is-valid');
                control = 1;
            } else {
                $('#prenom_profil').removeClass('is-valid');
                $('#prenom_profil').addClass('is-invalid');
                control = 0;
            }

            if(nom.length >= 3 && nom.length <= 20 && !nom.match(regex)) {
                $('#nom_profil').removeClass('is-invalid');
                $('#nom_profil').addClass('is-valid');
                control = 1;
            } else {
                $('#nom_profil').removeClass('is-valid');
                $('#nom_profil').addClass('is-invalid');
                control = 0;
            }

            if(email.match(isEmail)) {
                $('#email_profil').removeClass('is-invalid');
                $('#email_profil').addClass('is-valid');
                control = 1;
            } else {
                $('#email_profil').removeClass('is-valid');
                $('#email_profil').addClass('is-invalid');
                control = 0;
            }

            if(phone.match(isNumber)) {
                $('#telephone_profil').removeClass('is-invalid');
                $('#telephone_profil').addClass('is-valid');
                control = 1;
            } else {
                $('#telephone_profil').removeClass('is-valid');
                $('#telephone_profil').addClass('is-invalid');
                control = 0;
            }
        });
        // Fin verif formulaire profil
        
    
    $('.champVille').hide();

    //Affichage Prix minimum sur le coté de la barre
    $(function() {
        $('.rangeMin').next().text('0'); // Valeur par défaut
        $('.rangeMin').on('input', function() {
            var $set = $(this).val();
            $(this).next().text($set);
            $('.rangeMax').attr('min', $set); 
        });
    });


    //Affichage Prix maximum sur le coté de la bar
    $(function() {
        $('.rangeMax').next().text('Illimite'); // Valeur par défaut
        $('.rangeMax').on('input', function() {
            var $set = $(this).val();
            $(this).next().text($set);
            if ($set == 5000){
                $(this).next().text('Illimite');
            }
        });
    });

    
    
    //-----------------Ajax page d'acceuil-----------------------------
    
    //Ajax Globale qui renvoie l'affichage des annonces en fonction des parametres de tries
    $('.ajaxGlobale').on('change',function(){
        var inputRechercher = $('#champsRechercher').val()
        var choixCategorie = $('#categorie').val();
        var choixRegion = $('#region').val();
        var choixDepartement = $('#departement').val();
        var choixVille = $('#ville').val();
        var choixPrixMin = $('#prixMin').val();
        var choixPrixMax = $('#prixMax').val(); 
        var choixTrie = $('#optionTrie').val();
        /* var choixTrie = $("input[name='trie']:checked").val(); */
            var param = {
                rechercher:inputRechercher,
                categorie:choixCategorie,
                region:choixRegion,
                departement:choixDepartement,
                ville:choixVille,
                prixMin:choixPrixMin,
                prixMax:choixPrixMax,
                trie:choixTrie
            }

        $.post('traitement.php', param, function(reponse) {
            $('#contenerReponseRequete').html(reponse.reponseRequete);
//            console.log(response.afficher);
            $('contenerReponseRequete').fadeIn();
            }, 'json');
            
    });
    
    
    //Ajax Region, qui change la liste de departement
    $('#region').on('change',function(){
        var choixRegion = $(this).val();
            var param = {
                region:choixRegion
            }

        $.post('traitementRegion.php', param, function(reponse) {
            $('.selectDepartement').html(reponse.pourLeChampDepartement);   
            if (reponse.faireDisparaitreVille == "ok"){
                $('.champVille').hide();
            }; 
            }, 'json')
        
    });
    
    //Ajax Departement, qui fait apparaitre la ville et en change la liste
    $('#departement').on('change',function(){
        var choixDepartement = $(this).val();
            var param = {
                departement:choixDepartement
            }

        $.post('traitementDepartement.php', param, function(reponse) {
            $('.selectVille').html(reponse.pourLeChampVille);
            if (reponse.faireApparaitreVille == "ok"){
                $('.champVille').fadeIn();
            }; 
            
            }, 'json');
    });
    

    
//   ---------------------------------------------AUTOCOMPLETE------------------------------------------------------------
    

    
        //Ajax de l'autocompletion, va chercher une liste de ce qu'il y a a rechercher
    $('#champsRechercher').on('input',function(){
        var inputRechercher = $(this).val();
            var param = {
                premieresLettres:inputRechercher
            }

        $.post('traitementAutocompletion.php', param, function(reponse) {
            var listeAutocompletion = reponse.listeAutocompletion;
            
        $('#champsRechercher').autocomplete({
        source: listeAutocompletion
        
    });
            }, 'json');
    });


   //   ----------------------------------------------CONTACT-------------------------------------------------------------------

        // Ajax du formulaire de contact
        $('#contactForm').submit(function(e) {
            e.preventDefault();
            $('.comment').empty();
            var postdata = $('#contactForm').serialize();
            //console.log(result);
            $.ajax({
                type: 'POST',
                url: 'ajax-contact.php',
                data: postdata,
                dataType: 'json',
                success: function(result) {
                    if(result.isSuccess) {
                        $('#contactForm').append("<p class='thank-you'>Votre message a bien été envoyé. Merci de m'avoir contacté :)</p>");
                        $('#contactForm')[0].reset();
                    } else {
                        $('#contactNom + .comment').html(result.contactNomError);
                        $('#contactPrenom + .comment').html(result.contactPrenomError);
                        $('#contactObjet + .comment').html(result.contactObjetError);
                        $('#contactEmail + .comment').html(result.contactEmailError);
                        $('#contactMessage + .comment').html(result.contactMessageError);
                    }
                }
            });
        });
    });

        

