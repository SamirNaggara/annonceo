
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

    // ---------------------------Modal de connexion----------------------------------------
    function createThumbnail(sFile,sId) {
        var oReader = new FileReader();
        oReader.addEventListener('load', function() {
        var oImgElement = document.createElement('img');
        oImgElement.classList.add('imgPreview') 
        oImgElement.src = this.result;
        document.getElementById('preview-'+sId).appendChild(oImgElement);
        }, false);
    
        oReader.readAsDataURL(sFile);
    
        }//function
        function changeInputFil(oEvent){
            var oInputFile = oEvent.currentTarget,
                sName = oInputFile.name,
                aFiles = oInputFile.files,
                aAllowedTypes = ['png', 'jpg', 'jpeg', 'gif'],
                imgType;  
            document.getElementById('preview-'+sName).innerHTML ='';
            for (var i = 0 ; i < aFiles.length ; i++) {
            imgType = aFiles[i].name.split('.');
            imgType = imgType[imgType.length - 1];
            if(aAllowedTypes.indexOf(imgType) != -1) {
                createThumbnail(aFiles[i],sName);
            }//if
            }//for
        }//function 
        
        document.addEventListener('DOMContentLoaded',function(){
        var aFileInput = document.forms['myForm'].querySelectorAll('[type=file]');
            for(var k = 0; k < aFileInput.length;k++){
            aFileInput[k].addEventListener('change', changeInputFil, false);
            }//for
        });
/*    function handleFiles(files) {
        var imageType = /^image\//;
        for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (!imageType.test(file.type)) {
            alert("veuillez sélectionner une image");
        }else{
            if(i == 0){
            preview.innerHTML = '';
        }
            var img = document.createElement("img");
            img.classList.add("obj");
            img.file = file;
            preview.appendChild(img); 
            var reader = new FileReader();
            reader.onload = ( function(aImg) { 
            return function(e) { 
            aImg.src = e.target.result; 
        }; 
    })(img);
    reader.readAsDataURL(file);
        }
        }
    } 
   function handleFiles(files) {
        var imageType = /^image\//;
        for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (!imageType.test(file.type)) {
            alert("veuillez sélectionner une image");
        }else{
            if(i == 0){
            preview1.innerHTML = '';
        }
            var img = document.createElement("img");
            img.classList.add("obj");
            img.file = file;
            preview.appendChild(img); 
            var reader = new FileReader();
            reader.onload = ( function(aImg) { 
            return function(e) { 
            aImg.src = e.target.result; 
        }; 
    })(img);
    reader.readAsDataURL(file);
        }
        }
    } 
   function handleFiles(files) {
        var imageType = /^image\//;
        for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (!imageType.test(file.type)) {
            alert("veuillez sélectionner une image");
        }else{
            if(i == 0){
            preview.innerHTML = '';
        }
            var img = document.createElement("img");
            img.classList.add("obj");
            img.file = file;
            preview2.appendChild(img); 
            var reader = new FileReader();
            reader.onload = ( function(aImg) { 
            return function(e) { 
            aImg.src = e.target.result; 
        }; 
    })(img);
    reader.readAsDataURL(file);
        }
        }
    } 
   function handleFiles(files) {
        var imageType = /^image\//;
        for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (!imageType.test(file.type)) {
            alert("veuillez sélectionner une image");
        }else{
            if(i == 0){
            preview.innerHTML = '';
        }
            var img = document.createElement("img");
            img.classList.add("obj");
            img.file = file;
            preview3.appendChild(img); 
            var reader = new FileReader();
            reader.onload = ( function(aImg) { 
            return function(e) { 
            aImg.src = e.target.result; 
        }; 
    })(img);
    reader.readAsDataURL(file);
        }
        }
    } 
   function handleFiles(files) {
        var imageType = /^image\//;
        for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (!imageType.test(file.type)) {
            alert("veuillez sélectionner une image");
        }else{
            if(i == 0){
            preview4.innerHTML = '';
        }
            var img = document.createElement("img");
            img.classList.add("obj");
            img.file = file;
            preview.appendChild(img); 
            var reader = new FileReader();
            reader.onload = ( function(aImg) { 
            return function(e) { 
            aImg.src = e.target.result; 
        }; 
    })(img);
    reader.readAsDataURL(file);
        }
        }
    } 
   function handleFiles(files) {
        var imageType = /^image\//;
        for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (!imageType.test(file.type)) {
            alert("veuillez sélectionner une image");
        }else{
            if(i == 0){
            preview5.innerHTML = '';
        }
            var img = document.createElement("img");
            img.classList.add("obj");
            img.file = file;
            preview.appendChild(img); 
            var reader = new FileReader();
            reader.onload = ( function(aImg) { 
            return function(e) { 
            aImg.src = e.target.result; 
        }; 
    })(img);
    reader.readAsDataURL(file);
        }
        }
    }  */
    /* function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                imgId = '#preview-'+$(input).attr('id');
                $(imgId).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
      }


      $("form#mainform input[type='file']").change(function(){
        readURL(this);
      }); */