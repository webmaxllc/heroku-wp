<!-- SUMMARY -->
<div class="mw-loan-view" id="mw-loan-loan-view">
    <div id="loanOfficerInfo" class="MWLoanSection col-md-4">
        <h2>Loan Officer</h2>
        <?php
        if (!empty($loan->loan_officer)) {
            ?>
            <div><strong><?=$loan->loan_officer->first_name.' '.$loan->loan_officer->last_name;?></div></strong>
            <div><strong>Email: </strong> <?=$loan->loan_officer->email?></div>
            <?php
        } else {
            echo "No loan officer is associated with this loan.";
        }
        ?>
    </div>
    <div id="loanDetails" class="MWLoanSection col-md-4">
        <h2>Loan Summary</h2>
        <div>
            <div><strong>Loan ID: </strong> <?=$loan->id?></div>
            <div><strong>Status: </strong> <?=MortgageWareLoan::$loanStatuses[$loan->status]?></div>
            <div><strong>Completed: </strong> <?=$completed->format(MW_DATE_FORMAT)?></div>
            <div><strong>Borrower: </strong> <?=$borrowerName?></div>
            <?php
            if (!empty($co_borrowers)) {
                foreach ($co_borrowers as $co_borrower) {
                    ?>
                    <div><strong>Co Borrower: </strong> <?=$co_borrower->first_name.' '.$co_borrower->last_name?></div>
                    <?php
                }
            }
            ?>
            <div><strong>Loan Amount: </strong> $<?=number_format($loan->loan_amount)?></div>
            <div><strong>Last Modified: </strong> <?php $modified = new DateTime($loan->modified); echo $modified->format('n/j/Y g:i a')?></div>
            <div><strong>Property: </strong><br><?=$address?></div>
        </div>
    </div>
    <?php
    if (!empty($loan->milestone)) {
        ?>
        <div id="loanDetails" class="MWLoanSection col-md-4">
            <h2>Milestone</h2>
        </div>
        <?php
    }
    ?>
    <div class="clearfix"></div>
    <?php
    if (MW_DOCUMENTS_ENABLED == true) {
        ?>
        <div id="loanDocuments" class="MWLoanSection col-md-12">
            <h2>Documents</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Created</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($loan->document as $document) {
                    $sent = new DateTime($document->created);
                    if (isset($document->type)) {
                        $category = $document->type->term;
                        if ($document->status == 3) {
                            $uploadedCategories[$category] = $document->status;
                        }
                        else if (!isset($uploadedCategories[$category])) {
                            $uploadedCategories[$category] = $document->status;
                        }
                    } else {
                        $category = 'none';
                    }
                    ?>
                    <tr data-document_id="<?=$document->id?>">
                        <td><?=$document->name?></td>
                        <td><?=$category?></td>
                        <td><?=$sent->format(MW_DATETIME_FORMAT)?></td>
                        <td><?=$document->file->user->username?></td>
                        <td><?=MortgageWareDocument::$statuses[$document->status]?></td>
                        <td><button class="btn btn-primary MWDownloadDocument">Download</button></td>
                    </tr>
                    <?php
                }
                if (empty($loan->document)) {
                    ?>
                    <tr class="empty">
                        <td colspan="6">There are no documents to display</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>

        <div id="uploadDocuments" class="MWLoanSection col-md-4">
            <h2>Upload Document</h2>
            <form id="mw-document-form" class="form-vertical">
                <input type="hidden" name="guid" value="<?=$loan->guid?>">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="documentName" class="form-control" placeholder="Name of Document (required)" required>
                </div>
                <?php
                if (!empty($categories)) {
                    ?>
                    <div class="form-group">
                        <label for="category" for="documentCategory">Category</label>
                        <select name="type[id]" id="documentCategory" class="form-control" required>
                            <option value="">- Select a Category</option>
                            <?php
                            foreach ($categories as $category) {
                                ?>
                                <option value="<?=$category->id?>"><?=$category->term?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                }
                ?>
                <div class="form-group">
                    <label for="file">File</label>
                    <input type="text" style="cursor: pointer" id="documentSelect" autocomplete="off" aria-autocomplete="none" placeholder="Select a File (required)" class="form-control" required />
                    <div class="formats">.txt .pdf .doc .tif .jpg .jpeg & .jpe are acceptable formats</div>
                    <input class="hiddenUploader" type="file" id="documentUploader" />
                    <input type="hidden" name="file[content]" id="fileData">
                    <input type="hidden" name="file[mime_type]" id="fileMimeType">
                    <input type="hidden" name="file[filename]" id="fileName">
                    <input type="hidden" name="file[filesize]" id="fileSize">
                </div>
                <div class="form-group">
                    <button type="submit" id="uploadButton" class="btn btn-disabled">Upload Document</button>
                </div>
                <div class="form-group">
                    <div class="mw-form-message"></div>
                </div>
            </form>
        </div>

        <?php
        if (!empty($categories)) {
            ?>
            <div id="documentCategories" class="col-md-6 col-md-offset-2 space20">
                <div class="well">
                    <h2>Document Checklist</h2>
                    <ul>
                        <?php
                        foreach ($categories as $category) {
                            $icon = 'square';
                            if (isset($uploadedCategories[$category->term])) {
                                if ($uploadedCategories[$category->term] == 3) {
                                    $icon = 'check-square';
                                } else {
                                    $icon = 'clock';
                                }
                            }
                            ?>
                            <li><i class="fa fa-<?=$icon?>-o"></i> <?=$category->term?></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>