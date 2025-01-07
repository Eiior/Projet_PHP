<?php
require('../bd/ConnexionBD.php');

$stmt = $linkpdo->query('SELECT Numero_licence, Nom, Prenom, Statut, photo FROM Joueur');
$joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/GestionJoueurs.css" rel="stylesheet">
    <title>Gestion des Joueurs</title>
</head>
<body>

<header>Mes joueurs</header>

<a href="AjouterJoueurs.php" class="btn btn-ajouter">+ Ajouter un joueur</a>

<table>
    <thead>
        <tr>
            <th>Photo</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($joueurs as $joueur): ?>
        <tr>
            <td>
                <img src="<?= htmlspecialchars($joueur['photo'] ?? 'placeholder.png'); ?>" class="photo">
            </td>
            <td><?= htmlspecialchars($joueur['Nom'] ?? 'Inconnu'); ?></td>
            <td><?= htmlspecialchars($joueur['Prenom'] ?? 'Inconnu'); ?></td>
            <td><?= htmlspecialchars($joueur['Statut'] ?? 'Non défini'); ?></td>
            <td>
                <a href="FicheJoueur.php?id=<?= $joueur['Numero_licence']; ?>" class="btn">Voir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Lien pour revenir à la page principale -->
<a href="PageAccueil.php" class="btn btn-return">Retour à l'accueil</a>

</body>
</html>
