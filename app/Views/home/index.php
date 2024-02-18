<?php
$content = '<div class="row justify-content-center">
<h2 class="text-center text-white pb-5">Playlists</h2>';
$i = 0;
foreach ($super_playlists as $playlist) {
    $content .= "<div class='col-lg-2 mb-5 d-flex justify-content-center'>";
    $content .= "<a href='playlist/" . $playlist['Playlist']->getIdPlaylist() . "' class='text-decoration-none text-dark'>";
    $content .= "<div class='card rounded-card'>";
    if (count($playlist['Images']) > 0) {
        $count = 0;
        $content .= '<div class="row first-row">';
        foreach ($playlist['Images'] as $image) {
            if ($count >= 4) break;
            $content .= '<div class="col-6">';
            $content .= "<img src='data:image/jpeg;base64," . utf8_decode($image[0]->getDataImage()) . "' class='card-img-top small-image' alt='...'>";
            $content .= '</div>';
            if ($count % 2 == 1) {
                $content .= '</div><div class="row second-row">';
            }
            $count++;
        }
        if ($count != 4) {
            $content .= '<div class="col-6">';
            $content .= "<img src='data:image/jpeg;base64," . utf8_decode($playlist['Images'][0][0]->getDataImage()) . "' class='card-img-top small-image' alt='...'>";
            $content .= '</div>';
        }
        $content .= '</div>';
    }
    $content .= "<div class='card-body d-flex flex-column justify-content-center align-items-center text-center'>";
    $content .= "<h5 class='card-title fs-4'>" . $playlist['Playlist']->getNomPlaylist() . "</h5>";
    $content .= "<p class='card-text fs-6'>" . $playlist['NbMusiques'] . " musiques</p>";
    $content .= "</div>";
    $content .= "</div>";
    $content .= "</a>";
    $content .= "</div>";
}
$content .= "</div>";
$content .= '<div class="row justify-content-center">';
$content .= '<h2 class="text-center text-white pt-5">Favoris</h2>';



$content .= '<div id="slide">';

foreach ($super_favoris as $album) {
    $content .= "<div class='col-lg-2 mb-5 d-flex justify-content-center'>";
    $content .= "<a href='album/" . $album['Album']->getIdAlbum() . "' class='text-decoration-none text-dark'>";
    $content .= "<div class='card rounded-card'>";
    if ($album['Image']) {
        $content .= "<img class='card-img-top' src='data:image/jpeg;base64," . utf8_decode($album['Image'][0]->getDataImage()) . "' alt='" . $album['Image'][0]->getNomImage() . "'>";
    }
    $content .= "<div class='card-body d-flex flex-column justify-content-center align-items-center text-center'>";
    $content .= "<h5 class='card-title fs-4'>" . $album['Album']->getNomAlbum() . "</h5>";
    $content .= "<p class='card-text fs-6'>" . $album['Artiste'][0]->getNomArtiste() . '</p>';
    $content .= "</div>";
    $content .= "</div>";
    $content .= "</a>";
    $content .= "</div>";
    $i++;
}

$content .= '</div>';



$content .= '</div>';
$content .= '<div class="row justify-content-center">';
$content .= '<h2 class="text-center text-white pt-5 pb-5">Albums vedettes</h2>';
foreach ($super_albums as $album) {
    $content .= "<div class='col-lg-2 mb-5 d-flex justify-content-center'>";
    $content .= "<a href='album/" . $album['Album']->getIdAlbum() . "' class='text-decoration-none text-dark'>";
    $content .= "<div class='card rounded-card'>";
    if ($album['Image']) {
        $content .= "<img class='card-img-top' src='data:image/jpeg;base64," . utf8_decode($album['Image'][0]->getDataImage()) . "' alt='" . $album['Image'][0]->getNomImage() . "'>";
    }
    $content .= "<div class='card-body d-flex flex-column justify-content-center align-items-center text-center'>";
    $content .= "<h5 class='card-title fs-4'>" . $album['Album']->getNomAlbum() . "</h5>";
    $content .= "<p class='card-text fs-6'>" . $album['Artiste'][0]->getNomArtiste() . '</p>';
    $content .= "<div class='d-flex justify-content-center'>";
            for($i = 0; $i < floor($album['Note'][0] ?? 0); $i++) {
            $content .= '<i class="bi bi-star-fill star" style="font-size: 2em;" data-rating="'.($i+1).'" onclick="rate(this)" onmouseover="highlight(this)" onmouseout="unhighlight(this)"></i>';
        }
        if($album['Note'][0] - floor($album['Note'][0] ?? 0) > 0) {
            $content .= '<i class="bi bi-star-half star" style="font-size: 2em;" data-rating="'.($i+1).'" onclick="rate(this)" onmouseover="highlight(this)" onmouseout="unhighlight(this)"></i>';
            $i++;   
        }
        for(; $i < 5; $i++) {
            $content .= '<i class="bi bi-star star" style="font-size: 2em;" data-rating="'.($i+1).'" onclick="rate(this)" onmouseover="highlight(this)" onmouseout="unhighlight(this)"></i>';
        }
    $content .= '</div>';
    $content .= "</div>";
    $content .= "</div>";
    $content .= "</a>";
    $content .= "</div>";
}
$content .= "</div>";
$content .= "</div>";
    $content .= '</div>';
return $content;
?>