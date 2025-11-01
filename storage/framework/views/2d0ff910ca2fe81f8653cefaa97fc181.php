<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Transfer Certificate - <?php echo e($certificate_data['student_name']); ?></title>
    <style>
        @page {
            margin: 0.5cm; /* Set margins for the page */
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* The main page border */
        .page-border {
            border: 2px solid #333;
            position: fixed;
            top: 0.5cm;
            left: 0.5cm;
            right: 0.5cm;
            bottom: 0.5cm;
            z-index: -1;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.1;
            z-index: -10;
            max-width: 80%;
        }
        .watermark img {
            max-width: 400px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
        }

        .header img {
            max-width: 90px;
            max-height: 90px;
        }

        .header h1 {
            margin: 10px 0 5px 0;
            font-size: 26px;
            color: #2c3e50;
        }
        .header p {
             margin: 0;
             font-size: 12px;
        }

        .header h2 {
            margin: 20px 0 0 0;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
            display: inline-block; /* Keeps border from stretching */
        }

        .content {
            margin-top: 20px;
        }

        .content p {
            margin: 15px 0;
            text-align: justify;
            font-size: 14px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }

        .details-table td {
            padding: 10px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .details-table td:first-child {
            font-weight: bold;
            background-color: #f7f7f7;
            width: 30%;
        }

        .footer {
            margin-top: 60px;
            font-size: 13px;
            /* Use floats for side-by-side signatures */
            width: 100%;
        }
        
        .signature-box {
            float: left;
            width: 45%;
            text-align: center;
        }
        
        .signature-box.right {
            float: right;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 220px;
            margin: 40px auto 0 auto;
            padding-top: 5px;
        }

        .certificate-meta {
            width: 100%;
            margin-bottom: 15px;
            /* Clearfix for floats */
            overflow: auto; 
        }

        .meta-left {
            float: left;
        }

        .meta-right {
            float: right;
        }
    </style>
</head>

<body>
    <!-- The new page border -->
    <div class="page-border"></div>

    <!-- The new watermark -->
    <div class="watermark">
        <?php if($logo_base64): ?>
            <img src="<?php echo e($logo_base64); ?>" alt="Watermark">
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="header">
            <?php if($logo_base64): ?>
            <img src="<?php echo e($logo_base64); ?>" alt="<?php echo e($school->name); ?> Logo">
            <?php endif; ?>
            <h1><?php echo e($school->name); ?></h1>
            <p><?php echo e($school->address); ?></p>
            <h2>Transfer Certificate</h2>
        </div>

        <div class="certificate-meta">
            <span class="meta-left"><strong>Admission No:</strong> <?php echo e($certificate_data['admission_no'] ?? 'N/A'); ?></span>
            <span class="meta-right"><strong>Date of Issue:</strong> <?php echo e(\Carbon\Carbon::parse($certificate_data['issue_date'])->format('F j, Y')); ?></span>
        </div>

        <div class="content">
            <p>This is to certify that <strong><?php echo e($certificate_data['student_name']); ?></strong>, 
               Son/Daughter of <strong><?php echo e($certificate_data['guardian_name']); ?></strong>,
               was a bonafide student of this institution with Admission No. <strong><?php echo e($certificate_data['admission_no']); ?></strong>.
            </p>

            <p>As per the school records, their details are as follows:</p>

            <table class="details-table">
                <tr>
                    <td>Student's Name</td>
                    <td><?php echo e($certificate_data['student_name']); ?></td>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><?php echo e(\Carbon\Carbon::parse($certificate_data['date_of_birth'])->format('F j, Y')); ?></td>
                </tr>
                <tr>
                    <td>Student's Tenure at School</td>
                    <td>From <strong><?php echo e(\Carbon\Carbon::parse($certificate_data['admission_date'])->format('F j, Y')); ?></strong> to <strong><?php echo e(\Carbon\Carbon::parse($certificate_data['issue_date'])->format('F j, Y')); ?></strong></td>
                </tr>
                <tr>
                    <td>Last Class Attended</td>
                    <td><?php echo e($certificate_data['class_name']); ?> - <?php echo e($certificate_data['section_name']); ?></td>
                </tr>
                <tr>
                    <td>Promotion Status</td>
                    <td><?php echo e($certificate_data['promotion_status']); ?></td>
                </tr>
                <tr>
                    <td>Reason for Leaving</td>
                    <td><?php echo e($certificate_data['reason_for_leaving']); ?></td>
                </tr>
                <tr>
                    <td>Character & Conduct</td>
                    <td><?php echo e($certificate_data['character_conduct']); ?></td>
                </tr>
                <tr>
                    <td>Dues Cleared</td>
                    <td><?php echo e($certificate_data['dues_cleared']); ?></td>
                </tr>
                <tr>
                    <td>General Remarks</td>
                    <td><?php echo e($certificate_data['general_remarks'] ?? 'N/A'); ?></td>
                </tr>
            </table>

            <p>We wish the student all the best for their future endeavors.</p>
        </div>

        <div class="footer">
            <div class="signature-box">
                <div class="signature-line">
                    Prepared by (Clerk)
                </div>
            </div>
            
            <div class="signature-box right">
                <div class="signature-line">
                     Principal's Signature
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php /**PATH C:\xampp\htdocs\sms\resources\views/school-superadmin/certificates/templates/transfer-certificate.blade.php ENDPATH**/ ?>