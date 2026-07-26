/* ==========================================================================
   BS-Gartenpflege Reutlingen — Interaktionen
   Sticky-Header, Mobile-Menü, Count-up, Tabs, Slider, Reveal, Formular
   ========================================================================== */

(function () {
  "use strict";

  var prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---------- Sticky Header mit Blur ab 40px ---------- */
  var header = document.querySelector(".site-header");
  if (header) {
    /* Unterseiten starten mit dunklem Page-Hero — dort braucht der
       Header immer den hellen Hintergrund, sonst ist die Navigation unlesbar. */
    var hasDarkHero = !!document.querySelector(".page-hero");
    var onScroll = function () {
      header.classList.toggle("scrolled", hasDarkHero || window.scrollY > 40);
    };
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();
  }

  /* ---------- Mobile-Menü (Fullscreen-Overlay) ---------- */
  var burger = document.querySelector(".burger");
  var mobileMenu = document.querySelector(".mobile-menu");
  var mobileClose = document.querySelector(".mobile-close");

  function setMenu(open) {
    if (!mobileMenu) return;
    mobileMenu.classList.toggle("open", open);
    document.body.style.overflow = open ? "hidden" : "";
    if (burger) burger.setAttribute("aria-expanded", open ? "true" : "false");
    if (open) {
      var firstLink = mobileMenu.querySelector("a, button");
      if (firstLink) firstLink.focus();
    } else if (burger) {
      burger.focus();
    }
  }

  if (burger && mobileMenu) {
    burger.addEventListener("click", function () { setMenu(true); });
    if (mobileClose) mobileClose.addEventListener("click", function () { setMenu(false); });
    mobileMenu.addEventListener("click", function (e) {
      if (e.target.tagName === "A") setMenu(false);
    });
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && mobileMenu.classList.contains("open")) setMenu(false);
    });
  }

  /* ---------- Gestaffelte Reveals in Karten-Gruppen ---------- */
  if (!prefersReducedMotion) {
    var staggerGroups = document.querySelectorAll(
      ".stats-grid, .services-grid, .blog-grid, .team-grid, .feature-list, .pricing-grid, .wwa-acc, .prec-col"
    );
    staggerGroups.forEach(function (group) {
      var items = group.querySelectorAll(".reveal");
      items.forEach(function (el, i) {
        el.style.transitionDelay = (i * 0.1).toFixed(2) + "s";
      });
    });
  }

  /* ---------- Scroll-Reveal ---------- */
  var revealEls = document.querySelectorAll(".reveal");
  if (revealEls.length) {
    if (prefersReducedMotion || !("IntersectionObserver" in window)) {
      revealEls.forEach(function (el) { el.classList.add("in-view"); });
    } else {
      var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("in-view");
            revealObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12 });
      revealEls.forEach(function (el) { revealObserver.observe(el); });
    }
  }

  /* ---------- Count-up-Zähler ---------- */
  function animateCount(el) {
    var target = parseFloat(el.dataset.count);
    var decimals = parseInt(el.dataset.decimals || "0", 10);
    var suffix = el.dataset.suffix || "";
    var duration = 1800;

    if (prefersReducedMotion) {
      el.textContent = target.toFixed(decimals).replace(".", ",") + suffix;
      return;
    }

    var start = null;
    function tick(ts) {
      if (!start) start = ts;
      var progress = Math.min((ts - start) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3); /* easeOutCubic */
      var value = target * eased;
      el.textContent = value.toFixed(decimals).replace(".", ",") + suffix;
      if (progress < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }

  var counters = document.querySelectorAll("[data-count]");
  if (counters.length) {
    if (!("IntersectionObserver" in window)) {
      counters.forEach(animateCount);
    } else {
      var countObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            animateCount(entry.target);
            countObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.4 });
      counters.forEach(function (el) { countObserver.observe(el); });
    }
  }

  /* ---------- Service-Tabs ---------- */
  var tablists = document.querySelectorAll("[role='tablist']");
  tablists.forEach(function (tablist) {
    var tabs = tablist.querySelectorAll("[role='tab']");

    function activate(tab) {
      tabs.forEach(function (t) {
        var selected = t === tab;
        t.setAttribute("aria-selected", selected ? "true" : "false");
        t.tabIndex = selected ? 0 : -1;
        var panel = document.getElementById(t.getAttribute("aria-controls"));
        if (panel) panel.hidden = !selected;
      });
      tab.focus();
    }

    tabs.forEach(function (tab, i) {
      tab.addEventListener("click", function () { activate(tab); });
      tab.addEventListener("keydown", function (e) {
        var dir = e.key === "ArrowRight" ? 1 : e.key === "ArrowLeft" ? -1 : 0;
        if (dir) {
          e.preventDefault();
          activate(tabs[(i + dir + tabs.length) % tabs.length]);
        }
      });
    });
  });

  /* ---------- Leistungs-Karussells ---------- */
  document.querySelectorAll("[data-carousel]").forEach(function (wrap) {
    var track = wrap.querySelector(".svc-track");
    var cards = track ? track.children : [];
    var prevBtn = wrap.querySelector("[data-car-prev]");
    var nextBtn = wrap.querySelector("[data-car-next]");
    var dotsWrap = wrap.querySelector(".svc-dots");
    if (!track || !cards.length) return;

    var dots = [];
    if (dotsWrap) {
      Array.prototype.forEach.call(cards, function (_, i) {
        var dot = document.createElement("button");
        dot.type = "button";
        dot.setAttribute("aria-label", "Leistung " + (i + 1) + " anzeigen");
        if (i === 0) dot.setAttribute("aria-current", "true");
        dot.addEventListener("click", function () {
          track.scrollTo({ left: i * step(), behavior: prefersReducedMotion ? "auto" : "smooth" });
        });
        dotsWrap.appendChild(dot);
        dots.push(dot);
      });
    }

    function step() {
      var gap = parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap) || 0;
      return cards[0].getBoundingClientRect().width + gap;
    }

    function scrollByCard(dir) {
      track.scrollBy({ left: dir * step(), behavior: prefersReducedMotion ? "auto" : "smooth" });
    }

    if (prevBtn) prevBtn.addEventListener("click", function () { scrollByCard(-1); });
    if (nextBtn) nextBtn.addEventListener("click", function () { scrollByCard(1); });

    var scrollTimer = null;
    track.addEventListener("scroll", function () {
      clearTimeout(scrollTimer);
      scrollTimer = setTimeout(function () {
        var idx = Math.round(track.scrollLeft / step());
        dots.forEach(function (d, i) {
          if (i === idx) d.setAttribute("aria-current", "true");
          else d.removeAttribute("aria-current");
        });
      }, 80);
    }, { passive: true });
  });

  /* ---------- Testimonial-Slider ---------- */
  var slider = document.querySelector(".slider");
  if (slider) {
    var slides = slider.querySelectorAll(".slide");
    var dotsWrap = slider.parentElement.querySelector(".slider-dots");
    var prevBtn = slider.parentElement.querySelector("[data-slide='prev']");
    var nextBtn = slider.parentElement.querySelector("[data-slide='next']");
    var current = 0;
    var autoTimer = null;

    var dots = [];
    if (dotsWrap) {
      slides.forEach(function (_, i) {
        var dot = document.createElement("button");
        dot.type = "button";
        dot.setAttribute("aria-label", "Bewertung " + (i + 1) + " anzeigen");
        dot.addEventListener("click", function () { goTo(i, true); });
        dotsWrap.appendChild(dot);
        dots.push(dot);
      });
    }

    function goTo(index, manual) {
      current = (index + slides.length) % slides.length;
      slides.forEach(function (s, i) {
        s.classList.toggle("active", i === current);
      });
      dots.forEach(function (d, i) {
        d.setAttribute("aria-current", i === current ? "true" : "false");
      });
      if (manual) restartAuto();
    }

    function restartAuto() {
      if (prefersReducedMotion) return;
      clearInterval(autoTimer);
      autoTimer = setInterval(function () { goTo(current + 1); }, 7000);
    }

    if (prevBtn) prevBtn.addEventListener("click", function () { goTo(current - 1, true); });
    if (nextBtn) nextBtn.addEventListener("click", function () { goTo(current + 1, true); });

    goTo(0);
    restartAuto();
  }

  /* ---------- Akkordeons weich auf-/zuklappen ---------- */
  document.querySelectorAll(".wwa-item, .faq-item").forEach(function (item) {
    var summary = item.querySelector("summary");
    var body = item.querySelector(".wwa-body, .faq-body");
    if (!summary || !body) return;

    /* Inhalt in einen inneren Wrapper packen: das Padding sitzt dann konstant
       auf .acc-inner, während wir außen NUR die Höhe animieren. So kollabiert
       der Body sauber auf 0 und beim Öffnen "wächst" kein Padding sichtbar mit. */
    var inner = body.querySelector(".acc-inner");
    if (!inner) {
      inner = document.createElement("div");
      inner.className = "acc-inner";
      while (body.firstChild) inner.appendChild(body.firstChild);
      body.appendChild(inner);
    }

    summary.addEventListener("click", function (e) {
      if (prefersReducedMotion) return; /* natives Verhalten beibehalten */
      e.preventDefault();
      if (item.dataset.animating) return;
      item.dataset.animating = "1";

      var wasOpen = item.open;
      if (!wasOpen) item.open = true;        /* Inhalt rendern, bevor gemessen wird */

      var fullH = inner.offsetHeight;        /* volle Höhe inkl. Padding des Wrappers */
      var startH = wasOpen ? fullH : 0;
      var endH   = wasOpen ? 0 : fullH;

      var finish = function (ev) {
        if (ev && ev.propertyName !== "height") return;
        clearTimeout(safety);
        body.removeEventListener("transitionend", finish);
        body.style.height = "";              /* zurück zu auto */
        if (wasOpen) item.open = false;      /* nach dem Zuklappen wirklich schließen */
        delete item.dataset.animating;
      };

      body.style.height = startH + "px";
      void body.offsetHeight;                /* Reflow -> Startwert festschreiben */
      body.addEventListener("transitionend", finish);
      var safety = setTimeout(finish, 600);  /* Fallback, falls transitionend ausbleibt */
      body.style.height = endH + "px";
    });
  });

  /* ---------- Kontaktformular-Validierung ---------- */
  var form = document.getElementById("contact-form");
  if (form) {
    var successBox = document.getElementById("form-success");

    function setError(fieldWrap, hasError) {
      fieldWrap.classList.toggle("error", hasError);
      var input = fieldWrap.querySelector("input, textarea, select");
      if (input) input.setAttribute("aria-invalid", hasError ? "true" : "false");
    }

    function validateField(fieldWrap) {
      var input = fieldWrap.querySelector("input, textarea, select");
      if (!input) return true;
      var value = input.value.trim();
      var valid = true;

      if (input.hasAttribute("required")) {
        if (input.type === "checkbox") {
          valid = input.checked;
        } else {
          valid = value.length > 0;
        }
      }
      if (valid && input.type === "email" && value) {
        valid = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(value);
      }
      if (valid && input.dataset.minlength && value) {
        valid = value.length >= parseInt(input.dataset.minlength, 10);
      }

      setError(fieldWrap, !valid);
      return valid;
    }

    form.querySelectorAll(".form-field").forEach(function (fieldWrap) {
      var input = fieldWrap.querySelector("input, textarea, select");
      if (!input) return;
      input.addEventListener("blur", function () { validateField(fieldWrap); });
      input.addEventListener("input", function () {
        if (fieldWrap.classList.contains("error")) validateField(fieldWrap);
      });
    });

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var allValid = true;
      var firstInvalid = null;

      form.querySelectorAll(".form-field").forEach(function (fieldWrap) {
        var ok = validateField(fieldWrap);
        if (!ok && !firstInvalid) firstInvalid = fieldWrap.querySelector("input, textarea, select");
        allValid = allValid && ok;
      });

      if (!allValid) {
        if (firstInvalid) firstInvalid.focus();
        return;
      }

      /* Kein Backend vorhanden — Anfrage wird lokal bestätigt.
         Später: hier fetch() an einen Form-Endpoint (z. B. eigenes PHP-Skript
         oder einen Dienst wie Formspree) einsetzen. */
      form.reset();
      if (successBox) {
        successBox.classList.add("visible");
        successBox.focus();
        setTimeout(function () { successBox.classList.remove("visible"); }, 9000);
      }
    });
  }

  /* ---------- Aktiven Menüpunkt markieren ---------- */
  var currentPage = location.pathname.split("/").pop() || "index.html";
  document.querySelectorAll(".main-nav a, .mobile-nav a").forEach(function (link) {
    if (link.getAttribute("href") === currentPage) {
      link.setAttribute("aria-current", "page");
    }
  });

  /* ---------- Aktuelles Jahr im Footer ---------- */
  document.querySelectorAll("[data-year]").forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });
})();
