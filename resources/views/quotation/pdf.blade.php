<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 15px;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 800px;

            margin: auto;
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 20px;
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table th, .table td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 10px;
        }

        .table th {
            background-color: #f7f7f7;
            font-weight: bold;
            width: 20%;
            color: #555;
        }

        .image {
            text-align: center;
            margin-bottom: 15px;
        }

        .image img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        footer {
            font-size: 12px;
            text-align: center;
            color: #888;
            margin-top: 10px;
        }

        footer a {
            color: #0066cc;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Student Quotation / Course Comparison</h1>
    <div class="image">
        <!-- Placeholder for the institution logo -->
        <img src="{{public_path('cnl.png')}}" alt="Institution Logo">
    </div>

    <table class="table">
        <tr>

            <th>Institution Name</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->institution->name}}</td>
            @endforeach
        </tr>
        <tr>
            <th>Course Title</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->title}}</td>
            @endforeach

        </tr>
        <tr>
            <th>Course Duration</th>
            @foreach($quotation->quotationChoices as $index=> $choice)

                @php
                    $data = json_decode($choice->course->duration, true);
                    $year = $data['year'];
                    $months = $data['month'];
                    $weeks = $data['weeks'];

                    $months_to_years = $months / 12;
                    $weeks_to_years = $weeks / 52;

                    // Calculate total years
                    $total_years = $year + $months_to_years + $weeks_to_years;

                    // Round down to the nearest whole number
                    $total_years_whole = floor($total_years);
                @endphp
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$total_years_whole}} {{\Illuminate\Support\Str::plural('year', $total_years_whole)}}</td>
            @endforeach

        </tr>
        <tr>
            <th>Course Level</th>
            @foreach($quotation->quotationChoices as $index=> $choice)

                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{\App\Enums\CourseLevel::tryFrom($choice->course->level)->getLabel()}}</td>
            @endforeach

        </tr>
        <tr>
            <th>Course Fee</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->currency->symbol ?? $choice->course->currency->code}}{{$choice->course->fee}}</td>
            @endforeach

        </tr>
        <tr>
            <th>Application Fee</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->currency->symbol ?? $choice->course->currency->code}}{{$choice->course->application_fee}}</td>
            @endforeach

        </tr>
        <tr>
            <th>Course Benefits</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->course_benefits}}</td>
            @endforeach
        </tr>
        <tr>
            <th>Campus</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->campus}}</td>
            @endforeach
        </tr>
        <tr>
            <th>Awarding Body</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->awarding_body}}</td>
            @endforeach
        </tr>
        <tr>
            <th>General Eligibility</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">
                    {{$choice->course->general_eligibility}}
                </td>
            @endforeach
        </tr>
        <tr>
            <th>Language Requirements</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">
                    {{$choice->course->language_requirements}}
                </td>
            @endforeach

        </tr>
        <tr>
            <th>Monthly Living Cost</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->currency->symbol ?? $choice->course->currency->code}}{{$choice->course->monthly_living_cost}}</td>
            @endforeach

        </tr>
        <tr>
            <th>Funds Requirement for Visa</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->currency->symbol ?? $choice->course->currency->code}}{{$choice->course->representingInstitution->funds_required}}</td>
            @endforeach
        </tr>
        <tr>
            <th>Part-Time Work</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->part_time_work_details}}</td>
            @endforeach
        </tr>
        <tr>
            <th>Institutional Benefits</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->representingInstitution->institutional_benefits}}</td>
            @endforeach
        </tr>
        <tr>
            <th>Visa Requirement</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->representingInstitution->representingCountry->visa_requirements}}</td>
            @endforeach

        </tr>
        <tr>
            <th>Country Benefits</th>
            @foreach($quotation->quotationChoices as $index=> $choice)
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{$choice->course->representingInstitution->representingCountry->country_benefits}}</td>
            @endforeach

        </tr>
        <tr>
            <th>Course Intake</th>
            @foreach($quotation->quotationChoices as $index=> $choice)

                @php
                    $intakes = json_decode($choice->course->intake, true);
                @endphp
                <td style="background-color: {{ $index % 2 == 0 ? '#B8DAFF' : '#BEE5EB' }}">{{implode(', ', $intakes)}}</td>
            @endforeach

        </tr>
    </table>


    <footer>
        <span style="color: red">Declaration:</span> We confirm that the details on this sheet are fair and accurate to
        best of our knowledge. If you find different information elsewhere please inform us so that we can update our
        records. Do not hesitate to contact us for any further information and assistance with your admission process.
    </footer>
</div>
</body>
</html>
