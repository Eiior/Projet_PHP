<?php
require('../bd/ConnexionBD.php');

// Vérifier si l'ID du joueur et l'ID du match sont fournis
if (isset($_GET['id']) && isset($_GET['id_match'])) {
    $id = $_GET['id'];
    $id_match = $_GET['id_match'];

    // Préparer la requête pour récupérer les données du joueur
    $stmt = $linkpdo->prepare('SELECT * FROM Joueur WHERE Numero_licence = ?');
    $stmt->execute([$id]);
    $joueur = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si aucun joueur n'est trouvé
    if (!$joueur) {
        die('Joueur introuvable.');
    }

    // Préparer la requête pour récupérer l'évaluation du joueur dans la table Participer
    $stmt = $linkpdo->prepare('SELECT Evaluation FROM Participer WHERE Numero_licence = ? AND Id_Match = ?');
    $stmt->execute([$id, $id_match]);
    $evaluation = $stmt->fetch(PDO::FETCH_ASSOC);

    // Mise à jour de l'évaluation si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $nouvelle_eval = trim($_POST['Evaluation']);

        if ($nouvelle_eval === '' || !is_numeric($nouvelle_eval)) {
            die('Erreur : Champs invalides ou incomplets.');
        }

        $stmt = $linkpdo->prepare('UPDATE Participer SET Evaluation = ? WHERE Numero_licence = ? AND Id_Match = ?');
        $stmt->execute([$nouvelle_eval, $id, $id_match]);

        // Redirection après succès
        header('Location: FicheMatch.php?id=' . $id_match);
        exit;
    }
} else {
    die('ID joueur ou match non fourni.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/FicheEvaluation.css" rel="stylesheet">
    <title>Fiche Evaluation</title>
</head>
<body>

<h1>Fiche d'évaluation de <?= htmlspecialchars($joueur['Prenom']) . ' ' . htmlspecialchars($joueur['Nom']); ?></h1>

<div><a class="fiche-match" href="FicheMatch.php?id=<?= urlencode($id_match); ?>">Retour</a></div>

<div class="photo-container">
    <img src="<?= htmlspecialchars($joueur['Photo'] ?? 'placeholder.png'); ?>" alt="Photo du joueur" class="photo">
</div>

<p><strong>Nom :</strong> <?= htmlspecialchars($joueur['Nom']); ?></p>
<p><strong>Prénom :</strong> <?= htmlspecialchars($joueur['Prenom']); ?></p>

<form method="POST">
    <label>Evaluation : <br>
        <input type="number" step="1" name="Evaluation" value="<?= htmlspecialchars($evaluation['Evaluation'] ?? 0); ?>" min="0" max="5">
    </label><br>
    <button type="submit" name="update">Enregistrer</button>
</form>


<div>
    <a href="FicheJoueur.php?id=<?= urlencode($id); ?>" class="btn fiche-joueur">Voir la fiche du joueur</a>
</div>

</body>
</html>
