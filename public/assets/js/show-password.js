const showpassword = document.querySelector("#showPassword");
const password = document.querySelector("#password");

showpassword.addEventListener("click", function () {
    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    if(type === "password") {
        this.classList.remove("fe-eye");
        this.classList.add("fe-eye-off");
    } else {
        this.classList.remove("fe-eye-off");
        this.classList.add("fe-eye");
    }
});
