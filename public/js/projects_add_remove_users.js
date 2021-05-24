//Efect in alert when remove a user
$(".alert-success").slideDown(400);

$(".alert-success").delay(6000).slideUp(400, function () {
    $(this).alert('close');
});
