(() => {

  const timeTable = document.getElementById("time-table");
  const sumTime = document.getElementById("resultSum");

  function calculateTime() {
    let startTime = document.querySelectorAll(".start-time");
    let endTime = document.querySelectorAll(".end-time");
    let breakTime = document.querySelectorAll(".break-time");
    let result = document.querySelectorAll(".result");
    let resultSum = 0;

    for (let i = 0; i < timeTable.rows.length - 1; i++) {
      if (startTime[i].value != '' || endTime[i].value != '') {
        let sumMinute = parseInt(endTime[i].value.substr(3, 2)) - parseInt(startTime[i].value.substr(3, 2));
        let sumHour = parseInt(endTime[i].value.substr(0, 2)) - parseInt(startTime[i].value.substr(0, 2));
        sum = sumHour * 60 + sumMinute - breakTime[i].value;
        result[i].value = sum;
        resultSum += sum;
      }
    }

    return resultSum;
  }

  document.getElementById("calculate").addEventListener("click", () => {
    sumTime.value = calculateTime() + "分";
  })

})();

function insertRow(tableId, row) {
  var tr = document.querySelector(row).cloneNode(true);
  tr.querySelectorAll("input").forEach(input => {
    input.value = '';
  });
  document.getElementById(tableId).querySelector("tbody").appendChild(tr);
}

function deleteRow(obj) {
  tr = obj.parentNode.parentNode;
  if (tr.parentNode.rows.length > 2) {
    tr.parentNode.deleteRow(tr.sectionRowIndex);
  }
}
