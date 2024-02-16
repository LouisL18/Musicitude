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
            $content .= '<i class="bi bi-star-fill star" style="font-size: 2em;" data-rating="'.($i+1).'" onclick="rate(this)" onmouseover="highlight(this)" onmouseout="unhighlight(this)"></i>';
        }
        if($super_album[0]['Note'][0] - floor($super_album[0]['Note'][0] ?? 0) > 0) {
            $content .= '<i class="bi bi-star-half star" style="font-size: 2em;" data-rating="'.($i+1).'" onclick="rate(this)" onmouseover="highlight(this)" onmouseout="unhighlight(this)"></i>';
            $i++;   
        }
        for(; $i < 5; $i++) {
            $content .= '<i class="bi bi-star star" style="font-size: 2em;" data-rating="'.($i+1).'" onclick="rate(this)" onmouseover="highlight(this)" onmouseout="unhighlight(this)"></i>';
        }
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
                            <div class="col-md-3 no-padding">
                                <h5>' . $musique['Musique']->getNomMusique() . '</h5>
                                <p>' . $musique['Musique']->getDescriptionMusique() . '</p>
                            </div>
                            <div class="col-md-6 p-0 d-flex align-items-center">
                                <audio controls class="w-100">
                                    <source src="data:audio/mpeg;base64,' . utf8_decode($musique['Musique']->getDataMusique()) . '" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
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
    function rate(star) {
        fetch('/album/' + {$super_album[0]['Album']->getIdAlbum()} + '/note/' + star.getAttribute('data-rating'), {
            method: 'POST',
        })
        .then(response => {
            if(response.status === 200) {
                location.reload();
            }
        });
    }
    function highlight(star) {
        let stars = Array.from(document.querySelectorAll('.star')).reverse();
        let highlight = false;
        stars.forEach(function(s) {
            if (s === star) {
                highlight = true;
            }
            if (highlight) {
                s.classList.add('highlighted');
            } else {
                s.classList.remove('highlighted');
            }
        });
    }
    function unhighlight(star) {
        let stars = document.querySelectorAll('.star');
        stars.forEach(function(s) {
            s.classList.remove('highlighted');
        });
    }
    document.addEventListener('play', function(e){
        let audios = document.getElementsByTagName('audio');
        for(let i = 0, len = audios.length; i < len;i++){
            if(audios[i] != e.target){
                audios[i].pause();
                audios[i].currentTime = 0;
            }
        }
    }, true);
</script>
HTML;
return $content;