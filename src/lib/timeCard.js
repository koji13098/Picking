const startTime = document.getElementById("js-start");
const endTime = document.getElementById("js-end");
const breakTime = document.getElementById("js-break");
const resultTime = document.querySelector(".title");

function calculate() {
  let sumHour = parseInt(endTime.value.substr(0, 2)) - parseInt(startTime.value.substr(0, 2));
  let sumMinute = parseInt(endTime.value.substr(3, 2)) - parseInt(startTime.value.substr(3, 2)) - breakTime.value;

  return sumHour * 60 + sumMinute;
}

document.getElementById("js-calculate").addEventListener('click', () => {
  console.log(startTime.value);
  console.log(endTime.value);
  console.log(breakTime.value);
  if (!startTime.value || !endTime.value || !breakTime) {
    resultTime.innerText = "エラー";
  } else {
    console.log(calculate());
    resultTime.innerText = calculate() + "分";
  }
});

document.getElementById("js-reset").addEventListener('click', () => {
  startTime.value = '';
  endTime.value = '';
  breakTime.value = '';
  resultTime.innerText = "分";
});
