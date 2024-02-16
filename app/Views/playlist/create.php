<?php
$content = '<div class="container mb-3 rounded">';
$content .= '<div class="card rounded-card mb-3">';
$content .= '<div class="card-body">';
$content .= '<h3 class="display-4">Créer une playlist</h3>';
$content .= '<form action="/playlist/create" method="post" class="d-flex flex-column">';
$content .= '<div class="form-group mb-3">';
$content .= '<label for="nomPlaylist">Nom de la playlist</label>';
$content .= '<input type="text" class="form-control" id="nomPlaylist" name="nomPlaylist" required>';
$content .= '<label for="descriptionPlaylist">Description de la playlist</label>';
$content .= '<textarea class="form-control" id="descriptionPlaylist" name="descriptionPlaylist" required></textarea>';
$content .= '</div>';
$content .= '<button type="submit" class="btn btn-primary rounded-pill">Créer</button>';
$content .= '</form>';
$content .= '</div>';
$content .= '</div>';
$content .= '</div>';
return $content;
?>