
//Prix minimum
$(function() {
	$('.rangeMin').next().text('0'); // Valeur par défaut
	$('.rangeMin').on('input', function() {
		var $set = $(this).val();
		$(this).next().text($set);
	});
});


//Prix maximum
$(function() {
	$('.rangeMax').next().text('Illimité'); // Valeur par défaut
	$('.rangeMax').on('input', function() {
		var $set = $(this).val();
		$(this).next().text($set);
        console.log($(this).value);
        if ($set == 1000){
            $(this).next().text('Illimité');
        }
	});
});

//-----------------Ajax page d'acceuil-----------------------------


$(document).ready(function() {
$('.ajaxIndex').on('change',function(){
        var choixCategorie = $('#categorie').val();
        var choixRegion = $('#region').val();
        var choixDepartement = $('#departement').val();
        var choixPrixMin = $('#prixMin').val();
        var choixPrixMax = $('#prixMax').val();
    
        var param2 = {
                    idCategorie:choixCategorie,
                    region:choixRegion,
                    departement:choixDepartement,
                    prixMin:choixPrixMin,
                    prixMax:choixPrixMax
        }
    
    
    
        $.post('ajaxTraitement.php', param2, function (reponse) {
            $('#contenerResultat').html(reponse.resultat);
					}, 'json');
//
//        // $.post(url_cible, parametres, fonction_succes, type_de_données)
    });
});	

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
//     });
// };