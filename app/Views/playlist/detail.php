<?php
$content = '<div class="container mb-3 rounded">
    <div class="row">
        <div class="col-md-4">
        <div class="card rounded-card mb-3">';
        if (count($super_playlist['Images']) > 0) {
            $count = 0;
            $content .= '<div class="row first-row">';
            foreach ($super_playlist['Images'] as $image) {
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
                $content .= "<img src='data:image/jpeg;base64," . utf8_decode($super_playlist['Images'][0][0]->getDataImage()) . "' class='card-img-top small-image' alt='...'>";
                $content .= '</div>';
            }
            $content .= '</div>';
        }
$content .= '</div></div>
        <div class="col-md-7 flex-grow-1">
        <div class="card rounded-card text-dark mb-3">
        <div class="card-body">
        <h3 class="display-4">' . $super_playlist['Playlist']->getNomPlaylist() . '</h3>
        <p class="lead">' . $super_playlist['Playlist']->getDescriptionPlaylist() . '</p>';
$content .= '</div>';
$content .= '<a href="/playlist/' . $super_playlist['Playlist']->getIdPlaylist() . '/edit" class="btn btn-primary rounded-pill">Modifier</a>';
$content .= '</div></div>
    <div class="row mt-4">
        <h3 class="display-5 text-white">Titres</h3>
        <div class="col-md-12 scrollable mb-3 rounded pr-5 pl-5">';
        foreach ($super_playlist['Musiques'] as $musique) {
            $content .= '<div class="card rounded-card text-dark mr-3 flex-grow-1 mb-3 mt-3">
                    <div class="card-body row">
                            <div class="col-md-2 no-padding">
                                <img src="data:image/jpeg;base64,' . utf8_decode($musique['Image'][0]->getDataImage()) . '" alt="' . $musique['Musique']->getNomMusique() . '" class="img-fluid img-thumbnail small-image">
                            </div>
                            <div class="col-md-8 no-padding">
                                <h5>' . $musique['Musique']->getNomMusique() . '</h5>
                                <p>' . $musique['Musique']->getDescriptionMusique() . '</p>
                            </div>
                            <div class="col text-right d-flex justify-content-end align-items-baseline">
                                <button class="btn btn-primary" value="' . $super_playlist['Playlist']->getIdPlaylist() . ";" . $musique['Musique']->getIdMusique() . '" type="button" aria-expanded="false" onclick="removeMusiqueFromPlaylist(this)">-</button>';
                                $content .= '</div>
                    </div>
                </div>';
        }
$content .= '</div>
    </div>
</div>';
$content .= <<<HTML
<script>
    function removeMusiqueFromPlaylist(button) {
        let idPlaylist = button.value.split(';')[0];
        let idMusique = button.value.split(';')[1];
        fetch('/playlist/' + idPlaylist + '/remove/' + idMusique, {
            method: 'DELETE',
        })
        .then(response => {
            if(response.status === 200) {
                button.parentElement.parentElement.parentElement.remove();
            }
        });
    }
</script>
HTML;
return $content;