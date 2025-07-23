async function uploadVideo() {
  const fileInput = document.getElementById('videoFile');
  const status = document.getElementById('status');
  const file = fileInput.files[0];
  if (!file) {
    status.innerText = "Please select a video file.";
    return;
  }

  status.innerText = "Uploading video to DoodStream...";
  const formData = new FormData();
  formData.append("file", file);

  try {
    const uploadResponse = await fetch("upload.php", {
      method: "POST",
      body: formData
    });
    const uploadData = await uploadResponse.json();
    if (!uploadData || !uploadData.result || !uploadData.result.filecode) {
      status.innerText = "Upload failed.";
      return;
    }
    const videoId = uploadData.result.filecode;
    status.innerText = "Upload complete! Redirecting to player...";
    window.location.href = `player.html?video=${videoId}`;
  } catch (error) {
    status.innerText = "Upload error: " + error;
  }
}