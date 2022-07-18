const video = document.getElementById("js-video");
const canvas = document.getElementById("js-canvas");
const ctx = canvas.getContext("2d");

if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
  navigator.mediaDevices
    .getUserMedia({
      video: { facingMode: "environment" }
    })
    .then(function (stream) {
      video.srcObject = stream;
      video.play();
      console.log("Camera On");
    });
}


const pickNums = document.querySelectorAll(".pickNum");
const readNums = document.querySelectorAll(".readNum");
const invoiceNums = document.querySelectorAll(".invoiceNum");
const itemLocations = document.querySelectorAll(".value.location");
const amounts = document.querySelectorAll(".value.amount");
const itemNumbers1 = document.querySelectorAll(".item_number1");
const itemNumbers2 = document.querySelectorAll(".item_number2");

function updatePickList(pickNumCount) {
  if (pickNumCount < pickingLists.length) {
    pickNums.forEach(pickNum => {
      pickNum.innerText = pickNumCount + 1 + '/' + pickingLists.length + '件';
    });
    readNums.forEach(readNum => {
      readNum.innerText = pickingLists[pickNumCount]['readNum'];
    });
    invoiceNums.forEach(invoiceNum => {
      invoiceNum.innerText = pickingLists[pickNumCount]['invoiceNum'];
    });
    itemLocations.forEach(itemLocation => {
      itemLocation.innerText = pickingLists[pickNumCount]['location'].substr(0, 2) + '-' + pickingLists[pickNumCount]['location'].substr(2, 5);
    });
    amounts.forEach(amount => {
      amount.innerText = pickingLists[pickNumCount]['amount'];
    });
    itemNumbers1.forEach(itemNumber1 => {
      itemNumber1.innerText = pickingLists[pickNumCount]['item_number'].substr(0, 13);
    });
    itemNumbers2.forEach(itemNumber2 => {
      itemNumber2.innerText = pickingLists[pickNumCount]['item_number'].substr(13, 3);
    });
    console.log("PickingList updated");

    const timer = setInterval(() => {
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
      const code = jsQR(imageData.data, canvas.width, canvas.height);
      console.log("Reading on camera...")

      if (code) {
        input.value = code.data;
        btnSubmit.click();
        clearInterval(timer);
      }
    }, 500);

  } else {
    complete.style.display = 'grid';
  }
}

const input = document.getElementById("js-input");
const btnSubmit = document.getElementById("js-submit");
const complete = document.querySelector(".complete");
const popupCorrect = document.getElementById("js-popup-correct");
const popupCorrectClose = document.getElementById("js-popup-correct-close");
const incorrect = document.querySelector(".incorrect");
const popupIncorrect = document.getElementById("js-popup-incorrect");
const popupIncorrectClose = document.getElementById("js-popup-incorrect-close");


document.getElementById("js-quit").addEventListener('click', () => {
  if (confirm('ピッキング処理を取り消し、読み込んだ送り状番号をすべて破棄します。よろしいでしょうか？')) {
    location.href = "./index.php";
  }
});

document.getElementById("js-skip").addEventListener('click', () => {
  if (confirm('スキップしてもよろしいでしょうか？')) {
    pickNumCount++;
    updatePickList(pickNumCount);
  }
});

complete.addEventListener('click', () => {
  location.href = "./index.php";
});

incorrect.addEventListener('click', () => {
  popupIncorrect.style.display = 'flex';
  console.log("Incorrect item_number { " + input.value + " }");
  document.querySelector(".read_item_number").innerText = input.value;
});

popupCorrectClose.addEventListener('click', () => {
  popupCorrect.style.display = 'none';
  pickNumCount++;
  updatePickList(pickNumCount);
});

popupIncorrectClose.addEventListener('click', () => {
  incorrect.style.display = 'none';
  popupIncorrect.style.display = 'none';
  updatePickList(pickNumCount);
});

btnSubmit.addEventListener('click', (e) => {
  e.preventDefault();
  checkItemNumber(input.value);
})

function checkItemNumber(itemNumber) {
  if (pickingLists[pickNumCount]['item_number'].substr(0, 16) == itemNumber.substr(0, 16)) {
    popupCorrect.style.display = 'flex';
  } else {
    incorrect.style.display = 'grid';
  }
}

let pickNumCount = 0;
updatePickList(pickNumCount);
