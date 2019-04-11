window.onload = start;

function start() {
    const losen = document.querySelector("#losen");
    const ulosen = document.querySelector("#ulosen");

    /* Så fort användare skriver något i rutorna så... */
    losen.addEventListener("change", valideraLosen);
    ulosen.addEventListener("keyup", valideraLosen);

    function valideraLosen() {
        if (losen.value != ulosen.value) {
            ulosen.setCustomValidity("Inte samma lösenord!");
        } else {
            ulosen.setCustomValidity('');
        }
    }
}