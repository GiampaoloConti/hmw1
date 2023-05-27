function checkName(event){

    if(event.currentTarget.value == 0){
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.classList.remove('hidden');
        formStatusName = false;
    }
    else{
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusName = true;
    }
}

function checkSurname(event){

    if(event.currentTarget.value == 0){
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.classList.remove('hidden');
        formStatus = false;
    }
    else{
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusSurname = true;
    }
}

function checkUsername(event){

    if(!/^[a-zA-Z0-9_]{0,15}$/.test(event.currentTarget.value)) {
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.querySelector('span').textContent = "Sono ammesse lettere, numeri e underscore. Max. 15";
        container.classList.remove('hidden');
        formStatusUsername = false;
    }
    else if(event.currentTarget.value == 0){
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.querySelector('span').textContent = "Riempi il campo Username";
        container.classList.remove('hidden');
        formStatusUsername = false;

    }
    
    else {
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusUsername = true;
        fetch("check_username.php?q="+encodeURIComponent(event.currentTarget.value)).then(fetchResponse).then(jsonCheckUsername);
    }

}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function jsonCheckUsername(json) {
    // Controllo il campo exists ritornato dal JSON
    if (json.exists == false) {
        const element = document.querySelector('.username');
        const container = element.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusUsername = true;
    } else {
        const element = document.querySelector('.username');
        const container = element.parentNode.querySelector("#form_error");;
        container.querySelector('span').textContent = "Nome utente già in uso";
        container.classList.remove('hidden');
        formStatusUsername = false;
    }

}

function checkEmail(event) {
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(event.currentTarget.value).toLowerCase())) {
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.querySelector('span').textContent = "Email non valida";
        container.classList.remove('hidden');
        formStatusEmail = false;
    } else {
        fetch("check_email.php?q="+encodeURIComponent(String(event.currentTarget.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }
}

function jsonCheckEmail(json) {
    // Controllo il campo exists ritornato dal JSON
    if (json.exists == false) {
        const element = document.querySelector('.email');
        const container = element.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusEmail = true;
    } else {
        const element = document.querySelector('.email');
        const container = element.parentNode.querySelector("#form_error");;
        container.querySelector('span').textContent = "Email già in uso";
        container.classList.remove('hidden');
        formStatusUsername = false;
    }

}

function checkPassword(event) {

    if (event.currentTarget.value.length >= 8) {
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusPassword = true;
    } else {
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.classList.remove('hidden');
        formStatusPassword = false;
    }

}

function checkConfirmPassword(event){

    if (event.currentTarget.value === document.querySelector('.password').value){
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusPasswordConfirm = true;
    } else {
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.classList.remove('hidden');
        formStatusPasswordConfirm = false;
    }

}

function SendForm(event){

    if(
        formStatusName === false ||
        formStatusSurname === false ||
        formStatusUsername === false ||
        formStatusEmail === false ||
        formStatusPassword === false ||
        formStatusPasswordConfirm === false
    ){ 
        console.log(formStatusName);

        console.log(formStatusSurname);

        console.log(formStatusUsername);

        console.log(formStatusEmail);

        console.log(formStatusPassword);

        console.log(formStatusPasswordConfirm);

        event.preventDefault();
    }
        
}


const form_register = document.forms['form_register'];

let formStatusName = false;
let formStatusSurname = false;
let formStatusUsername = false;
let formStatusEmail = false;
let formStatusPassword = false;
let formStatusPasswordConfirm = false;
document.querySelector('.nome').addEventListener('blur', checkName);
document.querySelector('.cognome').addEventListener('blur', checkSurname);
document.querySelector('.username').addEventListener('blur', checkUsername);
document.querySelector('.email').addEventListener('blur', checkEmail);
document.querySelector('.password').addEventListener('blur', checkPassword);
document.querySelector('.password_confirm').addEventListener('blur', checkConfirmPassword);

document.querySelector('.invio').addEventListener('click', SendForm);

