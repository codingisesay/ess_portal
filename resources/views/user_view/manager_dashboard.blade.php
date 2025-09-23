
<div class="container">
    <h2>Manager Dashboard</h2>

    {{-- 1. Organization Goals Assigned --}}
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Organization Goals Assigned</strong></div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Goal</th>
                        <th>Period</th>
                        <th>Status</th>
                        <th>Add Insight</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($assignedGoals as $goal) --}}
                    <tr>
                        <td>Goal Title Example</td>
                        <td>Q1 2025</td>
                        <td>In Progress</td>
                        <td>
                            <form>
                                <input type="text" class="form-control mb-1" placeholder="Add insight...">
                                <button class="btn btn-sm btn-primary">Save</button>
                            </form>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- 2. Additional Goals/Tasks --}}
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Additional Goals/Tasks (Self/Juniors)</strong></div>
        <div class="card-body">
            <form class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Goal/Task Title">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control">
                            <option>Assign to Self</option>
                            <option>Assign to Junior 1</option>
                            <option>Assign to Junior 2</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success w-100">Add</button>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($additionalGoals as $goal) --}}
                    <tr>
                        <td>Extra Task Example</td>
                        <td>Junior 1</td>
                        <td>Pending</td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- 3. Task List --}}
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Task List (Own Tasks)</strong></div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($ownTasks as $task) --}}
                    <tr>
                        <td>My Task Example</td>
                        <td>Completed</td>
                        <td><button class="btn btn-sm btn-warning">Edit</button></td>
                        <td><button class="btn btn-sm btn-danger">Delete</button></td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- 4. Insights Section --}}
    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Insights on Organization Goals</strong></div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Goal</th>
                        <th>Insight</th>
                        <th>Added By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($insights as $insight) --}}
                    <tr>
                        <td>Goal Title Example</td>
                        <td>Insight text example...</td>
                        <td>Manager Name</td>
                        <td>2025-09-23</td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
