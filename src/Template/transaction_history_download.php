<?php
    $outfilename = "";
    $tbl=0;
    $total_amount = 0;
    $llx= 50; $lly=50; $urx=550; $ury=800;
    $invokedFrom = $t->get("invokedFrom");

    switch( $invokedFrom) {
        case _STATEMENT            :     $accountInfo = $t->get("accountInfo");
                                         $customer = $t->get("customer");
                                         $transactionList = $t->get("transactionList");
                                         $headers = array('Transaction ID', 'Transaction Date','Debit Amount','Credit Amount',
                                               'To/From Account ID');
                                         $pdfTitle ='Statement';
                                         $filename = 'Statement_'.time().'.pdf';
                                          break;
        case _TRANSACTION_HISTORY :       $accountInfo = $t->get("accountInfo");
                                          $customer = $t->get("customer");
                                          $transactionList = $t->get("transactionList");
                                          $headers = array('Transaction ID', 'Transaction Date','Amount','Beneficiary Account ID',
                                                      'Beneficiary Account Name', 'Status');
                                          $pdfTitle ='Transaction History';
                                          $filename = 'Transaction_History_'.time().'.pdf';
                                          $transactionStatus = array(
                                                                        '0' => 'COMPLETED',
                                                                        '1' => 'ON HOLD'
                                                                );
                                          break;
        case _CUSTOMER_DETAILS_PENDING_TRANSACTION :      $accountInfo = $t->get("accountInfo");
                                                          $customer = $t->get("customer");
                                                          $transactionList = $t->get("onHoldTransactionList");
                                                          $headers = array('Transaction ID', 'To Account Number',
                                                          'Transaction Date','Amount');
                                                          $pdfTitle ="Customer's Pending Transaction";
                                                          $filename ='Customer_Pending_transaction'.time().'.pdf';
                                                          break;
        case _CUSTOMER_DETAILS_COMPLETED_TRANSACTION :    $accountInfo = $t->get("accountInfo");
                                                          $customer = $t->get("customer");
                                                          $transactionList = $t->get("approvedTransactionList");
                                                          $headers = array('Transaction ID', 'To Account Number',
                                                          'Transaction Date','Amount');
                                                          $pdfTitle ="Customer's Completed Transaction";
                                                          $filename = 'Customer_Completed_transaction'.time().'.pdf';
                                                          break;
        case _PENDING_TRANSACTIONS                   :    $transactionList = $t->get("transactionList");
                                                          $headers = array('Transaction ID', 'Transaction Date','Amount','Beneficiary Account ID',
                                                                        'Beneficiary Account Name');
                                                          $pdfTitle ='Pending Transactions';
                                                          $filename = 'Pending_Transactions_'.time().'.pdf';
                                                          break;

    }

    $colspan = count($headers)+1;
    try {
        $p = new PDFlib();
    
        $p->set_option("errorpolicy=return");
        $p->set_option("stringformat=utf8");
    
        if ($p->begin_document($outfilename, "") == 0) {
            die("Error: " . $p->get_errmsg());
        }
    
        $p->set_info("Creator", "SecureBank");
        $p->set_info("Title", $pdfTitle);
    
        /* -------------------- Add table cells -------------------- */
    
        /* ---------- row 1: table header (spans all columns) */
        $row = 1; $col = 1;
        $font = $p->load_font("Times-Bold", "unicode", "");
        if ($font == 0) {
            die("Error: " . $p->get_errmsg());
        }
    
        $optlist = "fittextline={position=center font=" . $font . " fontsize=14} " .
                "colspan=".$colspan;
    
        $date = 'Date: '.date('d-m-Y');
        $headertext = $pdfTitle;
    
        $tbl = $p->add_table_cell($tbl, $col, $row, $headertext, $optlist);
        if ($tbl == 0) {
            die("Error: " . $p->get_errmsg());
        }
        $row++;

        if( $invokedFrom != _PENDING_TRANSACTIONS ){
            $optlist = "fittextline={position={left center} font=" . $font . " fontsize=12} " .
                    "colspan=".$colspan;

            $accountNo = 'Account No.  '.$accountInfo->getAccountId();
            $customer_name ='Customer Name : '.$customer->getFirstName().' '.$customer->getLastName();
            $date = 'Date: '.date('d-m-Y');
            $headertext = $accountNo.'             '.$customer_name.'               '.$date;

            $tbl = $p->add_table_cell($tbl, $col, $row, $headertext, $optlist);
            if ($tbl == 0) {
                die("Error: " . $p->get_errmsg());
            }
            $row++;
        }

    
        /* ---------- Table Headers -----------------*/
            $col =1;
            $font = $p->load_font("Times-Roman", "unicode", "");
            if ($font == 0) {
                die("Error: " . $p->get_errmsg());
            }
            foreach( $headers as $header ){
                $optlist = "fontname=Times-Roman encoding=unicode fontsize=10 ";
                $tf = $p->add_textflow(0,$header, $optlist);
                if ($tf == 0) {
                    die("Error: " . $p->get_errmsg());
                }
                $optlist = "margin=2 textflow=" . $tf;
                $tbl = $p->add_table_cell($tbl, $col++, $row, "", $optlist);
                if ($tbl == 0) {
                    die("Error: " . $p->get_errmsg());
                }
            }

          $optlist = "fittextline={position=center font=" . $font . " fontsize=10} ";
          $tbl = $p->add_table_cell($tbl, $col++, $row, 'Remarks', $optlist);
          $row++;


        /* ---------- Table Data -----------------*/
        foreach($transactionList as $transaction) {
                $col=1;
                $optlist = "colwidth=20% fittextline={font=" . $font . " fontsize=10}";
                $amount_field_optlist = "colwidth=20%  fittextline={position={right center} font=" . $font . " fontsize=10} ";
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

                                            $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getId(), $optlist);
                                            $tbl = $p->add_table_cell($tbl, $col++, $row, date('d.m.Y',strtotime($transaction->getTransactionDate() ) ), $optlist);

                                            $tbl = $p->add_table_cell($tbl, $col++, $row, $debit_amount, $amount_field_optlist);
                                            $tbl = $p->add_table_cell($tbl, $col++, $row, $credit_amount, $amount_field_optlist);
                                            $tbl = $p->add_table_cell($tbl, $col++, $row, $accountId, $optlist);
                                            $optlist = "fontname=Times-Roman encoding=unicode fontsize=10 ";
                                            $tf = $p->add_textflow(0,$transaction->getRemarks(), $optlist);
                                            if ($tf == 0) {
                                                die("Error: " . $p->get_errmsg());
                                            }
                                            $optlist = "margin=2 textflow=" . $tf;
                                            $tbl = $p->add_table_cell($tbl, $col++, $row, "", $optlist);
                                            if ($tbl == 0) {
                                                die("Error: " . $p->get_errmsg());
                                            }
                                            break;

                     case _TRANSACTION_HISTORY :
                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getId(), $optlist);
                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, date('d.m.Y',strtotime($transaction->getTransactionDate() ) ), $optlist);

                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getAmount(), $amount_field_optlist);
                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getToAccountID(), $optlist);
                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getToAccountName(), $optlist);
                                                  $status = $transactionStatus[$transaction->getIsOnHold()];
                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, $status, $optlist);
                                                  $optlist = "fontname=Times-Roman encoding=unicode fontsize=10 ";
                                                  $tf = $p->add_textflow(0,$transaction->getRemarks(), $optlist);
                                                  if ($tf == 0) {
                                                      die("Error: " . $p->get_errmsg());
                                                  }
                                                  $optlist = "margin=2 textflow=" . $tf;
                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, "", $optlist);
                                                  if ($tbl == 0) {
                                                      die("Error: " . $p->get_errmsg());
                                                  }
                                                  break;
                     case _CUSTOMER_DETAILS_PENDING_TRANSACTION :
                     case _CUSTOMER_DETAILS_COMPLETED_TRANSACTION :
                                                    $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getId(), $optlist);
                                                    $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getToAccountID(), $optlist);
                                                    $tbl = $p->add_table_cell($tbl, $col++, $row, date('d.m.Y',strtotime($transaction->getTransactionDate() ) ), $optlist);
                                                    $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getAmount(), $amount_field_optlist);
                                                    $optlist = "fontname=Times-Roman encoding=unicode fontsize=10 ";
                                                     $tf = $p->add_textflow(0,$transaction->getRemarks(), $optlist);
                                                      if ($tf == 0) {
                                                          die("Error: " . $p->get_errmsg());
                                                      }
                                                      $optlist = "margin=2 textflow=" . $tf;
                                                      $tbl = $p->add_table_cell($tbl, $col++, $row, "", $optlist);
                                                      if ($tbl == 0) {
                                                          die("Error: " . $p->get_errmsg());
                                                      }
                                                    break;
                     case _PENDING_TRANSACTIONS : $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getId(), $optlist);
                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, date('d.m.Y',strtotime($transaction->getTransactionDate() ) ), $optlist);
                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getAmount(), $amount_field_optlist);
                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getToAccountID(), $optlist);
                                                  $tbl = $p->add_table_cell($tbl, $col++, $row, $transaction->getToAccountName(), $optlist);

                                                  $optlist = "fontname=Times-Roman encoding=unicode fontsize=10 ";
                                                   $tf = $p->add_textflow(0,$transaction->getRemarks(), $optlist);
                                                    if ($tf == 0) {
                                                        die("Error: " . $p->get_errmsg());
                                                    }
                                                    $optlist = "margin=2 textflow=" . $tf;
                                                    $tbl = $p->add_table_cell($tbl, $col++, $row, "", $optlist);
                                                    if ($tbl == 0) {
                                                        die("Error: " . $p->get_errmsg());
                                                    }
                                                  break;
                }

                $row++;
        }
        /* ---------- Place the table on one or more pages ---------- */
    
        /*
         * Loop until all of the table is placed; create new pages
         * as long as more table instances need to be placed.
         */
        do {
            $p->begin_page_ext(0, 0, "width=a4.width height=a4.height");
    
            /* Shade every other $row; draw lines for all table cells.
             * Add "showcells showborder" to visualize cell borders
             */
            $optlist = "header=1 rowheightdefault=auto " .
            "fill={{area=rowodd fillcolor={gray 0.9}}} " .
            "stroke={{line=other}} ";
    
            /* Place the table instance */
            $result = $p->fit_table($tbl, $llx, $lly, $urx, $ury, $optlist);
            if ($result ==  "_error") {
                die("Couldn't place table: " . $p->get_errmsg());
            }
            $p->end_page_ext("");
    
        } while ($result == "_boxfull");
    
        /* Check the $result; "_stop" means all is ok. */
        if ($result != "_stop") {
            if ($result ==  "_error") {
                die("Error when placing table: " . $p->get_errmsg());
            }
            else {
                /* Any other return value is a user exit caused by
                 * the "return" option; this requires dedicated code to
                 * deal with.
                 */
                die("User return found in Table");
            }
        }
    
        /* This will also delete Textflow handles used in the table */
        $p->delete_table($tbl, "");
    
        $p->end_document("");
    
        $buf = $p->get_buffer();
        $len = strlen($buf);
        header("Content-type: application/pdf");
        header("Content-Length: $len");
        header("Content-Disposition: inline; filename=$filename");
        print $buf;
    }
    catch (PDFlibException $e) {
        die("PDFlib exception occurred in starter_table sample:\n" .
            "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
            $e->get_errmsg() . "\n");
    }
    catch (Exception $e) {
        die($e);
    }
    
    $p = 0;
    ?>