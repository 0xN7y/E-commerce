document.addEventListener('DOMContentLoaded', function() {
    initHeader();
    // initCarousels();
    // initProductGrid();
    initTestimonials();
    // initCart();
    // initNotifications();
    
    // Set current time in notch
    updateNotchTime();
    setInterval(updateNotchTime, 60000);
});



const searchBtn   = document.querySelector('.search-btn');
const searchBar   = document.getElementById('searchBar');
const searchClose = document.getElementById('searchClose');
const input       = searchBar.querySelector('input');

searchBtn.addEventListener('click', () => {
    searchBar.classList.add('active');
    input.focus();
});

searchClose.addEventListener('click', () => {
    searchBar.classList.remove('active');
    input.value = '';
});



function initHeader() {
    const searchBtn = document.getElementById('searchBtn');
    const searchBar = document.getElementById('searchBar');
    const searchClose = document.getElementById('searchClose');
    const cartBtn = document.getElementById('cartBtn');
    const cartDrawer = document.getElementById('cartDrawer');
    const cartOverlay = document.getElementById('cartOverlay');
    const cartClose = document.getElementById('cartClose');
    const header = document.getElementById('header');


    if (searchBtn && searchBar) {
        searchBtn.addEventListener('click', () => {
            searchBar.classList.add('active');
            setTimeout(() => {
                searchBar.querySelector('input').focus();
            }, 300);
        });

        if (searchClose) {
            searchClose.addEventListener('click', () => {
                searchBar.classList.remove('active');
            });
        }
    }

  
}



function updateNotchTime() {
    const notchTime = document.querySelector('.notch-time');
    if (notchTime) {
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        notchTime.textContent = timeString;
    }
}


function initTestimonials() {
    const testimonials = document.querySelectorAll('.testimonial');
    const dots = document.querySelectorAll('.dot');
    let currentTestimonial = 0;
    
    if (testimonials.length > 0 && dots.length > 0) {
        // Auto-rotate testimonials
        setInterval(() => {
            testimonials[currentTestimonial].classList.remove('active');
            dots[currentTestimonial].classList.remove('active');
            
            currentTestimonial = (currentTestimonial + 1) % testimonials.length;
            
            testimonials[currentTestimonial].classList.add('active');
            dots[currentTestimonial].classList.add('active');
        }, 5000);
        
        // Dot navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                testimonials[currentTestimonial].classList.remove('active');
                dots[currentTestimonial].classList.remove('active');
                
                currentTestimonial = index;
                
                testimonials[currentTestimonial].classList.add('active');
                dots[currentTestimonial].classList.add('active');
            });
        });
    }
}

function showNotification(message) {
  const toast = document.getElementById('notificationToast');
  const msgSpan = toast.querySelector('.toast-message');

  msgSpan.textContent = message;
  toast.style.display = 'block';   // show

  setTimeout(() => {
    toast.style.display = 'none';  // hide again
  }, 3000);
}


document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.querySelector('.newsletter-form');

      if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
          console.log("okkkkkkkkkk");
          e.preventDefault();
          const emailInput = this.querySelector('input[type="email"]');

          if (emailInput.value) {
            alert('Thank you for subscribing!')
            showNotification('Thank you for subscribing!');
            emailInput.value = '';
          }
        });
      }
    

    // const newsletterForm = document.querySelector('.newsletter-form');
    
    // if (newsletterForm) {
    //     newsletterForm.addEventListener('submit', function(e) {
    //         console.log("okkkkkkkkkk");
    //         e.preventDefault();
    //         const emailInput = this.querySelector('input[type="email"]');
            
    //         if (emailInput.value) {
    //             showNotification('Thank you for subscribing!');
    //             emailInput.value = '';
    //         }
    //     });
    // }
});
