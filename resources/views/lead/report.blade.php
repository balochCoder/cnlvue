<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eee;
        }

        .container {
            width: 700px;
            margin: 20px auto;
            background: white;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header .logo, .header .details {
            display: inline-block;  /* Use inline-block for both elements */
            vertical-align: middle;
            margin-top: 30px;/* Align them vertically */
            margin-left: 30px;
        }

        .header .details {
            text-align: right;
        }
        .header .logo img {
            width: 80px;
            height: 80px;
            border: 2px solid #ccc;
            border-radius: 50%;
        }


        .header .details h1 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .header h2 {
            color: #333;
            margin-right: 20px;
        }

        .header .details p {
            margin: 5px 0;
            font-size: 12px;
            color: #777;
        }

        .student-info {
            padding: 16px;
            background-color: #f5f7fa;
            border-bottom: 2px solid #ddd;
        }

        .student-info h2 {
            font-size: 16px;
            color: #333;
            margin: 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #5b9bd5;
        }

        .student-info .info-row {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .student-info .info-row div {
            font-size: 12px;
            color: #555;
        }

        .follow-up {
            padding: 20px;
            border-bottom: 2px solid #ddd;
        }

        .follow-up h3 {
            font-size: 12px;
            margin-bottom: 30px;
        }

        .follow-up .icons {
            display: flex !important;
            justify-content: space-around !important;
            flex-wrap: nowrap;  /* Ensures icons remain in a single line */
            width: 100%;
        }

        .follow-up .icons .icon {
            text-align: center;
            font-size: 12px;
            color: #555;
            width: 16%; /* Ensure icons are distributed evenly across the row */
            display: inline-block;  /* Use inline-block to ensure horizontal alignment */
            margin-right: 10px;
        }

        .follow-up .icons .icon img {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
        }

        .additional-info {
            padding: 20px;
            font-size: 12px;
            color: #555;
        }

        .additional-info .info-item {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }

        .additional-info .info-item strong {
            color: #333;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <img src="{{public_path('/cnl.png')}}" alt="No Image Available">
            </div>
            <div class="details">
                <h1>CNL UK</h1>
                <p>United Kingdom</p>
            </div>
        </div>
        <div style="margin-left: auto; text-align: right;">
            <h2>Student Report</h2>
        </div>
    </div>
    <!-- Student Info -->
    <div class="student-info">
        <h2>Student Name: <span>{{$lead->student_first_name}} {{$lead->student_last_name}}</span></h2>
        @if(request()->contact)
            <div class="info-row">
                <div>Email ID: {{$lead->student_email}}</div>
                <div>Contact Number: {{$lead->student_phone}}, {{$lead->student_mobile}}</div>
            </div>
        @endif
        <div class="info-row">
            @php
                $counsellorNames = $lead->counsellors ? collect($lead->counsellors)->pluck('user.name')->implode(', '): 'No counsellors found';
            @endphp
            <div>Counsellor: {{$counsellorNames}}</div>
            @if(request()->contact)
                <div>Date of Birth: {{\Carbon\Carbon::parse($lead->date_of_birth)->format('d M Y')}}</div>
            @endif
        </div>
        <div class="info-row">
            <div>Lead Source: {{\Illuminate\Support\Str::ucfirst($lead->leadSource->source_name)}}</div>
            <div>Lead Type: {{\App\Enums\LeadStatus::tryFrom($lead->status)?->getLabel()}}</div>
        </div>
        <div class="info-row">
            <div>Added On: {{\Carbon\Carbon::parse($lead->created_at)->format('d M Y')}}</div>
            <div>Last Updated: {{\Carbon\Carbon::parse($lead->updated_at)->format('d M Y')}}</div>
        </div>
    </div>

    <!-- Follow-up -->
    <div class="follow-up">
        <h3>Total Follow-up: {{count($lead->followups)}}</h3>
        <div class="icons">
            <div class="icon">
                <img src="{{public_path('/meeting.png')}}" alt="Meetings">
                <p>Meetings: {{$lead->followupsCountByMode['meeting'] ?? 0}}</p>
            </div>
            <div class="icon">
                <img src="{{public_path('/zoom.png')}}" alt="Zoom">
                <p>Zoom: {{$lead->followupsCountByMode['zoom'] ?? 0}}</p>
            </div>
            <div class="icon">
                <img src="{{public_path('/email.png')}}" alt="Email">
                <p>Email: {{$lead->followupsCountByMode['email'] ?? 0}}</p>
            </div>
            <div class="icon">
                <img src="{{public_path('/meet.png')}}" alt="Google Meet">
                <p>Google Meet: {{$lead->followupsCountByMode['google_meet'] ?? 0}}</p>
            </div>
            <div class="icon">
                <img src="{{public_path('/phone.jpg')}}" alt="Phone">
                <p>Phone: {{$lead->followupsCountByMode['phone'] ?? 0}}</p>
            </div>
            <div class="icon">
                <img src="{{public_path('/whatsapp.png')}}" alt="WhatsApp">
                <p>WhatsApp: {{$lead->followupsCountByMode['whatsapp'] ?? 0}}</p>
            </div>

            <div class="icon">
                <img src="{{public_path('/skype.png')}}" alt="Skype">
                <p>Skype: {{$lead->followupsCountByMode['skype'] ?? 0}}</p>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="additional-info">
        <div class="info-item">
            <strong>Country of Interest:</strong>
            <span>{{$lead->interestedCountry->name ?? '-'}}</span>
        </div>
        <div class="info-item">
            <strong>Interested Institution:</strong>
            <span>{{$lead->interestedInstitution->name ?? "-"}}</span>
        </div>
        <div class="info-item">
            <strong>Intake of Interest:</strong>
            <span>{{$lead->intake_of_interest_month}} - {{$lead->intake_of_interest_year}}</span>
        </div>
        <div class="info-item">
            <strong>Budget:</strong>
            <span>{{$lead->estimated_budget ?? "-"}}</span>
        </div>
        <div class="info-item">
            <strong>Field of Interest:</strong>
            @php
                // Map the selected categories to their labels
                $categoryLabels = $categoryLabels = $lead->course_category
    ? array_map(
        fn($category) => \App\Enums\CourseCategories::tryFrom($category)?->getLabel(),
        json_decode($lead->course_category)
      )
    : ["-"];;
                // Convert the array of labels to a comma-separated string
                $commaSeparatedLabels = implode(', ', $categoryLabels);
            @endphp
            <span>{{$commaSeparatedLabels}}</span>
        </div>
    </div>
</div>
</body>
</html>
