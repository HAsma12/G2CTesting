let slides = document.querySelectorAll(".slide");
let index = 0;

function showSlide(i) {
  slides.forEach((slide, idx) => {
    slide.classList.remove("active");
    if (idx === i) slide.classList.add("active");
  });
}

function nextSlide() {
  index = (index + 1) % slides.length;
  showSlide(index);
}

setInterval(nextSlide, 4000); // Change every 4 seconds
// Toggle navbar

const burger = document.getElementById('burger');
const navLinks = document.getElementById('nav-links');

burger.addEventListener('click', () => {
  navLinks.classList.toggle('show');
});


const phrases = [
  "Formez-vous avec des experts",
  "Boostez votre carrière",
  "Obtenez une certification reconnue",
  "Maîtrisez les compétences du futur"
];

let i = 0;        // phrase index
let j = 0;        // letter index
let currentPhrase = [];
let isDeleting = false;
let isEnd = false;

const typewriter = document.getElementById("typewriter");

function loop() {
  isEnd = false;
  typewriter.innerHTML = currentPhrase.join("");

  if (i < phrases.length) {
    if (!isDeleting && j <= phrases[i].length) {
      currentPhrase.push(phrases[i][j]);
      j++;
    }

    if (isDeleting && j > 0) {
      currentPhrase.pop();
      j--;
    }

    if (j === phrases[i].length) {
      isEnd = true;
      isDeleting = true;
    }

    if (isDeleting && j === 0) {
      currentPhrase = [];
      isDeleting = false;
      i++;
      if (i === phrases.length) {
        i = 0;
      }
    }
  }

  const speed = isEnd ? 2000 : isDeleting ? 50 : 100;
  setTimeout(loop, speed);
}


document.addEventListener('DOMContentLoaded', function() {
  const dropdownToggle = document.getElementById('dropdownToggle');
  const desktopDropdown = document.getElementById('desktopDropdown');

  if (!dropdownToggle || !desktopDropdown) return;

  function openDropdown() {
    // show so we can measure
    desktopDropdown.style.display = 'block';
    // wait next frame then position and animate
    requestAnimationFrame(() => {
      positionDropdown();
      desktopDropdown.classList.add('desktop-open');
      desktopDropdown.dataset.open = 'true';
    });
  }

  function closeDropdown() {
    desktopDropdown.classList.remove('desktop-open');
    desktopDropdown.dataset.open = 'false';
    // hide after animation
    setTimeout(() => {
      if (desktopDropdown.dataset.open !== 'true') desktopDropdown.style.display = 'none';
    }, 220);
  }

  function positionDropdown() {
    // mesure
    const btnRect = dropdownToggle.getBoundingClientRect();
    const ddRect = desktopDropdown.getBoundingClientRect();
    const vpWidth = document.documentElement.clientWidth;
    const margin = 8;

    // desired: center under button
    let desiredLeft = btnRect.left + btnRect.width / 2 - ddRect.width / 2;

    // clamp within viewport
    desiredLeft = Math.max(margin, Math.min(desiredLeft, vpWidth - ddRect.width - margin));

    // convert to offsetParent coordinates
    const parentRect = desktopDropdown.offsetParent.getBoundingClientRect();
    const leftRelativeToParent = desiredLeft - parentRect.left;

    desktopDropdown.style.left = leftRelativeToParent + 'px';
  }

  dropdownToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    if (desktopDropdown.dataset.open === 'true') closeDropdown();
    else openDropdown();
  });

  // close when click outside
  document.addEventListener('click', function(e) {
    if (desktopDropdown.dataset.open === 'true' &&
        !desktopDropdown.contains(e.target) &&
        !dropdownToggle.contains(e.target)) {
      closeDropdown();
    }
  });

  // reposition on resize (if open)
  window.addEventListener('resize', function() {
    if (desktopDropdown.dataset.open === 'true') {
      positionDropdown();
    }
  });
});





loop();
