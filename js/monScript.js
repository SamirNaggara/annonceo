$('.champVille').hide();
$(document).ready(function() {
    $('.blocRequete').fadeIn();

    //Affichage Prix minimum
$(function() {
	$('.rangeMin').next().text('0'); // Valeur par défaut
	$('.rangeMin').on('input', function() {
		var $set = $(this).val();
		$(this).next().text($set);
        $('.rangeMax').attr('min', $set); 
	});
});


//Affichage Prix maximum
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
    
    
    //Ajax Globale qui renvoie notre requete
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
            $('#contenerResultat').html(reponse.afficher);
            $('#contenerReponseRequete').html(reponse.reponseRequete);
            $('contenerReponseRequete').fadeIn();
            console.log(reponse.afficher);
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
        
        .fail(function(xhr, status, error){
//            console.log(xhr);
//            console.log(status);
//            console.log(error);
        })
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
    

    
   
    

    
    
                
    
//        $('.ajaxIndex').on('change',function(){
//            var choixDepartement = $('#departement').val();
////            var choixVille = $('.champsVille>select').val();
//            var param1 = {
//                        departement:choixDepartement
////                        ville:choixVille
//
//            }
//
//
//
//            $.post('ajaxTraitement.php', param1, function (reponse) {
//                $('.selectDepartement').html(reponse.pourLeChampDepartement);
//
//                
//                        }, 'json');
//    });	

    /******** TEST BLOQUAGE MODAL + AFFICHAGE ERREUR *********/
    // $(document).ready(function() {
    //     $("#register").submit(function() {
    //         Pseudo = $("input[name='pseudo']").val();
    //         Fname = $("input[name='nom']").val();
    //         Lname = $("input[name='prenom']").val();
    //         Email = $("input[name='email']").val();
    //         Phone = $("input[name='telephone']").val();

    //         console.log("Pseudo " + Pseudo);
    //         console.log("First name " + Fname);
    //         console.log("Last Name " + Lname);
    //         console.log("Email " + Email);
    //         console.log("Telephone " + Phone);

    //         // return false;
    //     })
    // });
    // function getProduitsByCategorie(categorie) {
    //     var urlAjx = "admin/inc/annonces.ajax.inc.php";
    //     var data = {categorie:categorie};
    //     $.ajax({ 
//               url:      urlAjx,
//               dataType: "json",
//               type:     "POST",
//               data:     data,
//               async:    false,
//               success:  function(data){
//               //console.log(data);
//               $("#listeproduits").html(data); 
//                },
//                error:function(jqXHR, textStatus){
//                var error = formatErrorMessage(jqXHR, textStatus);
//                alert('error :' + error);
//                }
     });
// };