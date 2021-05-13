function calculateTotalPriceBtn() { 

    let strBht = document.getElementsByName("type_id")[0].value;

    let objBht = JSON.parse(strBht);

    let hourPrice = objBht.bht_hp;
    
    let contractedHours = document.getElementsByName("contracted_hours")[0].value;

    if(Number.isInteger(parseInt(contractedHours))){
        let totalPrice = hourPrice * contractedHours;
        let totalPriceInput = document.getElementsByName("total_price")[0].value;
        //alert(totalPrice);
        totalPriceInput = totalPrice;
    }
    

} 

window.onload = function () {
    //Load popover btn listeners
    document.getElementById("calculatePrice").addEventListener("click", calculateTotalPriceBtn);
};