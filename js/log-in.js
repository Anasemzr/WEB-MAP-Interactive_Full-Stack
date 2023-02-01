const showPswrd = document.querySelector('i.password-show');
const pswrdInput = document.getElementById('passwordInput');

// Event listener qui affiche et cache le mot de passe
showPswrd.addEventListener("click", function(){
    pswrdInput.focus();
    if (showPswrd.classList.contains('fa-eye')){
        showPswrd.classList.replace('fa-eye','fa-eye-slash');
        pswrdInput.setAttribute("type","text");
    }
    else{
        showPswrd.classList.replace('fa-eye-slash','fa-eye');
        pswrdInput.setAttribute("type","password");
    }
});
