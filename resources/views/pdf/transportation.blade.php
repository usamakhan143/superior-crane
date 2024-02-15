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
            background-color:#FDF5F4;
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
                110 Konrad Cres. Unit 9 Markham, Ontario L3R 9X2: (416) 740-8107
            </p>
        </div>
        <div class="header-child">
            <p>Ticket No: <span class="ticket-number">{{ $data->ticketNumber }}</span></p>
        </div>
    </div>

    <!-- <div class="third-content">
        <p class="alert">
            TERMS: NET 30 DAVS FROM DATE OF INVOICE: Overdue accounts charged at 2%
            per month - 24% per year
        </p>
    </div> -->

    <table>
        <thead>
            <tr>
                <th>PICKUP ADDRESS</th>
                <th>BILLING ADDRESS</th>
                <th>Time In</th>
                <th>Time Out</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data->pickupAddress }}</td>
                <td>{{ $data->billingAddress }}</td>
                <td>{{ $data->TimeIn }}</td>
                <td>{{ $data->TimeOut }}</td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data->notes }}</td>
            </tr>
        </tbody>
    </table>
    <br />
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Special Instructions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Job Number</td>
                <td>{{ $data->job->job_number }}</td>
                <td>{{ $data->specialInstructionsForJobNumber }}</td>
            </tr>

            <tr>
                <td>PO #</td>
                <td>{{ $data->poNumber }}</td>
                <td>{{ $data->specialInstructionsForPoNumber }}</td>
            </tr>

            <tr>
                <td>Site Contact Name</td>
                <td>{{ $data->siteContactName }}</td>
                <td>{{ $data->specialInstructionsForSiteContactName }}</td>
            </tr>

            <tr>
                <td>Site Contact Number</td>
                <td>{{ $data->siteContactNumber }}</td>
                <td>{{ $data->specialInstructionsForSiteContactNumber }}</td>
            </tr>
        </tbody>
    </table>
    <br />
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Signature</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Shipper</td>
                <td>{{ $data->shipperName }}</td>
                <td>
                    @if ($data->shipperSignature->file_url ?? 0 != 0)
                        <img src="{{ asset('storage/'.$data->shipperSignature->file_url) ?? '-' }}" width="100px" />
                    @else
                        -
                    @endif
                </td>
                <td>{{ $data->shipperDate }}</td>
                <td>{{ $data->shipperTimeIn }}</td>
                <td>{{ $data->shipperTimeOut }}</td>
            </tr>

            <tr>
                <td>Customer</td>
                <td>{{ $data->customerName }}</td>
                <td>
                    @if ($data->customerSignature->file_url ?? 0 != 0)
                        <img src="{{ asset('storage/'.$data->customerSignature->file_url) ?? '-' }}" width="100px" />
                    @else
                        -
                    @endif
                </td>
                <td>{{ $data->customerDate }}</td>
                <td>{{ $data->customerTimeIn }}</td>
                <td>{{ $data->customerTimeOut }}</td>
            </tr>

            <tr>
                <td>Driver</td>
                <td>{{ $data->pickupDriverName }}</td>
                <td>
                    @if ($data->driverSignature->file_url ?? 0 != 0)
                        <img src="{{ asset('storage/'.$data->driverSignature->file_url) ?? '-' }}" width="100px" />
                    @else
                        -
                    @endif
                </td>
                <td>{{ $data->pickupDriverDate }}</td>
                <td>{{ $data->pickupDriverTimeIn }}</td>
                <td>{{ $data->pickupDriverTimeOut }}</td>
            </tr>

        </tbody>
    </table>
    <p class="alert-footer">
        Disclaimer: The shipper, upon tendering the shipment to the carrier, and the consignee, upon accepting the
        delivery of the shipment, shall be jointly and severally liable for all unpaid charges of the said shipment in
        accordance with applicable tariffs, including but not limited to sums advanced or disbursed by SCCI Logistics
        regarding the said shipment.

        Specialized equipment requires assembly/disassembly on-site. This service will be provided at the
        shipper's/receiver's expense. SCCI Logistics is not responsible for any crane and/or other third-party detention
        costs incurred due to varying weather conditions, equipment breakdowns, permit approvals, and/or police escort
        delays unless expressly stated in the quotation.

        Utilities, bridge surveys/evaluations, port charges, and all civil engineering are extra unless expressly stated
        in the quotation and will be billed upon payment being requested from SCCI Logistics by all third parties as an
        extra at cost plus 15%.

        Unless expressly stated in this quotation, loading and offloading will be the responsibility of the Customer,
        Shipper, Consignee, and/or others.
    </p>
</body>

</html>
