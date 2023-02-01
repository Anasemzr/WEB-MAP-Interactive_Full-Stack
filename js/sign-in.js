const form = document.getElementById('form-account');
const formElems = document.querySelectorAll('.form-class, .sub-group-form-class');
const btnNextElem = document.querySelectorAll('.nextFormElem');
const btnBackElem = document.querySelectorAll('.backFormElem');
const headCards = document.querySelectorAll('.head-card');
const inputsText = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], .enseigne-select');
const pswrd = document.querySelectorAll('.input-password');
const showPswrd = document.querySelectorAll('i.password-show');
const counters = document.querySelectorAll('.form-class .counter');
const table = document.querySelector('.form-class .recap-table tbody');

// Request pseudo and email checker
const inputPseudo = document.getElementById("pseudoInput");
const inputEmail = document.getElementById("emailInput");

let currentElemDisplayed = 0;

// Display the precedent form element and hide the current one
function backFormElem(){
    formElems[currentElemDisplayed].style.display = "none";
    formElems[--currentElemDisplayed].style.display = "block";
    headCards[currentElemDisplayed].classList.add("current-card");
    headCards[currentElemDisplayed+1].classList.remove("current-card");
}

// Display the next for element and hide the current one
function goToNextElem(){
    document.querySelector('.error-pop-up').style.display = 'none';
    formElems[currentElemDisplayed].style.display = "none";
    formElems[++currentElemDisplayed].style.display = "block";
    headCards[currentElemDisplayed].classList.add("current-card");
    headCards[currentElemDisplayed-1].classList.remove("current-card");
}

// Init back and next buttons event listeners
for(let i = 0; i < btnBackElem.length ; i++) btnBackElem[i].addEventListener("click", function(){backFormElem();});
for(let i = 0; i < btnNextElem.length ; i++) btnNextElem[i].addEventListener("click", function(){nextFormElem();});

// Animation HeadCard
let timing = 300;
for(let i = 0; i < headCards.length ; i++){
    const headcard = headCards[i];
    timing+=100;
    headcard.animate({transform : ["translateY(+200px)","translateY(0px)"]}, timing);
}

// Check if password 1 equal password 2
function checkPswrd(){
    return pswrd[0].value == pswrd[1].value || currentElemDisplayed <= 1;
}

// Control validity of current form element and switch to the next one
function nextFormElem(){
    if (document.querySelector('.user-created-popup') != null) document.querySelector('.user-created-popup').style.display = 'none';
    pswrd[0].setAttribute("type","password");
    pswrd[1].setAttribute("type","password");
    const childs = formElems[currentElemDisplayed].childNodes;
    const input = childs[1];
    if(input.type=="email"){// Check Email Validity
        if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(input.value)){
            let url = "mailChecker.php?email="+inputEmail.value;
            fetch(url)
            .then(res =>{
                if (res.ok) return res.json();
                else console.log('not success');
            }).then(data => {
                if(data.emailAlreadyExist){
                    formElems[currentElemDisplayed].style.display = "block";
                    document.querySelector('.error-pop-up-mail').style.display = 'block';
                    document.querySelector('.error-pop-up-mail').textContent = 'Cet email est déja utilisé !';
                }
                else{
                    document.querySelector('.error-pop-up-mail').style.display = 'none';
                    goToNextElem();
                }
            })
            .catch(error => console.log(error));
        }
        else{
            formElems[currentElemDisplayed].style.display = "block";
            document.querySelector('.error-pop-up-mail').style.display = 'block';
            document.querySelector('.error-pop-up-mail').innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Cet email est n'est pas conforme !";
        }
    }
    else if (input.type=="password"){// Check Password Validity
        if(/^[a-zA-Z0-9]{3,14}$/.test(input.value)){
            if (currentElemDisplayed==2){
                goToNextElem();
            }
            else{
                if (checkPswrd()){
                    document.querySelector('.error-pop-up').style.display = "none";
                    table.innerHTML = "";
                    let fData = new FormData(form);
                    for (var pair of fData.entries()) {
                        if(pair[0]=='PASSWORD1' || pair[0]=='PASSWORD2') {}
                        else table.innerHTML = table.innerHTML +'<tr><td>'+pair[0]+'</td><td>'+pair[1]+'</td></tr>'
                    }
                    goToNextElem();
                }
                else{ // Display Error Text Password 1 and 2 not equal
                    formElems[currentElemDisplayed].style.display = "block";
                    document.querySelector('.error-pop-up-password-2').innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Ce mot de passe ne correspond pas à celui tapé précedement.";
                    document.querySelector('.error-pop-up-password-2').style.display = "block";
                }
            }
        }
        else{ //Display Error Text Rules Password
            formElems[currentElemDisplayed].style.display = "block";
            document.querySelector('.error-pop-up-password-1').innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Votre mot de passe doit faire entre 6 et 20 charactère ainsi que contenir au moins 1 majuscule, 1 chiffre et aucun espace.";
            document.querySelector('.error-pop-up-password-1').style.display = "block"; 
        }
    }
    else if (input.type=="text"){
        // Check no whitessace and null value
        if (/^$|\s+/.test(input.value)){
            document.querySelector('.error-pop-up-pseudo').style.display = 'block';
            document.querySelector('.error-pop-up-pseudo').innerHTML = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Veuillez rentrer un pseudo valide';
            formElems[currentElemDisplayed].style.display = "block";
        }
        else{
            if(currentElemDisplayed==0){
                let url = "pseudoChecker.php?pseudo="+inputPseudo.value;
                fetch(url)
                .then(res =>{
                    if (res.ok) return res.json();
                    else console.log('not success');
                }).then(data => {
                    if(data.pseudoAlreadyExist){
                        formElems[currentElemDisplayed].style.display = "block";
                        document.querySelector('.error-pop-up-pseudo').style.display = 'block';
                        document.querySelector('.error-pop-up-pseudo').innerHTML = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Ce pseudo est déja pris';
                    }
                    else{
                        document.querySelector('.error-pop-up-pseudo').style.display = 'none';
                        goToNextElem();
                    }
                })
                .catch(error => console.log(error));
            }
            else goToNextElem();
        }
    }
}

// Show Password btn event listener init
for(let i = 0; i < showPswrd.length ; i++){
    showPswrd[i].addEventListener("click", function(){
        pswrd[i].focus();
        if (showPswrd[i].classList.contains('fa-eye')){
            showPswrd[i].classList.replace('fa-eye','fa-eye-slash');
            pswrd[i].setAttribute("type","text");
        }
        else{
            showPswrd[i].classList.replace('fa-eye-slash','fa-eye');
            pswrd[i].setAttribute("type","password");
        }
    });
}

// Add event listener counter of input Text
for(let index = 0; index < inputsText.length - 1 ; index++){
    inputsText[index].addEventListener("input", function(event){
        counters[index].innerText = (inputsText[index].value.length ) +" / "+inputsText[index].maxLength;
    });
}