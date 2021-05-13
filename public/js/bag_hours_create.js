function calculateTotalPriceBtn() { 

    var result = document.getElementsByName("type_id")[0].value;

    alert(result);

} 

window.onload = function () {
    //Load popover btn listeners
    document.getElementById("calculatePrice").addEventListener("click", calculateTotalPriceBtn);
};