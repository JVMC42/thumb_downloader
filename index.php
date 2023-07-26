<?php

if(isset($_POST['download'])){
    $imgUrl =  $_POST['imgUrl'];
    $ch = curl_init($imgUrl);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $download = curl_exec($ch);
    curl_close($ch);
    header('Content-type: image/jpg');
    header('Content-Disposition: attachment; filename="thumbnail.jpg"');
    echo $download;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloader YouTube Thumbnail</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <header>Baixar Thumbnail</header>
        <div class="url-input">
            <span class="title">Cole a url do video</span>
            <div class="field">
                <input type="text" placeholder="Url" required>
                <input class="hidden-input" type="hidden" name="imgUrl">
                <div class="bottom-line"></div>
            </div>
        </div>
        <div class="preview-area">
            <img class="thumbnail" src="" alt="thumbnail">
            <i class="icon fas fa-cloud-download-alt"></i>
            <span>Cole a url pra ver a preview</span>
        </div>
        <button class="download-btn" type="submit" name="download">Baixar Thumbnail</button>
    </form>

    <script>
        const urlField = document.querySelector(".field input"),
        previewArea = document.querySelector(".preview-area"),
        imgTag = previewArea.querySelector(".thumbnail"),
        hiddenInput = document.querySelector(".hidden-input")

        urlField.onkeyup = ()=>{
            let imgUrl = urlField.value
            previewArea.classList.add("active")

            if(imgUrl.indexOf("https://www.youtube.com/watch?v=") != -1){
                console.log(1)
                let vidId = imgUrl.split("v=")[1].substring(0,11)
                let ytThumbUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`
                imgTag.src = ytThumbUrl

            }else if(imgUrl.indexOf("https://youtu.be/") != -1){
                console.log(2);
                let vidId = imgUrl.split("be/")[1].substring(0,11)
                console.log(vidId);
                let ytThumbUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`
                imgTag.src = ytThumbUrl

            }else if(imgUrl.match(/\.(jpe?g|png|gif|bpm|webp)$/i)){
                imgTag.src = imgUrl

            }else {
                imgTag.src = ""
                previewArea.classList.remove("active")
            }
            hiddenInput.value = imgTag.src
        }

    </script>
</body>
</html>