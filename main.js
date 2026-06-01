// js/main.js

document.addEventListener("DOMContentLoaded", function () {
  // ============================================================
  // NAVBAR: sticky scroll + mobile toggle
  // ============================================================
  const navbar = document.getElementById("navbar");
  const navToggle = document.getElementById("navToggle");
  const navMenu = document.getElementById("navMenu");

  if (navbar) {
    window.addEventListener("scroll", function () {
      if (window.scrollY > 40) {
        navbar.classList.add("scrolled");
      } else {
        navbar.classList.remove("scrolled");
      }
    });
  }

  if (navToggle && navMenu) {
    navToggle.addEventListener("click", function () {
      navToggle.classList.toggle("active");
      navMenu.classList.toggle("open");
    });

    // Tutup menu saat link diklik
    navMenu.querySelectorAll(".nav-link").forEach(function (link) {
      link.addEventListener("click", function () {
        navToggle.classList.remove("active");
        navMenu.classList.remove("open");
      });
    });
  }

  // ============================================================
  // ADMIN SIDEBAR TOGGLE (mobile)
  // ============================================================
  const sidebarToggle = document.getElementById("sidebarToggle");
  const adminSidebar = document.getElementById("adminSidebar");

  if (sidebarToggle && adminSidebar) {
    sidebarToggle.addEventListener("click", function () {
      adminSidebar.classList.toggle("open");
    });
  }

  // ============================================================
  // FADE IN ON SCROLL
  // ============================================================
  const fadeEls = document.querySelectorAll(".fade-in");

  if (fadeEls.length > 0) {
    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: "0px 0px -40px 0px" },
    );

    fadeEls.forEach(function (el, idx) {
      el.style.transitionDelay = (idx % 4) * 0.08 + "s";
      observer.observe(el);
    });
  }

  // ============================================================
  // FILTER MAHASISWA
  // ============================================================
  const mhsFilterBtns = document.querySelectorAll("[data-filter]");
  const mhsGrid = document.getElementById("mahasiswaGrid");
  const noResult = document.getElementById("noResult");

  if (mhsGrid) {
    mhsFilterBtns.forEach(function (btn) {
      btn.addEventListener("click", function () {
        mhsFilterBtns.forEach(function (b) {
          b.classList.remove("active");
        });
        btn.classList.add("active");

        const filter = btn.getAttribute("data-filter");
        const cards = mhsGrid.querySelectorAll(".mahasiswa-card");
        let visible = 0;

        cards.forEach(function (card) {
          if (
            filter === "semua" ||
            card.getAttribute("data-kategori") === filter
          ) {
            card.style.display = "";
            visible++;
          } else {
            card.style.display = "none";
          }
        });

        if (noResult) {
          noResult.style.display = visible === 0 ? "block" : "none";
        }
      });
    });
  }

  // ============================================================
  // FILTER GALERI
  // ============================================================
  const galeriGrid = document.getElementById("galeriGrid");

  if (galeriGrid) {
    const galeriFilterBtns = document.querySelectorAll("[data-filter]");
    galeriFilterBtns.forEach(function (btn) {
      btn.addEventListener("click", function () {
        galeriFilterBtns.forEach(function (b) {
          b.classList.remove("active");
        });
        btn.classList.add("active");

        const filter = btn.getAttribute("data-filter");
        const items = galeriGrid.querySelectorAll(".galeri-item");

        items.forEach(function (item) {
          if (
            filter === "semua" ||
            item.getAttribute("data-kategori") === filter
          ) {
            item.style.display = "";
          } else {
            item.style.display = "none";
          }
        });
      });
    });
  }

  // ============================================================
  // VALIDASI FORM KONTAK
  // ============================================================
  const kontakForm = document.getElementById("kontakForm");
  if (kontakForm) {
    kontakForm.addEventListener("submit", function (e) {
      const nama = kontakForm.querySelector('[name="nama"]');
      const email = kontakForm.querySelector('[name="email"]');
      const pesan = kontakForm.querySelector('[name="pesan"]');

      let valid = true;

      [nama, email, pesan].forEach(function (el) {
        el.style.borderColor = "";
      });

      if (!nama.value.trim()) {
        nama.style.borderColor = "#ef4444";
        valid = false;
      }
      if (!email.value.trim() || !email.value.includes("@")) {
        email.style.borderColor = "#ef4444";
        valid = false;
      }
      if (!pesan.value.trim()) {
        pesan.style.borderColor = "#ef4444";
        valid = false;
      }

      if (!valid) {
        e.preventDefault();
        const firstInvalid = kontakForm.querySelector(
          '[style*="border-color: rgb(239"]',
        );
        if (firstInvalid) firstInvalid.focus();
      }
    });
  }
});

// ============================================================
// LIGHTBOX (galeri)
// ============================================================
function openLightbox(title, category) {
  const lb = document.getElementById("lightbox");
  if (!lb) return;
  document.getElementById("lightboxTitle").textContent = title;
  document.getElementById("lightboxCategory").textContent = category;
  lb.classList.add("open");
  document.body.style.overflow = "hidden";
}

function closeLightbox() {
  const lb = document.getElementById("lightbox");
  if (!lb) return;
  lb.classList.remove("open");
  document.body.style.overflow = "";
}

document.addEventListener("keydown", function (e) {
  if (e.key === "Escape") closeLightbox();
});
