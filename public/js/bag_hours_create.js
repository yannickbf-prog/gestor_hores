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

window.onload = function () {
    //Show hour price of bag hour type selected onload page
    let strBht = document.getElementsByName("type_id")[0].value;

    let objBht = JSON.parse(strBht);

    let hourPrice = objBht.bht_hp;

    document.getElementById("hourPrice").innerText = hourPrice;

    //Load popover btn listeners
    document.getElementById("calculatePrice").addEventListener("click", calculateTotalPriceBtn);

    //On change select we change hour price
    document.getElementsByName("type_id")[0].addEventListener("change",selectChange);
};