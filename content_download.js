function fetchResponse(response) {
    if (!response.ok) return null;
    console.log(response);
    return response.json();
}

function onJson(json){
 

    let jsonObject = JSON.parse(json);
    

    //inseriamo i contenuti scaricati nei vari blocchi della pagina
    const main_banner = document.querySelector('#main_news');
    main_banner.querySelector('.not_zoom').src = jsonObject.articles[0].urlToImage;
    main_banner.querySelector('h3').textContent = jsonObject.articles[0].title;
    main_banner.href = "article.php?url=" +jsonObject.articles[0].url;

    const banners_group1 = document.querySelector('#news_selection').querySelectorAll('.news');;

    let i = 1;
    
    for(let boxes of banners_group1){
        boxes.querySelector('.zoom').src = jsonObject.articles[i].urlToImage;
        boxes.querySelector('div').querySelector('h3').textContent = jsonObject.articles[i].title;
        boxes.href = "article.php?url=" +jsonObject.articles[i].url;
        i++;
    }

    const banner_group2 = document.querySelector('#small_news_section').querySelectorAll('.small_news');
    
    for(let boxes of banner_group2){
        boxes.querySelector('.small_news_image').querySelector('.zoom').src = jsonObject.articles[i].urlToImage;
        boxes.querySelector('.small_news_title').querySelector('h4').textContent = jsonObject.articles[i].title;
        boxes.href = "article.php?url=" +jsonObject.articles[i].url;
        i++;
    }

    const banner_group3 = document.querySelector('#hot_news_section').querySelectorAll('.small_news');
    
    for(let boxes of banner_group3){
        boxes.querySelector('.small_news_image').querySelector('.zoom').src = jsonObject.articles[i].urlToImage;
        boxes.querySelector('.small_news_title').querySelector('h4').textContent = jsonObject.articles[i].title;
        boxes.href = "article.php?url=" +jsonObject.articles[i].url;
        i++;
    }


}

function AnimePage(event){

    console.log("ciao");

    event.preventDefault();

    fetch("api_request.php?q=anime").then(fetchResponse).then(onJson);

}

function CinemaPage(event){

    event.preventDefault();

    fetch("api_request.php?q=cinema").then(fetchResponse).then(onJson);

}

function TVPage(event){

    event.preventDefault();

    fetch("api_request.php?q=tv").then(fetchResponse).then(onJson);

}

function GamesPage(event){

    event.preventDefault();

    fetch("api_request.php?q=games").then(fetchResponse).then(onJson);

}

//richiediamo i contenuti
fetch("api_request.php").then(fetchResponse).then(onJson);

anime_buttons = document.querySelectorAll('#anime_button');
if(anime_buttons){
    for(button of anime_buttons)
    button.addEventListener('click', AnimePage);
}
cinema_buttons = document.querySelectorAll('#cinema_button');
if(cinema_buttons){
    for(button of cinema_buttons)
    button.addEventListener('click', CinemaPage);
}
tv_buttons = document.querySelectorAll('#tv_button');
if(tv_buttons){
    for(button of tv_buttons)
    button.addEventListener('click', TVPage);
}
videogames_buttons = document.querySelectorAll('#videogames_button');
if(videogames_buttons){
    for(button of videogames_buttons)
    button.addEventListener('click', GamesPage);
}


