function openMobileSidebar() {
    var wrapper = document.getElementById("sidebar-wrapper");
    var mask = document.getElementById("mobile-sidebar-mask");
    if (wrapper != null && mask != null) {
        wrapper.style.width = "70%";
        mask.style.display = "block";
        mask.style.backgroundColor = "rgba(0,0,0,0.5)";
    }
}
function topFunction(){
    var scrollY = 0;
    var distance = 40;
    var speed = 24;
    var currentY = window.pageYOffset;
    var targetY = document.getElementsByTagName("BODY")[0].offsetTop;
    var animator = setTimeout('topFunction(\''+"BODY"+'\')',speed);
    if(currentY > targetY){
        scrollY = currentY-distance;
        window.scroll(0, scrollY);
    } else {
        clearTimeout(animator);
    }
}
function loadCSSstylesheet() {
	var location = document.location.pathname;
	var pos = location.lastIndexOf("/");
	location = location.substring(0, pos+1);

    var link = document.createElement("link");
    link.href = location+"/style/onlyJS.css";
    link.type = "text/css";
    link.rel = "stylesheet";
    document.getElementsByTagName("head")[0].appendChild(link);
}

function closeMobileSidebar() {
    var wrapper = document.getElementById("sidebar-wrapper");
    var mask = document.getElementById("mobile-sidebar-mask");
    if (wrapper != null && mask != null) {
        wrapper.style.width = "0%";
        mask.style.backgroundColor = "rgba(0,0,0,0.0)";
        mask.style.display = "none";
    }
}

function toggleMobileNavMenu() {
    var menu = document.getElementById("menu");
    if (menu != null) {
        if (menu.style.display == "block") {
            menu.style.display = "none";
        } else {
            menu.style.display = "block";
        }
    }
}

function sidebarExpandButtons() {
    var buttons = document.getElementsByClassName("expand-button");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", function (e) {
            e = e || window.event;
            var target = e.target || e.srcElement;
            var sublist = target.parentNode.parentNode.getElementsByTagName("UL")[0];
            if (sublist.style.display == "block") {
                target.src = "img/expand-button.svg";
                target.alt="Expand";
                sublist.style.display = "none";
            } else {
            	target.src = "img/collapse-button.svg";
            	target.alt="Collapse";
                sublist.style.display = "block";
            }
        }, false);
    }
}

//apre automaticamente la sezione del topic nella sidebar
function sidebarExtendTopic(topicID) {
    var topic = document.getElementById(topicID);
    if (topic != null) {
        var sublist = topic.parentNode.parentNode.getElementsByTagName("UL")[0];
        topic.src = "img/collapse-button.svg";
        topic.setAttribute("name", "auto-opened");
        sublist.style.display = "block";
    }
}

//----------------------------------------------------
//Controllo dati input form vari
//----------------------------------------------------

//---FUNZIONI GENERICHE---

//---FUNZIONI CONTROLLO VALORI---

function checkStringEquals(string1, string2) {
    if (string1 == null || string2 == null) {
        return false;
    }
    return string1 === string2;
}

function checkStringIsValid(value) {
    if (value == null) {
        return false;
    }
    if (value.trim() === "") {
        return false;
    }
    return value.length !== 0;

}

//Validazione con espressioni regolari

function checkEmailStringFormat(email) {
    //RE presa da http://jsfiddle.net/ghvj4gy9/embedded/result,js/
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

/*Currently not used*/
function checkSimpleStringFormat(value) {
    var re = /^[A-Za-z]{1,99}$/;
    return re.test(value);
}

function checkNameStringFormat(value) {
    var re = /^[a-zA-Z0-9_]+( [a-zA-Z0-9_]+)*$/;
    return re.test(value);
}

function checkFileUpload(value) {
    var _validFileExtensions = ["jpg", "jpeg", "png"];
    var extension = value.split('.').pop();
    if ((_validFileExtensions.indexOf(extension) > -1)) {
        return true;
    } else {
        return false;
    }
}

//---FUNZIONI PER MOSTRARE/NASCONDERE BOX ERRORE---

function CreateErrorBox(parentID, boxID, hideOnCreate) {
    var parent = document.getElementById(parentID);
    if (parent != null) {
        var createdElement = document.createElement("UL");
        createdElement.className = "regform-errorbox";
        createdElement.id = boxID;
        parent.appendChild(createdElement);
        if (createdElement != null && hideOnCreate) {
            return true && HideErrorBox(boxID);
        }
        return true;
    }
    return false;
}

function HideErrorBox(boxID) {
    var ErrorBox = document.getElementById(boxID);
    if (ErrorBox != null) {
        ErrorBox.style.display = "none";
        ErrorBox.innerHTML = "";
        return true;
    }
    return false;
}

function ShowErrorBox(boxID, HTML_message) {
    var ErrorBox = document.getElementById(boxID);
    if (ErrorBox != null) {
        ErrorBox.style.display = "block";
        ErrorBox.innerHTML = HTML_message;
        return true;
    }
    return false;
}

//---
//---PAGINA LOGIN.PHP---
//---

//Crea il box dell'errore nella posizione data
function LoginPage_CreateErrorBox() {
    CreateErrorBox("login-error-box-zone", "js-login-input-error",true);
}

//Nascondi il box dell'errore
function LoginPage_HideChangeLoginDataError() {
    HideErrorBox("js-login-input-error");
}

//Mostra il box dell'errore con un messaggio specifico
function LoginPage_ShowChangeLoginDataError(HTML_message) {
    ShowErrorBox("js-login-input-error", HTML_message);
}

//Valida i dati del cambio dati base
function validateLoginData() {
    var email = document.getElementById("lemail").value;
    var password = document.getElementById("lpassword").value;

    var errorMessage = "";
    if (!checkStringIsValid(email) || email.length > 100) {
        errorMessage += "<li>The email is not valid!</li>";
    }
    if (!checkStringIsValid(password) || password.length > 100) {
        errorMessage += "<li>The password is invalid!</li>";
    }
    if (errorMessage !== "") {
        LoginPage_ShowChangeLoginDataError(errorMessage);
        return false;
    }
    return true;
}

//---
//---PAGINA REGISTER.PHP---
//---

//Crea il box dell'errore nella posizione data
function RegisterPage_CreateErrorBox() {
    CreateErrorBox("register-error-box-zone", "js-register-input-error",true);
}

//Nascondi il box dell'errore
function RegisterPage_HideChangeLoginDataError() {
    HideErrorBox("js-register-input-error");
}

//Mostra il box dell'errore con un messaggio specifico
function RegisterPage_ShowChangeLoginDataError(HTML_message) {
    ShowErrorBox("js-register-input-error", HTML_message);
}

//Valida i dati del cambio dati base
function validateRegisterData() {
    var email = document.getElementById("lemail").value;
    var nick = document.getElementById("lnickname").value;
    var name = document.getElementById("lname").value;
    var surname = document.getElementById("lsurname").value;
    var password = document.getElementById("lpassword").value;

    var errorMessage = "";
    if (!checkStringIsValid(email) || email.length > 100 || !checkEmailStringFormat(email)) {
        errorMessage += "<li>The email is not valid!</li>";
    }
    if (!checkStringIsValid(nick) || nick.length > 100) {
        errorMessage += "<li>The nickname is not valid!</li>";
    }
    if (!checkStringIsValid(name) || name.length > 100 || !checkNameStringFormat(name)) {
        errorMessage += "<li>The name is not valid!</li>";
    }
    if (!checkStringIsValid(surname) || surname.length > 100 || !checkNameStringFormat(surname)) {
        errorMessage += "<li>The surname entered is not valid!</li>";
    }
    if (!checkStringIsValid(password) || password.length > 100) {
        errorMessage += "<li>The password is invalid!</li>";
    }
    if (errorMessage !== "") {
        RegisterPage_ShowChangeLoginDataError(errorMessage);
        return false;
    }
    return true;
}

//---
//---PAGINA PROFILE.PHP---
//---

//--->Zona di cambio dei dati base

//Crea il box dell'errore nella posizione data
function ProfilePage_CreateErrorBox_BasicData() {
    CreateErrorBox("profile-error-box-base-data", "base-data-error-box",true);
}

//Nascondi il box dell'errore
function ProfilePage_HideChangeBasicDataPWError() {
    HideErrorBox("base-data-error-box");
}

//Mostra il box dell'errore con un messaggio specifico
function ProfilePage_ShowChangeBasicDataError(HTML_message) {
    ShowErrorBox("base-data-error-box", HTML_message);
}

//Valida i dati del cambio dati base
function validateChangeBasicData() {
    var nickname = document.getElementById("lnickname").value;
    var name = document.getElementById("lname").value;
    var surname = document.getElementById("lsurname").value;

    var errorMessage = "";
    if (!checkStringIsValid(nickname) || nickname.length > 100) {
        errorMessage += "<li>The entered nickname is not valid!</li>";
    }
    if (!checkStringIsValid(name) || name.length > 100 || !checkNameStringFormat(name)) {
        errorMessage += "<li>The name is not valid!</li>";
    }
    if (!checkStringIsValid(surname) || surname.length > 100 || !checkNameStringFormat(surname)) {
        errorMessage += "<li>The surname is not valid!</li>";
    }
    if (errorMessage !== "") {
        ProfilePage_ShowChangeBasicDataError(errorMessage);
        return false;
    }
    return true;
}

//--->Zona di cambio password

//Crea il box dell'errore nella posizione data
function ProfilePage_CreateErrorBox_ChangePw() {
    CreateErrorBox("profile-error-box-change-pw", "password-error-box",true);
}

//Nascondi il box dell'errore
function ProfilePage_HideChangePWError() {
    HideErrorBox("password-error-box");
}

//Mostra il box dell'errore con un messaggio specifico
function ProfilePage_ShowChangePwError(HTML_message) {
    ShowErrorBox("password-error-box", HTML_message);
}

//Valida i dati del cambio password
function validateChangePassword() {
    var original_password = document.getElementById("lold-password").value;
    var new_password_1 = document.getElementById("lnew-password").value;
    var new_password_2 = document.getElementById("lconf-new-password").value;

    var errorMessage = "";
    if (!checkStringIsValid(original_password) || original_password.length > 100) {
        errorMessage += "<li>The original password is invalid!</li>";
    }
    if (!checkStringIsValid(new_password_1) || new_password_1.length > 100) {
        errorMessage += "<li>The new password is invalid!</li>";
    }
    if (!checkStringIsValid(new_password_2) || new_password_2.length > 100) {
        errorMessage += "<li>Confirmation of the new password is invalid!</li>";
    }
    if (errorMessage !== "") {
        ProfilePage_ShowChangePwError(errorMessage);
        return false;
    }
    if (!checkStringEquals(new_password_1, new_password_2)) {
        ProfilePage_ShowChangePwError("<li>The two passwords do not match!</li>");
        return false;
    }
    return true;
}

//---
//---PAGINA manageArguments.PHP---
//---

//Crea il box dell'errore nella posizione data
function ManageArguments_CreateErrorBox_InsertCard() {
    CreateErrorBox("arguments-error-box-insert-card", "card-error-box",true);
}

//Nascondi il box dell'errore
function ManageArguments_HideInsertCardError() {
    HideErrorBox("card-error-box");
}

//Mostra il box dell'errore con un messaggio specifico
function ManageArguments_ShowInsertCardError(HTML_message) {
    ShowErrorBox("card-error-box", HTML_message);
}

//Valida i dati del cambio dati base
function validateInsertCardData() {
    var title = document.getElementById("title-input-box").value;
    var description = document.getElementById("descrizione").value;
    var image = document.getElementById("file-upload").value;

    var errorMessage = "";
    if (!checkStringIsValid(title) || title.length > 100) {
        errorMessage += "<li>The title is not valid!</li>";
    }
    if (!checkStringIsValid(description) || description.length > 10000) {
        errorMessage += "<li>The description is invalid!</li>";
    }
    if (!checkFileUpload(image)) {
        errorMessage += "<li>The cover image is invalid (probably you're not uploading an image)!</li>";
    }
    if (errorMessage !== "") {
        ManageArguments_ShowInsertCardError(errorMessage);
        return false;
    }
    return true;
}

//---
//---PAGINA ReadArticle.PHP INSERIMENTO NUOVO COMMENTO---
//---

//Crea il box dell'errore nella posizione data
function ReadArticle_CreateErrorBox_InsertComment() {
    CreateErrorBox("comments-error-box-insert-comment", "insert-comment-error-box",true);
}

//Nascondi il box dell'errore
function ReadArticle_HideInsertCommentError() {
    HideErrorBox("insert-comment-error-box");
}

//Mostra il box dell'errore con un messaggio specifico
function ReadArticle_ShowInsertCommentError(HTML_message) {
    ShowErrorBox("insert-comment-error-box", HTML_message);
}

//Valida i dati del cambio dati base
function validateInsertCommentData() {
    var commentTextArea = document.getElementById("comment-text-area-input").value;

    var errorMessage = "";
    if (!checkStringIsValid(commentTextArea) || commentTextArea.length > 10000) {
        errorMessage += "<li>The comment content is invalid!</li>";
    }

    if (errorMessage !== "") {
        ReadArticle_ShowInsertCommentError(errorMessage);
        return false;
    }
    return true;
}

//---
//---PAGINA ArticleLinks.PHP INSERIMENTO NUOVO SUBTOPIC---
//---

//Crea il box dell'errore nella posizione data
function ArticleLinks_CreateErrorBox_InsertNewSubtopic() {
    CreateErrorBox("subtopics-error-box-insert-subtopic", "insert-new-subtopic-error-box",true);
}

//Nascondi il box dell'errore
function ArticleLinks_HideInsertNewSubtopicError() {
    HideErrorBox("insert-new-subtopic-error-box");
}

//Mostra il box dell'errore con un messaggio specifico
function ArticleLinks_ShowInsertNewSubtopicError(HTML_message) {
    ShowErrorBox("insert-new-subtopic-error-box", HTML_message);
}

//Valida i dati per la creazione di un nuovo subtopic
function validateInsertNewSubtopicData() {
    var subtopic_title = document.getElementById("new-subtopic-title").value;
    var subtopic_description = document.getElementById("descrizione").value;

    var errorMessage = "";
    if (!checkStringIsValid(subtopic_title) || subtopic_title.length > 100) {
        errorMessage += "<li>The title is not valid!</li>";
    }
    if (!checkStringIsValid(subtopic_description) || subtopic_description.length > 500) {
        errorMessage += "<li>The description is not valid!</li>";
    }

    if (errorMessage !== "") {
        ArticleLinks_ShowInsertNewSubtopicError(errorMessage);
        return false;
    }
    return true;
}

//---
//---PAGINA recoverPassword.PHP---
//---

//Crea il box dell'errore nella posizione data
function RecoverPassword_CreateErrorBox_ChangePw() {
    CreateErrorBox("forgot-pw-error-box-change-password", "recover-password-error-box",true);
}

//Nascondi il box dell'errore
function RecoverPassword_HideChangePwError() {
    HideErrorBox("recover-password-error-box");
}

//Mostra il box dell'errore con un messaggio specifico
function RecoverPassword_ShowChangePwError(HTML_message) {
    ShowErrorBox("recover-password-error-box", HTML_message);
}

//Valida i dati del cambio dati base
function validateRecoverPasswordData() {
    var new_password_1 = document.getElementById("lpassword").value;
    var new_password_2 = document.getElementById("lpassword-confirm").value;

    var errorMessage = "";
    if (!checkStringIsValid(new_password_1) || new_password_1.length > 100) {
        errorMessage += "<li>The new password is invalid!</li>";
    }
    if (!checkStringIsValid(new_password_2) || new_password_2.length > 100) {
        errorMessage += "<li>The confirmation of the new password is invalid!</li>";
    }
    if (errorMessage !== "") {
        RecoverPassword_ShowChangePwError(errorMessage);
        return false;
    }
    if (!checkStringEquals(new_password_1, new_password_2)) {
        RecoverPassword_ShowChangePwError("<li>The two passwords do not match!</li>");
        return false;
    }
    return true;
}

//---
//---PAGINA insertArticle.PHP---
//---

//Crea il box dell'errore nella posizione data
function InsertArticle_CreateErrorBox_InsertArticle() {
    CreateErrorBox("insert-article-error-box", "recover-password-error-box",true);
}

//Nascondi il box dell'errore
function InsertArticle_HideInsertArticleError() {
    HideErrorBox("recover-password-error-box");
}

//Mostra il box dell'errore con un messaggio specifico
function InsertArticle_ShowInsertArticleError(HTML_message) {
    ShowErrorBox("recover-password-error-box", HTML_message);
}

//Valida i dati del cambio dati base
function validateInsertNewArticleData() {
    var article_title = document.getElementById("title").value;
    var article_content = document.getElementById("new-article-content").value;

    var errorMessage = "";
    if (!checkStringIsValid(article_title) || article_title.length > 100) {
        errorMessage += "<li>The title is not valid!</li>";
    }
    if (!checkStringIsValid(article_content) || article_content.length > 100000) {
        errorMessage += "<li>The content of the article is not valid!</li>";
    }

    if (errorMessage !== "") {
        InsertArticle_ShowInsertArticleError(errorMessage);
        return false;
    }
    return true;
}

//---
//---PAGINA ADDADMIN.PHP---
//---

//Crea il box dell'errore nella posizione data
function AddAdmin_CreateErrorBox() {
    CreateErrorBox("add-admin-error-box-zone", "js-add-admin-input-error",true);
}

//Nascondi il box dell'errore
function AddAdmin_HideAddAdminEmailError() {
    HideErrorBox("js-add-admin-input-error");
}

//Mostra il box dell'errore con un messaggio specifico
function AddAdmin_ShowAddAdminEmailError(HTML_message) {
    ShowErrorBox("js-add-admin-input-error", HTML_message);
}

//Valida se l'email dell'utente è valida
function validateAddAdminData() {
    var email = document.getElementById("lemail").value;

    var errorMessage = "";
    if (!checkStringIsValid(email) || email.length > 100) {
        errorMessage += "<li>The email entered is not valid!</li>";
    }
    if (errorMessage !== "") {
        AddAdmin_ShowAddAdminEmailError(errorMessage);
        return false;
    }
    return true;
}

//---
//---PAGINA MANAGEUSERS.PHP---
//---

//Crea il box dell'errore nella posizione data
function BanUser_CreateErrorBox() {
    CreateErrorBox("ban-user-error-box-zone", "js-ban-user-input-error",true);
}

//Nascondi il box dell'errore
function BanUser_HideBanUserError() {
    HideErrorBox("js-ban-user-input-error");
}

//Mostra il box dell'errore con un messaggio specifico
function BanUser_ShowBanUserNicknameError(HTML_message) {
    ShowErrorBox("js-ban-user-input-error", HTML_message);
}

//Valida se il nickname dato è valido
function validateBanUserData() {
    nick = document.getElementById("lnickname").value;
    var errorMessage = "";
    if (!checkStringIsValid(nick) || nick.length > 100) {
        errorMessage += "<li>The entered nickname is not valid!</li>";
    }
    if (errorMessage !== "") {
        BanUser_ShowBanUserNicknameError(errorMessage);
        return false;
    }
    return true;
}

//----------------------------------------------------
//Principali EventListener
//----------------------------------------------------
function resize(lastWidth) {
    if (window.innerWidth != lastWidth) {
        var wrapper = document.getElementById("sidebar-wrapper");
        var mask = document.getElementById("mobile-sidebar-mask");
        var menu = document.getElementById("menu");
        if (window.innerWidth > 768) {
            if (wrapper != null && mask != null) {
                wrapper.style.width = "25%";
                mask.style.backgroundColor = "rgba(0,0,0,0.0)";
                mask.style.display = "none";
            }
            if (menu != null) {
                menu.style.display = "block";
            }
        } else {
            if (wrapper != null) {
                wrapper.style.width = "0%";
            }
            if (menu != null) {
                menu.style.display = "none";
            }

        }
    }
    return window.innerWidth;
}

function manageResize() {
    var l = window.innerWidth;
    window.addEventListener('resize', function () {
        l = resize(l)
    }, false);
}

window.addEventListener("scroll",function(){
    var retTop=document.getElementById("retTop");
    if (retTop!=null){
        if(window.pageYOffset<= 0){
            retTop.style.display="none";
        }else{
            retTop.style.display="block";            
        }
    }
},false);
window.addEventListener("load", function () {
    loadCSSstylesheet();
    var hamburger = document.getElementById("nav-hamburger");
    var mask = document.getElementById("mobile-sidebar-mask");
    var closeButton = document.getElementById("close-sidebar-button");
    var menuIcon = document.getElementById("nav-menu-icon");
    if (hamburger != null && mask != null && closeButton != null) {
        hamburger.addEventListener("click", openMobileSidebar, true);
        mask.addEventListener("click", closeMobileSidebar, true);
        closeButton.addEventListener("click", closeMobileSidebar, true);
    }
    if (menuIcon != null) {
        menuIcon.addEventListener("click", toggleMobileNavMenu, true);
    }
    //Profile.php
    var changePwForm = document.getElementById("change_pw_form");
    var changeBasicDataForm = document.getElementById("change_basic_data_form");
    if (changePwForm != null) {
        ProfilePage_CreateErrorBox_ChangePw();
        changePwForm.addEventListener("submit", function (event) {
            if (!validateChangePassword()) {
                event.preventDefault();
            }
        }, false);
    }
    if (changeBasicDataForm != null) {
        ProfilePage_CreateErrorBox_BasicData();
        changeBasicDataForm.addEventListener("submit", function (event) {
            if (!validateChangeBasicData()) {
                event.preventDefault();
            }
        }, false);
    }
    //Login.php
    var mainLoginForm = document.getElementById("login-main-form");
    if (mainLoginForm != null) {
        LoginPage_CreateErrorBox();
        mainLoginForm.addEventListener("submit", function (event) {
            if (!validateLoginData()) {
                event.preventDefault();
            }
        }, false);
    }
    //Register.php
    var mainRegisterForm = document.getElementById("register-main-form");
    if (mainRegisterForm != null) {
        RegisterPage_CreateErrorBox();
        mainRegisterForm.addEventListener("submit", function (event) {
            if (!validateRegisterData()) {
                event.preventDefault();
            }
        }, false);
    }
    //Manage Argument.php
    var insertCardForm = document.getElementById("insert-new-card-form");
    if (insertCardForm != null) {
        ManageArguments_CreateErrorBox_InsertCard();
        insertCardForm.addEventListener("submit", function (event) {
            if (!validateInsertCardData()) {
                event.preventDefault();
            }
        }, false);
    }
    //Comments.php
    var insertCommentForm = document.getElementById("insert-new-comment-form");
    if (insertCommentForm != null) {
        ReadArticle_CreateErrorBox_InsertComment();
        insertCommentForm.addEventListener("submit", function (event) {
            if (!validateInsertCommentData()) {
                event.preventDefault();
            }
        }, false);
    }
    //ArticleLinks
    var insertSubtopicForm = document.getElementById("insert-new-subtopic-form");
    if (insertSubtopicForm != null) {
        ArticleLinks_CreateErrorBox_InsertNewSubtopic();
        insertSubtopicForm.addEventListener("submit", function (event) {
            if (!validateInsertNewSubtopicData()) {
                event.preventDefault();
            }
        }, false);
    }
    //RecoverPassword
    var recoverPasswordChangeForm = document.getElementById("change-password-forgot-token");
    if (recoverPasswordChangeForm != null) {
        RecoverPassword_CreateErrorBox_ChangePw();
        recoverPasswordChangeForm.addEventListener("submit", function (event) {
            if (!validateRecoverPasswordData()) {
                event.preventDefault();
            }
        }, false);
    }
    //InsertArticle
    var insertNewArticleForm = document.getElementById("write-article-form");
    if (insertNewArticleForm != null) {
        InsertArticle_CreateErrorBox_InsertArticle();
        insertNewArticleForm.addEventListener("submit", function (event) {
            if (!validateInsertNewArticleData()) {
                event.preventDefault();
            }
        }, false);
    }
    //AddAdmin
    var addAdminForm = document.getElementById("add-admin-form");
    if (addAdminForm != null) {
        AddAdmin_CreateErrorBox();
        addAdminForm.addEventListener("submit", function (event) {
            if (!validateAddAdminData()) {
                event.preventDefault();
            }
        }, false);
    }
    //BanUser
    var banUserForm = document.getElementById("ban-user-form");
    if (banUserForm != null) {
        BanUser_CreateErrorBox();
        banUserForm.addEventListener("submit", function (event) {
            if (!validateBanUserData()) {
                event.preventDefault();
            }
        }, false);
    }
    //Funzioni di inizializzazione
    //Sidebar
    sidebarExpandButtons();
    manageResize()
});


/* nav-bar menu collapse */
document.addEventListener("DOMContentLoaded", function () {
    //The first argument are the elements to which the plugin shall be initialized
    //The second argument has to be at least a empty object or a object with your desired options
    var sidebar = document.getElementById("sidebar-wrapper");
    if (sidebar != null) {
        OverlayScrollbars(sidebar, {});
    }
});
