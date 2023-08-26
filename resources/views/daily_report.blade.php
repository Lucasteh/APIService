<html>
<head>
  <title>Laravel 9 Generate PDF File Using DomPDF - Techsolutionstuff</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12" style="margin-top: 15px ">
        <div class="pull-left">
          <h2>{{$title}}</h2>
        </div>
      </div>
    </div><br>
    <table class="table table-bordered">
      <tr>
        <th>Transaction ID</th>
        <th>Game ID</th>
        <th>Amount</th>
        <th>Draw Date</th>
        <th>Ticket Date</th>
      </tr>
      @foreach ($transactions as $transaction)
      <tr>
        <td>{{ $transaction->transaction_id }}</td>
        <td>{{ $transaction->game_id }}</td>
        <td>{{ $transaction->amount }}</td>
        <td>{{ $transaction->draw_date }}</td>
        <td>{{ $transaction->ticket_date }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</body>
</html>