<?php
require 'database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    //on initialise nos messages d'erreurs; 
    $titreError = '';
    $auteurError = '';
    $paragrapheError = '';
    $prixError = '';
    $imageError = '';
     // on recupère nos valeurs 
    $titre = htmlentities(trim($_POST['titre']));
    $auteur = htmlentities(trim($_POST['auteur']));
    $paragraphe = htmlentities(trim($_POST['paragraphe']));
    $prix = htmlentities(trim($_POST['prix']));
    $image = htmlentities(trim($_POST['image']));
    // on vérifie nos champs
    $valid = true;
    if (empty($titre)) {
        $titreError = 'Please enter Titre';
        $valid = false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $titre)) {
        $titreError = "Only letters and number ";
    }
    if (empty($auteur)) {
        $auteurError = 'Please enter auteur';
        $valid = false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $auteur)) {
        $nameError = "Only letters and white space allowed";
    }
    if (empty($paragraphe)) {
        $paragrapheError = 'Please enter paragraphe Address';
        $valid = false;
    } 
    
    if (empty($prix)) {
        $prixError = 'Please enter phone';
        $valid = false;
    } else if (!preg_match("[0.00-9999.99/", $prix)) {
        $telError = 'Please enter a valid phone';
        $valid = false;
    }


    
    // si les données sont présentes et bonnes, on se connecte à la base 
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO user (name, auteur, age, tel, email, pays,comment, metier, url) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($name, $auteur, $age, $tel, $email, $pays, $comment, $metier, $url));
        Database::disconnect();
        header("Location: index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <h3>Ajouter un contact</h3>
        </div>

        <form method="post" action="add.php">        
        <div class="control-group">
                <?php echo !empty($titreError) ? 'error' : ''; ?>
                <label class="control-label">firstname</label>
                <div class="controls">
                    <input type="text" name="titre" value="<?php echo !empty($titre) ? $titre : ''; ?>">
                    <?php if (!empty($titreError)) : ?>
                        <span class="help-inline"><?php echo $titreError; ?></span>
                    <?php endif; ?>
                    <?= var_dump($titre); ?>
                </div>
            </div>

        <div class="control-group <?php echo !empty($auteurError) ? 'error' : ''; ?>">
                <label class="control-label">Auteur</label>
                <div class="controls">
                    <input name="auteur" type="text" placeholder="Auteur" value="<?php echo !empty($auteur) ? $auteur : ''; ?>">
                    <?php if (!empty($auteurError)) : ?>
                        <span class="help-inline"><?php echo $auteurError; ?></span>
                    <?php endif; ?>
                </div>
                <?= var_dump($name); ?>
            </div>

           

            <div class="control-group">
                <?php echo !empty($ageError) ? 'error' : ''; ?>
                <label class="control-label">age</label>
                <div class="controls">
                    <input type="text" name="age" value="<?php echo !empty($age) ? $age : ''; ?>">
                    <?php if (!empty($ageError)) : ?>
                        <span class="help-inline">
                            <?php echo $ageError; ?>
                        </span>
                    <?php endif; ?>
                    <?= var_dump($age); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo !empty($emailError) ? 'error' : ''; ?>
                <label class="control-label">Email Address</label>
                <div class="controls">
                    <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email) ? $email : ''; ?>">
                    <?php if (!empty($emailError)) : ?>
                        <span class="help-inline">
                            <?php echo $emailError; ?>
                        </span>
                    <?php endif; ?>
                    <?= var_dump($email); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo !empty($telError) ? 'error' : ''; ?>
                <label class="control-label">Telephone</label>
                <div class="controls">
                    <input name="tel" type="tel" placeholder="Telephone" value="<?php echo !empty($tel) ? $tel : ''; ?>">
                    <?php if (!empty($telError)) : ?>
                        <span class="help-inline"><?php echo $telError; ?></span>
                    <?php endif; ?>
                    <?= var_dump($tel); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo !empty($paysError) ? 'error' : ''; ?>
                <select name="pays">
                    <option value="paris">Paris</option>
                    <option value="londres">Londres</option>
                    <option value="amsterdam">Amsterdam</option>
                </select>
                <?php if (!empty($paysError)) : ?>
                    <span class="help-inline">
                        <?php echo $paysError; ?>
                    </span>
                <?php endif; ?>
                <?= var_dump($pays); ?>
            </div>

            <div class="control-group">
                <?php echo !empty($metierError) ? 'error' : ''; ?>
                <label class="checkbox-inline">Metier</label>
                <div class="controls">
                    Dev :
                    <input type="radio" name="metier" value="dev" <?= (isset($metier) && $metier == "dev" ||  empty($metier)) ? "checked" : "" ?>>

                    Integrateur:
                    <input type="radio" name="metier" value="integrateur" <?= (isset($metier) && $metier == "integrateur") ? "checked" : "" ?>>

                    Reseau:
                    <input type="radio" name="metier" value="reseau" <?= (isset($metier) && $metier == "reseau") ? "checked" : "" ?>>

                </div>
                <?php if (!empty($metierError)) : ?>
                    <span class="help-inline">
                        <?php echo $metierError; ?>
                    </span>
                <?php endif; ?>
                <?= var_dump($metier); ?>
            </div>

            <div class="control-group">
                <?php echo !empty($urlError) ? 'error' : ''; ?>
                <label class="control-label">Siteweb</label>
                <div class="controls">
                    <input type="text" name="url" value="<?php echo !empty($url) ? $url : ''; ?>" <?php if (!empty($urlError)) : ?> <span class="help-inline">
                    <?php echo $urlError; ?>
                    </span>
                <?php endif; ?>
                <?= var_dump($url); ?>
                </div>

            </div>

            <div class="control-group">
                <?php echo !empty($commentError) ? 'error' : ''; ?>
                <label class="control-label">Commentaire</label>
                <div class="controls">
                    <textarea rows="4" cols="30" name="comment">
                            <?php if (isset($comment)) echo $comment; ?>
                        </textarea>
                    <?php if (!empty($commentError)) : ?>
                        <span class="help-inline">
                            <?php echo $commentError; ?>
                        </span>
                    <?php endif; ?>
                    <?= var_dump($comment); ?>
                </div>
            </div>

            <div class="form-actions">
                <input type="submit" class="btn btn-success" name="submit" value="submit">
                <a class="btn" href="index.php">Retour</a>
            </div>
        </form>
    </div>
</body>

</html>