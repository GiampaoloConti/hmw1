
function fetchResponse(response) {
    if (!response.ok) return null;
    console.log(response);
    return response.json();
}

function onJsonStart(json){
   

    for(let article of json){

        const article_box = document.createElement("a");
        article_box.classList.add('favourite');
        article_box.href = "article.php?q=preferiti&url=" +article.Link;

        document.querySelector('#favourites_box').appendChild(article_box);

        const article_image_box = document.createElement('div');
        article_image_box.classList.add('favourite_img_box');

        article_box.appendChild(article_image_box);

        const article_image = document.createElement('img');
        article_image.src = article.Immagine;
        article_image.classList.add('not_zoom_favourite');

        article_image_box.appendChild(article_image);

        const article_text_box = document.createElement('div');
        article_text_box.classList.add('favourite_text');

        article_box.appendChild(article_text_box);

        const title = document.createElement('div');
        title.classList.add('favourite_title');
        title.textContent = article.Titolo;

        article_text_box.appendChild(title);

        const bottom_box = document.createElement('div');
        bottom_box.classList.add('favourite_bottom_box');

        article_text_box.appendChild(bottom_box);
        
        const author_box = document.createElement('div');
        author_box.classList.add('favourite_author');
        author_box.textContent = article.Autore;

        bottom_box.appendChild(author_box);

        const button_box = document.createElement("a");
        button_box.classList.add('favourite_button');
        button_box.href = '#';
        bottom_box.addEventListener('click', RemoveFavourites);

        bottom_box.appendChild(button_box);

        const button_text = document.createElement("h2");
        button_text.textContent = "Rimuovi dai Preferiti";

        button_box.appendChild(button_text);

        const hidden_info = document.createElement('div');
        hidden_info.classList.add('hidden');
        hidden_info.textContent = article.Link;

        article_box.appendChild(hidden_info);


    }
}

function onJsonButton(json) {
    // Controllo il campo exists ritornato dal JSON
    console.log(json);
 
}

function RemoveFavourites(event){

    event.stopPropagation();
    event.preventDefault();

    const author = event.currentTarget.parentNode.querySelector('.favourite_author').textContent;
    const image = event.currentTarget.parentNode.parentNode.querySelector('.favourite_img_box').querySelector('img').src;
    const url = event.currentTarget.parentNode.parentNode.querySelector('.hidden').textContent;

    fetch("changeFavourites.php?Autore=" +author+ "&Immagine=" +image+ "&Link=" +url).then(fetchResponse).then(onJsonButton);

    const box = document.querySelector('#favourites_box');
    box.removeChild(event.currentTarget.parentNode.parentNode);

}

//svuotiamo il contenitore
document.querySelector('#favourites_box').innerHTML='';

//scarichiamo i preferiti
fetch("download_data.php?q=preferiti").then(fetchResponse).then(onJsonStart);
