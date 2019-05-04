
$( function() {
    
    
    //----------------------------AUTO-COMPLETION---------------------------------



    var allText =[];
    var allTextLines = [];
    var Lines = [];

    var txtFile = new XMLHttpRequest();
    txtFile.open("GET", "C:\wamp64\www\teamRocket\trunk/communce.csv", true);
    txtFile.onreadystatechange = function()
    {
        allText = txtFile.responseText;
        allTextLines = allText.split(/\r\n|\n/);
    };
//    };      

} );






