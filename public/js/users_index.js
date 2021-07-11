//Show and hide dates popover
var displayPopover = 1;
function togglePopover() {

    if (displayPopover % 2 === 0) {
        document.getElementById("datePopover").style.opacity = 0;

        setTimeout(function () {
            document.getElementById("datePopover").classList.remove("visible");
            document.getElementById("datePopover").classList.add("invisible");
        }, 300);

    } else {
        document.getElementById("datePopover").classList.remove("invisible");
        document.getElementById("datePopover").classList.add("visible");
        document.getElementById("datePopover").style.opacity = 1;

    }
    displayPopover++;
}

function closePopover() {
    document.getElementById("datePopover").style.opacity = 0;

    setTimeout(function () {
        document.getElementById("datePopover").classList.remove("visible");
        document.getElementById("datePopover").classList.add("invisible");
    }, 300);

    displayPopover = 1;
}

//Efect in alert when edit and save customer
$(".alert-success").slideDown(400);

$(".alert-success").delay(6000).slideUp(400, function () {
    $(this).alert('close');
});

//Translate datapiker and add jquery listener on date inputs with dateFormat for english version
$(function () {
    $(".datepicker").datepicker({dateFormat: "dd/mm/yy"}).val();
});

 $.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '< Ant',
    nextText: 'Sig >',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};


$.datepicker.regional["ca"] = {
    closeText: "Tancar",
    prevText: "< Ant",
    nextText: "Seg >",
    currentText: "Hoy",
    monthNames: [
        "Gener",
        "Febrer",
        "Març",
        "Abril",
        "Maig",
        "Juny",
        "Juliol",
        "Agost",
        "Septembre",
        "Octubre",
        "Novembre",
        "Desembre",
    ],
    monthNamesShort: [
        "Gen",
        "Feb",
        "Mar",
        "Abr",
        "Mai",
        "Jun",
        "Jul",
        "Ago",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ],
    dayNames: [
        "Diumenje",
        "Dilluns",
        "Dimarts",
        "Dimecres",
        "Dijous",
        "Divendres",
        "Dissabte",
    ],
    dayNamesShort: ["Diu", "Dil", "Dim", "Dme", "Dij", "Div", "Dis"],
    dayNamesMin: ["Di", "Dl", "Dm", "Dc", "Dj", "Dv", "Ds"],
    weekHeader: "Sm",
    dateFormat: "dd/mm/yy",
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: "",
};

var filterCount = 1;
  $("#filterTitleContainer").click(function(){

		if(filterCount % 2 == 0) 
			$('.bi-chevron-down').css("transform", "rotate(0deg)");

		else
        $('.bi-chevron-down').css("transform", "rotate(180deg)");
        
        filterCount++;

        // show hide paragraph on button click
        $("#filtersContainer").toggle(400);
    });


window.onload = function () {
    //Load popover btn listeners
    document.getElementById("datePopoverBtn").addEventListener("click", togglePopover);
    document.getElementsByClassName("close")[0].addEventListener("click", closePopover);
};


