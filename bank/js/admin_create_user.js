function validate() {

    const email = document.getElementById("email").value;
    const fullname = document.getElementById("fullname").value; 
    const sex = document.getElementsByName("sex");
    const dob = document.getElementById("dob").value;
    const phone = document.getElementById("phone").value;
    const address = document.getElementById("address").value;

    if(email == ''){
        alert("Email field is empty!");
        return false;
    }else if(fullname == ''){
        alert("Name field is empty!");
        return false;
    } else if(!sex[0].checked && !sex[1].checked ){
        alert("Sex field is empty!");
        return false;
    }else if(!dob){
        alert("Day of birth field is empty!");
        return false;
    } else if(phone == ''){
        alert("Phone field is empty!");
        return false;
    }else if(address == ''){
        alert("Address field is empty!");
        return false;
    } else {
        if(!email.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
            alert('Your Email is not valid.');
            return false;
        } else if(!phone.match(/((09|03|07|08|05)+([0-9]{8})\b)/g)){
            alert('Your Phone number is not valid.');
            return false;
        }

            return true;
    }
    
}