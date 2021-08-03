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

function calculateTotalPriceBtn() { 

    let strBht = document.getElementsByName("type_id")[0].value;

    let objBht = JSON.parse(strBht);

    let hourPrice = objBht.bht_hp;
    
    let contractedHours = document.getElementsByName("contracted_hours")[0].value;

    if(Number.isInteger(parseInt(contractedHours))){
        let totalPrice = Number.parseFloat(hourPrice * contractedHours).toFixed(2);
        document.getElementsByName("total_price")[0].value = totalPrice.toString().replace(/\./g,',');
        
        //Show info of price calculate
        let strInfo = hourPrice.toString().replace(/\./g,',')+"€ x "+contractedHours+"h = "+totalPrice.toString().replace(/\./g,',')+"€";

        document.getElementById("alertCalculatedPrice").classList.remove("d-none");
        document.getElementById("alertCalculatedPrice").getElementsByTagName("strong")[0].innerText = strInfo;
    }
    

} 

function selectChange(){
    let strBht = document.getElementsByName("type_id")[0].value;

    let objBht = JSON.parse(strBht);

    let hourPrice = objBht.bht_hp;

    document.getElementById("hourPrice").innerText = hourPrice;
}

    //Slide efects

    var addEditCount = 1;
    $("#addEditHeader").click(function () {

        if (addEditCount % 2 == 0)
            $('#addEditChevronDown').css("transform", "rotate(0deg)");

        else
            $('#addEditChevronDown').css("transform", "rotate(180deg)");

        addEditCount++;

        // show hide paragraph on button click
        $("#addEditContainer").toggle(400);
    });
    
    function onOffCalculateBtn() {
        let contractedHours = /^[0-9]*$/g.exec(document.getElementById("contractedHours").value);
        console.log(contractedHours)
        console.log(typeof contractedHours)
    	if(contractedHours == null || contractedHours == ""){
            document.getElementById("calculatePrice").classList.add("disabled");
    	}
    	else{
            document.getElementById("calculatePrice").classList.remove("disabled");
    	}
    }

    let contractedHours = /^[0-9]*$/g.exec(document.getElementById("contractedHours").value);
    if(contractedHours != null && contractedHours != "") {
        document.getElementById("calculatePrice").classList.remove("disabled");
    }

    
window.onload = function () {
    //Load popover btn listeners
    document.getElementById("datePopoverBtn").addEventListener("click", togglePopover);
    document.getElementsByClassName("close")[0].addEventListener("click", closePopover);
    
    //Show hour price of bag hour type selected onload page
    let strBht = document.getElementsByName("type_id")[0].value;

    let objBht = JSON.parse(strBht);

    let hourPrice = objBht.bht_hp;

    document.getElementById("hourPrice").innerText = hourPrice;

    //Load popover btn listeners
    document.getElementById("calculatePrice").addEventListener("click", calculateTotalPriceBtn);

    //On change select we change hour price
    document.getElementsByName("type_id")[0].addEventListener("change",selectChange);
    
    //On change contracted hours active / disable calculate button
    document.getElementById("contractedHours").addEventListener("input",onOffCalculateBtn);
};


