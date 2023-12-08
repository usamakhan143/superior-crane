<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Rigger Ticket</title>
  </head>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0px;
      color: #333;
    }

    @page  {
        margin: 1cm 1cm 1cm 1cm;
    }

    header {
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      max-width: 100px; /* Adjust the size as needed */
    }

    .header-child{
        float: left;
        width: 15%;
    }

    .heading{
        width: 70%;
        float: left;
      color: #555;
      margin: 0px;
      text-align: center;
    }

    section {
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    td {
      border: 1px solid #ddd;
      padding: 7px;
      text-align: left;
      font-size: 13px;
    }

    th {
      background-color: #f2f2f2;
      border: 1px solid #ddd;
      padding: 7px;
      text-align: left;
      font-size: 13px;
      font-weight: bolder;
    }

    .second-sec {
        
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .child-second-sec {
        /* float: left; */
      width: 50%;
    }

    .alert {
      color: red;
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
      padding: 0px;
      margin: 0px;
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
  <body>
    <header>
      <div class="header-child">
        <img class="logo" src="./logo.png" alt="Company Logo" />
      </div>
      <div class="heading header-child">
        <h1 class="company-info">SUPERIOR CRANE CANADA INC.</h1>
        <p class="tag-line">
          12 GREENBRIAR ROAD, TORONTO, ONTARIO M2K 1H5 TEL: (416) 740-8107
        </p>
      </div>
      <div class="header-child">
        <p>Ticket No: <span class="ticket-number">7373</span></p>
      </div>
    </header>

    <section>
        <div class="second-sec">
      <div class="child-second-sec">-----</div>
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
                John DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
                DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
                DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
                DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJoohn
                DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn Doe
              </td>
            </tr>
          </tbody>
        </table>
      </div>
        </div>
    </section>
    <div>
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
          <td>{{ $data->customer }}</td>
          <td>
            JoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
            DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
            DoeJohn DoeJohn DoeJohn DoeJohoe
          </td>
          <td>9292</td>
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
          <td>Date</td>
          <td>Leave yard</td>
          <td>START JOB</td>
          <td>FINISH JOB</td>
          <td>ARRIVAL YARD</td>
          <td>LUNCH</td>
          <td>TRAVEL TIME</td>
          <td>CRANE TIME</td>
          <td>TOTAL HOURS</td>
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
          <td>CRANE NUMBER</td>
          <td>RATING</td>
          <td>BOOM LENGTH</td>
          <td>OPERATOR</td>
          <td>OtdER EQUIPMENT</td>
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
            John DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
            DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
            DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
            DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
            DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
            DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
            DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn
            DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn DoeJohn Doe
          </td>
          <td>
            <img src="./logo.png" width="100px" />
          </td>
        </tr>
      </tbody>
    </table>

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
          <td>DATE</td>
          <td>LOCATION</td>
          <td>START TIME</td>
          <td>FINISH TIME</td>
          <td>TOTAL HOURS</td>
          <td>OFFICER</td>
          <td>OFFICER NAME</td>
          <td>DIVISION</td>
          <td><img src="./logo.png" width="100px" /></td>
        </tr>
      </tbody>
    </table>

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
