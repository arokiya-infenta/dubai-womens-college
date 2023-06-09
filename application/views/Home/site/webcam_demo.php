<style>
    html, body, video, canvas {
        margin: 0!important;
        padding: 0!important;
    }
</style>

<title>onStateChanged using RecordRTC</title>
<h1>onStateChanged using RecordRTC</h1>

<br>
<label>State preview: </label>
<span id="state-preview" style="color: red;">inactive</span>

<button id="btn-start-recording">Start Recording</button>
<button id="btn-stop-recording" disabled>Stop Recording</button>
<button id="btn-pause-recording" disabled>Pause Recording</button>

<hr>
<video controls autoplay playsinline></video>

<script src="/RecordRTC.js"></script>
<script>
var video = document.querySelector('video');

function captureCamera(callback) {
    navigator.mediaDevices.getUserMedia({ audio: true, video: true }).then(function(camera) {
        callback(camera);
    }).catch(function(error) {
        alert('Unable to capture your camera. Please check console logs.');
        console.error(error);
    });
}

function stopRecordingCallback() {
    video.srcObject = null;
    var blob = recorder.getBlob();
    video.src = URL.createObjectURL(blob);

    recorder.camera.stop();
}

var recorder; // globally accessible

document.getElementById('btn-start-recording').onclick = function() {
    this.disabled = true;
    captureCamera(function(camera) {
        video.srcObject = camera;

        recorder = RecordRTC(camera, {
            type: 'video'
        });

        recorder.onStateChanged = function(state) {
            document.getElementById('state-preview').innerHTML = state;
        };

        recorder.startRecording();

        // release camera on stopRecording
        recorder.camera = camera;

        document.getElementById('btn-stop-recording').disabled = false;
        document.getElementById('btn-pause-recording').disabled = false;
    });
};

document.getElementById('btn-stop-recording').onclick = function() {
    this.disabled = true;
    recorder.stopRecording(stopRecordingCallback);
};

document.getElementById('btn-pause-recording').onclick = function() {
    this.disabled = true;

    if(this.innerHTML === 'Pause Recording') {
        recorder.pauseRecording();
        this.innerHTML = 'Resume Recording';
    }
    else {
        recorder.resumeRecording();
        this.innerHTML = 'Pause Recording';
    }

    setTimeout(function() {
        document.getElementById('btn-pause-recording').disabled = false;
    }, 2000);
};
</script>

<footer style="margin-top: 20px;"><small id="send-message"></small></footer>
<script src="https://www.webrtc-experiment.com/common.js"></script>