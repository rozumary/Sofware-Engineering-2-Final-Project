<?php
// Include necessary files and initialize database connection
require __DIR__ . '/functions.php';
require __DIR__ . '/vendor/autoload.php';

set_config_inc();

require (MYSQL);

// Check if export button is clicked
if (isset($_POST['export_pdf'])) {
    // Generate PDF
    generatePDF($dbc);
}
elseif (isset($_POST['probationer_pdf'])) {
    generatePDFProbationer($dbc);
}
elseif (isset($_POST['denied_pdf'])) {
    generatePDFDenied($dbc);
}
elseif (isset($_POST['completed_pdf'])) {
    generatePDFCompleted($dbc);
}
elseif (isset($_POST['revoked_pdf'])) {
    generatePDFRevoked($dbc);
}
