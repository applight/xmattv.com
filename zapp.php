<?php
include_once('./PageGen.php');

$pagegen = PageGen::title('Cam');
$pagegen->setHeadChildren( ['script' => ['src' => 'http://source.zoom.us/videosdk/zoom-video-1.9.8.min.js'] ] );

$content = <<<EOF
<div>
<video-player-container></video-player-container>

<video id="my-self-view-video" width="1920" height="1080"></video>

<canvas id="my-self-view-canvas" width="1920" height="1080"></canvas>

</div>

<style>
video-player-container {
    width: 100%;
    height: 1000px;
}

video-player {
  width: 100%;
  height: auto;
  aspect-ratio: 16/9;
}

#my-self-view-video, #my-self-view-canvas {
  width: 100%;
  height: auto;
}

</style>

<script src="./zapp.js"></script>
EOF;

echo $pagegen->contentWrap($content);
?>