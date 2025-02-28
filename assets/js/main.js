// Configurações globais
const ANIMATION_CONFIG = {
  DEFAULT_DURATION: 1,
  SHORT_DURATION: 0.8,
  STAGGER_DELAY: 0.15,
  MOBILE_BREAKPOINT: 991,
  EASING: {
    DEFAULT: "power2.out",
    SOFT: "power3.out",
    FAST: "power1.inOut"
  }
};

// DOM
const DOM = {
  heroLogoLetters: document.querySelectorAll(".hero-logo .letter"),
  heroLogoVector: document.querySelectorAll(".hero-logo .logo-vector"),
  introP: document.querySelector(".intro-p"),
  heroImg: document.querySelector(".heroimg"),
  menuTextWrap: document.querySelector(".menu_text_wrap"),
  menuIconWrap: document.querySelector(".menu_icon_wrap"),
  fadeInElements: document.querySelectorAll(".fade-in"),
  nopaddingImg: document.querySelector(".nopaddingsec .heroimg"),
  introWrap: document.querySelector(".intro_wrap"),
  nav: document.querySelector(".nav"),
  close: document.querySelector(".close"),
  open: document.querySelector(".open")
};

// Utilitário pra não chamar um gazilhão de vezes o resize
const DEBOUNCE_DELAY = 200;
function debounce(fn, delay) {
  let timeout;
  return (...args) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => fn(...args), delay);
  };
}

const isMobileOrTablet = window.matchMedia(`(max-width: ${ANIMATION_CONFIG.MOBILE_BREAKPOINT}px)`).matches;

function isCSSVar(data) {
  return /^--[a-zA-Z][\w-]*$/.exec(data);
}

function convertCSSColorToHex(color) {
  const ctx = document.createElement("canvas").getContext("2d");
  ctx.fillStyle = color;
  return ctx.fillStyle;
}

function hexToRGB(hex) {
  hex = hex.replace(/^#/, "");
  const r = parseInt(hex.substring(0, 2), 16);
  const g = parseInt(hex.substring(2, 4), 16);
  const b = parseInt(hex.substring(4, 6), 16);
  return [r, g, b];
}

function addWillChange(elements, properties) {
  if (NodeList.prototype.isPrototypeOf(elements) || Array.isArray(elements)) {
    elements.forEach((element) => {
      element.style.willChange = properties;
    });
  } else if (elements instanceof HTMLElement) {
    elements.style.willChange = properties;
  }
}

function removeWillChange(elements) {
  if (NodeList.prototype.isPrototypeOf(elements) || Array.isArray(elements)) {
    elements.forEach((element) => {
      element.style.willChange = "";
    });
  } else if (elements instanceof HTMLElement) {
    elements.style.willChange = "";
  }
}

function initializeScrollTrigger(locoScroll) {
  gsap.registerPlugin(ScrollTrigger);

  locoScroll.on("scroll", ScrollTrigger.update);

  ScrollTrigger.scrollerProxy("#sccont", {
    scrollTop(value) {
      return arguments.length
        ? locoScroll.scrollTo(value, 0, 0)
        : locoScroll.scroll.instance.scroll.y;
    },
    getBoundingClientRect() {
      return {
        top: 0,
        left: 0,
        width: window.innerWidth,
        height: window.innerHeight,
      };
    },
    pinType: document.querySelector("#sccont").style.transform
      ? "transform"
      : "fixed",
  });

  ScrollTrigger.addEventListener("refresh", () => locoScroll.update());
  ScrollTrigger.refresh();
}

class AnimationCanvas {
  constructor(el, options = {}) {
    this.el = el;
    const colorData = getComputedStyle(document.documentElement)
      .getPropertyValue("--final-sections-bg")
      .trim();
    this.color = hexToRGB(convertCSSColorToHex(colorData));
    this.inverted = options.inverted || false;
    this.direction = options.direction || "up";
    this.needsRedraw = true;
  }

  init() {
    if (window.matchMedia("(prefers-reduced-motion)").matches) return;

    this.checkResizeBind = debounce(() => this.setup(), DEBOUNCE_DELAY);
    window.addEventListener("resize", this.checkResizeBind);

    this.setup();
    this.drawBind = this.draw.bind(this);
    gsap.ticker.add(this.drawBind);
  }

  setup() {
    this.compute();
    this.populate();
    this.animate();
  }

  compute() {
    this.ctx = this.el.getContext("2d");
    this.BCR = this.el.getBoundingClientRect();
    this.ctx.width = this.el.width = this.BCR.width;
    this.ctx.height = this.el.height = this.BCR.height;

    this.viewport = {
      width: window.innerWidth,
      height: window.innerHeight,
    };

    this.itemDimensions = {};
    this.ratio = 4 / 3;
    this.colsNb = 20;
    this.minItemWidth = 80;

    this.widthByNb = Math.ceil(this.ctx.width / this.colsNb);
    this.minWidth = Math.ceil(this.ctx.width / Math.floor(this.ctx.width / this.minItemWidth));
    this.itemDimensions.width = Math.max(this.widthByNb, this.minWidth);
    this.rowsNb = Math.floor(this.ctx.height / (this.itemDimensions.width * (1 / this.ratio)));
    this.itemDimensions.height = Math.ceil(this.ctx.height / this.rowsNb);
  }

  populate() {
    this.items = [];
    for (let y = 0; y < this.rowsNb; y++) {
      const items = [];
      for (let x = 0; x < this.colsNb; x++) {
        const item = { x, y, opacity: 0.0, id: y * this.colsNb + x };
        items.push(item);
      }
      this.items.push(items);
    }
  }

  animate() {
    this.tl?.kill?.();
    this.tl = gsap.timeline({});
    let count = 0;
    const duration = ANIMATION_CONFIG.DEFAULT_DURATION;
    const animateRow = (y) => {
      this.tl.to(
        gsap.utils.shuffle(this.items[y]),
        {
          opacity: 1,
          duration,
          stagger: duration / this.colsNb,
        },
        count * duration * 0.4
      );
      this.items[y] = this.items[y].sort((a, b) => a.id - b.id);
    };

    if (this.direction === "up") {
      for (let y = 0; y < this.rowsNb; y++) {
        animateRow(y);
        count++;
      }
    } else {
      for (let y = this.rowsNb - 1; y >= 0; y--) {
        animateRow(y);
        count++;
      }
    }

    this.tl.progress(0);
    this.tl.pause();
  }

  onScrollProgress(progress) {
    this.tl?.progress?.(this.inverted ? 1 - progress : progress);
    this.needsRedraw = true;
  }

  draw() {
    if (!this.needsRedraw) return;
    this.ctx.clearRect(0, 0, this.ctx.width, this.ctx.height);
    this.ctx.textAlign = "center";

    for (let y = 0; y < this.rowsNb; y++) {
      for (let x = 0; x < this.colsNb; x++) {
        const item = this.items[y][x];
        this.ctx.fillStyle = `rgba(${this.color.join(",")},${item.opacity})`;
        this.ctx.fillRect(
          this.itemDimensions.width * x,
          this.itemDimensions.height * y,
          this.itemDimensions.width,
          this.itemDimensions.height
        );
      }
    }
    this.needsRedraw = false;
  }

  destroy() {
    window.removeEventListener("resize", this.checkResizeBind);
    gsap.ticker.remove(this.drawBind);
  }
}

class IntroAnimation {
  constructor() {
    this.heroLogoLetters = DOM.heroLogoLetters;
    this.heroLogoVector = DOM.heroLogoVector;
    this.introP = DOM.introP;
    this.lines = new SplitType(this.introP, { types: "lines" }).lines;
    this.heroImg = DOM.heroImg;
    this.language = DOM.menuTextWrap;
    this.menu = DOM.menuIconWrap;
  }

  setInitialStates() {
    gsap.set(this.language, { y: "100%" });
    addWillChange(this.language, "opacity, transform");

    gsap.set([this.heroLogoVector, this.menu], { opacity: 0 });
    gsap.set([this.heroLogoVector, this.heroImg], { clipPath: "inset(100% 0 0 0)" });
    gsap.set([this.lines, this.heroLogoLetters], { y: "0%", opacity: 1 });

    this.lines.forEach((line, index) => {
      const parentLine = document.createElement("div");
      parentLine.classList.add("parent-line");
      line.parentNode.insertBefore(parentLine, line);
      parentLine.appendChild(line);
      if (index === this.lines.length - 1) parentLine.classList.add("last-line");
    });
  }

  animateIntro(introWrap, remainingTime) {
    CustomEase.create("outCircle", "M0,0 C0.075,0.82 0.165,1 1,1");
    const isTabletOrBelow = window.matchMedia(`(max-width: ${ANIMATION_CONFIG.MOBILE_BREAKPOINT}px)`).matches;

    const manualOrder = [
      this.heroLogoLetters[3], // B
      this.heroLogoLetters[4], // A
      this.heroLogoLetters[2], // N
      this.heroLogoLetters[5], // R
      this.heroLogoLetters[1], // O
      this.heroLogoLetters[6], // R
      this.heroLogoLetters[0], // C
      this.heroLogoLetters[7], // A
    ];

    const timeline = gsap.timeline({
      defaults: { duration: ANIMATION_CONFIG.DEFAULT_DURATION, ease: ANIMATION_CONFIG.EASING.DEFAULT }
    });

    const d = remainingTime / 1000 + 0.75;

    timeline
      .to(introWrap, {
        opacity: 0,
        display: "none",
        ease: ANIMATION_CONFIG.EASING.FAST,
        duration: 0.7,
        onComplete: () => document.body.classList.remove("menu-open"),
      }, remainingTime / 1000)
      .from(manualOrder, {
        opacity: 0,
        y: "100%",
        duration: ANIMATION_CONFIG.DEFAULT_DURATION,
        ease: ANIMATION_CONFIG.EASING.DEFAULT,
        stagger: 0.1,
      }, d)
      .from(this.lines, {
        y: "100%",
        stagger: ANIMATION_CONFIG.STAGGER_DELAY,
        ease: ANIMATION_CONFIG.EASING.DEFAULT,
      }, d + 0.5)
      .to(this.heroLogoVector, {
        opacity: 1,
        clipPath: "inset(0% 0 0 0)",
        duration: ANIMATION_CONFIG.DEFAULT_DURATION,
      }, d + 0.7)
      .to(this.heroImg, {
        clipPath: "inset(0% 0 0 0)",
        ease: isTabletOrBelow ? ANIMATION_CONFIG.EASING.DEFAULT : "outCircle",
        duration: 1.3,
      }, d + 0.8)
      .to(this.menu, { opacity: 1 }, d - 0.2)
      .to(this.language, { y: "0%", duration: 0.9 }, d + 0.5);

    return timeline;
  }

  removeLinesAndKeepText() {
    const container = DOM.introP;
    const parentLines = document.querySelectorAll(".parent-line");

    parentLines.forEach((parentLine) => {
      const textContent = Array.from(parentLine.querySelectorAll(".line"))
        .map((line) => line.textContent)
        .join(" ");
      const textNode = document.createTextNode(textContent + " ");
      container.insertBefore(textNode, parentLine);
      parentLine.remove();
    });
  }

  handleFontLoadSuccess(introWrap, start) {
    const end = performance.now();
    const duration = end - start;
    const MIN_SHOW_TIME = 2000;
    const remainingTime = Math.max(MIN_SHOW_TIME - duration, 0);

    this.setInitialStates();
    this.animateIntro(introWrap, remainingTime);
    console.log(`Fonte Gotham Ultra carregada em ${duration}ms`);
  }

  handleFontLoadFailure(introWrap, start) {
    console.error("Conexão fraca");
    setTimeout(() => this.handleFontLoadSuccess(introWrap, start), 5000);
  }
}

function setupColorAnimation(initialBegeRGB) {
  gsap.to(":root", {
    scrollTrigger: {
      trigger: ".hero",
      scroller: "#sccont",
      start: "top",
      end: "bottom center",
      scrub: true,
    },
    ease: "power1.Out",
    onUpdate: function () {
      const progress = this.progress();
      const endColor = [16, 16, 16];
      const currentColor = initialBegeRGB.map((start, index) =>
        Math.round(start + (endColor[index] - start) * progress)
      );
      document.documentElement.style.setProperty("--beige", `rgb(${currentColor.join(",")})`);
    },
  });
}

function BlogPostAnimation() {
  const listItems = document.querySelectorAll(".post-item");
  listItems.forEach((item, index) => {
    gsap.fromTo(item, { y: "5%", opacity: 0 }, {
      y: "0%",
      opacity: 1,
      duration: ANIMATION_CONFIG.SHORT_DURATION,
      ease: ANIMATION_CONFIG.EASING.DEFAULT,
      scrollTrigger: { trigger: item, scroller: "#sccont", start: "top 100%" },
      delay: isMobileOrTablet ? ANIMATION_CONFIG.STAGGER_DELAY : (index * ANIMATION_CONFIG.STAGGER_DELAY),
    });
  });
}

function adjustScrollAttributes() {
  if (window.innerWidth <= ANIMATION_CONFIG.MOBILE_BREAKPOINT) {
    document.querySelectorAll("[data-scroll], [data-scroll-delay], [data-scroll-speed]").forEach((el) => {
      el.setAttribute("data-scroll-delay", ".01");
      el.setAttribute("data-scroll", "1");
      el.setAttribute("data-scroll-speed", "1.05");
    });
  }
}

function setupCanvasScrollTrigger(canvasSelector, triggerSelector, options = {}, start, end) {
  const canvasElement = document.querySelector(canvasSelector);
  if (!canvasElement) return null;

  const animationModule = new AnimationCanvas(canvasElement, options);
  animationModule.init();

  ScrollTrigger.create({
    trigger: triggerSelector,
    scroller: "#sccont",
    start,
    end,
    scrub: true,
    onUpdate: (self) => animationModule.onScrollProgress(self.progress),
  });

  return animationModule;
}

function initializeCanvasAnimations(locoScroll) {
  setupCanvasScrollTrigger(
    ".animation-canvas",
    ".nopaddingsec",
    { inverted: false, direction: "down" },
    isMobileOrTablet ? "top top" : `top ${window.innerHeight * 0.1}px`,
    "bottom top"
  );

  setupCanvasScrollTrigger(
    ".animation-canvas-reverse",
    ".footersec",
    { inverted: true, direction: "up" },
    undefined,
    isMobileOrTablet ? "bottom 110%" : "center 50%"
  );
}

function setupHoverAnimation(selector, duration = 0, ease = "none") {
  const grey = getComputedStyle(document.documentElement).getPropertyValue("--grey").trim();
  const menuLinkHover = getComputedStyle(document.documentElement).getPropertyValue("--menulinkhover").trim();
  const elements = document.querySelectorAll(selector);

  elements.forEach((element) => {
    let hoverTimeline;
    element.addEventListener("mouseenter", () => {
      if (hoverTimeline) hoverTimeline.kill();
      gsap.to(element, { color: menuLinkHover, duration: 0 });
    });
    element.addEventListener("mouseleave", () => {
      hoverTimeline = gsap.to(element, { color: grey, duration, ease });
    });
  });
}

function setupFadeInAnimations() {
  const y = isMobileOrTablet ? "10%" : "20%";

  DOM.fadeInElements.forEach((element) => {
    addWillChange(element, "opacity, transform");

    const offset = parseInt(element.getAttribute("offset"), 10) || 0;
    const startPercentage = (offset - 100) * -1;

    gsap.set(element, { y, opacity: 0 });

    const scrollTrigger = {
      trigger: element,
      scroller: "#sccont",
      start: isMobileOrTablet ? "top 75%" : `top ${startPercentage}%`,
    };

    gsap.to(element, {
      y: "0%",
      duration: ANIMATION_CONFIG.SHORT_DURATION,
      ease: ANIMATION_CONFIG.EASING.SOFT,
      scrollTrigger,
    });

    gsap.to(element, {
      opacity: 1,
      duration: ANIMATION_CONFIG.DEFAULT_DURATION,
      ease: ANIMATION_CONFIG.EASING.FAST,
      scrollTrigger,
    });
  });
}

function initializeHoverAnimations() {
  setupHoverAnimation([".navlink", ".link"]);
  setupHoverAnimation(".menusocialiconwrap", 0.5, "ease");
}

function setupBtnWrapperHoverAnimation() {
  const grey = getComputedStyle(document.documentElement).getPropertyValue("--grey").trim();
  const black = getComputedStyle(document.documentElement).getPropertyValue("--black").trim();
  const elements = document.querySelectorAll(".btn-wrapper");

  elements.forEach((element) => {
    const textElement = element.querySelector(".ver-artigos");
    let hoverTimeline;

    element.addEventListener("mouseenter", () => {
      if (hoverTimeline) hoverTimeline.kill();
      hoverTimeline = gsap.timeline({ defaults: { duration: 0.4, ease: ANIMATION_CONFIG.EASING.SOFT } });
      hoverTimeline.to(textElement, { color: black }).to(element, { backgroundColor: grey }, 0);
    });

    element.addEventListener("mouseleave", () => {
      hoverTimeline = gsap.timeline({ defaults: { duration: 0.4, ease: ANIMATION_CONFIG.EASING.DEFAULT } });
      hoverTimeline.to(textElement, { color: grey }).to(element, { backgroundColor: black }, 0);
    });
  });
}

function setupLinkTextHoverAnimation() {
  const element = document.querySelector(".linktext");
  const linkLine = document.querySelector(".linkline");
  if (!element || !linkLine) return;

  element.addEventListener("mouseenter", () => {
    gsap.timeline({ defaults: { duration: 0.35, ease: ANIMATION_CONFIG.EASING.SOFT } })
      .to(linkLine, { xPercent: 101 })
      .set(linkLine, { xPercent: -101 });
  });

  element.addEventListener("mouseleave", () => {
    gsap.timeline({ defaults: { duration: 0.35, ease: ANIMATION_CONFIG.EASING.SOFT } })
      .to(linkLine, { xPercent: 0 });
  });
}

function SegundaSecaoIntView() {
  const Pfade = document.querySelector("p.fade");
  const linkWrap = document.querySelector(".link_wrap");
  if (!Pfade || !linkWrap) return;

  addWillChange([Pfade, linkWrap], "opacity, transform");

  gsap.set(Pfade, { y: "10%", opacity: 0 });
  gsap.set(linkWrap, { opacity: 0 });

  const timeline = gsap.timeline({
    scrollTrigger: { trigger: ".content_bottom", scroller: "#sccont", start: "top 80%" },
    onComplete: () => removeWillChange([Pfade, linkWrap]),
  });

  timeline.to(Pfade, { opacity: 1, duration: ANIMATION_CONFIG.DEFAULT_DURATION, ease: ANIMATION_CONFIG.EASING.FAST });
  timeline.to(Pfade, { y: "0%", duration: ANIMATION_CONFIG.DEFAULT_DURATION, ease: ANIMATION_CONFIG.EASING.SOFT }, 0);
  timeline.to(linkWrap, { opacity: 1, duration: ANIMATION_CONFIG.DEFAULT_DURATION, ease: ANIMATION_CONFIG.EASING.FAST }, 0.3);
}

function setupServicosAnimation() {
  const servicosWraps = document.querySelectorAll(".servicos-wrap");

  servicosWraps.forEach((servicosWrap) => {
    const separator = servicosWrap.querySelector(".separator");
    const right = servicosWrap.querySelector(".right");
    const servicos = servicosWrap.querySelector(".servicos");
    if (!separator || !right || !servicos) return;

    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: servicosWrap,
        scroller: "#sccont",
        start: isMobileOrTablet ? "top 75%" : "top 80%",
      },
      defaults: { duration: ANIMATION_CONFIG.DEFAULT_DURATION, ease: ANIMATION_CONFIG.EASING.FAST },
      onStart: () => addWillChange([servicos, separator, right], "opacity, transform"),
    });

    gsap.set(servicos, { y: "-5%", opacity: 0 });
    gsap.set(separator, { scaleX: 0, opacity: 0 });
    gsap.set(right, { y: "10%", opacity: 0 });

    tl.to(separator, { scaleX: 1, opacity: 1 });
    tl.to(servicos, { opacity: 1 }, 0.1);
    tl.to(servicos, { y: "0%", ease: ANIMATION_CONFIG.EASING.SOFT }, 0.1);
    tl.to(right, { opacity: 1 }, 0.1);
    tl.to(right, { y: "0%", ease: ANIMATION_CONFIG.EASING.SOFT }, 0.1);
  });
}

function setupMenuAnimation() {
  const menuIconWrap = DOM.menuIconWrap;
  if (!menuIconWrap) return;

  const menuTextWrap = DOM.menuTextWrap;
  const nav = DOM.nav;
  const close = DOM.close;
  const open = DOM.open;
  if (!menuTextWrap || !nav || !close || !open) return;

  gsap.set(nav, { display: "none", opacity: 0 });
  gsap.set([menuTextWrap, close], { opacity: 1 });
  gsap.set(close, { opacity: 0 });

  let menuOpen = false;

  menuIconWrap.addEventListener("click", () => {
    const tl = gsap.timeline({
      defaults: { duration: ANIMATION_CONFIG.SHORT_DURATION, ease: ANIMATION_CONFIG.EASING.FAST }
    });

    if (!menuOpen) {
      tl.set(nav, { display: "block", duration: 0 }, 0)
        .to(open, { opacity: 0, duration: 0.5 })
        .to(close, { opacity: 1, duration: 0.5 }, 0.2)
        .to(menuTextWrap, { opacity: 0, ease: ANIMATION_CONFIG.EASING.SOFT }, 0)
        .to(nav, { opacity: 1 }, 0);
      document.body.classList.add("menu-open");
    } else {
      tl.to(close, { opacity: 0, duration: 0.5 })
        .to(open, { opacity: 1, duration: 0.5 }, 0.2)
        .to(menuTextWrap, { opacity: 1, ease: ANIMATION_CONFIG.EASING.DEFAULT }, 0)
        .to(nav, { opacity: 0 }, 0.1)
        .set(nav, { display: "none", duration: 0 });
      document.body.classList.remove("menu-open");
    }

    menuOpen = !menuOpen;
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const locoScroll = new LocomotiveScroll({
    el: document.querySelector("#sccont"),
    smooth: true,
    lerp: 0.08,
    multiplier: 0.6,
  });
  initializeScrollTrigger(locoScroll);//locoscroll

  const introAnimation = new IntroAnimation();

  window.addEventListener("resize", debounce(() => {
    adjustScrollAttributes();
    locoScroll.update();
    introAnimation.removeLinesAndKeepText();
  }, DEBOUNCE_DELAY));

  //daqui eu pucho a intro que começa assim que a font carregar
  const gothamUltra = new FontFaceObserver("Gotham Ultra");
  gothamUltra.load()
    .then(() => introAnimation.handleFontLoadSuccess(DOM.introWrap, performance.now()))
    .catch(() => introAnimation.handleFontLoadFailure(DOM.introWrap, performance.now()));

  DOM.nopaddingImg.onload = () => {
    ScrollTrigger.refresh();
    locoScroll.update();
  };

  const initialBegeHex = getComputedStyle(document.documentElement).getPropertyValue("--beige").trim();
  const initialBegeRGB = hexToRGB(initialBegeHex);

  setupMenuAnimation();
  setupColorAnimation(initialBegeRGB);
  initializeCanvasAnimations(locoScroll);

  if (window.matchMedia(`(min-width: ${ANIMATION_CONFIG.MOBILE_BREAKPOINT}px)`).matches) {
    initializeHoverAnimations();
    setupBtnWrapperHoverAnimation();
    setupLinkTextHoverAnimation();
  }

  adjustScrollAttributes();
  SegundaSecaoIntView();
  setupFadeInAnimations();
  setupServicosAnimation();
  BlogPostAnimation();
});