//Efect in alert when validate a entry hours
$(".alert-success").slideDown(400);

$(".alert-success").delay(6000).slideUp(400, function () {
    $(this).alert('close');
});
