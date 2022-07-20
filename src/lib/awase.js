const video = document.getElementById("js-video");
const canvas = document.getElementById("js-canvas");
const ctx = canvas.getContext("2d");
const title = document.querySelector(".title");
const item_number1 = document.getElementById("item-number1");
const item_number2 = document.getElementById("item-number2");
const item_number2_block = document.querySelector(".item-number2");
const complete = document.querySelector(".complete");
const incorrect = document.querySelector(".incorrect");
const popupIncorrect = document.getElementById("js-popup-incorrect");
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

function checkItemNumber() {
  if (item_number1.value.substr(0, 16) == item_number2.value.substr(0, 16)) {
    complete.style.display = 'grid';
  } else {
    incorrect.style.display = 'grid';
  }
  item_number2_block.style.visibility = 'hidden';
}

function clearInputs(inputs) {
  inputs.forEach(input => {
    input.value = '';
  });
}

document.getElementById("js-read").addEventListener('click', () => {
  console.log("isCameraOn = " + isCameraOn);
  if (!isCameraOn) {
    cameraOn().then(() => {
      if (item_number1.value == '') {
        timer = setInterval(() => {
          if (code = readQR()) {
            console.log(code.data);
            clearInterval(timer);
            cameraOff();
            item_number1.value = code.data;
            title.innerText = "２つ目品番";
            item_number2_block.style.visibility = 'visible';
          }
        }, 500);
      } else {
        timer = setInterval(() => {
          if (code = readQR()) {
            console.log(code.data);
            clearInterval(timer);
            cameraOff();
            item_number2.value = code.data;
            checkItemNumber();
          }
        }, 500);
      }
    });
    console.log("camera true");
  } else {
    cameraOff();
  }
});

complete.addEventListener('click', () => {
  complete.style.display = 'none';
  clearInputs([item_number1, item_number2]);
  title.innerText = "１つ目品番";
});

incorrect.addEventListener('click', () => {
  popupIncorrect.style.display = 'flex';
  document.querySelector(".read_item_number1").innerText = item_number1.value;
  document.querySelector(".read_item_number2").innerText = item_number2.value;
});

document.getElementById("js-popup-incorrect-close").addEventListener('click', () => {
  incorrect.style.display = 'none';
  popupIncorrect.style.display = 'none';
  title.innerText = "１つ目品番";
  clearInputs([item_number1, item_number2]);
});

document.getElementById("js-quit").addEventListener('click', () => {
  if (item_number2.value != '') {
    clearInputs([item_number2]);
  } else if (item_number1.value != '') {
    clearInputs([item_number1]);
    item_number2_block.style.visibility = 'hidden';
    title.innerText = "１つ目品番";
  } else {
    location.href = "./index.php";
  }
});
