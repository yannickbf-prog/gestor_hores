function calculateTotalPriceBtn() { 

    var result = document.getElementsByName("type_id")[0].value;

    result = JSON.parse(result); 
    
    alert(result.num_sequence);

} 

window.onload = function () {
    //Load popover btn listeners
    document.getElementById("calculatePrice").addEventListener("click", calculateTotalPriceBtn);
};