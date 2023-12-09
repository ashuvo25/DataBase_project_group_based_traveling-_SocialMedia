
const parentContainer = document.querySelector('.right_sidebar');
parentContainer.addEventListener('click', event => {
    const current = event.target;

    const isMorebtn = current.classList.contains('more');

    if (!isMorebtn) {
        return;
    }

    const options = event.target.parentNode.querySelector('.more-options');
    options.classList.toggle('more-options--show');

    current.textContent = current.textContent.includes('See More') ? "See Less..." : "See more...";
});


