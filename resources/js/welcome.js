// Menangani menu mobile
const menuBtn = document.getElementById("menuBtn");
const mobileMenu = document.getElementById("mobileMenu");

menuBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
});

// Mengubah slide secara otomatis pada carousel
const carouselInner = document.getElementById("carousel-inner");
let currentSlide = 0;

function changeSlide() {
    const slides = carouselInner.querySelectorAll("img");
    const totalSlides = slides.length;

    currentSlide = (currentSlide + 1) % totalSlides; // Menentukan slide berikutnya
    const offset = -currentSlide * 500; // Pindahkan ke slide yang sesuai (500px adalah lebar gambar)
    carouselInner.style.transform = `translateX(${offset}px)`; // Menggeser gambar
}

// Menjalankan fungsi changeSlide setiap 3 detik (3000ms)
setInterval(changeSlide, 3000);
