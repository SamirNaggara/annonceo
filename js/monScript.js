$('.champVille').hide();
$(document).ready(function() {
    
    //Affichage Prix minimum
$(function() {
	$('.rangeMin').next().text('0'); // Valeur par défaut
	$('.rangeMin').on('input', function() {
		var $set = $(this).val();
		$(this).next().text($set);
	});
});


//Affichage Prix maximum
$(function() {
	$('.rangeMax').next().text('Illimité'); // Valeur par défaut
	$('.rangeMax').on('input', function() {
		var $set = $(this).val();
		$(this).next().text($set);
        if ($set == 1000){
            $(this).next().text('Illimité');
        }
	});
});

    
    
    //-----------------Ajax page d'acceuil-----------------------------
    
    
    //Ajax Categorie
    $('#categorie').on('change',function(){
        var choixCategorie = $(this).val();
            var param = {
                categorie:choixCategorie
            }

        $.post('traitementCategorie.php', param, function(reponse) {
            $('#contenerResultat').html(reponse.afficher);            
            }, 'json');
    });
    
    
    //Ajax Region
    $('#region').on('change',function(){
        var choixRegion = $(this).val();
            var param = {
                region:choixRegion
            }

        $.post('traitementRegion.php', param, function(reponse) {
            $('.selectDepartement').html(reponse.pourLeChampDepartement);
            $('#contenerResultat').html(reponse.afficher);            
            }, 'json');
    });
    
    //Ajax Departement
    $('#departement').on('change',function(){
        var choixDepartement = $(this).val();
            var param = {
                departement:choixDepartement
            }

        $.post('traitementDepartement.php', param, function(reponse) {
            $('.selectVille').html(reponse.pourLeChampVille);
            console.log(reponse.faireApparaitreVille);
            if (reponse.faireApparaitreVille == "ok"){
                $('.champVille').show();
            }
            $('#contenerResultat').html(reponse.afficher); 
            
            }, 'json');
    });
    
        //Ajax Ville
    $('#ville').on('change',function(){
        var choixVille = $(this).val();
            var param = {
                ville:choixVille
            }

        $.post('traitementVille.php', param, function(reponse) {
             $('#contenerResultat').html(reponse.afficher); 
            
            }, 'json');
    });
    
    //Ajax prixMinimum
    $('#prixMinimum').on('change',function(){
        var choixPrixMin = $(this).val();
            var param = {
                prixMin:choixPrixMin
            }

        $.post('traitementPrixMin.php', param, function(reponse) {
             $('#contenerResultat').html(reponse.afficher);             
            }, 'json');
    });    
    
    //Ajax prixMaximum
    $('#prixMaximum').on('change',function(){
        var choixPrixMax = $(this).val();
            var param = {
                prixMax:choixPrixMax
            }

        $.post('traitementPrixMax.php', param, function(reponse) {
             $('#contenerResultat').html(reponse.afficher);             
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