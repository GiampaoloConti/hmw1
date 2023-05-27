function ModifyAccount(event){
    document.querySelector('#information_box').classList.add('hidden');
    document.querySelector('#register_box').classList.remove('hidden');
}

//Controlla che l'username non sia uguale al precedente(può essere vuoto)
function checkUsername(event){

    if(event.currentTarget.value == 0){
        const element = document.querySelector('.username');
        const container = element.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusUsername = true;
        return;
    }
    else if(!/^[a-zA-Z0-9_]{0,15}$/.test(event.currentTarget.value)) {
        const container = event.currentTarget.parentNode.querySelector("#form_error");
        container.querySelector('span').textContent = "Sono ammesse lettere, numeri e underscore. Max. 15";
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
    console.log(response);
    return response.json();
}


//Torna exists true se è già presente nel database
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
        container.querySelector('span').textContent = "Nome utente già in uso o uguale al precedente";
        container.classList.remove('hidden');
        formStatusUsername = false;
    }

}

function checkEmail(event) {

    if(event.currentTarget.value == 0){
        const element = document.querySelector('.email');
        const container = element.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusEmail = true;
        return;
    }
    else if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(event.currentTarget.value).toLowerCase())) {
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
        container.querySelector('span').textContent = "Email già in uso o uguale alla precedente";
        container.classList.remove('hidden');
        formStatusEmail = false;
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

function checkName(event){

    if(event.currentTarget.value == 0){
        const element = document.querySelector('.nome');
        const container = element.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusName = true;
        return;
    }
    else{
        fetch("check_userdata.php?name="+encodeURIComponent(String(event.currentTarget.value).toLowerCase())).then(fetchResponse).then(jsonCheckName);
    }
}

function jsonCheckName(json) {
    // Controllo il campo exists ritornato dal JSON
    if (json.exists == false) {
        const element = document.querySelector('.nome');
        const container = element.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusName = true;
    } else {
        const element = document.querySelector('.nome');
        const container = element.parentNode.querySelector("#form_error");;
        container.querySelector('span').textContent = "Nome uguale al precedente";
        container.classList.remove('hidden');
        formStatusName = false;
    }

}

function jsonCheckSurname(json) {
    // Controllo il campo exists ritornato dal JSON
    if (json.exists == false) {
        const element = document.querySelector('.cognome');
        const container = element.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusSurname = true;
    } else {
        const element = document.querySelector('.cognome');
        const container = element.parentNode.querySelector("#form_error");;
        container.querySelector('span').textContent = "Cognome uguale al precedente";
        container.classList.remove('hidden');
        formStatusSurname = false;
    }

}

function jsonCheckPassword(json) {

    console.log(json);
    // Controllo il campo exists ritornato dal JSON
    if (json.exists == false) {
        const element = document.querySelector('.password');
        const container = element.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusPassword = true;
    } else {
        const element = document.querySelector('.password');
        const container = element.parentNode.querySelector("#form_error");;
        container.querySelector('span').textContent = "Password uguale alla precedente";
        container.classList.remove('hidden');
        formStatusPassword = false;
    }

}

function checkSurname(event){

    if(event.currentTarget.value == 0){
        const element = document.querySelector('.cognome');
        const container = element.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusSurname = true;
        return;
    }
    else{
        fetch("check_userdata.php?surname="+encodeURIComponent(String(event.currentTarget.value).toLowerCase())).then(fetchResponse).then(jsonCheckSurname);
    }
}

async function checkPassword(event) {

    if(event.currentTarget.value == 0){
        const element = document.querySelector('.password');
        const container = element.parentNode.querySelector("#form_error");
        container.classList.add('hidden');
        formStatusPassword = true;
        return;
    }
    else if (event.currentTarget.value.length >= 8) {
        await fetch("check_userdata.php?password="+encodeURIComponent(String(event.currentTarget.value))).then(fetchResponse).then(jsonCheckPassword);
    } else {
        const element = document.querySelector('.password');
        const container = element.parentNode.querySelector("#form_error");;
        container.querySelector('span').textContent = "La password deve essere almeno di 8 caratteri";
        container.classList.remove('hidden');
        formStatusPassword = false;
    }

}

//La modifica può essere inviata solo se non ci sono errori
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




const button = document.querySelector('#change');
button.addEventListener('click', ModifyAccount);


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