@extends('user_view.header')
@section('content')
<?php 
error_reporting(0);
?>
 
 <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}"> 

 <div class=" mx-4">
    <h2>
        <span onclick="history.back()"> &lt; </span>
         Reimbursement Claims        
    </h2>
                    <div class="claim-panel p-3">
        <p class="claim-summary m-0" onclick="toggleBody(this)">Tracking ID :<strong> #RM-Z32X7SRD7G </strong></p>
        <div>
            <hr>
            <!-- <p class="claim-summary">Total Amount: Rs. 400.00</p> -->
            <p class="">Description:<strong> Demo</strong></p>
                <div class=" tbl-container "> <!-- Open by default -->
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Date</th>
                                <th>Entered Amount</th>
                                <th>Bill</th>
                                <th>Applicant Comment</th>
                                <th>Manager Remark</th>
                                <th>Action</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                              <tr>
                                <td>1</td>
                                <td>17/04/2025</td>
                                <td>400.00</td>
                                <td>
                                  <a href="#" target="_blank" class="text-decoration-none" title="open in new tab">
                                    <x-icon name="newtab" />
                                  </a>
                                </td>
                                <td>demo</td>
                                <td>-</td>
                                <td> 
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked="">
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <input class="input-field py-1 " type="text" placeholder="Remark" style="width:200px" fdprocessedid="whw1u">
                                </td>  
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="text-align: right; font-weight: bold;">Total Amount:</td>
                                <td colspan="4" style="font-weight: bold;">Rs. 800.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row ">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="floating-label-wrapper">
                                <input type="text" maxlength="200" id="task" name="task_name" placeholder="Task Description" class="input-field" required="" fdprocessedid="13u67k">
                                <label for="task">Task</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-end  mt-2">
                    <button class="py-1 mx-1 px-3 btn-warning text-white" fdprocessedid="4kwxe7">Revert</button>
                    <button class="py-1 mx-1 px-3 btn-danger" fdprocessedid="uorz0p">Reject</button>
                    <button class="py-1 mx-1 px-3 btn-success" fdprocessedid="worwoi">Approve</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection
