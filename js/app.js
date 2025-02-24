"use strict"

const header = document.querySelector('header');

let isScrolled = false;

const scrollListener = window.addEventListener('scroll', () => {
  const currentScroll = window.scrollY;

  if(currentScroll > 0 && !isScrolled) {
    header.classList.add('scrolled');
    isScrolled = true;
  }
  if(currentScroll === 0) {
    header.classList.remove('scrolled');
    isScrolled = false;
  }
})