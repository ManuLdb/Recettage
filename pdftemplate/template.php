<?php
require('../fpdf.php');
require('../config/db.php');
require('../config/session.php');

class PDF extends FPDF
{
function Header()
{
	global $titre;

	$this->Image('logo.png',10,6,30);
	// Arial gras 18
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
	$this->Cell(40,10,'nom entreprise');
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
	$this->SetFont('Arial','',16);
	// Couleur de fond
	// Titre
	$this->Cell(0,6,"$num - $libelle",0,"L");
	// Saut de ligne
	$this->Ln(10);
	// Arial 12


}

function CorpsChapitre($fichier, $contenu)
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
	$this->SetFont('Arial','',16);
	// Couleur de fond
	// Titre
	$this->Cell(0,5,$contenu);
	// Saut de ligne
	$this->Ln(10);
	// Arial 12

}

function AjouterChapitre($num, $titre, $contenu,$fichier)
{
	$this->AddPage();
	$this->TitreChapitre($num,$titre);
	$this->CorpsChapitre($fichier,$contenu);
}
}

$pdf = new PDF();
$id = $_GET['id'];
$variable= $db->query("SELECT id, titre, author_id FROM recette WHERE id = $id" );
while($data =$variable->fetch()) {
	$titre = $data['titre'];

}
$pdf->SetTitle($titre);
$variable->closeCursor();
$pdf->AliasNbPages();
$pdf->AjouterChapitre(1,'Pitch et brief','oui','20k_c1.txt');
$pdf->AjouterChapitre(2,'Cdc fonctionnel','oui','20k_c1.txt');
$pdf->AjouterChapitre(3,'Objectifs projet','oui','20k_c1.txt');
$pdf->AjouterChapitre(4,'Equipe projet','oui','20k_c1.txt');
$pdf->AjouterChapitre(5,'Process et outils','oui');
$pdf->AjouterChapitre(6,'Process et outils','oui');
$pdf->AjouterChapitre(7,'Organisation projet','oui');
$pdf->AjouterChapitre(8,'Information','oui');
$pdf->AjouterChapitre(9,'Gestion des Risques','oui');
$pdf->AjouterChapitre(10,'Composants','oui');
$pdf->AjouterChapitre(11,'Test matrices','oui');
$pdf->AjouterChapitre(12,'Feuille de recettage','oui');
$pdf->Output();
?>
