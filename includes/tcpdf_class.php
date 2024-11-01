<?php
class MYPDF extends TCPDF 
{

	//Page header
	public function Header() {

        // Logo

	$logo_url = wp_upload_dir();
	$pdf_image = $logo_url['baseurl'] . '/web-hosting-uploads/logo.png' ;
		$pdf_image_width = '15';$pdf_image_height = '15';

// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

        $this->Image($pdf_image, 10, 10, $pdf_image_width, $pdf_image_height, 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        
        
        // Set font
        $this->SetFont('helvetica', 'I', 10);
        
$this->SetY(-280);
$this->Cell(350, 0, '' , 0, false, 'C', 0, '', 0, false, 'T', 'M'); 
$this->SetY(-275);
$this->Cell(350, 0, '' , 0, false, 'C', 0, '', 0, false, 'T', 'M'); 
$this->SetY(-270);
$this->Cell(350, 0, '' , 0, false, 'C', 0, '', 0, false, 'T', 'M'); 
$this->SetY(-265);
$this->Cell(350, 0, '' , 0, false, 'C', 0, '', 0, false, 'T', 'M'); 
$this->SetY(-260);
$this->Cell(350, 0, '' , 0, false, 'C', 0, '', 0, false, 'T', 'M'); 
$this->SetY(-255);
$this->Cell(350, 0, '' , 0, false, 'C', 0, '', 0, false, 'T', 'M'); 
$this->SetY(-250);
$this->Cell(350, 0, '' , 0, false, 'C', 0, '', 0, false, 'T', 'M'); 



 
    }

}
?>