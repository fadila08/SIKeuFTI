function showProjectTransaction() {
  //untuk nama project
  var data_project = document.getElementById("id_project");
  var text_project = data_project.options[data_project.selectedIndex].text;
  console.log(text_project);
  $("#project_value").text(text_project);                                                 

  //untuk tanggal
  var data_date = document.getElementById("input-date").value;
  console.log(text_project);
  $("#date_value").text(data_date);
}