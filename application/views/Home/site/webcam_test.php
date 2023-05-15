<script src="https://www.webrtc-experiment.com/RecordRTC.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<video id="your-video-id"  autoplay playsinline></video>
       
<script type="text/javascript">
var time = 1;

var interval = setInterval(function() { 
   if (time <= 30) { 


navigator.mediaDevices.getUserMedia({ video: true, audio: true }).then(function(camera) {

// preview camera during recording
document.getElementById('your-video-id').muted = true;
document.getElementById('your-video-id').srcObject = camera;

// recording configuration/hints/parameters
var recordingHints = {
    type: 'video'
};

// initiating the recorder
var recorder = RecordRTC(camera, recordingHints);

// starting recording here
recorder.startRecording();








setTimeout(function() {

// stop recording
recorder.stopRecording(function() {
    
    // get recorded blob
    var blob = recorder.getBlob();

    // generating a random file name
    var fileName = getFileName('webm');

    // we need to upload "File" --- not "Blob"
    var fileObject = new File([blob], fileName, {
        type: 'video/webm'
    });

    var formData = new FormData();

    // recorded data
    formData.append('video-blob', fileObject);

    // file name
    formData.append('video-filename', fileObject.name);

 //   document.getElementById('header').innerHTML = 'Uploading to PHP using jQuery.... file size: (' +  bytesToSize(fileObject.size) + ')';

    var upload_url = '<?=base_url()?>/DemoExam/saveVideo/';
// var upload_url = 'RecordRTC-to-PHP/save.php';

var upload_directory = '<?=base_url()?>/demo/';
    // var upload_directory = 'RecordRTC-to-PHP/uploads/';

    // upload using jQuery
    $.ajax({
        url: upload_url, // replace with your own server URL
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(response) {
            if (response === 'success') {
             //   alert('successfully uploaded recorded blob');

                // file path on server
                var fileDownloadURL = upload_directory + fileObject.name;





                
/* 
                // preview the uploaded file URL
                document.getElementById('header').innerHTML = '<a href="' + fileDownloadURL + '" target="_blank">' + fileDownloadURL + '</a>';

                // preview uploaded file in a VIDEO element
                document.getElementById('your-video-id').srcObject = null;
                document.getElementById('your-video-id').src = fileDownloadURL;

                // open uploaded file in a new tab
                window.open(fileDownloadURL); */
            } else {
               // alert(response); // error/failure
            }
        }
    });

    // release camera
    document.getElementById('your-video-id').srcObject = document.getElementById('your-video-id').src = null;
    camera.getTracks().forEach(function(track) {
        track.stop();
    });

});
/* var recorder = RecordRTC(camera, recordingHints);
recorder.startRecording(); */
},55000);


}).catch(function(error){

alert(error);
alert("Give access to camera and microphone");

});

// this function is used to generate random file name
function getFileName(fileExtension) {
var d = new Date();
var year = d.getUTCFullYear();
var month = d.getUTCMonth();
var date = d.getUTCDate();
var ttt = d.getTime();
return '<?=$this->session->userdata('user')['user_id']?>-<?=$this->session->userdata('user_exam')['exam_details']?>-' + year + month + date + '-'+ ttt +'-' + getRandomString() + '.' + fileExtension;
}

 function getRandomString() {
if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
    var a = window.crypto.getRandomValues(new Uint32Array(3)),
        token = '';
    for (var i = 0, l = a.length; i < l; i++) {
        token += a[i].toString(36);
    }
    return token;
} else {
    return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
}
} 

     
time++;
   }
   else { 
      clearInterval(interval);
   }
}, 3000);
        </script>

        <footer style="margin-top: 20px;"><small id="send-message"></small></footer>
        <script src="https://www.webrtc-experiment.com/common.js"></script>
