function openTrajet(x) {
    let contents = document.querySelectorAll(".tab-content");
    let btns = document.getElementsByName("btnTrajet"); 
    for (let i = 0; i < contents.length; i++) {
        contents[i].style.display = "none";
        btns[i].classList.remove("btn");
        btns[i].classList.remove("btn-primary");
        btns[i].classList.remove("btn");
        btns[i].classList.remove("btn-outline-primary");
    }
    contents[x].style.display = "block";
    console.log(btns);
    btns[x].classList.add("btn");
    btns[x].classList.add("btn-primary");
    if (x==0) {
        btns[1].classList.add("btn");
        btns[1].classList.add("btn-outline-primary"); 
    }
    else{
        btns[0].classList.add("btn");
        btns[0].classList.add("btn-outline-primary"); 
    }
}

