<?php
$content = '<div class="container mb-3 rounded">';
$content .= '<form method="post" action="/album/create" enctype="multipart/form-data">';
$content .= '<div class="row">';
$content .= '<div class="col-md-4">';
$content .= '<div class="mb-3 card rounded-card">';
$content .= '<div class="image-container position-relative">';
$content .= '<input type="file" class="form-control" id="imageAlbum" name="imageAlbum" accept="image/*" required onchange="previewImage(event, this)">';
$content .= '<img id="preview" class="card-img-top img-fluid" src="" alt="Image de l\'album">';
$content .= '</div>';
$content .= '</div>';
$content .= '</div>';
$content .= '<div class="col-md-7 flex-grow-1">';
$content .= '<div class="card rounded-card text-dark mb-3">';
$content .= '<div class="card-body">';
$content .= '<div class="mb-3">';
$content .= '<label for="nomAlbum" class="form-label">Nom de l\'album</label>';
$content .= '<input type="text" class="form-control" id="nomAlbum" name="nomAlbum" required>';
$content .= '</div>';
$content .= '<div class="mb-3">';
$content .= '<label for="descriptionAlbum" class="form-label">Description de l\'album</label>';
$content .= '<textarea class="form-control" id="descriptionAlbum" name="descriptionAlbum" required></textarea>';
$content .= '</div>';
$content .= '<div class="mb-3">';
$content .= '<label for="anneeAlbum" class="form-label">Année de l\'album</label>';
$content .= '<input type="number" class="form-control" id="anneeAlbum" name="anneeAlbum" required>';
$content .= '</div>';
$content .= '<div class="mb-3">';
$content .= '<label for="idGenre" class="form-label">Genres</label>';
$content .= '<div class="d-flex flex-wrap mt-3 overflow-auto p-3 mb-3" style="height: 10vh;">';
foreach($all_genres as $genre) {
    $content .= '<div class="alert alert-secondary m-2"><input type="checkbox" name="genres[]" value="' . $genre->getIdGenre() . '" class="m-1">' . $genre->getNomGenre() . '</div>';
}
$content .= '</div>';
$content .= '</div>';
$content .= '</div>';
$content .= '</div>';
$content .= '</div>';
$content .= '<div class="row mt-4 align-items-center">';
$content .= '<div class="col">';
$content .= '<h3 class="display-5 text-white">Ajouter des titres</h3>';
$content .= '</div>';
$content .= '<div class="col-auto">';
$content .= '<button type="button" class="btn btn-primary" onclick="addMusic()" id="addMusic">Ajouter</button>';
$content .= '</div>';
$content .= '</div>';
$content .= '<div class="col-md-12 scrollable mb-3 rounded pr-5 pl-5" id="musicList">';
$content .= '<div class="card rounded-card text-dark mr-3 flex-grow-1 mb-3 mt-3">';
$content .= '<div class="card-body row">';
$content .= '<div class="col-md-3 no-padding">';
$content .= '<label for="musicImage[]" class="form-label">Image</label>';
$content .= '<input type="file" class="form-control" id="musicImage[]" name="musicImage[]" accept="image/*">';
$content .= '</div>';
$content .= '<div class="col-md-4 no-padding">';
$content .= '<label for="musicName[]" class="form-label">Titre</label>';
$content .= '<input type="text" class="form-control" id="musicName[]" name="musicName[]">';
$content .= '</div>';
$content .= '<div class="col-md-4 no-padding">';
$content .= '<label for="musicDescription[]" class="form-label">Description</label>';
$content .= '<textarea class="form-control" id="musicDescription[]" name="musicDescription[]"></textarea>';
$content .= '</div>';
$content .= '<div class="col-md-1 d-flex no-padding">';
$content .= '<button type="button" class="btn btn-danger" onclick="deleteMusic(this)">Supprimer</button>';
$content .= '</div>';
$content .= '</div>';
$content .= '</div>';
$content .= '</div>';
$content .= '</div>';
$content .=  '<input type="submit" value="Créer l\'album" class="position-fixed btn btn-primary" style="bottom: 1vh; right: 1vw;">';
$content .= '</form>';
$content .= '</div>';
$content .= '<script>
function previewImage(event, input) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById("preview");
        output.src = reader.result;
        input.style.display = "none";
    };
    reader.readAsDataURL(event.target.files[0]);
}
window.onload = function() {
    function addMusic() {
        var musicList = document.getElementById("musicList");
        var newMusic = musicList.children[0].cloneNode(true);
        newMusic.querySelector("input[type=text]").value = "";
        newMusic.querySelector("textarea").value = "";
        newMusic.querySelector("input[type=file]").value = "";
        musicList.appendChild(newMusic);
    }
    document.getElementById("addMusic").addEventListener("click", addMusic);
}
function deleteMusic(button) {
    if (document.getElementById("musicList").children.length === 1) {
        return;
    }
    var selectedMusic = button.parentNode.parentNode.parentNode;
    selectedMusic.parentNode.removeChild(selectedMusic);
}
</script>';

return $content;
?>