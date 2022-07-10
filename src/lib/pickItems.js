const video = document.getElementById("js-video");
const canvas = document.getElementById("js-canvas");
const ctx = canvas.getContext("2d");
const input = document.getElementById("js-input");


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

const timer = setInterval(() => {
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
  const code = jsQR(imageData.data, canvas.width, canvas.height);

  if (code) {
    input.value = code.data;
    document.form.submit();
    clearInterval(timer);
  }
}, 500);
