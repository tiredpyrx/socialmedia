document.querySelectorAll("form[action*='post']").forEach(form => {
    if (form.getAttribute("action").endsWith("destroy")) {
        form.addEventListener("click", confirmPostDelete)
    } 
})

function confirmPostDelete() {

}