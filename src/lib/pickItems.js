const video = document.getElementById("js-video");
const canvas = document.getElementById("js-canvas");
const ctx = canvas.getContext("2d");
const pickNums = document.querySelectorAll(".pickNum");
const readNums = document.querySelectorAll(".readNum");
const invoiceNums = document.querySelectorAll(".invoiceNum");
const itemLocations = document.querySelectorAll(".value.location");
const amounts = document.querySelectorAll(".value.amount");
const itemNumbers1 = document.querySelectorAll(".item_number1");
const itemNumbers2 = document.querySelectorAll(".item_number2");

let isCameraOn = false;
let timer = 0;

function cameraOn() {
  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    return navigator.mediaDevices
      .getUserMedia({
        video: { facingMode: "environment" }
      })
      .then((stream) => {
        video.srcObject = stream;
        video.play();
        console.log("Camera On");
        isCameraOn = true;
      })
      .catch((err) => {
        console.log("Error: Cannot connect to camera.");
        console.log(err);
      });
  }
}

function cameraOff() {
  const tracks = video.srcObject.getTracks();
  tracks.forEach(track => {
    track.stop();
  });
  console.log("Camera Stopped");
  video.srcObject = null;
  clearInterval(timer);
  isCameraOn = false;
}

function readQR() {
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
  const code = jsQR(imageData.data, canvas.width, canvas.height);
  console.log("Reading on camera...")
  return code;
}

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
    input.value = '';
    console.log("PickingList updated");
  } else {
    complete.style.display = 'grid';
  }
}

function checkItemNumber(itemNumber) {
  cameraOff();
  if (pickingLists[pickNumCount]['item_number'].substr(0, 16) == itemNumber.substr(0, 16)) {
    popupCorrect.style.display = 'flex';
  } else {
    incorrect.style.display = 'grid';
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
const popupSkip = document.getElementById("js-popup-skip");
const popupQuit = document.getElementById("js-popup-quit");


document.getElementById("js-quit").addEventListener('click', () => {
  popupQuit.style.display = 'flex';
});

document.getElementById("js-popup-quit-yes").addEventListener('click', () => {
  location.href = "./index.php";
});

document.getElementById("js-popup-quit-no").addEventListener('click', () => {
  popupQuit.style.display = 'none';
});

document.getElementById("js-skip").addEventListener('click', () => {
  popupSkip.style.display = 'flex';
});

document.getElementById("js-popup-skip-yes").addEventListener('click', () => {
  pickNumCount++;
  updatePickList(pickNumCount);
  popupSkip.style.display = 'none';
});

document.getElementById("js-popup-skip-no").addEventListener('click', () => {
  popupSkip.style.display = 'none';
});

complete.addEventListener('click', () => {
  location.href = "./readList.php";
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
  if (!isCameraOn) {
    cameraOn().then(() => {
      timer = setInterval(() => {
        if (code = readQR()) {
          console.log(code.data);
          input.value = code.data;
          checkItemNumber(input.value);
        }
      }, 500);
    });
  } else {
    cameraOff();
  }
});

let pickNumCount = 0;
updatePickList(pickNumCount);
