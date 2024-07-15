// Navbar icon
let menuIcon = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');

menuIcon.onclick = () => {
  menuIcon.classList.toggle('bx-x');
  navbar.classList.toggle('active');
};

let sections = document.querySelectorAll('section');
let navLinks = document.querySelectorAll('header nav a');

window.onscroll = () => {
  sections.forEach(sec => {
    let top = window.scrollY;
    let offset = sec.offsetTop - 150;
    let height = sec.offsetHeight;
    let id = sec.getAttribute('id');

    if (top >= offset && top < offset + height) {
      navLinks.forEach(link => {
        link.classList.remove('active');
        document.querySelector('header nav a[href*="' + id + '"]').classList.add('active');
      });
    };
  });

  // Sticky navbar
  let header = document.querySelector('header');
  header.classList.toggle('sticky', window.scrollY > 100);
  
  // Remove navbar
  menuIcon.classList.remove('bx-x');
  navbar.classList.remove('active');
};

// Scroll animate
ScrollReveal({
  reset: true,
  distance: '80px',
  duration: 2000,
  delay: 200
});

ScrollReveal().reveal('.home-content, .heading', { origin: 'top'});
ScrollReveal().reveal('.home-img, .services-container, .projects-box, .contact-info, .skills-content, .circular-skills', { origin: 'bottom'});
ScrollReveal().reveal('.home-content h1, .about-img', { origin: 'top'});
ScrollReveal().reveal('.home-content p, .about-content', { origin: 'top'});

// Circular skills animation
document.addEventListener("DOMContentLoaded", function() {
  const circles = document.querySelectorAll('.circle');

  circles.forEach(circle => {
    let percentage = circle.dataset.percent;
    let circleInner = circle.querySelector('.circle-inner');
    let percentElement = circle.querySelector('.percent');

    // Calculate angle to fill the circle based on percentage
    let angle = (percentage / 100) * 360;
    circleInner.style.background = `conic-gradient(var(--main-color) 0deg, var(--main-color) ${angle}deg, #cadcff ${angle}deg 360deg)`;

    // Animation for the percentage count
    let count = 0;
    let animationDuration = 2000; // Animation duration in milliseconds
    let increment = percentage > 0 ? Math.ceil(percentage / (animationDuration / 10)) : 0; // Calculate increment per animation frame

    let interval = setInterval(() => {
      if (count <= percentage) {
        percentElement.textContent = `${count}%`;
        count += increment;
      } else {
        percentElement.textContent = `${percentage}%`; // Ensure exact percentage display
        clearInterval(interval);
      }
    }, 10); // Adjust animation speed here (milliseconds per frame)
  });
});

// Typed.js animations
const typed = new Typed('.multiple-text', {
  strings: ['FrontEnd Developer', 'Mobile Developer', 'Designer'],
  typeSpeed: 50,
  backSpeed: 70,
  backDelay: 1000,
  loop: true
});

const typedd = new Typed('.multiple-text-about', {
  strings: ['FrontEnd Developer', 'Mobile Developer', 'Designer'],
  typeSpeed: 50,
  backSpeed: 70,
  backDelay: 1000,
  loop: true
});


