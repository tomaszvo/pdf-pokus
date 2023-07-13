<?php

// Check if the form was submitted
if (isset($_FILES['pdf'])) {

    // Get the PDF file
    $pdf = $_FILES['pdf'];

    // Check if the file is a valid PDF file
    if ($pdf['type'] != 'application/pdf') {
        die('The file is not a valid PDF file.');
    }

    // Get the PDF dimensions
    $dimensions = getimagesize($pdf['tmp_name']);

    // Calculate the number of pages
    $pages = ceil($dimensions[0] / $dimensions[3]);

    // Create a new PDF document
    $pdf = new PDF();

    // Add each page to the document
    for ($i = 0; $i < $pages; $i++) {
        $pdf->addPage();
        $pdf->image($pdf['tmp_name'], 0, 0, $dimensions[0], $dimensions[1]);
    }

    // Set the page size to SRA3
    $pdf->setPageSize('SRA3');

    // Add the crop marks
    $pdf->addCropMarks();

    // Save the document
    $pdf->save('output.pdf');

    // Redirect the user to the output file
    header('Location: output.pdf');

}

?>
