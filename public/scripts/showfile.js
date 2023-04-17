function showFileName() {
  const fileInput = document.getElementById("file");
  const fileName = fileInput.value.split("\\").pop();
  document.getElementById("file-name").innerHTML = fileName;
}

function showButton() {
  document.getElementById("send-btn").style.display = "block";
}
