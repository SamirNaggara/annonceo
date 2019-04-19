console.log('je fonctionne');

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