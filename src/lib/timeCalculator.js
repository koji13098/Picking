const timeTable = document.getElementById("time-table");
const breakTable = document.getElementById("break-table");
const sumTime = document.getElementById("resultSum");

function insertRow(tableId, row) {
  console.log(tableId);
  console.log(row);
  var tr = document.querySelector(row).cloneNode(true);
  document.getElementById(tableId).querySelector("tbody").appendChild(tr);
}

function deleteRow(obj) {
  tr = obj.parentNode.parentNode;
  if (tr.parentNode.rows.length > 2) {
    tr.parentNode.deleteRow(tr.sectionRowIndex);
  }
}

function calculateTime() {
  let startTime = document.querySelectorAll(".start-time");
  let endTime = document.querySelectorAll(".end-time");
  let breakTime = document.querySelectorAll(".break-time");
  let result = document.querySelectorAll(".result");
  let resultSum = 0;

  for (let i = 0; i < timeTable.rows.length - 1; i++) {
    console.log(timeTable.rows.length);
    console.log(startTime[i]);
    console.log("start = " + startTime[i].value);
    console.log("end = " + endTime[i].value);
    let sumHour = parseInt(endTime[i].value.substr(0, 2)) - parseInt(startTime[i].value.substr(0, 2));
    let sumMinute = parseInt(endTime[i].value.substr(3, 2)) - parseInt(startTime[i].value.substr(3, 2));
    sum = sumHour * 60 + sumMinute - breakTime[i].value;
    result[i].value = sum;
    resultSum += sum;
    console.log(sum);
    console.log(resultSum);
  }

  return resultSum;
}

document.getElementById("calculate").addEventListener("click", () => {
  sumTime.value = calculateTime();
})
