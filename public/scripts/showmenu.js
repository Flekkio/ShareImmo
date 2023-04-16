function toggleMenu() {
  const menu = document.querySelector(".menu-client");
  menu.classList.toggle("visible");
}

const burger = document.querySelector(".burger");
burger.addEventListener("click", toggleMenu);
