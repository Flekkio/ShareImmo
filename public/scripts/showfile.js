function showFileName() {
  var fileInput = document.getElementById("file");
  var fileName = fileInput.value.split("\\").pop();
  document.getElementById("file-name").innerHTML = fileName;
}

function showButton() {
  document.getElementById("send-btn").style.display = "block";
}
