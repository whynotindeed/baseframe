document.addEventListener('DOMContentLoaded', function() {
  'use strict';

  // Mobile menu toggle
  var hamburger = document.getElementById('bf-hamburger');
  var nav = document.getElementById('bf-nav');
  if (hamburger && nav) {
    hamburger.addEventListener('click', function() {
      var open = nav.classList.toggle('is-open');
      hamburger.setAttribute('aria-expanded', open);
    });
    // Close on link click
    nav.querySelectorAll('.nav-item a').forEach(function(link) {
      link.addEventListener('click', function() {
        nav.classList.remove('is-open');
        hamburger.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // Close "More" dropdown on click outside
  document.addEventListener('click', function(e) {
    document.querySelectorAll('.mod-menu__toggle-sub').forEach(function(btn) {
      var parent = btn.closest('.nav-item');
      if (!parent || parent.contains(e.target)) return;
      var sub = parent.querySelector('.mod-menu__sub');
      if (sub && sub.getAttribute('aria-hidden') === 'false') {
        sub.setAttribute('aria-hidden', 'true');
        sub.classList.remove('show-menu');
        btn.setAttribute('aria-expanded', 'false');
      }
    });
  });

  // Back to top button
  var btt = document.getElementById('bf-back-to-top');
  if (btt) {
    window.addEventListener('scroll', function() {
      btt.classList.toggle('is-visible', window.scrollY > 400);
    });
    btt.addEventListener('click', function() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // Card block links — make entire card clickable
  document.querySelectorAll('.bf-card').forEach(function(card) {
    var link = card.querySelector('.bf-card-title a') || card.querySelector('.bf-card-readmore');
    if (!link) return;
    card.classList.add('bf-card-clickable');
    card.addEventListener('click', function(e) {
      if (e.target.closest('a')) return;
      link.click();
    });
  });
});
