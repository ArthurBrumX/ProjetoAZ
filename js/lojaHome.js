const carouselContainer = document.querySelector(".carousel-container-loja");
const carouselControlsContainer = document.querySelector(".carousel-controls-loja");
const carouselControls = ["previous", "next"];
const carouselItems = document.querySelectorAll(".carousel-item");

window.onload = function () {
  document.getElementById("next").click();
  //console.log(next);
};

class Carousel {
  constructor(container, items, controls) {
    this.carouselContainer = container;
    this.carouselControls = controls;
    this.carouselArray = [...items];
  }

  updateCarousel() {
    this.carouselArray.forEach((element) => {
      element.classList.remove("carousel-item-1");
      element.classList.remove("carousel-item-2");
      element.classList.remove("carousel-item-3");
      element.classList.remove("carousel-item-4");
      element.classList.remove("carousel-item-5");
      element.classList.remove("carousel-item-6");
    });

    this.carouselArray.slice(0, 5).forEach((el, i) => {
      el.classList.add(`carousel-item-${i + 1}`);
    });
  }
  setCurrentState(direction) {
    if (direction === "carousel-controls-loja-previous") {
      this.carouselArray.unshift(this.carouselArray.pop());
    } else {
      this.carouselArray.push(this.carouselArray.shift());
    }
    this.updateCarousel();
  }
  setControls() {
    this.carouselControls.forEach((control) => {
      carouselControlsContainer.appendChild(
        document.createElement("button")
      ).className = `carousel-controls-loja-${control}`;
      document.querySelector(`.carousel-controls-loja-${control}`).innerHTML =
        control;
    });
  }

  useControls() {
    const triggers = [...carouselControlsContainer.childNodes];
    triggers.forEach((control) => {
      control.addEventListener("click", (e) => {
        e.preventDefault();
        this.setCurrentState(control.className);
      });
    });
  }
}
const exampleCarousel = new Carousel(
  carouselContainer,
  carouselItems,
  carouselControls
);

exampleCarousel.setControls();
exampleCarousel.useControls();
 