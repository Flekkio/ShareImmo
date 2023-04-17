$(document).ready(function () {
  $("input[name='searchtext']").on("keyup", function () {
    const value = $(this).val().toLowerCase();
    $(".list li").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
});
