<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Transportation Ticket</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            /* display: flex; */
            width: 100%;
            height: 100px;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .company-head {
            width: 70%;
            float: left;
            text-align: center;
        }

        .header-child {
            float: left;
            width: 15%;
            text-align: center;
        }

        .logo {
            width: 150px;
            /* Adjust the size as needed */
        }

        h1 {
            color: #555;
            margin: 0;
        }

        .company-info {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #ddd;
            padding: 7px;
            text-align: left;
            font-size: 13px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .container {
            height: 100px !important;
        }

        .second-sec {
            /* display: flex; */
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .child-second-sec {
            float: left;
            width: 50%;
        }

        .third-content {
            height: 50px;
            width: 100%;
            display: table;
        }

        .alert {
            color: red;
            vertical-align: middle;
            display: table-cell;
            text-align: center;
            line-height: 16px;
            font-size: 14px;
        }

        .alert-footer {
            color: red;
            text-align: left;
            line-height: 16px;
            font-size: 14px;
        }

        .tag-line {
            font-size: 14px;
            padding: 0;
            margin: 0;
        }

        .ticket-number {
            color: red;
            line-height: 16px;
            font-weight: bold;
        }

        .second-form {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-child">
            <img class="logo" src="{{ app()->isLocal() ? './logo.png' : asset('logo.png') }}" alt="Company Logo" />
        </div>
        <div class="company-head">
            <h1 class="company-info">SUPERIOR CRANE CANADA INC.</h1>
            <p class="tag-line">
                12 GREENBRIAR ROAD, TORONTO, ONTARIO M2K 1H5 TEL: (416) 740-8107
            </p>
        </div>
        <div class="header-child">
            <p>Ticket No: <span class="ticket-number">{{ $data->ticketNumber }}</span></p>
        </div>
    </div>

    <div class="container">
        <div class="second-sec">
            <div class="child-second-sec"></div>
            <div class="child-second-sec">
                <table>
                    <thead>
                        <tr>
                            <th>SPECIFICATIONS AND REMARKS:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{-- {{ $data->specificationsAndRemarks }} --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="third-content">
        <p class="alert">
            TERMS: NET 30 DAVS FROM DATE OF INVOICE: Overdue accounts charged at 2%
            per month - 24% per year
        </p>
    </div>
    <!-- 1ST ROW -->
    <table>
        <thead>
            <tr>
                <th>CUSTOMER</th>
                <th>LOCATION</th>
                <th>P.O. NUMBER</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{-- {{ $data->customer }} --}}
                </td>
                <td>
                    {{-- {{ $data->location }} --}}
                </td>
                <td>
                    {{-- {{ $data->poNumber }} --}}
                </td>
            </tr>
            <!-- Add more data rows as needed -->
        </tbody>
    </table>
    <!--2ND ROW-->
    <table>
        <thead>
            <tr>
                <th>DATE</th>
                <th>LEAVE YARD</th>
                <th>START JOB</th>
                <th>FINISH JOB</th>
                <th>ARRIVAL YARD</th>
                <th>LUNCH</th>
                <th>TRAVEL TIME</th>
                <th>CRANE TIME</th>
                <th>TOTAL HOURS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data->date }}</td>
                <td>{{ $data->leaveYard }}</td>
                <td>{{ $data->startJob }}</td>
                <td>{{ $data->finishJob }}</td>
                <td>{{ $data->arrivalYard }}</td>
                <td>{{ $data->lunch }}</td>
                <td>{{ $data->travelTime }}</td>
                <td>{{ $data->craneTime }}</td>
                <td>{{ $data->totalHours }}</td>
            </tr>
            <!-- Add more data rows as needed -->
        </tbody>
    </table>
    <!-- 3RD ROW-->
    <table>
        <thead>
            <tr>
                <th>CRANE NUMBER</th>
                <th>RATING</th>
                <th>BOOM LENGTH</th>
                <th>OPERATOR</th>
                <th>OTHER EQUIPMENT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data->craneNumber }}</td>
                <td>{{ $data->rating }}</td>
                <td>{{ $data->boomLength }}</td>
                <td>{{ $data->operation }}</td>
                <td>{{ $data->otherEquipment }}</td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th>NOTES/OTHER:</th>
                <th>SIGNATURE</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $data->notesOthers }}
                </td>
                <td>
                    <img src='{{ $data->signature->file_url }}' width="100px" />
                </td>
            </tr>
        </tbody>
    </table>

    @if ($data->isPayDuty != 0)
        <div>
            <h3 class="second-form">PayDuty</h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th>DATE</th>
                    <th>LOCATION</th>
                    <th>START TIME</th>
                    <th>FINISH TIME</th>
                    <th>TOTAL HOURS</th>
                    <th>OFFICER</th>
                    <th>OFFICER NAME</th>
                    <th>DIVISION</th>
                    <th>SIGNATURE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data->payDuty->date }}</td>
                    <td>{{ $data->payDuty->location }}</td>
                    <td>{{ $data->payDuty->startTime }}</td>
                    <td>{{ $data->payDuty->finishTime }}</td>
                    <td>{{ $data->payDuty->totalHours }}</td>
                    <td>{{ $data->payDuty->officer }}</td>
                    <td>{{ $data->payDuty->officerName }}</td>
                    <td>{{ $data->payDuty->division }}</td>
                    <td><img src='{{ $data->payDuty->signature->file_url }}' width="100px" /></td>
                </tr>
            </tbody>
        </table>
    @endif
    <p class="alert-footer">
        Customer agrees should the grounds or site be unfit or blocked by
        obstructions and the machine operator is instructed to proceed by customer
        or agent, the customer and agent assume full liability for damages to the
        machine and the surrounding grounds, buildings and materials. Customer
        shall pay any overtime charges incurred for operators in accordance with
        our union contract, if applicable. Fuel surcharges may be adjusted from
        time to time without notice. The undersigned acknowledges that the above
        services were received and performed to satisfaction by Superior Crane.
    </p>
</body>

</html>
