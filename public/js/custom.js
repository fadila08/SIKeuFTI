function showProjectTransaction() {
  //untuk nama project
  var data_project = document.getElementById("id_project");
  var text_project = data_project.options[data_project.selectedIndex].text;
  // console.log(text_project);
  $("#project_value").text(text_project);                                                 

  //untuk tanggal
  var data_date = document.getElementById("input-date").value;
  // console.log(text_project);
  $("#date_value").text(data_date);

  //untuk deskripsi
  var data_desc = document.getElementById("input-description").value;
  $("#desc_value").text(data_desc);

  //untuk nomor bukti transaksi
  var data_proofnum = document.getElementById("input-proof-num").value;
  $("#proof_num_value").text(data_proofnum);

  //untuk akun debet
  var data_debet_acc = document.getElementById("id_debet_acc");
  var text_debet_acc = data_debet_acc.options[data_debet_acc.selectedIndex].text;
  $("#debet_acc_value").text(text_debet_acc);                                                 

  //untuk akun kredit
  var data_cred_acc = document.getElementById("id_cred_acc");
  var text_cred_acc = data_cred_acc.options[data_cred_acc.selectedIndex].text;
  $("#cred_acc_value").text(text_cred_acc);

  //untuk nominal
  var data_nominal = document.getElementById("input-nominal").value;
  $("#nominal_value").text(data_nominal);
}