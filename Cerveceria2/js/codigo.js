const container = document.querySelector(".container");

const btnIn = document.getElementById("btn-sign-in");
const btnUp = document.getElementById("btn-sign-up");
window.addEventListener("DOMContentLoaded",()=>{
    console.log("empezamos");
    btnUp.addEventListener("click",()=>{
        container.classList.remove("toggle");
        console.log("11");
    });
    
    btnIn.addEventListener("click",()=>{
        container.classList.add("toggle");
        console.log("22");
    });
})
