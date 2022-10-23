function validate() {

    const balance = document.getElementById("balance").value;
    const secanswer = document.getElementById("secanswer").value; 
    const u_id = document.getElementById("u_id").value; 

    if(balance == ''){
        alert("Balance field is empty!");
        return false;
    }else if(secanswer == ''){
        alert("Security answer field is empty!");
        return false;
    } else if(u_id == '0'){
        alert("You did not choose User ID!");
        return false;
    } else {
        if (document.getElementById("upfile").files.length == 0 ){
            alert("You did not upload imageD!");
            return false;
        }else{
            return true;
        }
    }
    
}