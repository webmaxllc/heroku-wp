<?php

    $_SESSION['MW_LOAN_ID'] = $loan->id;

    $address = isset($loan->property_location->address1)?$address = $loan->property_location->address1.'<br>':'';
    $address.= isset($loan->property_location->address2)?$address = $loan->property_location->address2.'<br>':'';
    $address.= isset($loan->property_location->city)?$loan->property_location->city.', ':'';
    $address.= $loan->property_location->state->abbreviation;

    $completed = new DateTime($loan->completed_date);
    $modified = new DateTime($loan->modified);

    $borrower = $loan->borrower;
    $co_borrowers = $loan->co_borrower;

    $borrowerName = $borrower->first_name.' '.$borrower->last_name;
    $borrowerSSN = substr($borrower->ssn,-4);
    $borrowerDOB = new DateTime($borrower->birth_date);

    if (MW_DOCUMENTS_ENABLED == true) {
        if (!isset($_SESSION['MW_LOAN_DOCUMENT_CATEGORIES'])) {
            $categories = MortgageWareAPI::getLoanDocumentCategories();
            $_SESSION['MW_LOAN_DOCUMENT_CATEGORIES'] = $categories;
        } else {
            $categories = $_SESSION['MW_LOAN_DOCUMENT_CATEGORIES'];
        }
    }

    $uploadedCategories = array();