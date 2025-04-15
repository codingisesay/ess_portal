@extends('user_view.header')
@section('content')

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
  <h2>Raised Clims </h2>
  <p> Raised By :John Doe Claims</p>
  <p>No Of Claims : 3</p>
  <p>Total Amount : 6000</p>
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse1">#clm-001 | Rs. 2000</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">

            <div class="container-fluid">
          
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>S.No.</th>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Max Amount</th>
                      <th>Entered Amount</th>
                      <th>Bill</th>
                      <th>Claim Desc</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>1</td>
                        <td>01/01/2020</td>
                        <td>food</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Taking food</td>
                        <td><input type="checkbox" class="approval-checkbox" checked>
                        <textarea style="display:none;"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>01/01/2020</td>
                        <td>movie</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Watch Movie</td>
                        <td><input type="checkbox" class="approval-checkbox" checked>
                            <textarea style="display:none;"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>01/01/2020</td>
                        <td>club</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Drink</td>
                        <td><input type="checkbox" class="approval-checkbox" checked>
                            <textarea style="display:none;"></textarea>
                        </td>
                    </tr>
                  </tbody>
                </table>
                <button>Approv</button>
                <button>Review</button>
              </div>


        </div>
       
      </div>
    </div>
  </div>

  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse2">#clm-002 | Rs. 2000</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="container-fluid">
          
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>S.No.</th>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Max Amount</th>
                      <th>Entered Amount</th>
                      <th>Bill</th>
                      <th>Claim Desc</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>1</td>
                        <td>01/01/2020</td>
                        <td>food</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Taking food</td>
                        <td><input type="checkbox" checked></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>01/01/2020</td>
                        <td>movie</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Watch Movie</td>
                        <td><input type="checkbox" checked></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>01/01/2020</td>
                        <td>club</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Drink</td>
                        <td><input type="checkbox" checked></td>
                    </tr>
                  </tbody>
                </table>
              </div>
        </div>
       
      </div>
    </div>
  </div>

  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse3">#clm-003 | Rs. 2000</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="container-fluid">
          
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>S.No.</th>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Max Amount</th>
                      <th>Entered Amount</th>
                      <th>Bill</th>
                      <th>Claim Desc</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>1</td>
                        <td>01/01/2020</td>
                        <td>food</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Taking food</td>
                        <td><input type="checkbox" checked></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>01/01/2020</td>
                        <td>movie</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Watch Movie</td>
                        <td><input type="checkbox" checked></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>01/01/2020</td>
                        <td>club</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Drink</td>
                        <td><input type="checkbox" checked></td>
                    </tr>
                  </tbody>
                </table>
              </div>
        </div>
       
      </div>
    </div>
  </div>
</div>
    
        <script>
  // Select all checkboxes with the class
  const checkboxes = document.querySelectorAll('.approval-checkbox');

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function () {
      // Get the textarea next to the checkbox
      const textarea = this.nextElementSibling;

      if (!this.checked) {
        textarea.style.display = 'block';
      } else {
        textarea.style.display = 'none';
      }
    });
  });
</script> 

</body>


@endsection