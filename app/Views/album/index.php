<?php
$content = "";
foreach ($super_albums as $album) {
    $content .= "<div class='album'>";
    $content .= "<h2>" . $album['Album']->getNomAlbum() . "</h2>";
    if ($album['Image']) {
        $content .= "<img src='data:image/jpeg;base64," . utf8_decode($album['Image'][0]->getDataImage()) . "' alt='" . $album['Image'][0]->getNomImage() . "'>";
    }
    $content .= "<p>" . $album['Album']->getDescriptionAlbum() . "</p>";
    $content .= "<p>" . $album['Artiste'][0]->getNomArtiste() . '</p>';
    $content .= "<p>" . $album['Album']->getAnneeAlbum() . "</p>";
    $content .= "</div>";
}
return $content;
?>