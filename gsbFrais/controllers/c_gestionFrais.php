<?php
/** @var PdoGsb $pdo */
include 'views/v_sommaire.php';
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];


switch ($action) {
    case 'gestionFrais':
    {
		
        
        include("views/v_accueil.php");
		
        break;
    }

	case 'gestionnaireFrais':{

		$idVisiteur = $_SESSION['idVisiteur'];
		$mois = htmlspecialchars($_POST['mois']);
		$annee = htmlspecialchars($_POST['annee']);
		$repas = htmlspecialchars($_POST['REP']);
		$km = htmlspecialchars ($_POST['KM']);
		$nuites = htmlspecialchars ($_POST['NUI']);
		$etapes = htmlspecialchars ($_POST['ETP']);

		$date = date("Y-m-d");
		$leMois = $pdo->getMoisLigne($annee,$mois);

		$rep = 0;
		$kmm = 0;
		$nui = 0;
		$etp = 0;

		// Verifier si le input n'est pas négatif pour chaque champs
	
		if($repas>0){$rep = $pdo->setRepas($repas,$idVisiteur,$leMois,$date);}
		
		if($km>0){$kmm = $pdo->setKm($km,$idVisiteur,$leMois,$date );}
		if($nuites>0){$nui = $pdo->setNuites($nuites,$idVisiteur,$leMois,$date);}
		if($etapes > 0) {$etp= $pdo->setEtp($etapes,$idVisiteur,$leMois,$date);}

		$justificatif = $pdo->updtJustificatif($repas, $etapes, $nuites,$km, $etp,$leMois, $idVisiteur);
		$montant = $pdo -> updtMontant($repas, $etapes, $nuites,$km, $etp,$leMois, $idVisiteur);
		

	
	
		include("views/v_accueil.php");
		
		break;
	}
  
	
}




	


