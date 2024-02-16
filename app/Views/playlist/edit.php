<?php
$content = '<div class="container mb-3 rounded">';
$content .= '<div class="card rounded-card mb-3">';
$content .= '<div class="card-body">';
$content .= '<h3 class="display-4">Modifier la playlist ' . $playlist->getNomPlaylist() . '</h3>';
$content .= '<form action="/playlist/' . $playlist->getIdPlaylist() . '/edit" method="post" class="d-flex flex-column">';
$content .= '<div class="form-group mb-3">';
$content .= '<input type="hidden" name="idPlaylist" value="' . $playlist->getIdPlaylist() . '">';
$content .= '<label for="nomPlaylist">Nom de la playlist</label>';
$content .= '<input type="text" class="form-control" id="nomPlaylist" name="nomPlaylist" value="' . $playlist->getNomPlaylist() . '" required>';
$content .= '<label for="descriptionPlaylist">Description de la playlist</label>';
$content .= '<textarea class="form-control" id="descriptionPlaylist" name="descriptionPlaylist" required>' . $playlist->getDescriptionPlaylist() .  '</textarea>';
$content .= '</div>';
$content .= '<button type="submit" class="btn btn-primary rounded-pill">Valider</button>';
$content .= '</form>';
$content .= '</div>';
$content .= '<div class="card-body d-flex justify-content-center" style="padding-top: 1rem;">';
$content .= '<button class="btn btn-danger rounded-pill" style="width: 100%;">Supprimer</button>';
$content .=  '</div>';
$content .= '</div>';
$content .= '</div>';
$content .= <<<HTML
    <script>
        document.querySelector('button.btn-danger').addEventListener('click', function() {
            let id_playlist = document.querySelector('input[name="idPlaylist"]').value;
            if (confirm('Voulez-vous vraiment supprimer cette playlist ?')) {
                fetch('/playlist/' + id_playlist + '/delete', {
                    method: 'DELETE',
                })
                .then(response => {
                    if(response.status === 200) {
                        window.location.href = '/playlists';
                    }
                });
            }
        });
    </script>
HTML;
return $content;
?>