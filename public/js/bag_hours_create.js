function calculateTotalPriceBtn() { 

    let strBht = document.getElementsByName("type_id")[0].value;

    let objBht = JSON.parse(strBht);

    let hourPrice = objBht.bht_hp;
    
    let contractedHours = document.getElementsByName("contracted_hours")[0].value;

    if(Number.isInteger(parseInt(contractedHours))){
        let totalPrice = hourPrice * contractedHours;
        document.getElementsByName("total_price")[0].value = Number.parseFloat(totalPrice).toFixed(2);
        
        //Show info of price calculate
        let strInfo = hourPrice+"€ x "+contractedHours+"h = "
    }
    

} 

window.onload = function () {
    //Load popover btn listeners
    document.getElementById("calculatePrice").addEventListener("click", calculateTotalPriceBtn);
};