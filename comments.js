
function AggiungiCommento(event){
    event.preventDefault();

    if(form.comment_text.value.length == 0){
        return;
    }

    //passiamo l'articolo a cui si riferisce
    console.log(form.comment_text.value);

    fetch("AddComment.php?text_value=" +form.comment_text.value+ "&link=" +form.url.value+ "&propic=" +form.propic.value).then(fetchResponse).then(onJson);;
   

}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function onJson(json) {
    // Controllo il campo exists ritornato dal JSON

    console.log(json);

    const comment_box = document.querySelector('#comment_box');

        const comment_element = document.createElement('div');
        comment_element.classList.add('comment');

        comment_box.appendChild(comment_element);

        const propic_box = document.createElement('div');
        propic_box.classList.add('propic_box');

        comment_element.appendChild(propic_box);

        const comment_image = document.createElement('img');
        comment_image.classList.add('propic_comment');
        comment_image.src = json.ProfilePic;

        propic_box.appendChild(comment_image);

        const username = document.createElement('div');
        username.classList.add('username_comment');
        username.textContent = json.UserID;

        comment_element.appendChild(username);

        const comment_text = document.createElement('div');
        comment_text.classList.add('comment_text');

        comment_element.appendChild(comment_text);

        const text = document.createElement('h3');
        text.textContent = json.Testo;

        console.log(json.Testo);
        comment_text.appendChild(text);

        const delete_button = document.createElement('a');
        delete_button.classList.add('delete_comment');
        delete_button.href= '#';
        delete_button.addEventListener('click',DeleteComment);
        delete_button.textContent = "Elimina Commento";

        comment_element.appendChild(delete_button);

        form.comment_text.value='';

}

function onJsonIdentity(json){

    if(json.exists === true) return true;
    else return false;

}

async function onJsonComments(json){
    

    for(let comment of json){

        const comment_box = document.querySelector('#comment_box');

        const comment_element = document.createElement('div');
        comment_element.classList.add('comment');

        comment_box.appendChild(comment_element);

        const propic_box = document.createElement('div');
        propic_box.classList.add('propic_box');

        comment_element.appendChild(propic_box);

        const comment_image = document.createElement('img');
        comment_image.classList.add('propic_comment');
        comment_image.src = comment.ProfilePic;

        propic_box.appendChild(comment_image);

        const username = document.createElement('div');
        username.classList.add('username_comment');
        username.textContent = comment.UserID;

        comment_element.appendChild(username);

        const comment_text = document.createElement('div');
        comment_text.classList.add('comment_text');

        comment_element.appendChild(comment_text);

        const text = document.createElement('h3');
        text.textContent = comment.Testo;

        comment_text.appendChild(text);

        const result = await fetch("CheckIdentity.php?user_id=" +comment.UserID).then(fetchResponse).then(onJsonIdentity);

        //se l'user id del commento è uguale a quello della sessione aggiungiamo il pulsante elimina
        if(result === true){

            const delete_button = document.createElement('a');
            delete_button.classList.add('delete_comment');
            delete_button.addEventListener('click',DeleteComment);
            delete_button.textContent = "Elimina Commento";

            comment_element.appendChild(delete_button);
        }
    }
}


function onJsonDelete(json){
    console.log(json);
}

function DeleteComment(event){

    event.stopPropagation();
    event.preventDefault();


    const link = document.querySelector('#keep_reading').href.trim();
    const propic = form.propic.value;
    const text = encodeURIComponent(event.currentTarget.parentNode.querySelector('.comment_text').querySelector('h3').textContent);

    fetch("AddComment.php?q=Delete&text_value=" +text+ "&link=" +link+ "&propic=" +propic).then(fetchResponse).then(onJsonDelete);;

    const box = document.querySelector('#comment_box');
    box.removeChild(event.currentTarget.parentNode);

}


//svuotiamo la sezione commenti
document.querySelector('#comment_box').innerHTML='';

const form = document.forms["form_comment"];

if(form) form.addEventListener('submit', AggiungiCommento);

const link = document.querySelector('#keep_reading').href.trim();

//scarichiamo i dati dell'articolo
fetch("download_data.php?link=" +link).then(fetchResponse).then(onJsonComments);
