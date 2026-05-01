document.addEventListener("DOMContentLoaded", function () {

    const hero = document.querySelector(".hero");

    const images = [
        "image/student.jpeg",
        "image/meet.jpeg",
        "image/man.jpeg",
    ];

    let currentIndex = 0;

    // Create slides dynamically
    images.forEach((image, index) => {
        const slide = document.createElement("div");
        slide.classList.add("hero-slide");
        slide.style.backgroundImage = `url('${image}')`;

        if (index === 0) {
            slide.classList.add("active");
        }

        hero.appendChild(slide);
    });

    const slides = document.querySelectorAll(".hero-slide");

    function changeSlide() {
        slides[currentIndex].classList.remove("active");

        currentIndex++;
        if (currentIndex >= slides.length) {
            currentIndex = 0;
        }

        slides[currentIndex].classList.add("active");
    }

    setInterval(changeSlide, 3000);

});