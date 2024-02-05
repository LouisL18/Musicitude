<?php
$content = "<div class='row justify-content-center'>";
$i = 0;
foreach ($super_albums as $album) {
    if ($i % 5 == 0 && $i != 0) {
        $content .= "</div><div class='row justify-content-center'>";
    }
    $content .= "<div class='col-lg-2 mb-5 d-flex justify-content-center'>";
    $content .= "<a href='album/" . $album['Album']->getIdAlbum() . "' class='text-decoration-none text-dark'>";
    $content .= "<div class='card rounded-card'>";
    if ($album['Image']) {
        $content .= "<img class='card-img-top' src='data:image/jpeg;base64," . utf8_decode($album['Image'][0]->getDataImage()) . "' alt='" . $album['Image'][0]->getNomImage() . "'>";
    }
    $content .= "<div class='card-body d-flex flex-column justify-content-center align-items-center text-center'>";
    $content .= "<h5 class='card-title fs-4'>" . $album['Album']->getNomAlbum() . "</h5>";
    $content .= "<p class='card-text fs-6'>" . $album['Album']->getDescriptionAlbum() . "</p>";
    $content .= "<p class='card-text fs-6'>" . $album['Artiste'][0]->getNomArtiste() . '</p>';
    $content .= "<p class='card-text fs-6'>" . $album['Album']->getAnneeAlbum() . "</p>";
    $content .= "</div>";
    $content .= "</div>";
    $content .= "</a>";
    $content .= "</div>";
    $i++;
}
$content .= "</div>";
return $content;
?>