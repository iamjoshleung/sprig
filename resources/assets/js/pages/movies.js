import Masonry from "isotope-layout";

if (document.querySelector(".js-page-movies-index")) {
  window.addEventListener("load", () => {
    let msnry = new Masonry(".js-items", {
      itemSelector: ".card",
      percentPosition: true,
      masonry: {
        gutter: 8
      },
      stagger: 30
    });
  });
}
