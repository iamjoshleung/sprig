import { LuminousGallery } from 'luminous-lightbox';

if( document.querySelector('.js-pages-movies-show') ) {
    window.addEventListener('load', _ => {
        new LuminousGallery(document.querySelectorAll(".preview-img"));
    })
}   