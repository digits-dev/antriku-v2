<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signed PDF Copy</title>
    <style>
        /* Reset styles for email clients */
        body,
        p,
        div,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #1d1d1f;
            background-color: #e3e3e5;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #f2f2f4;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        }

        .email-header {
            background-color: #e0e0e2;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #d1d1d3;
        }

        .logo {
            font-size: 22px;
            font-weight: 500;
            color: #1d1d1f;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 600;
            color: #1d1d1f;
            letter-spacing: -0.5px;
        }

        .logo-tagline {
            font-size: 13px;
            color: #6e6e73;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        .email-content {
            padding: 40px 30px;
            background-color: #ffffff;
        }

        .greeting {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: #1d1d1f;
        }

        .message {
            margin-bottom: 25px;
            color: #333336;
            font-size: 15px;
        }

        .attachment-info {
            background-color: #e8e8ea;
            border-radius: 10px;
            padding: 16px;
            margin: 25px 0;
            display: flex;
            align-items: center;
        }

        .attachment-icon {
            width: 44px;
            height: 44px;
            background-color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .attachment-icon span {
            font-size: 20px;
        }

        .attachment-text {
            font-size: 14px;
            color: #333336;
        }

        .attachment-text strong {
            display: block;
            margin-bottom: 3px;
            color: #1d1d1f;
        }

        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #d8d8da;
            color: #333336;
        }

        .company-name {
            font-weight: 500;
            color: #1d1d1f;
        }

        .email-footer {
            background-color: #e0e0e2;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6e6e73;
            border-top: 1px solid #d1d1d3;
        }

        .button {
            display: inline-block;
            background-color: #0066cc;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 980px;
            font-weight: 500;
            margin-top: 15px;
            font-size: 15px;
            text-align: center;
        }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100%;
                margin: 0;
                border-radius: 0;
            }

            .email-header,
            .email-content,
            .email-footer {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <a href="#" class="logo">
                <div class="logo-container">
                    <div class="logo-main">
                        <div class="logo-text">
                            <img src="https://antriku.beyondthebox.ph/uploads/2021-08/7490c5fe894ec42ddfd9eacbf01e958b.png" width="300" alt="Service Center Logo">
                            <br>
                            Beyond The Box
                        </div>
                    </div>
                    <div class="logo-tagline">
                        SERVICE CENTER
                    </div>
                </div>
            </a>
        </div>

        <div class="email-content">
            <p class="greeting">Dear Customer,</p>

            <p class="message">Please find the attached ZIP file for the signed PDF copy of your document.</p>
            <p class="message"><strong>Zip Key 🔑</strong>: 
                <span>{{ str_repeat('*', strlen($zipPassword)) }}</span>
                <ul style="list-style:square">
                    <p style="color: #333336; font-size: 15px;">Follow the pattern below to get your Zip Key:</p>
                    <li>Last 4 digits of your Contact No.</li>
                    <li>First letter of your First Name (UPPERCASE)</li>
                    <li>First letter of your Last Name (UPPERCASE)</li>
                    <li>Last letter of your Last Name (UPPERCASE)</li>
                </ul>
            </p>

            <div class="attachment-info">
                <div class="attachment-icon">
                    <span> 🗃️</span>
                </div>
                <div class="attachment-text">
                    <strong>{{ $zipFileName }}</strong> 
                    <span>ZIP PDF Document</span>
                </div>
            </div>            

            <p class="message">If you have any questions or need further assistance, please don't hesitate to reach out
                to our support team.</p>

            <div class="signature">
                <p>Best regards,<br>
                    <span class="company-name">BTB Service Center</span>
                </p>
            </div>
        </div>

        <div class="email-footer">
            <p>© 2025 Digits Trading Corp. All rights reserved.</p>
            <p>Digits Cubao, Quezon City, Philippines</p>
        </div>
    </div>
</body>

</html>
