const scrollButton = document.getElementById('scroll-top-button');
const homeSection = document.getElementById('home');

window.addEventListener('scroll', () => {
    if (!homeSection) {
        return;
    }

    const homeSectionBottom = homeSection.offsetTop + homeSection.offsetHeight;

    if (window.scrollY > homeSectionBottom && window.scrollY > 100) { // Affiche le bouton après avoir fait défiler de 100 pixels et en dehors de la section "home"
        scrollButton?.classList.remove('hidden');
    } else {
        scrollButton?.classList.add('hidden');
    }
});

scrollButton?.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
