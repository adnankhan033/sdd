var swiper = new Swiper('.heroswiper', {
    spaceBetween: 20,

    breakpoints: {
        640: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 4,
        },
    },
});

var swiper = new Swiper('.Initiatives-swiper', {
    slidesPerView: 1.1,
    spaceBetween: 54,
    speed: 300,
});

const stickySection = document.getElementById("sticky-section");
const firstSection = document.querySelector(".first-section");
const footer = document.querySelector("footer");

window.addEventListener("scroll", () => {
    const scrollPosition = window.scrollY || window.pageYOffset;
    const windowHeight = window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight;
    const footerHeight = footer.offsetHeight;

    const passedFirstSection = scrollPosition >= firstSection.offsetHeight;

    const reachedBottom = (windowHeight + scrollPosition) >= (documentHeight - footerHeight);

    if (passedFirstSection && !reachedBottom) {
        stickySection.classList.add("sticky-bottom");
    } else {
        stickySection.classList.remove("sticky-bottom");
    }
});


document.querySelector('.hamburger-toggle')?.addEventListener('click', function (e) {
    document.documentElement.classList.toggle('menu-opened');
});
document.querySelector('.close-menu ')?.addEventListener('click', function (e) {
    document.documentElement.classList.toggle('menu-opened');
});


$(document).on('click', '.dropdown-item', function (e) {
    if (window.innerWidth < 1024) {
        e.preventDefault();
        e.stopPropagation();
        $(this).find('.dropdown-menu').addClass('show');
    }
});

$(document).on('click', '.back-menu', function (e) {
    if (window.innerWidth < 1024) {
        e.preventDefault();
        e.stopPropagation();
        $(this).closest('.dropdown-menu').removeClass('show');
    }
});

$(document).on('click', '.close-menu', function (e) {
    if (window.innerWidth < 1024) {
        e.preventDefault();
        e.stopPropagation();
        $('html').removeClass('menu-opened');
        $('.dropdown-menu').removeClass('show');
    }
});

$(document).on('click', '.footer-menu', function (e) {
    if (window.innerWidth < 639) {
        e.preventDefault();
        e.stopPropagation();

        const submenu = $(this).find('ul');
        const isVisible = !submenu.hasClass('hidden');

         $('.footer-menu ul').addClass('hidden').removeClass('grid');
        $('.footer-menu').removeClass('open');

        if (!isVisible) {
             submenu.removeClass('hidden').addClass('grid');
            $(this).addClass('open');
        }
    }
});


