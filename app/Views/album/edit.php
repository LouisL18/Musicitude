<?php
if (isset($_SESSION['artist_id']) && $super_album[0]['Artiste'][0]->getIdArtiste() != $_SESSION['artist_id'] || !isset($_SESSION['artist_id'])) {
    die('Vous n\'avez pas les droits pour modifier cet album');
}
$id = $_SESSION['edit_id'];
$content = <<<HTML
<form action="/album/$id/edit" method="post" class="container mb-3 rounded" enctype="multipart/form-data">
HTML;
$content .= '<div class="row">';
$content .= '<div class="col-md-4">';
if ($super_album[0]['Image']) {
    $content .= '<div class="card rounded-card mb-3">';
    $content .= '<div class="image-container position-relative">
    <img class="card-img-top img-fluid editable-image" src="data:image/jpeg;base64,' . utf8_decode($super_album[0]['Image'][0]->getDataImage()) . '" alt="' . $super_album[0]['Image'][0]->getNomImage() . '" data-toggle="tooltip" data-placement="bottom" title="Double-cliquez pour changer l\'image">
    <input type="file" name="imageAlbum" accept="image/*" style="display: none;">
</div>';
    $content .= '</div>';
}
$content .= '</div>';
$content .= '<div class="col-md-7 flex-grow-1">';
$content .= '<div class="card rounded-card text-dark mb-3">';
$content .= '<div class="card-body">';
$content .= '<h3 class="display-4"><input type="text" name="nomAlbum" value="' . $super_album[0]['Album']->getNomAlbum() . '"></h3>';
$content .= '<p class="lead"><textarea name="descriptionAlbum">' . $super_album[0]['Album']->getDescriptionAlbum() . '</textarea></p>';
$content .= '<p class="lead">' . $super_album[0]['Artiste'][0]->getNomArtiste() . '</p>';
$content .= '<p class="lead"><input type="number" name="anneeAlbum" value="' . $super_album[0]['Album']->getAnneeAlbum() . '" required></p>';

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
$content .= '<div class="d-flex flex-wrap mt-3 overflow-auto p-3 mb-3" style="height: 10vh;">';
foreach($all_genres as $genre) {
    $checked = in_array($genre->getIdGenre(), array_map(function($g) { return $g->getIdGenre(); }, $super_album[0]['Genres'])) ? ' checked' : '';
    $content .= '<div class="alert alert-secondary m-2"><input type="checkbox" name="genres[]" value="' . $genre->getIdGenre() . '"' . $checked . ' class="m-1">' . $genre->getNomGenre() . '</div>';
}
$content .= '</div>';
$content .= '</div>';
$content .= '</div>';
$content .= '</div>';
$content .= '<div class="row mt-4">';
$content .= '<h3 class="display-5 text-white">Titres</h3>';
$content .= '<div class="col-md-12 scrollable mb-3 rounded pr-5 pl-5">';
foreach ($super_album[0]['Musiques'] as $musique) {
    $content .= '<div class="card rounded-card text-dark mr-3 flex-grow-1 mb-3 mt-3">';
    $content .= '<div class="card-body row">';
    $content .= '<input type="hidden" name="musicId[]" value="' . $musique['Musique']->getIdMusique() . '">';
    $content .= '<div class="col-md-2 no-padding">';
    $content .= '<img src="data:image/jpeg;base64,' . utf8_decode($musique['Image'][0]->getDataImage()) . '" alt="' . $musique['Musique']->getNomMusique() . '" class="img-fluid img-thumbnail small-image editable-image" data-toggle="tooltip" data-placement="bottom" title="Double-cliquez pour changer l\'image">';
    $content .= '<input type="file" name="musicImage[]" accept="image/*" style="display: none;">';
    $content .= '</div>';
    $content .= '<div class="col-md-2 no-padding">';
    $content .= '<label for="musicName[]" class="form-label">Titre</label>';
    $content .= '<input type="text" class="form-control" id="musicName[]" name="musicName[]" value="' . $musique['Musique']->getNomMusique() . '" required>';
    $content .= '</div>';
    $content .= '<div class="col-md-3 no-padding">';
    $content .= '<label for="musicDescription[]" class="form-label">Description</label>';
    $content .= '<textarea rows="1" class="form-control" id="musicDescription[]" name="musicDescription[]">' . $musique['Musique']->getDescriptionMusique() . '</textarea>';
    $content .= '</div>';
    $content .=  '<div class="col-md-3 no-padding">';
    $content .= '<label for="musicFile[]" class="form-label">Fichier audio</label>';
    if (isset($musique['Musique']) && $musique['Musique']->getDataMusique() != '' && $musique['Musique']->getDataMusique() != null) {
        $content .= '<audio controls><source src="data:audio/mpeg;base64,' . utf8_decode($musique['Musique']->getDataMusique()) . '" type="audio/mpeg">Your browser does not support the audio element.</audio>';
    }
    $content .= '<input type="file" class="form-control musique" id="musicFile[]" name="musicFile[]" accept="audio/*">';
    $content .= '</div>';
    $content .= '<div class="col-md-1 d-flex no-padding justify-content-center align-items-center">';
    $content .= '<button type="button" class="btn btn-danger delete-music" data-id="' . $musique['Musique']->getIdMusique() . '">Supprimer</button>';
    $content .= '</div>';
    $content .= '</div>';
    $content .= '</div>';
}
$content .= '</div>';
$content .= '</div>';
$content .= '<button type="button" class="btn btn-danger position-fixed delete-album" style="width: auto; bottom: 1vh; left: 1vw;">Supprimer l\'album</button>';
$content .= '<input type="submit" value="Mettre à jour" class="position-fixed btn btn-primary" style="width: auto; bottom: 1vh; right: 1vw;">';
$content .= '</form>';
$content .= <<<HTML
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    document.querySelectorAll(".editable-image").forEach(function(image) {
        var container = image.parentNode;
        var input = container.querySelector("input[type=file]");
        image.addEventListener("dblclick", function() {
            input.click();
        });
        input.addEventListener("change", function() {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
    document.querySelector(".delete-album").addEventListener("click", function() {
        if (confirm("Voulez-vous vraiment supprimer cet album ?")) {
            fetch("/album/$id", {
                method: "DELETE"
            }).then(response => response.status)
            .then(status => {
                if (status === 200) {
                    window.location.href = "/albums";
                }
            });
        }
    });
    document.querySelectorAll(".delete-music").forEach(function(button) {
        button.addEventListener("click", function() {
            if (confirm("Voulez-vous vraiment supprimer cette musique ?")) {
                fetch("/musique/" + button.getAttribute("data-id"), {
                    method: "DELETE"
                }).then(response => response.status)
                .then(status => {
                    if (status === 200) {
                        button.parentNode.parentNode.parentNode.remove();
                    }
                });
            }
        });
    });
    document.addEventListener('play', function(e){
        let audios = document.getElementsByTagName('audio');
        for(let i = 0, len = audios.length; i < len;i++){
            if(audios[i] != e.target){
                audios[i].pause();
                audios[i].currentTime = 0;
            }
        }
    }, true);
</script>';
HTML;
return $content;
?>