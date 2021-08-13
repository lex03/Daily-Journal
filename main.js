let id = $("input[name*='task_id']");
id.attr("readonly", "readonly");
//edit button
$(".btnedit").click((e) => {
  let textvalues = displayData(e);

  let name = $("input[name*='task_name']");
  let det = $("input[name*='task_detail']");
  let status = $("input[name*='task_status']");
  let due = $("input[name*='task_due']");

  id.val(textvalues[0]);
  name.val(textvalues[1]);
  det.val(textvalues[2]);
  status.val(textvalues[3]);
  due.val(textvalues[4]);
});

function displayData(e) {
  let id = 0;
  const td = $("#tbody tr td");
  let textvalues = [];

  for (const value of td) {
    if (value.dataset.id == e.target.dataset.id) {
      textvalues[id++] = value.textContent;
    }
  }
  return textvalues;
}
