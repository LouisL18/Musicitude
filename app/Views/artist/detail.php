<?php
$content = '<div class="container mb-3 rounded">
    <div class="row">
        <div class="col-md-4">';
if ($super_artist['Image']) {
    $content .= '<div class="card rounded-card mb-3"><img class="card-img-top img-fluid" src="data:image/jpeg;base64,' . $super_artist['Image'][0]->getDataImage() . '" alt="' . $super_artist['Image'][0]->getNomImage() . '"></div>';
}
$content .= '</div>
        <div class="col-md-7 flex-grow-1">';
        $content .= '<div class="card rounded-card text-dark mb-3">
        <div class="card-body">
        <h3 class="display-4">' . $super_artist['Artist']->getNomArtiste() . '</h3>
        <p class="lead">' . $super_artist['Artist']->getDescriptionArtiste() . '</p>';
        for($i = 0; $i < floor($super_artist['Note'] ?? 0); $i++) {
            $content .= '<i class="bi bi-star-fill" style="font-size: 2em;"></i>';
        }
        if($super_artist['Note'] - floor($super_artist['Note'] ?? 0) > 0) {
            $content .= '<i class="bi bi-star-half" style="font-size: 2em;"></i>';
            $i++;   
        }
        for(; $i < 5; $i++) {
            $content .= '<i class="bi bi-star" style="font-size: 2em;"></i>';
        }
        $content .= '<i class="" style="font-size: 2em;"> ('.strval($super_artist['NbNotes']).')</i>';
$content .= '</div></div>';
$content .= '</div></div>';
$content .= "<h3 class='display-5 text-white'>Albums</h3>";
$content .= '</div></div>';
$content .= "<div class='row justify-content-center'>";
$i = 0;
foreach ($super_artist['Albums'] as $album) {
    if ($i % 5 == 0 && $i != 0) {
        $content .= "</div><div class='row justify-content-center'>";
    }
    $content .= "<div class='col-lg-2 mb-5 d-flex justify-content-center'>";
    $content .= "<a href='/album/" . $album['Album']->getIdAlbum() . "' class='text-decoration-none text-dark'>";
    $content .= "<div class='card rounded-card album'>";
    if ($album['Image']) {
        $content .= "<img class='card-img-top' src='data:image/jpeg;base64," . utf8_decode($album['Image'][0]->getDataImage()) . "' alt='" . $album['Image'][0]->getNomImage() . "'>";
    }
    $content .= "<div class='card-body d-flex flex-column justify-content-center align-items-center text-center'>";
    $content .= "<h5 class='card-title fs-4'>" . $album['Album']->getNomAlbum() . "</h5>";
    $content .= "<p class='card-text fs-6'>" . $super_artist['Artist']->getNomArtiste() . '</p>';
    $content .= "</div>";
    $content .= "</div>";
    $content .= "</a>";
    $content .= "</div>";
    $i++;
}
$content .= "</div>";
return $content;
?>