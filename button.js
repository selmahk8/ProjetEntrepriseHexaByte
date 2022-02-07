let toggle = document.querySelector(".background")
let ball = document.querySelector(".ball")

let darkmode = false

toggle.addEventListener("click", function () {
    HandleDarkMode()
})

function HandleDarkMode() {
    if (darkmode) {
        ball.classList.remove("activated")
        document.body.style.backgroundColor = "white"
        darkmode = false
    } else {
        ball.classList.add("activated")
        document.body.style.backgroundColor = "black"
        darkmode = true
    }
}
