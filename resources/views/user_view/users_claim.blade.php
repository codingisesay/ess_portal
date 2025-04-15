@extends('user_view.header')
@section('content')
<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
=======

>>>>>>> 9227786157a3e718be928006df4ae1b4ef70cc8e
<head>
    <meta charset="UTF-8">
    <title>Claims Page</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="claim-container">
    <h2 class="claim-summary">John Doe Claims</h2>
    <p class="claim-summary">No Of Claims: 3</p>
    <p class="claim-summary">Total Amount: 6000</p>

<<<<<<< HEAD
    <!-- Claim Panel -->
    <div class="claim-panel">
        <div class="claim-header" onclick="toggleBody(this)">#clm-001 | Rs. 2000</div>
        <div class="claim-body" style="display: block;">
            <table class="custom-table">
                <thead>
=======
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
>>>>>>> 9227786157a3e718be928006df4ae1b4ef70cc8e
                    <tr>
                        <th>S.No.</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Max Amount</th>
                        <th>Entered Amount</th>
                        <th>Bill</th>
                        <th>Comment</th>
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
                        <td>Testing</td>
                        <td>Taking food</td>
                        <td>
                            <input type="checkbox" class="approval-checkbox" checked>
                            <textarea></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>01/01/2020</td>
                        <td>movie</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Testing</td>
                        <td>Watch Movie</td>
                        <td>
                            <input type="checkbox" class="approval-checkbox" checked>
                            <textarea></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>01/01/2020</td>
                        <td>club</td>
                        <td>250</td>
                        <td>500</td>
                        <td></td>
                        <td>Testing</td>
                        <td>Drink</td>
                        <td>
                            <input type="checkbox" class="approval-checkbox" checked>
                            <textarea></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="button-group">
                <button>Approve</button>
                <button>Review</button>
            </div>
        </div>
    </div>

    <div class="claim-panel">
        <div class="claim-header" onclick="toggleBody(this)">#clm-002 | Rs. 2500</div>
        <div class="claim-body">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Max Amount</th>
                        <th>Entered Amount</th>
                        <th>Bill</th>
                        <th>Comment</th>
                        <th>Claim Desc</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>02/01/2020</td>
                        <td>travel</td>
                        <td>500</td>
                        <td>1000</td>
                        <td></td>
                        <td>Testing</td>
                        <td>Travel Expenses</td>
                        <td>
                            <input type="checkbox" class="approval-checkbox" checked>
                            <textarea></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>02/01/2020</td>
                        <td>lodging</td>
                        <td>1000</td>
                        <td>1500</td>
                        <td></td>
                        <td>Testing</td>
                        <td>Hotel Stay</td>
                        <td>
                            <input type="checkbox" class="approval-checkbox" checked>
                            <textarea></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="button-group">
                <button>Approve</button>
                <button>Review</button>
            </div>
        </div>
    </div>

    <div class="claim-panel">
        <div class="claim-header" onclick="toggleBody(this)">#clm-003 | Rs. 1500</div>
        <div class="claim-body">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Max Amount</th>
                        <th>Entered Amount</th>
                        <th>Bill</th>
                        <th>Comment</th>
                        <th>Claim Desc</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>03/01/2020</td>
                        <td>medical</td>
                        <td>500</td>
                        <td>700</td>
                        <td></td>
                        <td>Testing</td>
                        <td>Medical Expenses</td>
                        <td>
                            <input type="checkbox" class="approval-checkbox" checked>
                            <textarea></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>03/01/2020</td>
                        <td>stationery</td>
                        <td>300</td>
                        <td>800</td>
                        <td></td>
                        <td>Testing</td>
                        <td>Office Supplies</td>
                        <td>
                            <input type="checkbox" class="approval-checkbox" checked>
                            <textarea></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="button-group">
                <button>Approve</button>
                <button>Review</button>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleBody(header) {
        const body = header.nextElementSibling;
        body.style.display = body.style.display === 'block' ? 'none' : 'block';
    }

    document.querySelectorAll('.approval-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const textarea = this.nextElementSibling;
            textarea.style.display = this.checked ? 'none' : 'block';
        });
    });
<<<<<<< HEAD
</script>

<style>
  /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


.claim-container {
    /* max-width: 1000px; */
    width: 100%;
    margin: 0 auto;
    padding: 20px;
}

.claim-container h2 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}

.claim-summary {
    margin-bottom: 10px;
    color: #666;
}

.claim-panel {
    background-color: #ffffff;
    margin-bottom: 25px;
    border-radius: 5px;
    overflow: hidden;
    /* box-shadow: 0 2px 5px rgba(0,0,0,0.1); */
    box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
}

.claim-header {
    padding: 15px 20px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    background: #ffffff;
    color: #333;
    transition: background 0.3s ease;
}

.claim-header:hover {
    background: #ffffff;
}

.claim-body {
    display: none;
    padding: 20px;
    background-color: #fff;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.custom-table th,
.custom-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.custom-table th {
    background-color: #E0AFA0;
}

.custom-table tr:nth-child(even) {
    background-color: #fff;
}

.custom-table tr:nth-child(odd) {
    background-color: #f9f9f9;
}

textarea {
    display: none;
    margin-top: 5px;
    width: 100%;
    padding: 8px;
    font-size: 14px;
    resize: none;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.button-group {
    margin-top: 15px;
    display: flex;
    gap: 10px;
    margin-left: 1242px;
}

.button-group button {
    padding: 10px 20px;
    background-color: #8A3366;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

.button-group button:hover {
    background-color: #9b4bab;
}

</style>

</body>
</html>
@endsection

=======
  });
</script> 

</body>


@endsection
>>>>>>> 9227786157a3e718be928006df4ae1b4ef70cc8e
