function login(event){
    
    event.preventDefault();
    

    const element = document.querySelector('#overlay');
    element.classList.remove("hidden");

    element.style.top = window.pageYOffset + 'px';
    

    document.body.classList.add("no-scroll");

}

function login_mobile(event){
    
    event.preventDefault();

    document.querySelector('#nav_bar').classList.add('hidden');
    document.querySelector('#nav_bar').style.width = "0";
    document.querySelector('#nav_bar').style.padding = "0";

    mobile_button.removeEventListener('click', CloseNav);

    mobile_button.addEventListener('click', OpenNav);
    
    const element = document.querySelector('#overlay');
    element.classList.remove("hidden");

    element.style.top = window.pageYOffset + 'px';
    

    document.body.classList.add("no-scroll");

}

function normal(event){

    if (event.currentTarget !== event.target) {
        return;
      }

    event.target.classList.add("hidden");

    document.body.classList.remove("no-scroll");
}

function register(event){

    event.preventDefault();

    const element = document.querySelector('#login_box');
    element.classList.add("hidden");

    const element2 = document.querySelector('#register_box');
    element2.classList.remove('hidden');

    const element_box = document.querySelector('.login_popup');
    element_box.classList.add("register_popup");
    element_box.classList.remove("login_popup");

}

function login_register(event){

    event.preventDefault();

    const element2 = document.querySelector('#register_box');
    element2.classList.add('hidden');

    const element = document.querySelector('#login_box');
    element.classList.remove("hidden");

    const element_box = document.querySelector('.register_popup');
    element_box.classList.remove("register_popup");
    element_box.classList.add("login_popup");

}

function OpenNav(event){

    document.querySelector('#nav_bar').classList.remove('hidden');

    document.querySelector('#nav_bar').style.width = "30vw";
    document.querySelector('#nav_bar').style.padding = "3%";


    event.currentTarget.removeEventListener('click', OpenNav);

    event.currentTarget.addEventListener('click', CloseNav);

}

function CloseNav(event){

    document.querySelector('#nav_bar').style.width = "0";
    document.querySelector('#nav_bar').style.padding = "0";

    event.currentTarget.removeEventListener('click', CloseNav);

    event.currentTarget.addEventListener('click', OpenNav);

}

const login_button = document.querySelector("#login_icon");

if(login_button != null)
login_button.addEventListener('click', login);

const login_button_mobile = document.querySelector("#login_icon_mobile");

if(login_button_mobile != null)
login_button_mobile.addEventListener('click', login_mobile);

const favourites_button = document.querySelector("#favourites_nologin");

if(favourites_button != null)
favourites_button.addEventListener('click', login);

const favourites_button_check = document.querySelector("#favourites_nologin_button");

if(favourites_button_check != null)
favourites_button_check.addEventListener('click', login);

const register_button = document.querySelector('#register');

if(register_button)
register_button.addEventListener('click', register);

const login_register_button = document.querySelector('#login');

if(login_register_button)
login_register_button.addEventListener('click', login_register);


const background = document.querySelector('#overlay');

if(background)
background.addEventListener('click', normal);

const mobile_button = document.querySelector('#nav_icon_box');

if(mobile_button) mobile_button.addEventListener('click', OpenNav);

