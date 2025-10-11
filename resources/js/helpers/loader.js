const loader = document.querySelector('#loader');
const loaderText = document.querySelector('#loader-text');


const handleTransitionEnd = ()=>{
    loader.classList.add('hidden');
    loaderText.textContent = '';
    loader.removeEventListener('transitionend', handleTransitionEnd); // Elimina el listener después de ejecutarse

}

const showLoader = (textLoading = 'Cargando') => {
    loaderText.textContent = textLoading;
    loader.classList.remove('hidden','opacity-0');
    loader.classList.add('opacity-100', 'transition-opacity', 'duration-1000');

}

const hideLoader = () => {
    
    loader.classList.remove('opacity-100');
    loader.classList.add('opacity-0', 'transition-opacity', 'duration-1000');

    setTimeout(()=>{
        loader.classList.add('hidden');
    },1000);

    // Opcional: Después de la animación, oculta completamente
// loader.addEventListener(
    //     'transitionend',
    //     () => {
    //         loader.classList.add('hidden');
    //         loaderText.textContent = '';
    //     },
    //     { once: true } // Asegura que el listener se ejecute solo una vez
    // );
}

export { showLoader, hideLoader };