
$(document).ready(function() {
    
    
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
        var choixTrie = $("input[name='trie']:checked").val();
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

});
