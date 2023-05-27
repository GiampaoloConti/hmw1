function Search(event){

    event.preventDefault();

    document.querySelector('#search_box').innerHTML='';

    if(form.search.value.length != 0) fetch("api_request.php?q=" + form.search.value).then(fetchResponse).then(onJson);

}

function fetchResponse(response) {
    if (!response.ok) return null;
    console.log(response);
    return response.json();
}

function onJson(json){
 

  //scarichiamo i contenuti (all'apertura della pagina saranno quelli vecchi, dopo la ricerca quelli nuovi")
    fetch("download_data.php").then(fetchResponse).then(onJsonStart);
}

function onJsonStart(json){
   

    for(let article of json){

        const article_box = document.createElement("a");
        article_box.classList.add('article_box');
        article_box.href = "article.php?url=" +article.Link;

        document.querySelector('#search_box').appendChild(article_box);

        const article_image_box = document.createElement('div');
        article_image_box.classList.add('article_image');

        article_box.appendChild(article_image_box);

        const article_image = document.createElement('img');
        article_image.src = article.Immagine;
        article_image.classList.add('not_zoom');

        article_image_box.appendChild(article_image);

        const article_text_box = document.createElement('div');
        article_text_box.classList.add('article_text_box');

        article_box.appendChild(article_text_box);

        const title = document.createElement('h2');
        title.textContent = article.Titolo;

        article_text_box.appendChild(title);

        const author = document.createElement('h3');
        author.textContent = article.Autore;

        article_text_box.appendChild(author);
    }
}

//controlliamo se la pagina è stata caricata andando indietro nel browser

var perfEntries = performance.getEntriesByType("navigation");

  if (perfEntries.length > 0) {
    var navigationType = perfEntries[0].type;
    if (navigationType === "back_forward") {
      location.reload();
    }
  }

document.querySelector('#search_box').innerHTML='';

fetch("download_data.php?").then(fetchResponse).then(onJsonStart);

const form = document.forms['form_search'];

form.addEventListener('submit', Search);