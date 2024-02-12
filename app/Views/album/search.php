<?php
$content = '<div class="container mb-5">
<form method="post" class="mb-1" action="/albums">
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" name="search" value="' . htmlspecialchars($filters['search']) . '" placeholder="Rechercher un album...">
        </div>
        <div class="col-auto">
            <input type="submit" class="btn btn-primary" value="Rechercher">
        </div>
    </div>';
$content .= '
<details class="text-white">
    <summary style="text-align: right;" class="text-decoration-none text-white">Recerche avancée</summary>
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="genre" class="form-label">Par genre</label>
                    <select class="form-select" name="genre">
                        <option value="">Sélectionner un genre...</option>';

foreach ($genres as $genre) {
    $content .= '<option value="' . htmlspecialchars($genre->getIdGenre()) . '"' . ($filters['genre'] == $genre->getIdGenre() ? ' selected' : '') . '>' . htmlspecialchars($genre->getNomGenre()) . '</option>';
}
$content .= '</select>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="artist" class="form-label">Par artiste</label>
                    <select class="form-select" name="artist">
                        <option value="">Sélectionner un artiste...</option>';
foreach ($artists as $artist) {
    $content .= '<option value="' . htmlspecialchars($artist->getIdArtiste()) . '"' . ($filters['artist'] == $artist->getIdArtiste() ? ' selected' : '') . '>' . htmlspecialchars($artist->getNomArtiste()) . '</option>';
}
$content .= '</select>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="year" class="form-label">Par année</label>
                    <select class="form-select" name="year">
                        <option value="">Sélectionner une année...</option>';
foreach ($years as $year) {
    $content .= '<option value="' . htmlspecialchars(strval($year[0])) . '"' . ($filters['year'] == strval($year[0]) ? ' selected' : '') . '>' . htmlspecialchars(strval($year[0])) . '</option>';
}
$content .= '</select>
                </div>
            </div>
        </div>
</details>
</form>
</div>';

return $content;
?>