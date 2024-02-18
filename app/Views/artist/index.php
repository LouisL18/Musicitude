<?php
$content = "<div class='row justify-content-center'>";
$i = 0;
foreach ($super_artists as $artist) {
    if ($i % 5 == 0 && $i != 0) {
        $content .= "</div><div class='row justify-content-center'>";
    }
    $content .= "<div class='col-lg-2 mb-5 d-flex justify-content-center'>";
    $content .= "<a href='artist/" . $artist['Artist']->getIdArtiste() . "' class='text-decoration-none text-dark'>";
    $content .= "<div class='card rounded-card'>";
    if ($artist['Image']) {
        $content .= "<img class='card-img-top' src='data:image/jpeg;base64," . utf8_decode($artist['Image'][0]->getDataImage()) . "' alt='" . $artist['Image'][0]->getNomImage() . "'>";
    }
    $content .= "<div class='card-body d-flex flex-column justify-content-center align-items-center text-center'>";
    $content .= "<h5 class='card-title fs-4'>" . $artist['Artist']->getNomArtiste() . "</h5>";
    $content .= "</div>";
    $content .= "</div>";
    $content .= "</a>";
    $content .= "</div>";
    $i++;
}
$content .= "</div>";
return $content;
?>