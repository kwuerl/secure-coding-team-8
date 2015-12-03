<?php
namespace Service;

/**
 * This Service can be used to provide PDF related services
 *
 * @author Vivek Sethia <vivek.sethia@tum.de>
 */
class PdfService {
	/**
	 * Constructor
	 */
	function __construct() {
		
	}
	/**
	 * Creates pdf containing TANS for newly registered customers
	 *
	 * @param array $tans
	 * @param string $pdfPassword
	 *
	 * @return boolean
	 */
	public function generatePdfWithTans($tans, $pdfPassword) {
		$pdf=new \FPDF_Protection();
		$pdf->SetProtection(array('print'), $pdfPassword);
		$pdf->AddPage();
		$pdf->SetFont('Arial');
		$pdf->SetFont('Arial','',12);
		$pdf->SetFillColor(224,224,224);
		$pdf->Cell(10,12,"No.",1,0,'C',true);
		$pdf->Cell(50,12,"TAN Codes",1,0,'C',true);
		$pdf->Ln();
		$i = 1;
		foreach ($tans as $key => $tan) {
		   $pdf->Cell(10,8,$i++,1,0,'C',false);
		   $pdf->Cell(50,8,$tan->getCode(),1,0,'C',false);
		   $pdf->Ln();
		}

		$pdfdoc = $pdf->Output("", "S");
		ob_end_clean();
	    // encode data (puts attachment in proper format)
		$attachment = chunk_split(base64_encode($pdfdoc));
		return $attachment;
	}
}