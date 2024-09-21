<?php
/** @var PdoGsb $pdo */
include 'views/v_sommaire.php';
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];


$action= $_REQUEST['action'];



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
		$repas =htmlspecialchars($_POST['REP']);
		$km =htmlspecialchars ($_POST['KM']);
		$nuites =htmlspecialchars ($_POST['NUI']);
		$etapes =htmlspecialchars ($_POST['ETP']);

		$date = date("Y-m-d");
		$leMois = $pdo->getMoisLigne($annee,$mois);

		
		$rep = $pdo->setRepas($repas,$idVisiteur,$leMois,$date);
		$kmm = $pdo->setKm($km,$idVisiteur,$leMois,$date );
		$nui = $pdo->setNuites($nuites,$idVisiteur,$leMois,$date);
		$etp = $pdo->setEtp($etapes,$idVisiteur,$leMois,$date);

		$justificatif = $pdo -> updtJustificatif($repas, $etapes, $nuites,$km, $etp,$leMois, $idVisiteur);
		$montant = $pdo -> updtMontant($repas, $etapes, $nuites,$km, $etp,$leMois, $idVisiteur);
		

		var_dump($rep);
		var_dump($kmm);
		var_dump($nui);
		var_dump($etp);
	
		include("views/v_accueil.php");
		
		break;
	}
  
	
}




	


