<?php


/////////////////////////////////////////////////////////////////

// But : transformer une date francaise en une date anglaise
// Entrée : date francaise (string)
// Sortie : date anglaise (string)
function getEnglishDate($date){
	$membres = explode('/', $date);
	$date = $membres[2].'-'.$membres[1].'-'.$membres[0];
	return $date;
}
// But : transformer une date anglaise en une date francaise
// Entrée : date anglaise (string)
// Sortie : date francaise (string)
function getFrenchDate($date){
	$membres = explode('-',$date);
	$date = $membres[2].'/'.$membres[1].'/'.$membres[0];
	return $date;
}


///////////////////////////////////////////////////////////////////


// But : cryper un mot de passe avec sha256 et un grain de sel
// Entree : mot de passe (string)
// Sortie : mot de passe crypte (string de longueur 64 caractères)
function crypter($password){
	$password .= "2@sdf!Gr@in2Sel";
	return hash("sha256", $password);
}


////////////////////////////////////////////////////////////////////


// But : ajouter une erreur
// Entrée : erreur (String)
// Sortie : $_SESSION["erreur"]
function ajouterErreur($erreur){
	$_SESSION["erreur"] = $erreur;
}
// But : fonction qui affiche les erreurs
// Entree : / ($_SESSION["erreurs"])
// Sortie : Affichage de l'erreur
function afficherErreurs(){
	if (isset($_SESSION["erreur"])){
		$erreur = $_SESSION["erreur"];
		unset($_SESSION["erreur"]);
		echo '<p><img src="image/erreur.svg" alt="Erreur" class="imageSvg"> '.$erreur.'</p>';
	}
}


///////////////////////////////////////////////////////////////////////////////


function redirigerVersLaPageAccueil(){
	echo '<meta http-equiv="refresh" content="0;url=index.php?page=0"/>';
}
function redirigerVersLaPage($page){
	echo '<meta http-equiv="refresh" content="0;url=index.php?page='.$page.'"/>';
}
function redirigerAvecDuree($page, $duree){
	echo '<meta http-equiv="refresh" content="'.$duree.';url=index.php?page='.$page.'"/>';
}



/////////////////////////////////////////////////////////////////////////



// But : fonction qui permet à un utilisateur de se connecter
//Entree : utilisateur (objet personne)
//Sortie : /
function connecter($utilisateur){
	$_SESSION['utilisateur'] = serialize($utilisateur);
}

// But : fonction qui indique si l'utilisateur est connecté
// Entree : /
// Sortie : booleen
function utilisateurEstConnecte(){
	return isset($_SESSION['utilisateur']);
}
// But : fonction qui indique si l'utilisateur n'est pas connecté
// Entree : /
// Sortie : booleen
function utilisateurNEstPasConnecte(){
	return !utilisateurEstConnecte();
}
// But : fonction qui renvoie l'utilisateur
// attention : pas te test pour savoir si l'utilisateur est connecté
// Entree : /
// Sortie : objet personne
function utilisateur(){
	return unserialize($_SESSION["utilisateur"]);
}
// But : déconnecter l'utilisateur de son compte
// Entrée : /
// Sortie : /
function deconnecterUtilisateur(){
	unset($_SESSION["utilisateur"]);?>
	<meta http-equiv="refresh" content="2;url=index.php"/><?php
}





///////////////////////////////////////////////////////////////////////




function afficherStageCandidater($stage){ ?>
	<?php
	$db = new MyPdo();
	$deviseManager = new DeviseManager($db);
	$entrepriseManager = new EntrepriseManager($db);
	$niveauEtudeManager = new NiveauEtudeManager($db);
	$candidatureManager=new CandidatureManager($db);
	$paysManager = new PaysManager($db);

	$devise = $deviseManager->getDevise($stage->getIdDevise());
	$entreprise = $entrepriseManager->getEntreprise($stage->getIdEntreprise());
	$pays = $paysManager->getPays($entreprise->getIdPays());
	?>

	<article class="offre">
		<h2> <?php echo $stage->getTitre() ?> - <?php echo $entreprise->getNom() ?></h2>
		<p> <?php echo $pays->getNomFr()?> - <?php echo $entreprise->getVille() ?> </p>


		<p>Durée : <?php echo $stage->getDureeMin() ?> / <?php echo $stage->getDureeMax() ?> semaines</p>
		<p>Niveau d'étude : de <?php echo $niveauEtudeManager->getNiveauEtude($stage->getIdNiveauEtudeMin())->getNom() ?> à <?php echo $niveauEtudeManager->getNiveauEtude($stage->getIdNiveauEtudeMax())->getNom()?></p>
		<p>Date de début : entre le <?php echo getFrenchDate($stage->getDateDebut()) ?> et le <?php echo getFrenchDate($stage->getDateFin()) ?> </p>
		<p>Gratification : <?php echo $stage->getGratification().' '.$devise->getSymbole().' ('.$devise->getCode().')' ?> /mois</p>


		<p>Description : </p>
		<p class="descriptionStage"><?php echo $stage->getDescription(); ?></p>

		<?php
		if (utilisateurEstConnecte() && utilisateur()->estUnEtudiant()){ ?>
			<br>

			<ul>
				<?php
					if($candidatureManager->getCandidature($stage->getIdStage(),utilisateur()->getIdPersonne())==null){

				?>
					<li><a href="index.php?page=3&numst=<?php echo $stage->getIdStage();?>">Candidater</a></li>
				<?php
			}
			else{
				?>
				<li><a href="index.php?page=48">Voir ma candature</a></li>
				<?php
			}
				?>
			</ul>
		<?php
		} ?>
	</article>
<?php
}


function afficherStage($stage){ ?>
	<?php
	$db = new MyPdo();
	$deviseManager = new DeviseManager($db);
	$entrepriseManager = new EntrepriseManager($db);
	$paysManager = new PaysManager($db);

	$entreprise = $entrepriseManager->getEntreprise($stage->getIdEntreprise());
	$pays = $paysManager->getPays($entreprise->getIdPays());
	$devise = $deviseManager->getDevise($stage->getIdDevise());


	?>

	<article class="proposition">
		<h2> <?php echo $stage->getTitre() ?> - <?php echo $entreprise->getNom() ?></h2>
		<p> <?php echo $pays->getNomFr()?> - <?php echo $entreprise->getVille() ?> </p>


		<p>Durée : <?php echo $stage->getDureeMin() ?> / <?php echo $stage->getDureeMax() ?> semaines</p>
		<p>Date de début : entre le <?php echo getFrenchDate($stage->getDateDebut()) ?> et le <?php echo getFrenchDate($stage->getDateFin()) ?> </p>
		<p>Gratification : <?php echo $stage->getGratification().' '.$devise->getSymbole().' ('.$devise->getCode().')' ?> / mois</p>


		<p>Description : </p>
		<p class="descriptionStage"><?php echo $stage->getDescription(); ?></p>
	</article>
<?php
}

?>
