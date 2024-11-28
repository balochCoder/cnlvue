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
    <h1>Course Details</h1>
    <div class="image">
        <!-- Placeholder for the institution logo -->
        <img src="{{public_path('cnl.png')}}" alt="Institution Logo">
    </div>

    <table class="table">
        <tr>
            <th>Institution Name</th>

            <td style="background-color: #B8DAFF;">{{$course->representingInstitution->name}}</td>

        </tr>
        <tr>
            <th>Course Title</th>

            <td style="background-color: #B8DAFF;">{{$course->title}}</td>


        </tr>
        <tr>
            <th>Course Duration</th>


            @php
                $data = json_decode($course->duration, true);
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
            <td style="background-color: #B8DAFF;">{{$total_years_whole}} {{\Illuminate\Support\Str::plural('year', $total_years_whole)}}</td>


        </tr>
        <tr>
            <th>Course Level</th>


            <td style="background-color: #B8DAFF;">{{\App\Enums\CourseLevel::tryFrom($course->level)->getLabel()}}</td>


        </tr>
        <tr>
            <th>Course Fee</th>

            <td style="background-color: #B8DAFF;">{{$course->currency->symbol ?? $course->currency->code}}{{$course->fee}}</td>


        </tr>
        <tr>
            <th>Application Fee</th>

            <td style="background-color: #B8DAFF;">{{$course->currency->symbol ?? $course->currency->code}}{{$course->application_fee}}</td>


        </tr>
        <tr>
            <th>Course Benefits</th>

            <td style="background-color: #B8DAFF;">{{$course->course_benefits}}</td>

        </tr>
        <tr>
            <th>Campus</th>

            <td style="background-color: #B8DAFF;">{{$course->campus}}</td>

        </tr>
        <tr>
            <th>Awarding Body</th>

            <td style="background-color: #B8DAFF;">{{$course->awarding_body}}</td>

        </tr>
        <tr>
            <th>General Eligibility</th>

            <td style="background-color: #B8DAFF;">
                {{$course->general_eligibility}}
            </td>

        </tr>
        <tr>
            <th>Language Requirements</th>

            <td style="background-color: #B8DAFF;">
                {{$course->language_requirements}}
            </td>


        </tr>
        <tr>
            <th>Monthly Living Cost</th>

            <td style="background-color: #B8DAFF;">{{$course->currency->symbol ?? $course->currency->code}}{{$course->monthly_living_cost}}</td>


        </tr>
        <tr>
            <th>Funds Requirement for Visa</th>

            <td style="background-color: #B8DAFF;">{{$course->currency->symbol ?? $course->currency->code}}{{$course->representingInstitution->funds_required}}</td>

        </tr>
        <tr>
            <th>Part-Time Work</th>

            <td style="background-color: #B8DAFF;">{{$course->part_time_work_details}}</td>

        </tr>
        <tr>
            <th>Institutional Benefits</th>

            <td style="background-color: #B8DAFF;">{{$course->representingInstitution->institutional_benefits}}</td>

        </tr>
        <tr>
            <th>Visa Requirement</th>

            <td style="background-color: #B8DAFF;">{{$course->representingInstitution->representingCountry->visa_requirements}}</td>


        </tr>
        <tr>
            <th>Country Benefits</th>

            <td style="background-color: #B8DAFF;">{{$course->representingInstitution->representingCountry->country_benefits}}</td>


        </tr>
        <tr>
            <th>Course Intake</th>


            @php
                $intakes = json_decode($course->intake, true);
            @endphp
            <td style="background-color: #B8DAFF;">{{implode(', ', $intakes)}}</td>


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
