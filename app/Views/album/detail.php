<?php
$content = '<div class="container mb-3 rounded">
    <div class="row">
        <div class="col-md-4">';
if ($super_album[0]['Image']) {
    $content .= '<div class="card rounded-card mb-3"><img class="card-img-top img-fluid" src="data:image/jpeg;base64,' . utf8_decode($super_album[0]['Image'][0]->getDataImage()) . '" alt="' . $super_album[0]['Image'][0]->getNomImage() . '"></div>';
}
$content .= '</div>
        <div class="col-md-7 flex-grow-1">';
        $content .= '<div class="card rounded-card text-dark mb-3">
        <div class="card-body">
        <h3 class="display-4">' . $super_album[0]['Album']->getNomAlbum() . '</h3>
        <p class="lead">' . $super_album[0]['Album']->getDescriptionAlbum() . '</p>
        <p class="lead">' . $super_album[0]['Artiste'][0]->getNomArtiste() . '</p>
        <p class="lead">' . $super_album[0]['Album']->getAnneeAlbum() . '</p>';
        for($i = 0; $i < floor($super_album[0]['Note'][0] ?? 0); $i++) {
            $content .= '<i class="bi bi-star-fill" style="font-size: 2em;"></i>';
        }
        if($super_album[0]['Note'][0] - floor($super_album[0]['Note'][0] ?? 0) > 0) {
            $content .= '<i class="bi bi-star-half" style="font-size: 2em;"></i>';
            $i++;   
        }
        for(; $i < 5; $i++) {
            $content .= '<i class="bi bi-star" style="font-size: 2em;"></i>';
        }
        $content .= '<i class="" style="font-size: 2em;"> ('.strval($super_album[0]['NbNote'][0]).')</i>';
        $content .= '<div class="d-flex flex-wrap mt-3">';
        foreach($super_album[0]['Genres'] as $genre) {
            $content .= '<div class="alert alert-secondary m-1" role="alert">' . $genre->getNomGenre() . '</div>';
        }
$content .= '</div></div>';
if (isset($_SESSION['artist_id']) && $super_album[0]['Artiste'][0]->getIdArtiste() == $_SESSION['artist_id']) {
    $content .= '<a href="/album/' . $super_album[0]['Album']->getIdAlbum() . '/edit" class="btn btn-primary rounded-pill">Modifier</a>';
}
$content .= '</div></div>
    <div class="row mt-4">
        <h3 class="display-5 text-white">Titres</h3>
        <div class="col-md-12 scrollable mb-3 rounded pr-5 pl-5">';
        foreach ($super_album[0]['Musiques'] as $musique) {
            $content .= '<div class="card rounded-card text-dark mr-3 flex-grow-1 mb-3 mt-3">
                    <div class="card-body row">
                            <div class="col-md-2 no-padding">
                                <img src="data:image/jpeg;base64,' . utf8_decode($musique['Image'][0]->getDataImage()) . '" alt="' . $musique['Musique']->getNomMusique() . '" class="img-fluid img-thumbnail small-image">
                            </div>
                            <div class="col-md-8 no-padding">
                                <h5>' . $musique['Musique']->getNomMusique() . '</h5>
                                <p>' . $musique['Musique']->getDescriptionMusique() . '</p>
                            </div>
                            <div class="col text-right d-flex justify-content-end">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">+</button>
                                    <div class="dropdown-menu detail" aria-labelledby="dropdownMenuButton">';
                                    foreach($super_playlist as $playlist) {
                                        $isInPLaylist = false;
                                        foreach($playlist['Musiques'] as $musiqueInPlaylist) {
                                            if($musiqueInPlaylist->getIdMusique() == $musique['Musique']->getIdMusique()) {
                                                $isInPLaylist = true;
                                                break;
                                            }
                                        }
                                        if(!$isInPLaylist) {
                                            $content .= '<button class="dropdown-item" type="button" value="' . $playlist['Playlist']->getIdPlaylist() . ";" . $musique['Musique']->getIdMusique() . '" onclick="addMusiqueToPlaylist(this)">Ajouter à ' . $playlist['Playlist']->getNomPlaylist() . '</button>';
                                        }
                                        else {
                                            $content .= '<button class="dropdown-item" type="button" value="' . $playlist['Playlist']->getIdPlaylist() . ";" . $musique['Musique']->getIdMusique() . '" onclick="addMusiqueToPlaylist(this)" disabled>Déjà dans ' . $playlist['Playlist']->getNomPlaylist() . '</button>';
                                        }
                                    }
                                    
                                    $content .= '</div>
                            </div>
                    </div>
                    </div>
                </div>';
        }
$content .= '</div>
    </div>
</div>';
$content .= <<<HTML
<script>
    function addMusiqueToPlaylist(button) {
        let idPlaylist = button.value.split(';')[0];
        let idMusique = button.value.split(';')[1];
        fetch('/playlist/' + idPlaylist + '/add/' + idMusique, {
            method: 'PUT',
        })
        .then(response => {
            if(response.status === 200) {
                button.innerText = "Ajouté avec succès";
                button.disabled = true;
            }
        });
    }
</script>
HTML;
return $content;