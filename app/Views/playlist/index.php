<?php
$content = "<div class='row justify-content-center'>";
$i = 0;
foreach ($super_playlists as $playlist) {
    if ($i % 5 == 0 && $i != 0) {
        $content .= "</div><div class='row justify-content-center'>";
    }
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
    $content .= "<p class='card-text fs-6'>" . $playlist['Playlist']->getDescriptionPlaylist() . "</p>";
    $content .= "<p class='card-text fs-6'>" . $playlist['NbMusiques'] . " musiques</p>";
    $content .= "</div>";
    $content .= "</div>";
    $content .= "</a>";
    $content .= "</div>";
    $i++;
}
$content .= "</div>";
return $content;
?>