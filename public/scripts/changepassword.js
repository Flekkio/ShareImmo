const btnPassword = document.getElementById("btn-password");
const formPassword = document.getElementById("form-password");
const cancelPassword = document.getElementById("cancel-password");

btnPassword.addEventListener("click", () => {
  btnPassword.style.display = "none";
  formPassword.style.display = "block";
});

cancelPassword.addEventListener("click", () => {
  btnPassword.style.display = "block";
  formPassword.style.display = "none";
});

formPassword.addEventListener("submit", (event) => {
  // Ajoutez ici le code pour valider les données du formulaire

  btnPassword.style.display = "block";
  formPassword.style.display = "none";
});
