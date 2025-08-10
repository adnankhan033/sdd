var swiper = new Swiper('.heroswiper', {
    spaceBetween: 20,
    speed: 3000,
    slidesPerView: 1.5,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    breakpoints: {

        768: {
            slidesPerView: 2.5,
        },
        1024: {
            slidesPerView: 3,
        }, 1280: {
            slidesPerView: 4,
        },
    },
});

var swiper = new Swiper('.Initiatives-swiper', {
    slidesPerView: 1.1,
    spaceBetween: 20,
    speed: 1000,
    // autoplay: {
    //     delay: 4000,
    //     disableOnInteraction: false,
    // },
    breakpoints: {

        768: {
            spaceBetween: 54,

        },

    },



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





const menuToggle = document.getElementById("menuToggle");
const menuItems = document.getElementById("menuItems");
const menuIcon = document.getElementById("menuIcon");
const overlay = document.getElementById("overlay");


menuToggle?.addEventListener("click", () => {
    menuItems.classList.toggle("opacity-0");
    menuItems.classList.toggle("translate-y-10");
    menuItems.classList.toggle("pointer-events-none");

    overlay.classList.toggle("opacity-0");
    overlay.classList.toggle("pointer-events-none");

    if (menuItems.classList.contains("opacity-0")) {
        menuToggle.classList.remove("active");
        menuIcon.textContent = "⋯";

    } else {
        menuToggle.classList.add("active");
        menuIcon.textContent = "✕";
        
    }
});

const containers = document.querySelectorAll('.lottie-container');
 
const groups = [
    [0, 3],  
    [1, 2]   
];

function playGroup(index = 0) {
    if (index >= groups.length) index = 0;  

    const currentGroup = groups[index];
    let completedCount = 0;

     currentGroup.forEach(i => {
         containers[i].innerHTML = '';

        const animation = lottie.loadAnimation({
            container: containers[i],
            renderer: 'svg',
            loop: false,
            autoplay: true,
            path: 'assets/video/lotti.json'
        });

        animation.addEventListener('complete', () => {
            animation.destroy();
            completedCount++;

             if (completedCount === currentGroup.length) {
                playGroup(index + 1);
            }
        });
    });
}

 
playGroup();
