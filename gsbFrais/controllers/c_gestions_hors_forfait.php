<?php
/** @var PdoGsb $pdo */
include 'views/v_sommaire.php';
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];


switch ($action) {
    case 'gestionhorsFrais':
    {
        $libelle = $pdo->libelle_hors_forfait();
        var_dump($libelle);
        
        include("views/v_horsforfait.php");
		
        break;
    }

	case 'gestionnairehorsfrais':{
        var_dump("hello");
        $libelle = $pdo->libelle_hors_forfait(); 
		$idVisiteur = $_SESSION['idVisiteur'];
		$mois = htmlspecialchars($_POST['mois']);
		$annee = htmlspecialchars($_POST['annee']);
		$libellee = htmlspecialchars($_POST['libelle']);
        $montant = htmlspecialchars($_POST['montant']);

		$date = date("Y-m-d");
		$leMois = $pdo->getMoisLigne($annee,$mois);

		//$libelle = "";


      $inserer = $pdo -> fraisHorsForfait($idVisiteur, $mois, $date,$libelle,$montant);
      
		// Verifier si le input n'est pas négatif pour chaque champs
	
		/*if($repas>0){$rep = $pdo->setRepas($repas,$idVisiteur,$leMois,$date);}
		
		if($km>0){$kmm = $pdo->setKm($km,$idVisiteur,$leMois,$date );}
		if($nuites>0){$nui = $pdo->setNuites($nuites,$idVisiteur,$leMois,$date);}
		if($etapes > 0) {$etp= $pdo->setEtp($etapes,$idVisiteur,$leMois,$date);}

		$justificatif = $pdo->updtJustificatif($repas, $etapes, $nuites,$km, $etp,$leMois, $idVisiteur);
		$montant = $pdo -> updtMontant($repas, $etapes, $nuites,$km, $etp,$leMois, $idVisiteur);
		
*/
	
	
		include("views/v_horsforfait.php");
		
		break;
	}
  
	
}



