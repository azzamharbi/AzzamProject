<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MySQL Ajax CRUD with Bootstrap 5 and Datatables Library</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Datatables CSS  -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <!-- CSS  -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#00ff5573;">برنامج النشامى للتقسيط والتمويل
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-body-secondary">
                <span class="h5">All Users</span>
                <br>
                Manage all your existing users or add a new on
            </div>
            <!-- Button to trigger Add user offcanvas -->
            <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
                <i class="fa-solid fa-user-plus fa-xs"></i>
                Add new user
            </button>
        </div>


        <table class="table table-bordered table-striped table-hover align-middle" id="myTable" style="width:100%;">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>العقد</th>
                    <th>العميل</th>
                    <th>تاريخ العقد</th>
                    <th>تاريخ نهاية العقد</th>
                    <th>الكمية</th>
                    <th>القسط</th>
                    <th>اجمالي العقد</th>
                    <th>طريقة السداد</th>
                    <th>حالة العقد</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>



    <!-- Add user offcanvas  -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" style="width:600px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add new user</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form dir="rtl" method="POST" id="insertForm">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">العقد</label>
                        <input type="text" class="form-control" name="contract" placeholder="العقد">
                    </div>
                    <div class="col">
                        <label class="form-label">العميل</label>
                        <input type="text" class="form-control" name="client" placeholder="العميل">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">تاريخ العقد</label>
                    <input type="date" class="form-control" name="contdate" placeholder="تاريخ العقد">
                </div>
                <div class="mb-3">
                    <label class="form-label">تاريخ نهاية العقد</label>
                    <input type="date" class="form-control" name="contenddate" placeholder="تاريخ نهاية العقد">
                </div>
                <div class="mb-3">
                    <label class="form-label">الكمية</label>
                    <input type="text" class="form-control" name="kamia" placeholder="الكمية">
                </div>
                <div class="mb-3">
                    <label class="form-label">القسط</label>
                    <input type="text" class="form-control" name="qist" placeholder="القسط">
                </div>
                <div class="mb-3">
                    <label class="form-label">إجمالي العقد</label>
                    <input type="text" class="form-control" name="conttotal" placeholder="إجمالي العقد">
                </div>
                <div class="col-10">
                    <label class="form-label">طريقة السداد</label>
                    <select name="wayofpay" class="form-control">
                        <option value="استقطاع">استقطاع</option>
                        <option value="نقدي">نقدي</option>
                        <option value="استقطاع ضمان">استقطاع ضمان</option>
                        <option value="تسليم البطاقة">تسليم بطاقة</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">حالة العقد:</label>
                    &nbsp;&nbsp;
                    <input type="radio" class="form-check-input" name="status" value="نشط">
                    <label class="form-input-label">نشط</label>
                    &nbsp;
                    <input type="radio" class="form-check-input" name="status" value="مخالصة">
                    <label class="form-input-label">مخالصة</label>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary me-1" id="insertBtn">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>



    <!-- Edit user offcanvas  -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditUser" style="width:600px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Edit user data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form dir="rtl" method=" POST" id="editForm">
                <input type="hidden" name="id" id="id">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">العقد</label>
                        <input type="text" class="form-control" name="contract" placeholder="العقد">
                    </div>
                    <div class="col">
                        <label class="form-label">العميل</label>
                        <input type="text" class="form-control" name="client" placeholder="العميل">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">تاريخ العقد</label>
                    <input type="date" class="form-control" name="contdate" placeholder="تاريخ العقد">
                </div>
                <div class="mb-3">
                    <label class="form-label">تاريخ نهاية العقد</label>
                    <input type="date" class="form-control" name="contenddate" placeholder="تاريخ نهاية العقد">
                </div>
                <div class="mb-3">
                    <label class="form-label">الكمية</label>
                    <input type="text" class="form-control" name="kamia" placeholder="الكمية">
                </div>
                <div class="mb-3">
                    <label class="form-label">القسط</label>
                    <input type="text" class="form-control" name="qist" placeholder="القسط">
                </div>
                <div class="mb-3">
                    <label class="form-label">إجمالي العقد</label>
                    <input type="text" class="form-control" name="conttotal" placeholder="إجمالي العقد">
                </div>      
        <div class="mb-3">
            <label class="form-label">طريقة السداد</label>
            <select name="wayofpay" class="form-control">
                <option value="استقطاع">استقطاع</option>
                <option value="نقدي">نقدي</option>
                <option value="استقطاع ضمان">استقطاع ضمان</option>
                <option value="تسليم البطاقة">تسليم بطاقة</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">حالة العقد:</label>
            &nbsp;&nbsp;
            <input type="radio" class="form-check-input" name="status" value="نشط">
            <label class="form-input-label">نشط</label>
            &nbsp;
            <input type="radio" class="form-check-input" name="status" value="مخالصة">
            <label class="form-input-label">مخالصة</label>
        </div>
        <div>
            <button type="submit" class="btn btn-primary me-1" id="editBtn">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
        </form>
    </div>
    </div>



    <!-- Toast container  -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <!-- Success toast  -->
        <div class="toast align-items-center text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"
            id="successToast">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>Success!</strong>
                    <span id="successMsg"></span>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <!-- Error toast  -->
        <div class="toast align-items-center text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true"
            id="errorToast">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>Error!</strong>
                    <span id="errorMsg"></span>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>


    <!-- Bootstrap  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Datatables  -->
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
    <!-- JS  -->
    <script src="script.js"></script>
</body>

</html>