function checkData(event){ //senza async non aspetta la risposta della fetch con await


    if(form_login.nome_utente.value.length == 0 || form_login.password.value.length == 0){
        event.preventDefault();

        const container = document.querySelector("#login_error");
        const element = container.querySelector('span');
        container.classList.remove('hidden');
        element.textContent = "Completa tutti i campi";
        return;   
    }


}

const form_login = document.forms['form_login'];
form_login.addEventListener('submit', checkData);

