<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation Certificate</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap');
        @page {
            margin: 0.8cm;
            size: 8.5in 13in; /* Long bond paper size */
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            color: #333;
            background: linear-gradient(135deg, #f0e6ff 0%, #e8d5ff 100%);
        }
        .certificate-container {
            width: 100%;
            min-height: 13in; /* Long bond paper height */
            padding: 15px;
            box-sizing: border-box;
            background: linear-gradient(135deg, #f0e6ff 0%, #e8d5ff 100%);
        }
        .certificate-content {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
            min-height: calc(13in - 30px); /* Adjust for container padding */
        }
        .header-section {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .logo-cell {
            display: table-cell;
            width: 100px;
            vertical-align: top;
        }
        .logo-cell img {
            width: 80px;
            height: 80px;
        }
        .header-info {
            display: table-cell;
            text-align: center;
            vertical-align: top;
            padding: 0 20px;
        }
        .cert-id-cell {
            display: table-cell;
            width: 120px;
            text-align: right;
            vertical-align: top;
        }
         .cert-id-cell img {
            width: 80px;
            height: 80px;
        }
        .diocese-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
        }
        .parish-name {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
        }
        .parish-address {
            font-size: 12px;
            color: #333;
            line-height: 1.3;
        }
        .cert-id-box {
            background: #f0e6ff;
            border: 2px solid #8b5a96;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
            color: #8b5a96;
        }
        .certificate-title {
            font-family: 'UnifrakturMaguntia', cursive;
            font-weight: 400;
            font-style: normal;
            font-size: 45;
            color: #8b5a96;
            text-align: center;
            margin: 15px 0;
            /* text-decoration: underline; */
            text-decoration-color: #8b5a96;
        }
        .main-layout {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .content-left {
            display: table-cell;
            width: 65%;
            vertical-align: top;
            padding-right: 20px;
        }
        .content-right {
            display: table-cell;
            width: 35%;
            vertical-align: top;
        }
        .confirmation-image {
            text-align: center;
            margin-bottom: 15px;
        }
        .confirmation-image img {
            width: 180px;
            height: 180px;
            transform: scaleX(-1);
        }
        .scripture-box {
            background: #f9f5ff;
            border: 1px solid #d4b5e0;
            padding: 15px;
            border-radius: 8px;
            font-style: italic;
            font-size: 15px;
            line-height: 1.5;
            color: #555;
            text-align: justify;
        }
        .scripture-reference {
            font-weight: bold;
            color: #8b5a96;
            text-align: right;
            margin-top: 8px;
            font-size: 15px;
        }
        .certificate-text {
            font-size: 13px;
            line-height: 1.6;
            color: #333;
        }
        .person-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 15px 0;
        }
        .field-line {
            margin-bottom: 8px;
        }
        .underlined {
            border-bottom: 1px solid #333;
            display: inline-block;
            min-width: 150px;
            padding-bottom: 1px;
        }
        .registry-info {
            text-align: center;
            margin: 20px 0;
            font-size: 12px;
        }
        .parish-approval {
            background: #f0f8ff;
            border: 2px solid #8b5a96;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #333;
        }
        .approval-title {
            font-weight: bold;
            color: #8b5a96;
            font-size: 13px;
            margin-bottom: 8px;
        }
        .approval-text {
            line-height: 1.4;
            font-size: 11px;
        }
        .digital-disclaimer {
            background: linear-gradient(135deg, #8b5a96, #a855f7);
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-size: 10px;
            line-height: 1.4;
            margin-top: 20px;
        }
        .disclaimer-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-content">
            <!-- Header Section -->
            <div class="header-section">
                <div class="logo-cell">
                    <img src="{{ public_path('images/ditascom-logo.png') }}" alt="Diocese Logo">
                </div>
                <div class="header-info">
                    <div class="diocese-title">The Roman Catholic Diocese of Tagum</div>
                    <div class="parish-name">{{ strtoupper($certificate->subadmin->parish_name ?? 'SANTO NIÑO PARISH') }}</div>
                    <div class="parish-address">{{ $certificate->subadmin->parish_address ?? 'Panabo City, Davao del Norte, Philippines, 8105' }}</div>
                </div>
                <div class="cert-id-cell">
                    @if($certificate->subadmin && $certificate->subadmin->parish_logo)
                        <img src="{{ public_path('storage/' . $certificate->subadmin->parish_logo) }}" alt="Parish Logo" class="w-20 h-20 object-cover rounded-lg">
                    @else
                        <div class="cert-id-box">{{ $certificate->cert_id }}</div>
                    @endif
                </div>
            </div>
            
            <!-- Certificate Title -->
            <div class="certificate-title">Certificate of Confirmation</div>
            
            <!-- Main Layout -->
            <div class="main-layout">
                <div class="content-left">
                    <div class="certificate-text">
                        <div style="font-style: italic; margin-bottom: 15px;">According to the rites of the Roman Catholic Church</div>
                        
                        <div class="person-name">{{ $certificate->full_name }}</div>
                        
                        <div class="field-line">Child of</div>
                        <div class="field-line" style="font-weight: bold;"><span class="underlined">{{ $certificate->fathers_full_name ?? 'N/A' }}</span></div>
                        <div class="field-line">and</div>
                        <div class="field-line"style="font-weight: bold;"><span class="underlined">{{ $certificate->mothers_full_name ?? 'N/A' }}</span></div>
                        <div class="field-line">was baptized on</div>
                        <div class="field-line" style="font-weight: bold;"><span class="underlined">{{ \Carbon\Carbon::parse($certificate->date_of_baptism)->format('F d, Y') }}</span></div>
                        <div class="field-line">in the Church of</div>
                        <div class="field-line" style="font-weight: bold;"><span class="underlined">{{ $certificate->place_of_baptism ?? 'Sto. Niño Parish Panabo City' }}</span></div>
                        <div class="field-line">received the Holy Sacrament of <strong>CONFIRMATION</strong> on</div>
                        <div class="field-line" style="font-weight: bold;"><span class="underlined">{{ \Carbon\Carbon::parse($certificate->date_of_confirmation)->format('F d, Y') }}</span></div>
                        <div class="field-line">at <strong>{{ strtoupper($certificate->subadmin->parish_name ?? 'SANTO NIÑO PARISH') }}</strong>, {{ $certificate->subadmin->parish_address ?? 'Panabo City, Davao del Norte, Philippines, 8105' }}</div>
                        
                        <div style="margin-top: 15px;">
                            <div class="field-line">the sponsors being</div>
                            <div class="field-line"><span class="underlined">{{ $certificate->sponsor1 ?? 'N/A' }}</span></div>
                            @if($certificate->sponsor2)
                            <div class="field-line"><span class="underlined">{{ $certificate->sponsor2 }}</span></div>
                            @endif
                        </div>
                        
                        <div style="margin-top: 15px;">
                            <div class="field-line">by</div>
                            <div class="field-line"><strong>{{ $certificate->officiant ?? 'Bp. Wilfredo Manlapaz' }}</strong></div>
                            <div class="field-line" style="font-size: 11px;">as it appears in the Parish Confirmation Registry</div>
                        </div>
                    </div>
                </div>
                
                <div class="content-right">
                    <div class="confirmation-image">
                        <img src="{{ public_path('images/confirmation_png.png') }}" alt="Confirmation Symbol">
                    </div>
                    <div class="scripture-box">
                        "If anyone thirsts, let him come to me. Let him drink who believes in me. Scripture has it: 'From within rivers of living water shall flow.' Here he was referring to the Spirit, whom those that came to believe in him were to receive."
                        <div class="scripture-reference">Jn 7:37-39</div>
                    </div>
                </div>
            </div>
            
            <!-- Registry Information -->
            <div class="registry-info">
                <div style="font-weight: bold; margin-bottom: 5px;">{{ $certificate->cert_id }}</div>
                <div style="margin-bottom: 3px;">Date of Issue: {{ now()->format('l, F d, Y') }}</div>
                <div style="margin-bottom: 3px;">Purpose of Certificate: {{ $certRequest->purpose }}</div>
                @if($certificate->remarks)
                <div>Remarks: {{ $certificate->remarks }}</div>
                @endif
            </div>
            
            <!-- Parish Approval Section -->
            <div class="parish-approval">
                <div class="approval-title">PARISH APPROVED CERTIFICATE</div>
                <div class="approval-text">
                    This certificate has been electronically generated and approved by {{ strtoupper($certificate->subadmin->parish_name ?? 'SANTO NIÑO PARISH') }}. 
                    No physical seal is required as this document has been digitally authenticated and verified by the parish administration. 
                    This certificate carries the same validity and authority as traditionally sealed documents.
                </div>
            </div>
            
            <!-- Digital Disclaimer -->
            <div class="digital-disclaimer">
                <div class="disclaimer-title">DIGITALLY GENERATED CERTIFICATE</div>
                <div>This certificate has been electronically generated and is valid without physical seal. Any alteration renders it invalid. For verification, contact the parish office with ID: {{ $certificate->cert_id }}</div>
            </div>
        </div>
    </div>
</body>
</html>
