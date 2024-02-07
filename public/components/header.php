<?php
if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['artist_id'])) {
        $add_album = '<li><a class="dropdown-item" href="/albums/create">Ajouter un album</a></li>';
    } else {
        $add_album = '';
    }
    $albums_dropdown = <<<HTML
    <ul class="dropdown-menu bg-secondary" aria-labelledby="dropdownMenuLink">
        <li><a class="dropdown-item" href="/albums">Tous les albums</a></li>
        <li><a class="dropdown-item" href="/albums/search">Rechercher des albums</a></li>
        $add_album
    </ul>
    HTML;
    $artists_dropdown = <<<HTML
    <ul class="dropdown-menu bg-secondary" aria-labelledby="dropdownMenuLink">
        <li><a class="dropdown-item" href="/artists">Tous les artistes</a></li>
        <li><a class="dropdown-item" href="/artists/search">Rechercher des artistes</a></li>
    </ul>
    HTML;
    $profile_dropdown = <<<HTML
    <ul class="dropdown-menu bg-secondary" aria-labelledby="dropdownMenuLink">
        <li><a class="dropdown-item" href="/user">Mon profil</a></li>
        <li><a class="dropdown-item" href="#">Modifier mon profil</a></li>
        <li><a class="dropdown-item" href="/logout">Se déconnecter</a></li>
    </ul>
    HTML;
} else {
    $albums_dropdown = '';
    $artists_dropdown = '';
    $profile_dropdown = '';
    $add_album = '';
}
return <<<HTML
<nav class="navbar navbar-expand-lg bg-secondary">
    <div class="container-fluid justify-content-between">
        <div class="dropdown">
            <a class="navbar-brand" href="/albums" role="button" id="dropdownMenuLink" aria-expanded="false">
                <img src="/images/album.png" alt="Album Logo" class="logo">
                <span class="text-dark h3">Albums</span>
            </a>
            $albums_dropdown
        </div>
        <div class="dropdown">
            <a class="navbar-brand" href="/artists" role="button" id="dropdownMenuLink" aria-expanded="false">
                <img src="/images/artist.png" alt="Artiste Logo" class="logo">
                <span class="text-dark h3">Artistes</span>
            </a>
            $artists_dropdown
        </div>
        <a class="navbar-brand" href="/">
            <img src="/images/logo.png" alt="Musicitude Logo" class="logo">
            <span class="text-dark h3">Musicitude</span>
        </a>
        <a class="navbar-brand" href="/playlists">
            <img src="/images/playlist.png" alt="Playlist Logo" class="logo">
            <span class="text-dark h3">Playlists</span>
        </a>
        <div class="dropdown">
            <a class="navbar-brand" href="/user">
                <img src="/images/profile.png" alt="Profile Logo" class="logo">
                <span class="text-dark h3">Profil</span>
            </a>
            $profile_dropdown
        </div>
    </div>
</nav>
HTML;
?>