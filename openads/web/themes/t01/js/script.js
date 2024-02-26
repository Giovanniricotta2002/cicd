$(function() {

});

function autojump(currentId, nextId, event)
{
    var element = document.getElementById(currentId);
    if(element.value.length >= 4 && event.keyCode != 16){
        nextId.focus(); 
    }
}

function concatenate_citizen_access_key()
{

    $('#cle_acces_citoyen_complete').val($('#cle_acces_citoyen_split1').val() + '-' +
                         $('#cle_acces_citoyen_split2').val() + '-' +
                         $('#cle_acces_citoyen_split3').val() + '-' +
                         $('#cle_acces_citoyen_split4').val());
    //}
}
