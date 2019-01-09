function openMobileSidebar(){
    var wrapper=document.getElementById("sidebar-wrapper");
    var mask=document.getElementById("mobile-sidebar-mask");
    if(wrapper!=null && mask!=null){
        wrapper.style.width="70%";
        mask.style.display="block";
        mask.style.backgroundColor="rgba(0,0,0,0.5)";
    }
}
function loadCSSstylesheet(){
    var file = location.pathname.split( "/" ).pop();

    var link = document.createElement( "link" );
    link.href = "onlyJS.css";
    link.type = "text/css";
    link.rel = "stylesheet";
    document.getElementsByTagName( "head" )[0].appendChild( link );	
}
function closeMobileSidebar(){
    var wrapper=document.getElementById("sidebar-wrapper");
    var mask=document.getElementById("mobile-sidebar-mask");
    if(wrapper!=null && mask!=null){
        wrapper.style.width="0%";
        mask.style.backgroundColor="rgba(0,0,0,0.0)";		
        mask.style.display="none";
    }
}

function toggleMobileNavMenu(){
    var menu=document.getElementById("menu");
    if(menu!=null){
        if(menu.style.display=="block"){
            menu.style.display="none";		
        }else{
            menu.style.display="block";	
        }
    }
}

function sidebarExpandButtons(){
    var buttons = document.getElementsByClassName("expand-button");
    for(var i=0; i<buttons.length;i++){
        buttons[i].addEventListener("click",function(e){
            e = e || window.event;
            var target = e.target || e.srcElement;
            var sublist= target.parentNode.parentNode.getElementsByTagName("UL")[0];
            if(sublist.style.display=="block"){
                target.src="img/expand-button.svg";
                sublist.style.display="none";
            }else{
                sublist.style.display="block";
                target.src="img/collapse-button.svg";				
            }
        },false);
    }
}

//----------------------------------------------------
//Controllo dati input form vari
//----------------------------------------------------

//---FUNZIONI GENERICHE---

function HideAllErrorBoxes(){
    ProfilePage_HideChangePWError();
    ProfilePage_HideChangeBasicDataPWError();
    LoginPage_HideChangeLoginDataError();
    RegisterPage_HideChangeLoginDataError();
}

function checkStringEquals(string1, string2){
    if(string1 == null || string2 == null){
        return false;
    }
    return string1 == string2;
}

function checkStringIsValid(value){
    if(value == null){
        return false;
    }
    if(value.trim() == ""){
        return false;
    }
    if(value.length == 0){
        return false;
    }
    return true;
}

//---
//---PAGINA LOGIN.PHP---
//---

//Nascondi il box dell'errore
function LoginPage_HideChangeLoginDataError(){
    var changePwErrorBox = document.getElementById("js-login-input-error");
    if (changePwErrorBox!=null){
        changePwErrorBox.style.display = "none";
        changePwErrorBox.innerHTML = "";
    }
}

//Mostra il box dell'errore con un messaggio specifico
function LoginPage_ShowChangeLoginDataError(HTML_message){
    var errorbox = document.getElementById("js-login-input-error");
    errorbox.style.display = "block";
    errorbox.innerHTML = HTML_message;
}

//Valida i dati del cambio dati base
function validateLoginData(){
    email = document.getElementById("lemail").value;
    password = document.getElementById("lpassword").value;
    var errorMessage = "";
    if(!checkStringIsValid(email) || email.length > 100){
        errorMessage += "<li>L'email inserita non è valida!</li>";
    } 
    if(!checkStringIsValid(password) || password.length > 100){
        errorMessage += "<li>La password inserita non è valida!</li>";
    }
    if(errorMessage != ""){
        LoginPage_ShowChangeLoginDataError(errorMessage);
        return false;
    }
    return true;
}

//---
//---PAGINA REGISTER.PHP---
//---

//Nascondi il box dell'errore
function RegisterPage_HideChangeLoginDataError(){
    var changePwErrorBox = document.getElementById("js-register-input-error");
    if (changePwErrorBox!=null){
        changePwErrorBox.style.display = "none";
        changePwErrorBox.innerHTML = "";
    }
}

//Mostra il box dell'errore con un messaggio specifico
function RegisterPage_ShowChangeLoginDataError(HTML_message){
    var errorbox = document.getElementById("js-register-input-error");
    errorbox.style.display = "block";
    errorbox.innerHTML = HTML_message;
}

//Valida i dati del cambio dati base
function validateRegisterData(){
    email = document.getElementById("lemail").value;
    nick = document.getElementById("lnickname").value;
    name = document.getElementById("lname").value;
    surname = document.getElementById("lsurname").value;
    password = document.getElementById("lpassword").value;
    var errorMessage = "";
    if(!checkStringIsValid(email) || email.length > 100){
        errorMessage += "<li>L'email inserita non è valida!</li>";
    }
    if(!checkStringIsValid(nick) || nick.length > 100){
        errorMessage += "<li>Il nickname inserito non è valido!</li>";
    }
    if(!checkStringIsValid(name) || name.length > 100){
        errorMessage += "<li>Il nome inserito non è valido!</li>";
    }
    if(!checkStringIsValid(surname) || surname.length > 100){
        errorMessage += "<li>Il cognome inserito non è valido!</li>";
    }
    if(!checkStringIsValid(password) || password.length > 100){
        errorMessage += "<li>La password inserita non è valida!</li>";
    }
    if(errorMessage != ""){
        RegisterPage_ShowChangeLoginDataError(errorMessage);
        return false;
    }
    return true;
}

//---
//---PAGINA PROFILE.PHP---
//---

//--->Zona di cambio dei dati base

//Nascondi il box dell'errore
function ProfilePage_HideChangeBasicDataPWError(){
    var changePwErrorBox = document.getElementById("base-data-error-box");
    if (changePwErrorBox!=null){
        changePwErrorBox.style.display = "none";
        changePwErrorBox.innerHTML = "";
    }
}

//Mostra il box dell'errore con un messaggio specifico
function ProfilePage_ShowChangeBasicDataError(HTML_message){
    var errorbox = document.getElementById("base-data-error-box");
    errorbox.style.display = "block";
    errorbox.innerHTML = HTML_message;
}

//Valida i dati del cambio dati base
function validateChangeBasicData(){
    nickname = document.getElementById("lnickname").value;
    name = document.getElementById("lname").value;
    surname = document.getElementById("lsurname").value;
    var errorMessage = "";
    if(!checkStringIsValid(nickname) || nickname.length > 100){
        errorMessage += "<li>Il nickname inserito non è valido!</li>";
    } 
    if(!checkStringIsValid(name) || name.length > 100){
        errorMessage += "<li>Il nome inserito non è valido!</li>";
    }
    if(!checkStringIsValid(surname) || surname.length > 100){
        errorMessage += "<li>Il cognome inserito non è valido!</li>";
    }
    if(errorMessage != ""){
        ProfilePage_ShowChangeBasicDataError(errorMessage);
        return false;
    }
    return true;
}

//--->Zona di cambio password

//Nascondi il box dell'errore
function ProfilePage_HideChangePWError(){
    var changePwErrorBox = document.getElementById("password-error-box");
    if (changePwErrorBox!=null){
        changePwErrorBox.style.display = "none";
        changePwErrorBox.innerHTML = "";
    }
}

//Mostra il box dell'errore con un messaggio specifico
function ProfilePage_ShowChangePwError(HTML_message){
    var errorbox = document.getElementById("password-error-box");
    errorbox.style.display = "block";
    errorbox.innerHTML = HTML_message;
}

//Valida i dati del cambio password
function validateChangePassword(){
    original_password = document.getElementById("lold-password").value;
    new_password_1 = document.getElementById("lnew-password").value;
    new_password_2 = document.getElementById("lconf-new-password").value;
    var errorMessage = "";
    if(!checkStringIsValid(original_password) || original_password.length > 100){
        errorMessage += "<li>La passowrd originale non è valida!</li>";
    } 
    if(!checkStringIsValid(new_password_1) || original_password.length > 100){
        errorMessage += "<li>La nuova password non è valida!</li>";
    }
    if(!checkStringIsValid(new_password_2) || original_password.length > 100){
        errorMessage += "<li>La conferma della nuova password non è valida!</li>";
    }
    if(errorMessage != ""){
        ProfilePage_ShowChangePwError(errorMessage);
        return false;
    }
    if(!checkStringEquals(new_password_1, new_password_2)){
        ProfilePage_ShowChangePwError("Le due password non coincidono!");
        return false;
    }
    return true;
}

//----------------------------------------------------
//Principali EventListener
//----------------------------------------------------

window.addEventListener("load", function(){
    loadCSSstylesheet();
    var hamburger=document.getElementById("nav-hamburger");
    var mask=document.getElementById("mobile-sidebar-mask");
    var menuIcon=document.getElementById("nav-menu-icon");
    if(hamburger!=null && mask!=null){
        hamburger.addEventListener("click",openMobileSidebar, true);
        mask.addEventListener("click",closeMobileSidebar, true);
    }
    if(menuIcon!=null){
        menuIcon.addEventListener("click",toggleMobileNavMenu , true);
    }
    //Profile.php
    var changePwForm=document.getElementById("change_pw_form");
    var changeBasicDataForm=document.getElementById("change_basic_data_form");
    if(changePwForm!=null){
        changePwForm.addEventListener("submit", function(event) {
            if(!validateChangePassword()){
                event.preventDefault();
            }
        }, false);
    }
    if(changeBasicDataForm!=null){
        changeBasicDataForm.addEventListener("submit", function(event) {
            if(!validateChangeBasicData()){
                event.preventDefault();
            }
        }, false);
    }
    //Login.php
    var mainLoginForm=document.getElementById("login-main-form");
    if(mainLoginForm != null){
        mainLoginForm.addEventListener("submit", function(event) {
            if(!validateLoginData()){
                event.preventDefault();
            }
        }, false);
    }
    //Register.php
    var mainRegisterForm=document.getElementById("register-main-form");
    if(mainRegisterForm != null){
        mainRegisterForm.addEventListener("submit", function(event) {
            if(!validateRegisterData()){
                event.preventDefault();
            }
        }, false);
    }
    //Funzioni di inizializzazione
    sidebarExpandButtons();
    HideAllErrorBoxes();
});

window.addEventListener('resize', function(e) {
    var wrapper=document.getElementById("sidebar-wrapper");
    var mask=document.getElementById("mobile-sidebar-mask");
    var menu=document.getElementById("menu");
    if(window.innerWidth>768){
        if(wrapper!=null && mask!=null){
            wrapper.style.width="25%";
            mask.style.backgroundColor="rgba(0,0,0,0.0)";		
            mask.style.display="none";
        }
        if(menu!=null){
            menu.style.display="block";
        }
    }else{
        if(wrapper!=null){
            wrapper.style.width="0%";
        }
        if(menu!=null){
            menu.style.display="none";
        }

    }
}, false);

/* nav-bar menu collapse */
document.addEventListener("DOMContentLoaded", function() {
    //The first argument are the elements to which the plugin shall be initialized
    //The second argument has to be at least a empty object or a object with your desired options
    var sidebar=document.getElementById("sidebar-wrapper");
    if(sidebar!=null){
        OverlayScrollbars(sidebar, { });
    }
});

//----------------------------------------------------
//Gestione scroll verso l'alto
//----------------------------------------------------

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    var goTop = document.getElementById("retTop");
    if(goTop!=null){
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("retTop").style.display = "block";
        } else {
            document.getElementById("retTop").style.display = "none";
        }
    }
}



// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    scrollTo(document.documentElement, 0, 1250); 
}

function scrollTo(element, to, duration) {
    var start = element.scrollTop,
        change = to - start,
        currentTime = 0,
        increment = 20;
        
    var animateScroll = function(){        
        currentTime += increment;
        var val = Math.easeInOutQuad(currentTime, start, change, duration);
        element.scrollTop = val;
        if(currentTime < duration) {
            setTimeout(animateScroll, increment);
        }
    };
    animateScroll();
}

//t = current time
//b = start value
//c = change in value
//d = duration
Math.easeInOutQuad = function (t, b, c, d) {
    t /= d/2;
    if (t < 1) return c/2*t*t + b;
    t--;
    return -c/2 * (t*(t-2) - 1) + b;
};

