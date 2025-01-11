const menuBtn = document.querySelector(".menu-btn");
const navigation = document.querySelector(".navigation");

menuBtn.addEventListener("click", () => {
    menuBtn.classList.toggle("active");
    navigation.classList.toggle("active");
});

const btns = document.querySelectorAll(".nav-btn");
const slides = document.querySelectorAll(".img-slide");
const contents = document.querySelectorAll(".content");

let currentIndex = 0;

// Fungsi untuk mengatur slide dan konten yang aktif
const sliderNav = function(index) {
    // Menghapus kelas "active" dari semua elemen
    btns.forEach((btn) => {
        btn.classList.remove("active");
    });

    slides.forEach((slide) => {
        slide.classList.remove("active");
    });

    contents.forEach((content) => {
        content.classList.remove("active");
    });

    // Menambahkan kelas "active" pada elemen yang sesuai
    btns[index].classList.add("active");
    slides[index].classList.add("active");
    contents[index].classList.add("active");
};

// Menambahkan event listener pada setiap tombol navigasi
btns.forEach((btn, i) => {
    btn.addEventListener("click", () => {
        sliderNav(i);
        currentIndex = i; // Update indeks saat tombol di-klik
        resetAutoSlide(); // Restart interval otomatis ketika tombol diklik
    });
});

// Fungsi untuk berpindah ke slide berikutnya secara otomatis
const autoSlide = () => {
    currentIndex++;
    if (currentIndex >= btns.length) {
        currentIndex = 0;
    }
    sliderNav(currentIndex);
};

// Set interval untuk mengubah slide setiap 3 detik
let slideInterval = setInterval(autoSlide, 3000);

// Fungsi untuk mereset interval otomatis
const resetAutoSlide = () => {
    clearInterval(slideInterval);
    slideInterval = setInterval(autoSlide, 3000);
};

// Memastikan slider pertama aktif saat halaman dimuat
sliderNav(currentIndex);
