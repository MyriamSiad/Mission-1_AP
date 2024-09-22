<?php
/**
 * Classe d'accès aux données.

 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO
 * $monPdoGsb qui contiendra l'unique instance de la classe

 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsbfrais';
      	private static $user='root' ;
      	private static $mdp='' ;
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
     * @return null L'unique objet de la classe PdoGsb
     */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;
	}

    /**
     * Retourne les informations d'un visiteur
     * @param $login
     * @param $mdp
     * @return mixed L'id, le nom et le prénom sous la forme d'un tableau associatif
     */
    public function getInfosVisiteur($login, $mdp){
        $req = "select id, nom, prenom from visiteur where login='$login' and mdp='$mdp'";
        $rs = PdoGsb::$monPdo->query($req);
        $ligne = $rs->fetch();
        return $ligne;
    }

    /**
     * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
     
    * @param $madate au format  jj/mm/aaaa
    * @return la date au format anglais aaaa-mm-jj
    */
    public function dateAnglaisVersFrancais($maDate){
        @list($annee,$mois,$jour)=explode('-',$maDate);
        $date="$jour"."/".$mois."/".$annee;
        return $date;
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
     * concernées par les deux arguments
     * La boucle foreach ne peut être utilisée ici, car on procède
     * à une modification de la structure itérée - transformation du champ date-
     * @param $idVisiteur
     * @param $mois 'sous la forme aaaamm
     * @return array 'Tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif
     */
    public function getLesFraisHorsForfait($idVisiteur,$mois){
        $req = "select * from lignefraishorsforfait where idvisiteur ='$idVisiteur' 
		and mois = '$mois' ";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        $nbLignes = count($lesLignes);
        for ($i=0; $i<$nbLignes; $i++){
            $date = $lesLignes[$i]['date'];
            //Gestion des dates
            @list($annee,$mois,$jour) = explode('-',$date);
            $dateStr = "$jour"."/".$mois."/".$annee;
            $lesLignes[$i]['date'] = $dateStr;
        }
        return $lesLignes;
    }


    /**
     * Retourne les mois pour lesquels, un visiteur a une fiche de frais
     * @param $idVisiteur
     * @return array 'Un tableau associatif de clé un mois - aaaamm - et de valeurs l'année et le mois correspondant
     */
    public function getLesMoisDisponibles($idVisiteur){
        $req = "select mois from  fichefrais where idvisiteur ='$idVisiteur' order by mois desc ";
        $res = PdoGsb::$monPdo->query($req);
        $lesMois =array();
        $laLigne = $res->fetch();
        while($laLigne != null)	{
            $mois = $laLigne['mois'];
            $numAnnee =substr( $mois,0,4);
            $numMois =substr( $mois,4,2);
            $lesMois["$mois"]=array(
                "mois"=>"$mois",
                "numAnnee"  => "$numAnnee",
                "numMois"  => "$numMois"
            );
            $laLigne = $res->fetch();
        }
        return $lesMois;
    }

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donn�
     * @param $idVisiteur
     * @param $mois 'sous la forme aaaamm
     * @return mixed 'Un tableau avec des champs de jointure entre une fiche de frais et la ligne d'�tat
     */
    public function getLesInfosFicheFrais($idVisiteur,$mois){
        $req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs, 
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id 
			where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne;
    }

   
   
   /****************************************************
    * 
    *                           MA PARTIE DE CODE 
    *
    *
    *
    *****************************************************/
   
   
   
   
   
    //Fonction permmettant de concaténé les deux unput annee + mois, comme dans la bdd
    
    public function getMoisLigne($annee, $mois)
    {
        // On concate les deux variable int $annee et moi 
        $str = "";
        $str = $annee."".$mois;
        return $str;
    }

    //Fonction pour update la TABLE Fiche Frais pour le Justificatifs 

    public  function updtJustificatif($repas, $etapes,$nuites,$km, $etp,$mois, $idVisiteur)
    {
        $justificatif = 0;
        $justificatif =(int) $etapes + (int)$km + (int)$etp + (int)$nuites;

        $req = "update fichefrais set nbJustificatifs = $justificatif
                where idVisiteur = '$idVisiteur' and mois = '$mois'";

         $res = PdoGsb::$monPdo->query($req);
    }


    // Fonction pour Update la table FicheFRais pour le Montant Valider

    public function  updtMontant($repas, $etapes, $nuites,$km, $etp,$mois, $idVisiteur)
    {
        $montant =((float)$repas * 25.00) + ((float)$nuites * 80.00) + ((float)$km*0.25) + ((float)$etp*110.00);
      

        $req = "update fichefrais set montantValide = '$montant'
                where idVisiteur = '$idVisiteur' and mois = '$mois'";
        
                $res = PdoGsb::$monPdo->query($req);
    }

    // Quantite faite pour les repas 
    public function setRepas($repas,$idVisiteur,$mois,$date)
    {
    
        $str ="";
        $req = "select * from fichefrais where idVisiteur ='$idVisiteur'
        and mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);

        $req2 = "select * from lignefraisforfait where idVisiteur ='$idVisiteur' and mois = '$mois' and idFraisForfait  = 'REP' ";
        $res2 = PdoGsb::$monPdo->query($req2);

        
        if($res->rowCount() == 0 &&  $res2->rowCount() == 0  ){
        $req = "insert  into fichefrais (idVisiteur, mois, dateModif) values ('$idVisiteur','$mois','$date')";
        $res = PdoGsb::$monPdo->query($req);

        $req = "insert  into lignefraisforfait (idVisiteur, mois, quantite, idFraisForfait) values ('$idVisiteur','$mois','$repas', 'REP')";
        $res = PdoGsb::$monPdo->query($req);
        $str = "Votre saisie a bien été prise en compte pour le repas.";
        }

        
        else if ($res->rowCount() > 0 &&  $res2->rowCount() == 0 )
        {

        $req = "insert  into lignefraisforfait (idVisiteur, mois, quantite, idFraisForfait) values ('$idVisiteur','$mois','$repas', 'REP')";
        $res = PdoGsb::$monPdo->query($req);
        $str = "Votre saisie a bien été prise en compte pour le repas.";

        }
  
        else
        {
            $str = "Votre requête n’a pas abouti, une erreur s’est produite. Veuillez contacter les services du Secrétariat.";
        }

        return $str;
    }




        public function setKm($km,$idVisiteur,$mois, $date)
        {
        
            $str = "";
            $req = "select * from fichefrais where idVisiteur ='$idVisiteur'
            and mois = '$mois'";
           
            $res = PdoGsb::$monPdo->query($req);
            $req2 = "select * from lignefraisforfait where idVisiteur ='$idVisiteur'
            and mois = '$mois' and idFraisForfait = 'KM'";
            
            $res2 = PdoGsb::$monPdo->query($req2);


            if($res->rowCount()  == 0 &&  $res2->rowCount() == 0  )
            {
                $req = "insert  into fichefrais (idVisiteur, mois, dateModif) values ('$idVisiteur','$mois','$date')";
                $res = PdoGsb::$monPdo->query($req);
                $req = "insert into lignefraisforfait (idVisiteur, mois,quantite, idFraisForfait) values ('$idVisiteur','$mois','$km','KM')";
    
        
                $res = PdoGsb::$monPdo->query($req);
    
                $str = "Votre saisie a bien été prise en compte pour le nombre de Kilomètres.";

            }
           else  if($res->rowCount() > 0  && $res2->rowCount() == 0)
            {

               
                // Requete INSERT INTO lignefraisForfait si il n'y pas de doublons  
                $req = "insert into lignefraisforfait (idVisiteur, mois,quantite, idFraisForfait) values ('$idVisiteur','$mois','$km','KM')";
    
        
                $res = PdoGsb::$monPdo->query($req);
    
                $str = "Votre saisie a bien été prise en compte pour le nombre de Kilomètres.";
            
    
            }
    
            else
            {
                $str =  "Votre requête n’a pas abouti, une erreur s’est produite. Veuillez contacter les services du Secrétariat.";
            }
            return $str;
        }


           
        public function setEtp($etape,$idVisiteur,$mois,$date)
        {
            $str = "";
        
            $req = "select * from fichefrais where idVisiteur ='$idVisiteur'
            and mois = '$mois'";
            $res = PdoGsb::$monPdo->query($req);
    
            $req2 = "select * from lignefraisforfait where idVisiteur ='$idVisiteur'
            and mois = '$mois' and idFraisForfait = 'ETP'";
            $res2 = PdoGsb::$monPdo->query($req2);

            if($res->rowCount() == 0 &&  $res2->rowCount() == 0  )
            {

                $req = "insert  into fichefrais (idVisiteur, mois, dateModif) values ('$idVisiteur','$mois','$date')";
                $res = PdoGsb::$monPdo->query($req);
                $req = "insert  into lignefraisforfait (idVisiteur, mois,quantite, idFraisForfait) values ('$idVisiteur','$mois','$etape','ETP')";
    
        
                $res = PdoGsb::$monPdo->query($req);
    
                $str = "Votre saisie a bien été prise en compte pour le nombre d'étapes";
            
            }
            else if($res->rowCount() > 0  && $res2->rowCount() == 0)
            {
               
                // Requete INSERT INTO lignefraisForfait si il n'y pas de doublons  
                $req = "insert  into lignefraisforfait (idVisiteur, mois,quantite, idFraisForfait) values ('$idVisiteur','$mois','$etape','ETP')";
    
        
                $res = PdoGsb::$monPdo->query($req);
    
                $str = "Votre saisie a bien été prise en compte pour le nombre d'étapes.";
            
    
            }
    
            else
            {
                $str = "Votre requête n’a pas abouti, une erreur s’est produite. Veuillez contacter les services du Secrétariat.";
            }

            return $str;
        }
        
        public function setNuites($nuites,$idVisiteur,$mois,$date)
        {
            $str ="";
            $req = "select * from fichefrais where idVisiteur ='$idVisiteur'
            and mois = '$mois'";
            $res = PdoGsb::$monPdo->query($req);


            $req2 = "select * from lignefraisforfait where idVisiteur ='$idVisiteur'
            and mois = '$mois' and idFraisForfait = 'NUI'";
            $res2 = PdoGsb::$monPdo->query($req2);

            if($res -> rowCount () == 0 &&  $res2->rowCount() == 0 ) 
            {
                $req = "insert  into fichefrais (idVisiteur, mois, dateModif) values ('$idVisiteur','$mois','$date')";
                $res = PdoGsb::$monPdo->query($req);
                $req = "insert  into lignefraisforfait (idVisiteur, mois,quantite, idFraisForfait) values ('$idVisiteur','$mois','$nuites','NUI')";
    
        
                $res = PdoGsb::$monPdo->query($req);
                $str = "Votre saisie a bien été prise en compte pour le nombre de nuités.";

            }
            else if($res->rowCount() > 0  && $res2->rowCount() == 0)
            {
               
                // Requete INSERT INTO lignefraisForfait si il n'y pas de doublons  
                $req = "insert  into lignefraisforfait (idVisiteur, mois,quantite, idFraisForfait) values ('$idVisiteur','$mois','$nuites','NUI')";
    
        
                $res = PdoGsb::$monPdo->query($req);
    
                $str = "Votre saisie a bien été prise en compte pour le nombre de nuités.";
            
    
            }
    
            else
            {
                $str = "Votre requête n’a pas abouti, une erreur s’est produite. Veuillez contacter les services du Secrétariat.";
            }

            return $str;
        }
        


    }
    
    
