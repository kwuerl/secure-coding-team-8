<?php

$textColour = array(0, 0, 0);
$headerColour = array(100, 100, 100);
$tableHeaderTopTextColour = array(255, 255, 255);
$tableHeaderTopFillColour = array(125, 152, 179);
$tableBorderColour = array(50, 50, 50);
$tableRowFillColour = array(213, 170, 170);

$invokedFrom = $t->get("invokedFrom");

switch( $invokedFrom) {
    case _STATEMENT            :     $accountInfo = $t->get("accountInfo");
                                     $customer = $t->get("customer");
                                     $transactionList = $t->get("transactionList");
                                     $headers = array(
                                             "ID"                   => "10" ,
                                             "To / From Account No." => "40" ,
                                             "Date"                 => "25" ,
                                             "Debit Amount"         => "40" ,
                                             "Credit Amount"        => "40" ,
                                             "Remarks"              => "40" ,

                                     );
                                     $pdfTitle ='Statement';
                                     $filename = 'Statement_'.time().'.pdf';
                                     break;
    case _TRANSACTION_HISTORY :      $accountInfo = $t->get("accountInfo");
                                     $customer = $t->get("customer");
                                     $transactionList = $t->get("transactionList");
                                     $headers = array(
                                               "ID"                   => "10" ,
                                               "To Account No."        => "35" ,
                                               "To Account Name"      => "25" ,
                                               "Date"                 => "35" ,
                                               "Amount"               => "25" ,
                                               "Status"               => "20" ,
                                               "Remarks"              => "40" ,

                                     );
                                     $pdfTitle ='Transaction History';
                                     $filename = 'Transaction_History_'.time().'.pdf';
                                     $transactionStatus = array(
                                                             '0' => 'COMPLETED',
                                                             '1' => 'ON HOLD',
                                                             '2' => "REJECTED"
                                                             );
                                     break;
     case _CUSTOMER_DETAILS_PENDING_TRANSACTION :   $accountInfo = $t->get("accountInfo");
                                                    $customer = $t->get("customer");
                                                    $transactionList = $t->get("onHoldTransactionList");
                                                    $headers = array(
                                                           "ID"                   => "50" ,
                                                           "To Account No."       => "50" ,
                                                           "Date"                 => "40" ,
                                                           "Amount"               => "50" ,

                                                    );
                                                    $pdfTitle ="Customer's Pending Transaction";
                                                    $filename = 'Customer_Pending_transaction'.time().'.pdf';
                                                    break;
    case _CUSTOMER_DETAILS_COMPLETED_TRANSACTION :    $accountInfo = $t->get("accountInfo");
                                                      $customer = $t->get("customer");
                                                      $transactionList = $t->get("approvedTransactionList");
                                                      $headers = array(
                                                             "ID"                   => "10" ,
                                                             "From Account No."     => "30" ,
                                                             "From Account Name"    => "30" ,
                                                             "To Account No."       => "30" ,
                                                             "To Account Name"      => "25" ,
                                                             "Date"                 => "20" ,
                                                             "Amount"               => "20" ,
                                                             "Remarks"              => "30" ,

                                                      );
                                                      $pdfTitle ="Customer's Completed Transaction";
                                                      $filename = 'Customer_Completed_transaction'.time().'.pdf';
                                                      break;
    case _PENDING_TRANSACTIONS                   :    $transactionList = $t->get("transactionList");
                                                      $headers = array(
                                                           "ID"                   => "10" ,
                                                           "From Account No."     => "30" ,
                                                           "From Account Name"    => "30" ,
                                                           "To Account No."       => "30" ,
                                                           "To Account Name"      => "25" ,
                                                           "Date"                 => "20" ,
                                                           "Amount"               => "20" ,
                                                           "Remarks"              => "30" ,

                                                      );
                                                      $pdfTitle ='Pending Transactions';
                                                      $filename = 'Pending_Transactions_'.time().'.pdf';
                                                      break;

}


$pdf = new \FPDF( 'P', 'mm', 'A4' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );

$pdf->AddPage();
$pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
$pdf->SetFont( 'Arial', '', 16 );
$pdf->Cell( 0, 15, 'Secure Bank', 0, 0, 'C' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'Arial', '', 14 );
$pdf->Ln( 10);
$pdf->Cell( 0, 15, $pdfTitle , 0, 0, 'C' );
$pdf->Ln( 15 );
if( $invokedFrom != _PENDING_TRANSACTIONS ){
    //$customer_name ='Customer Name : '.$customer->getFirstName().' '.$customer->getLastName();
    $pdf->SetFont( 'Arial', 'B', 10 );
    $pdf->Cell( 0, 6, 'Account Number : '.$accountInfo->getAccountId(), 0, 0, 'L' );
    //$pdf->Cell( 0, 6, $customer_name, 0, -10, 'C' );
    $pdf->Cell( 0, 6, "Date : ".date('d-m-Y'), 0, 0, 'R' );
    $pdf->Ln( 8);
}
$col_height =6;
$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(224,224,224);
$width = array();
foreach($headers as $key=>$value){
    $pdf->Cell($value,8,$key,1,0,'C',true);
    array_push($width, $value);
}
$pdf->Ln();
$pdf->SetFont('Arial','',8);
foreach($transactionList as $transaction) {
  $i=0;
  switch ($invokedFrom){
         case _STATEMENT :      if ($accountInfo->getAccountId() != $transaction->getFromAccountId()) {
                                    $credit_amount = $transaction->getAmount();
                                    $debit_amount = '--';
                                    $accountId = $transaction->getFromAccountId();
                                } else {
                                    $debit_amount = $transaction->getAmount();
                                    $credit_amount = '--';
                                    $accountId = $transaction->getToAccountId();
                               }
                               $pdf->Cell($width[$i++],$col_height,$transaction->getId(),1,0,'C',false);
                               $pdf->Cell($width[$i++],$col_height,$accountId,1,0,'C',false);
                               $pdf->Cell($width[$i++],$col_height,date('d.m.Y',strtotime($transaction->getTransactionDate() ) ),1,0,'C',false);
                               $pdf->Cell($width[$i++],$col_height,$debit_amount,1,0,'R',false);
                               $pdf->Cell($width[$i++],$col_height,$credit_amount,1,0,'R',false);
                               $pdf->Cell($width[$i++],$col_height,$transaction->getRemarks(),1,0,'C',false);
                               $pdf->Ln();
                                break;
          case _TRANSACTION_HISTORY : $status = ($transaction->getIsRejected()) ? $transactionStatus[2] : $transactionStatus[$transaction->getIsOnHold()];
                                      $pdf->Cell($width[$i++],$col_height,$transaction->getId(),1,0,'C',false);
                                      $pdf->Cell($width[$i++],$col_height,$transaction->getToAccountId(),1,0,'C',false);
                                      $pdf->Cell($width[$i++],$col_height,$transaction->getToAccountName(),1,0,'C',false);
                                      $pdf->Cell($width[$i++],$col_height,date('d.m.Y',strtotime($transaction->getTransactionDate() ) ),1,0,'C',false);
                                      $pdf->Cell($width[$i++],$col_height,$transaction->getAmount(),1,0,'R',false);
                                      $pdf->Cell($width[$i++],$col_height,$status,1,0,'C',false);
                                      $pdf->Cell($width[$i++],$col_height,$transaction->getRemarks(),1,0,'C',false);
                                      $pdf->Ln();
                                       break;
          case _CUSTOMER_DETAILS_PENDING_TRANSACTION :
                                      $pdf->Cell($width[$i++],$col_height,$transaction->getId(),1,0,'C',false);
                                      $pdf->Cell($width[$i++],$col_height,$transaction->getToAccountId(),1,0,'C',false);
                                      $pdf->Cell($width[$i++],$col_height,date('d.m.Y',strtotime($transaction->getTransactionDate() ) ),1,0,'C',false);
                                      $pdf->Cell($width[$i++],$col_height,$transaction->getAmount(),1,0,'R',false);
                                      $pdf->Ln();
                                       break;
          case _CUSTOMER_DETAILS_COMPLETED_TRANSACTION :
                                       $pdf->Cell($width[$i++],$col_height,$transaction->getId(),1,0,'C',false);
                                       $pdf->Cell($width[$i++],$col_height,$transaction->getFromAccountId(),1,0,'C',false);
                                       $pdf->Cell($width[$i++],$col_height,$transaction->getFromAccountName(),1,0,'C',false);
                                       $pdf->Cell($width[$i++],$col_height,$transaction->getToAccountId(),1,0,'C',false);
                                       $pdf->Cell($width[$i++],$col_height,$transaction->getToAccountName(),1,0,'C',false);
                                       $pdf->Cell($width[$i++],$col_height,date('d.m.Y',strtotime($transaction->getTransactionDate() ) ),1,0,'C',false);
                                       $pdf->Cell($width[$i++],$col_height,$transaction->getAmount(),1,0,'R',false);
                                       $pdf->Cell($width[$i++],$col_height,$transaction->getRemarks(),1,0,'C',false);
                                       $pdf->Ln();
                                        break;
          case _PENDING_TRANSACTIONS :    $pdf->Cell($width[$i++],$col_height,$transaction->getId(),1,0,'C',false);
                                          $pdf->Cell($width[$i++],$col_height,$transaction->getFromAccountId(),1,0,'C',false);
                                          $pdf->Cell($width[$i++],$col_height,$transaction->getFromAccountName(),1,0,'C',false);
                                          $pdf->Cell($width[$i++],$col_height,$transaction->getToAccountId(),1,0,'C',false);
                                          $pdf->Cell($width[$i++],$col_height,$transaction->getToAccountName(),1,0,'C',false);
                                          $pdf->Cell($width[$i++],$col_height,date('d.m.Y',strtotime($transaction->getTransactionDate() ) ),1,0,'C',false);
                                          $pdf->Cell($width[$i++],$col_height,$transaction->getAmount(),1,0,'R',false);
                                          $pdf->Cell($width[$i++],$col_height,$transaction->getRemarks(),1,0,'C',false);
                                          $pdf->Ln();
                                          break;
    }
}
$pdf->Output($filename, "I");

?>