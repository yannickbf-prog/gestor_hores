//Efect when delete logo
window.onload = function () {
    
    $(".alert-success").slideDown(400);

    $(".alert-success").delay(6000).slideUp(400, function () {
        $(this).alert('close');
    });

};


