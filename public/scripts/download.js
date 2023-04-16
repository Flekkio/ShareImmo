function telecharger(nomFichier, contenuFichier) {
  let byteCharacters = atob(contenuFichier);
  let byteNumbers = new Array(byteCharacters.length);
  for (let i = 0; i < byteCharacters.length; i++) {
    byteNumbers[i] = byteCharacters.charCodeAt(i);
  }
  let byteArray = new Uint8Array(byteNumbers);
  let blob = new Blob([byteArray], { type: "application/pdf" });
  let link = document.createElement("a");
  link.href = window.URL.createObjectURL(blob);
  link.download = nomFichier;
  link.click();
}
