function validate() {

    const email = document.getElementById("email").value;
    const address = document.getElementById("address").value;

    if(email == '' || address == '')
        return false;
    else{
        if (!email.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
            alert('Your Email is not valid.');
            return false;
        }else
            return true;
    }
}