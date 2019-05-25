
$(document).ready(function() {

        // Début verif de tous les formulaires
        // initialisation de la variable de controle
        var control = 0; 
        
        // Verif formulaire profil
        $('.proForm').on('keyup', function(){
            var pseudo = $('#pseudo_profil').val();
            var nom = $('#nom_profil').val();
            var prenom = $('#prenom_profil').val();
            var phone = $('#telephone_profil').val();
            var email = $('#email_profil').val();
            var regex = /["<>&]/g;
            var isEmail =    /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/; 
            var isPhone = /^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/; // Nombre
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

            if(phone.match(isPhone)) {
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

        // Verif formulaire de contact
        $('#contactForm').on('keyup', function(){
            var nom = $('#contactNom').val();
            var prenom = $('#contactPrenom').val();
            var objet = $('#contactObjet').val();
            var message = $( "#contactForm" ).find( "textarea" ).val();
            var email = $('#contactEmail').val();
            var regex = /["<>&]/g;
            var isEmail = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/; 
            
            if(prenom.length >= 3 && prenom.length <= 20 && !prenom.match(regex)) {
                $('#contactPrenom').removeClass('is-invalid');
                $('#contactPrenom').addClass('is-valid');
                control = 1;
            } else {
                $('#contactPrenom').removeClass('is-valid');
                $('#contactPrenom').addClass('is-invalid');
                control = 0;
            }

            if(nom.length >= 3 && nom.length <= 20 && !nom.match(regex)) {
                $('#contactNom').removeClass('is-invalid');
                $('#contactNom').addClass('is-valid');
                control = 1;
            } else {
                $('#contactNom').removeClass('is-valid');
                $('#contactNom').addClass('is-invalid');
                control = 0;
            }

            if(email.match(isEmail)) {
                $('#contactEmail').removeClass('is-invalid');
                $('#contactEmail').addClass('is-valid');
                control = 1;
            } else {
                $('#contactEmail').removeClass('is-valid');
                $('#contactEmail').addClass('is-invalid');
                control = 0;
            }

            if(!objet.match(regex) && objet != "") {
                $('#contactObjet').removeClass('is-invalid');
                $('#contactObjet').addClass('is-valid');
                control = 1;
            } else {
                $('#contactObjet').removeClass('is-valid');
                $('#contactObjet').addClass('is-invalid');
                control = 0;
            }
            if(!message.match(regex) && message != "") {
                $('#contactMessage').removeClass('is-invalid');
                $('#contactMessage').addClass('is-valid');
                control = 1;
            } else {
                $('#contactMessage').removeClass('is-valid');
                $('#contactMessage').addClass('is-invalid');
                control = 0;
            }
        });
        // Fin verif formulaire de contact

        // Verif formulaire d'inscription
        $('#inscriptionModal').on('keyup', function(){
            var pseudo = $('#inputPseudo').val();
            var password = $('#registerinputPassword').val();
            var nom = $('#inputName').val();
            var prenom = $('#inputFirstName').val();
            var registeremail = $('#registerinputEmail').val();
            var telephone = $('#registerinputPhone').val();

            var regex = /["<>&]/g;
            var regexPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
            var isEmail = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/; 
            var isPhone = /^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/;

            if(pseudo.length >= 3 && pseudo.length <= 20 && !pseudo.match(regex) && pseudo != "") {
                $('#inputPseudo').removeClass('is-invalid');
                $('#inputPseudo').addClass('is-valid');
                control = 1;
            } else {
                $('#inputPseudo').removeClass('is-valid');
                $('#inputPseudo').addClass('is-invalid');
                control = 0;
            }

            if(prenom.length >= 3 && prenom.length <= 20 && !prenom.match(regex) && prenom != "") {
                $('#inputFirstName').removeClass('is-invalid');
                $('#inputFirstName').addClass('is-valid');
                control = 1;
            } else {
                $('#inputFirstName').removeClass('is-valid');
                $('#inputFirstName').addClass('is-invalid');
                control = 0;
            }

            if(nom.length >= 3 && nom.length <= 20 && !nom.match(regex) && nom != "") {
                $('#inputName').removeClass('is-invalid');
                $('#inputName').addClass('is-valid');
                control = 1;
            } else {
                $('#inputName').removeClass('is-valid');
                $('#inputName').addClass('is-invalid');
                control = 0;
            }

            if(registeremail.match(isEmail)) {
                $('#registerinputEmail').removeClass('is-invalid');
                $('#registerinputEmail').addClass('is-valid');
                control = 1;
            } else {
                $('#registerinputEmail').removeClass('is-valid');
                $('#registerinputEmail').addClass('is-invalid');
                control = 0;
            }

            if(password.match(regexPassword) && password != "") {
                $('#registerinputPassword').removeClass('is-invalid');
                $('#registerinputPassword').addClass('is-valid');
                control = 1;
            } else {
                $('#registerinputPassword').removeClass('is-valid');
                $('#registerinputPassword').addClass('is-invalid');
                control = 0;
            }
            if(telephone.match(isPhone) && telephone != "") {
                $('#registerinputPhone').removeClass('is-invalid');
                $('#registerinputPhone').addClass('is-valid');
                control = 1;
            } else {
                $('#registerinputPhone').removeClass('is-valid');
                $('#registerinputPhone').addClass('is-invalid');
                control = 0;
            }
        });

        // Verif formulaire d'envoi de réinitialisation de mdp
        $('.rstPswd').on('keyup', function(){
            var resetEmail = $('#inlineFormInputGroup').val();
            var isEmail = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/; 

            if(resetEmail.match(isEmail)) {
                $('#inlineFormInputGroup').removeClass('is-invalid');
                $('#inlineFormInputGroup').addClass('is-valid');
                control = 1;
            } else {
                $('#inlineFormInputGroup').removeClass('is-valid');
                $('#inlineFormInputGroup').addClass('is-invalid');
                control = 0;
            }
        });
        // Fin verif formulaire d'envoi de réinitialisation de mdp

        // Verif formulaire de modification de mdp
        $('.newPass').on('keyup', function(){
            var password = $('#pwd1').val();
            var password2 = $('#pwd2').val();
            var regexPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;

            if(password.match(regexPassword)) {
                $('#pwd1').removeClass('is-invalid');
                $('#pwd1').addClass('is-valid');
                control = 1;
            } else {
                $('#pwd1').removeClass('is-valid');
                $('#pwd1').addClass('is-invalid');
                control = 0;
            }

            if(password2.match(regexPassword)) {
                $('#pwd2').removeClass('is-invalid');
                $('#pwd2').addClass('is-valid');
                control = 1;
            } else {
                $('#pwd2').removeClass('is-valid');
                $('#pwd2').addClass('is-invalid');
                control = 0;
            }
        });
        // Fin verif formulaire de modification de mdp

        // Verif formulaire de connexion
        $('#connexionModal').on('keyup', function(){
            var pseudo = $('#connecxionInputPseudo').val();
            var password = $('#connexionInputPassword').val();
            var regex = /["<>&]/g;
            var regexPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
            
            // Me retourne la valeur tapée dans le champs lorsqu'on quitte le champs
            
            if(pseudo.length >= 3 && pseudo.length <= 20 && !pseudo.match(regex)) {
                $('#connecxionInputPseudo').removeClass('is-invalid');
                $('#connecxionInputPseudo').addClass('is-valid');
                control = 1;
            } else {
                $('#connecxionInputPseudo').removeClass('is-valid');
                $('#connecxionInputPseudo').addClass('is-invalid');
                control = 0;
            }

            if(password.match(regexPassword)) {
                $('#connexionInputPassword').removeClass('is-invalid');
                $('#connexionInputPassword').addClass('is-valid');
                control = 1;
            } else {
                $('#connexionInputPassword').removeClass('is-valid');
                $('#connexionInputPassword').addClass('is-invalid');
                control = 0;
            }
        });
        // Fin verif formulaire de connexion
        
    
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
    

    
//   ------------------AUTOCOMPLETE-------------------------------
    

    
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


   //   -------------------CONTACT-------------------------------------

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
                        $('#contactNom').attr('class', 'form-control');
                        $('#contactPrenom').attr('class', 'form-control');
                        $('#contactObjet').attr('class', 'form-control');
                        $('#contactEmail').attr('class', 'form-control');
                        $('#contactMessage').attr('class', 'form-control col-md-12');
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
        var timestart = 3;
var downloadTimer = setInterval(function(){
  document.getElementById("crono").innerHTML = timestart + " sec";
  timestart -= 1;
  if(timestart <= 0){
    clearInterval(downloadTimer);
  }
}, 1000);
    });
//------------ Début script décompte ------------------
/* var cpt = 3 ;
var compt = document.getElementById("crono");

function decompte() {
    if(cpt>=0) {
        compt.innerHTML = cpt ;
        cpt-- ;
        setInterval(decompte,300);
    }
} */
//------------ Fin script décompte ------------------
/* var spanTime= document.getElementById('crono');
var time= '3';

function refreshTimer () {

    
    if (time > 1) {
        spanTime.innerHTML= time +' sec';
        time--;
    } else {
        clearInterval(x);
    }
}

setInterval(refreshTimer, 100); */ 


	
