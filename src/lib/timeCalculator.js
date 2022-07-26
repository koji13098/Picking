(() => {

  const timeTable = document.getElementById("timeTable");
  const sumTime1 = document.getElementById("result1");
  const sumTime2 = document.getElementById("result2");
  const sumTimeAll = document.getElementById("resultSum");

  function calculateTime() {
    let jobNum = document.querySelectorAll(".job-num");
    let startTime = document.querySelectorAll(".start-time");
    let endTime = document.querySelectorAll(".end-time");
    let breakTime = document.querySelectorAll(".break-time");
    let result = document.querySelectorAll(".result");
    let result1 = 0;
    let result2 = 0;
    let resultSum = 0;

    for (let i = 0; i < timeTable.rows.length - 1; i++) {
      if (startTime[i].value != '' || endTime[i].value != '') {
        let sumMinute = parseInt(endTime[i].value.substr(3, 2)) - parseInt(startTime[i].value.substr(3, 2));
        let sumHour = parseInt(endTime[i].value.substr(0, 2)) - parseInt(startTime[i].value.substr(0, 2));
        sum = sumHour * 60 + sumMinute - breakTime[i].value;
        result[i].value = sum;
        resultSum += sum;
        if (jobNum[i].value == 1) {
          result1 += sum;
        } else if (jobNum[i].value == 2) {
          result2 += sum;
        }
      }
    }

    return {
      result1: result1,
      result2: result2,
      resultSum: resultSum
    };
  }

  document.getElementById("addTime").addEventListener("click", () => {
    const trs = document.querySelectorAll(".time");
    const trLast = trs[trs.length - 1].cloneNode(true);
    const inputs = trLast.querySelectorAll("input");
    inputs.forEach(input => {
      console.log(input.className);
      if (input.className == "start-time") {
        input.value = trLast.querySelector(".end-time").value;
      } else {
        input.value = "";
      }
    });
    document.getElementById("timeTable").querySelector("tbody").appendChild(trLast);
  });

  document.getElementById("calculate").addEventListener("click", () => {
    let resultTime = calculateTime();
    console.log(resultTime);
    sumTime1.value = resultTime.result1 + "分";
    sumTime2.value = resultTime.result2 + "分";
    sumTimeAll.value = resultTime.resultSum + "分";
  });

  document.getElementById("reset").addEventListener("click", () => {
    document.querySelectorAll("input").forEach(input => {
      input.value = '';
    });
    while (timeTable.querySelectorAll(".time").length > 1) {
      timeTable.deleteRow(-1);
    }
  });

})();

function deleteRow(obj) {
  const tr = obj.parentNode.parentNode;
  if (tr.parentNode.rows.length > 2) {
    tr.parentNode.deleteRow(tr.sectionRowIndex);
  }
}
