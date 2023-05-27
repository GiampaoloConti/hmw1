function Change(event){
    event.preventDefault();
    event.currentTarget.classList.remove('favourites_button');
    event.currentTarget.classList.add('favourites_button_selected');
    event.currentTarget.textContent = "Aggiunto ai Preferiti";
    event.currentTarget.removeEventListener('click', Change);
    event.currentTarget.addEventListener('click', Changeback);

    fetch("changeFavourites.php?Titolo=" +title+ "&Contenuto=" +content+ "&Autore=" +author+ "&Immagine=" +image+ "&Link=" +url).then(fetchResponse).then(onJsonFavourites);

}

function Changeback(event){
    event.preventDefault();
    event.currentTarget.classList.remove('favourites_button_selected');
    event.currentTarget.classList.add('favourites_button');
    event.currentTarget.textContent = "Aggiungi ai Preferiti";
    event.currentTarget.removeEventListener('click', Changeback);
    event.currentTarget.addEventListener('click', Change);

    fetch("changeFavourites.php?Titolo=" +title+ "&Contenuto=" +content+ "&Autore=" +author+ "&Immagine=" +image+ "&Link=" +url).then(fetchResponse).then(onJsonFavourites);
}

function fetchResponse(response) {
    if (!response.ok) return null;
    console.log(response);
    return response.json();
}

function onJsonFavourites(json) {
    // Controllo il campo exists ritornato dal JSON
    console.log(json);
 
}

let title = document.querySelector('#title').innerText;
let content = document.querySelector('#text_box').innerText;
let author = document.querySelector('#author_name').innerText;
let image = document.querySelector('#main_image').src;
let url = document.querySelector('#keep_reading').href;



if(document.querySelector('.favourites_button')) document.querySelector('.favourites_button').addEventListener('click', Change);
if(document.querySelector('.favourites_button_selected')) document.querySelector('.favourites_button_selected').addEventListener('click', Changeback);
