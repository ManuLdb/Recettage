<?php
require('../fpdf.php');
require('../tfpdf.php');
require('../config/db.php');
require('../config/session.php');





class PDF extends FPDF
{
function Header()
{

	global $titre;
	global $entreprise;
	global $img;


	$this->Image("../$img",10,6,30);


	$this->SetFont('Arial','B',20);
	// Calcul de la largeur du titre et positionnement
	$w = $this->GetStringWidth($titre)+6;
	$this->SetX((210-$w)/2);
	// Couleurs du cadre, du fond et du texte
	$this->SetDrawColor(0,0,0);
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	// Epaisseur du cadre (1 mm)
	$this->SetLineWidth(0);
	// Titre
	$this->Cell($w,9,$titre,1,1,'C',true);
	// Saut de ligne
	$this->Ln(10);
	$this->SetFont('Arial','',14);
	// Couleur de fond
	// Titre
	$this->Cell(40,10,$entreprise);
	// Saut de ligne
	$this->Ln(20);
}

function Footer()
{
	// Positionnement � 1,5 cm du bas
	$this->SetY(-15);
	// Police Arial italique 8
	$this->SetFont('Arial','I',8);
	// Num�ro de page
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function TitreChapitre($num, $libelle)
{
	// Arial 12
	$this->SetFont('Arial','B',16);
	// Couleur de fond
	// Titre
	$this->Cell(0,6,"$num - $libelle",0,"L");
	// Saut de ligne
	$this->Ln(10);
	// Arial 12


}

function CorpsChapitre($fichier, $contenu, $contenu2, $titre1, $titre2)
{




	// Lecture du fichier texte
	$txt = file_get_contents($fichier);
	// Times 12
	$this->SetFont('Times','',12);
	// Sortie du texte justifi�
	$this->MultiCell(0,5,$txt);
	// Saut de ligne
	$this->Ln();
	// Arial 12




	$this->SetFont('Arial','B',14);
	// Couleur de fond
	// Titre
	$this->Cell(0,6,"$titre1",0,"L");
	// Saut de ligne
	$this->Ln(15);
	// Arial 12

	$this->SetFont('Arial','',16);

	$this->MultiCell(0,5,$contenu);
	// Saut de ligne
	$this->Ln(20);

	$this->SetFont('Arial','B',14);
	// Couleur de fond
	// Titre
	$this->Cell(0,6,"$titre2",0,"L");
	// Saut de ligne
	$this->Ln(15);
	$this->SetFont('Arial','',16);
	// Couleur de fond
	// Titre
	$this->MultiCell(0,5,$contenu2);
	// Saut de ligne
	$this->Ln(10);
	// Arial 12





}

function AjouterChapitre($num, $titre, $titre1, $contenu, $titre2, $contenu2, $fichier)
{
	$this->AddPage();
	$this->TitreChapitre($num,$titre);
	$this->CorpsChapitre($fichier, $contenu, $contenu2, $titre1, $titre2);
}
}



$pdf = new PDF();

$id = $_GET['id'];
$variable= $db->query("SELECT path FROM image WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$img = $data['path'];


}
$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, titre, author_id FROM recette WHERE id = $id" );
while($data =$variable->fetch()) {

	$titre = $data['titre'];

}
$pdf->SetTitle($titre);
$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, titre FROM entreprise WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$entreprise = $data['titre'];
	$entreprise = nl2br($entreprise);
	$entreprise = str_replace("<br />", "\n", $entreprise);

}
$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, titre FROM pitch WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$pitch = $data['titre'];
	$pitch = nl2br($pitch);
	$pitch = str_replace("<br />", "\n", $pitch);

}
$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, titre FROM brief WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$brief = $data['titre'];
	$brief = nl2br($brief);
	$brief = str_replace("<br />", "\n", $brief);
}
$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, titre FROM smart WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$smart = $data['titre'];
	$smart = nl2br($smart);
	$smart = str_replace("<br />", "\n", $smart);

}
$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, titre FROM equipe WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$equipe = $data['titre'];
	$equipe = nl2br($equipe);
	$equipe = str_replace("<br />", "\n", $equipe);
}
$variable->closeCursor();
$id = $_GET['id'];
$variable= $db->query("SELECT id, titre, bool FROM process WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$process = $data['titre'];
	$process = nl2br($process);
	$process = str_replace("<br />", "\n", $process);
	$bool = $data['bool'];
	$bool = nl2br($bool);
	$bool = str_replace("<br />", "\n", $bool);
}
$variable->closeCursor();

$variable->closeCursor();
$id = $_GET['id'];
$variable= $db->query("SELECT nom, chemin FROM gantt WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$Path = $data['chemin'];
	$gantt = $data['nom'];


}
$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, resume, date FROM reunion WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$resume = $data['resume'];
	$resume = nl2br($resume);
	$resume = str_replace("<br />", "\n", $resume);
	$date = $data['date'];

}

$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, name FROM mdp WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$mdp = $data['name'];
	$mdp = nl2br($mdp);
	$mdp = str_replace("<br />", "\n", $mdp);


}


$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, name FROM risque WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$risque = $data['name'];
	$risque = nl2br($risque);
	$risque = str_replace("<br />", "\n", $risque);


}
$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, name FROM solution WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$solution = $data['name'];
	$solution = nl2br($solution);
	$solution = str_replace("<br />", "\n", $solution);


}
$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, titre, bool FROM matrice WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$matrice = $data['titre'];
	$matrice = nl2br($matrice);
	$matrice = str_replace("<br />", "\n", $matrice);
	$bool = $data['bool'];

}
$variable->closeCursor();

$id = $_GET['id'];
$variable= $db->query("SELECT id, name FROM recettage WHERE recette_id = $id" );
while($data =$variable->fetch()){


	$feuille = $data['name'];
	$feuille = nl2br($feuille);
	$feuille = str_replace("<br />", "\n", $feuille);


}
$variable->closeCursor();



$pdf->AliasNbPages();
$pdf->AjouterChapitre(1,'Pitch et brief','Pitch :',utf8_decode($pitch),'Brief :',utf8_decode($brief));
$pdf->AjouterChapitre(2,'Cdc fonctionnel','oui','20k_c1.txt');
$pdf->AjouterChapitre(3,'Objectifs projet','', utf8_decode($smart));
$pdf->AjouterChapitre(4,'Equipe projet','',utf8_decode($equipe));
$pdf->AjouterChapitre(5,'Process et outils','',utf8_decode($process),utf8_decode('Test validé :'),utf8_decode($bool));
$pdf->AjouterChapitre(6,'Organisation projet','Planning de Gantt',$gantt);
$pdf->Image("../$Path");
$pdf->AjouterChapitre(6,'Organisation projet',utf8_decode('Réunion du :'),utf8_decode($date),'Compte rendu :',utf8_decode($resume));
$pdf->AjouterChapitre(6,'Organisation projet',utf8_decode('Comptes et sécurité :'),utf8_decode($mdp));
$pdf->AjouterChapitre(7,'Information','oui');
$pdf->AjouterChapitre(8,'Gestion des Risques','Risque :',utf8_decode($risque),'Solutions :', utf8_decode($solution));
$pdf->AjouterChapitre(9,'Composants','Liste des composants');
$pdf->AjouterChapitre(10,'Test matrices','',utf8_decode($matrice),utf8_decode('Test Validé :'),$bool);
$pdf->AjouterChapitre(11,'Feuille de recettage','',utf8_decode($feuille));
$pdf->Output();
?>
