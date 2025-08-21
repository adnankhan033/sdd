if (document.querySelector('.heroswiper')) {
  var swiper = new Swiper('.heroswiper', {
    spaceBetween: 20,
    speed: 2000,
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
      },
      1280: {
        slidesPerView: 4,
      },
    },
  });
}



if (document.querySelector('.Initiatives-swiper')) {
  var swiper = new Swiper('.Initiatives-swiper', {
    slidesPerView: 1.1,
    spaceBetween: 20,
    speed: 1500,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    
    breakpoints: {
      768: {
        spaceBetween: 54,
      },
    },
  });
}
if (document.querySelector('.swiperlogos')) {


  var swiper = new Swiper(".swiperlogos", {
    spaceBetween: 20,
    breakpoints: {
      768: {
        slidesPerView: 2.5,
      },
      1024: {
        slidesPerView: 3,
      },
      1280: {
        slidesPerView: 5,
      },
    },

  pagination: {
    el: ".swiper-pagination",
    type: "progressbar",
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

}
if (document.querySelector('.aboutswiper')) {
  var swiper = new Swiper('.aboutswiper', {
    spaceBetween: 20,
    speed: 1500,
    slidesPerView: 1,

    breakpoints: {
      768: {
        slidesPerView: 1.5,
      },
      1024: {
        slidesPerView: 2.1,
      },
      1280: {
        slidesPerView: 2.5,
      },
    },
  });
}
if (document.querySelector('.news-details')) {

  var swiper = new Swiper(".news-details", {
  spaceBetween: 16,
  speed: 1500,
  slidesPerView: 1,
  breakpoints: {
    768: {
      slidesPerView: 2,
    },
   
  },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

  pagination: {
    el: ".swiper-pagination",
    type: "fraction",

  },
});

}


if (document.querySelector('.journeyswiper')) {

  var swiper = new Swiper(".journeyswiper", {
    spaceBetween: 16,
    speed: 1500,
    slidesPerView: 1,
    breakpoints: {
      768: {
        slidesPerView: 7,
      },

    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    pagination: {
      el: ".swiper-pagination",
      type: "fraction",

    },
  });

}



const stickySection = document.getElementById('sticky-section');
const firstSection = document.querySelector('.first-section');
const footer = document.querySelector('footer');

window.addEventListener('scroll', () => {
  const scrollPosition = window.scrollY || window.pageYOffset;
  const windowHeight = window.innerHeight;
  const documentHeight = document.documentElement.scrollHeight;
  const footerHeight = footer.offsetHeight;

  const passedFirstSection = scrollPosition >= firstSection.offsetHeight;

  const reachedBottom = windowHeight + scrollPosition >= documentHeight - footerHeight;

  if (passedFirstSection && !reachedBottom) {
    stickySection.classList.add('sticky-bottom');
  } else {
    stickySection.classList.remove('sticky-bottom');
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

const menuToggle = document.getElementById('menuToggle');
const menuItems = document.getElementById('menuItems');
const menuIcon = document.getElementById('menuIcon');
const overlay = document.getElementById('overlay');

menuToggle?.addEventListener('click', () => {
  menuItems.classList.toggle('opacity-0');
  menuItems.classList.toggle('translate-y-10');
  menuItems.classList.toggle('pointer-events-none');

  overlay.classList.toggle('opacity-0');
  overlay.classList.toggle('pointer-events-none');

  if (menuItems.classList.contains('opacity-0')) {
    menuToggle.classList.remove('active');
    menuIcon.textContent = '⋯';
    menuItems.classList.remove('flex');
    menuItems.classList.add('hidden');
  } else {
    menuToggle.classList.add('active');
    menuIcon.textContent = '✕';

    menuItems.classList.add('flex');
    menuItems.classList.remove('hidden');
  }
});

const containers = document.querySelectorAll('.lottie-container');

const groups = [
  [0, 3],
  [1, 2],
];

if (containers.length > 0) {
  playGroup();
}

function playGroup(index = 0) {
  if (index >= groups.length) index = 0;

  const currentGroup = groups[index];
  let completedCount = 0;

  currentGroup.forEach((i) => {
    containers[i].innerHTML = '';

    const animation = lottie.loadAnimation({
      container: containers[i],
      renderer: 'svg',
      loop: false,
      autoplay: true,
      path: '/themes/custom/theme_sdd/assets/video/lotti.json',
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

document.querySelectorAll('.faq-btn').forEach((btn) => {
  btn.addEventListener('click', () => {
    const content = btn.nextElementSibling;
    const icon = btn.querySelector('.faq-icon');
    const title = btn.querySelector('.faq-title');

    document.querySelectorAll('.faq-content').forEach((c) => {
      if (c !== content) {
        c.classList.add('hidden');
        const otherBtn = c.previousElementSibling;
        if (otherBtn.querySelector('.faq-icon')) {
          otherBtn.querySelector('.faq-icon').textContent = '+';
          otherBtn.querySelector('.faq-icon').classList.remove('text-orange');
          otherBtn.querySelector('.faq-title').classList.remove('text-orange');
        }
      }
    });

    content.classList.toggle('hidden');

    if (content.classList.contains('hidden')) {
      icon.textContent = '+';
      icon.classList.remove('text-orange');
      title.classList.remove('text-orange');
    } else {
      icon.textContent = '−';
      icon.classList.add('text-orange');
      title.classList.add('text-orange');
    }
  });
});

$(document).ready(function () {
  $('[data-filter]').click(function () {
    const filter = $(this).data('filter');

    $('[data-filter]').removeClass('active');

    $(this).addClass('active');

    if (filter === 'all') {
      $('[data-content]').fadeIn();
    } else {
      $('[data-content]').each(function () {
        if ($(this).data('content') === filter) {
          $(this).fadeIn();
        } else {
          $(this).fadeOut();
        }
      });
    }
  });
});

$(document).on('click', '.show_search', function () {
  $('.search-block').slideDown();
  $(this).addClass('active');
});

$(document).on('click', '.search-block .close_search', function () {
  $('.search-block').slideUp();
  $('.show_search').removeClass('active');
});
document.getElementById('categorySelect')?.addEventListener('change', function () {
  let value = this.value;
  document.querySelector(`[data-filter="${value}"]`)?.click();
});


$(document).on('click', '.chnage-layout', function () {

  let data= $(this).data('layout');
  $('.chnage-layout ').removeClass('active');
  $(this).addClass('active'); 

  $('.section-layout').removeClass('list grid');
  $('.section-layout').addClass(data);
 



});


document.querySelectorAll('.video').forEach(wrapper => {
  const video = wrapper.querySelector('video');
  const overlay = wrapper.querySelector('.videoOverlay');

 
  video.controls = false;

  overlay?.addEventListener('click', () => {
    video.controls = true;
    video.play();
    overlay.style.display = 'none';
  });

 
   video?.addEventListener('ended', () => {
    overlay.style.display = 'flex';
    video.controls = false;
  });
});




jQuery(document).on('input', '.gradient-text', function () {

  let value = $(this).val();
  if (value){
    $(this).removeClass('gradient-text');
  }
  
});