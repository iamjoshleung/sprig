import Masonry from "isotope-layout";

if( document.querySelector('.js-page-movies-index') ) {
    window.addEventListener('load', () => {
        let msnry = new Masonry('.l-movies__items', {
          itemSelector: ".card",
          percentPosition: true,
          masonry: {
              gutter: 8,
          }
        });
      });
}