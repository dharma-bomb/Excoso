<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry List</title>

    <!-- favicon  -->
    <link rel="icon" type="image/x-icon" href="./assets/favicon.png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- font cdn -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- font cdn -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">

    <style>
        .create-btn-parent {
            position: relative;
        }

        .btn-create {
            position: absolute;
            top: 0;
            right: 0;
        }

        .no-decoration {
            text-decoration: none;
            color: black
        }

        .no-decoration:hover {
            text-decoration: none;
            color: blue;
        }

        .head1 {
            position: sticky;
            top: 75px;
            z-index: 999;
            background-color: #ffffff;
        }

        #example_wrapper .dataTables_scrollHead thead {
            position: sticky !important;
            top: 75px !important;
            background-color: #ffffff;
        }

        #main-content .table::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row ">

            <!-- Navbar -->
            <div id="navbar" class="col">
                <!-- navbar start -->
                <?php include('./navbar.php') ?>
                <!-- navbar ends -->

                <!-- search bar start -->
                <div class="container px-3 bg-white head1" id="main-content">
                    <div class="row mt-4">
                        <div class="col pt-3">
                            <h5>Enquiry List</h5>
                        </div>
                        <div class="col pt-3 col-xxl-4 create-btn-parent">
                            <a href="./cr_enq.php"><button class="btn  btn-create" style="background-color: #E7521C;color:white;">Create Enquiry</button></a>
                        </div>
                    </div>
                </div>
                <!-- search bar end -->

                <!-- table start -->
                <div class="container px-3" id="main-content">
                    <div class="row ">
                        <div class="col">
                            <div class="container-fluid table-responsive pb-5">
                                <table id="example" class="table myTable table-hover">
                                    <thead class="rounded">
                                        <tr class="rounded" style="border-radius:20px;">
                                            <th scope="col-2 fs-5" class="text-center">#</th>
                                            <th scope="col-2">Sales Person</th>
                                            <th scope="col-2">Company</th>
                                            <th scope="col-2">Item</th>
                                            <th scope="col-2">Qty</th>
                                            <th scope="col-2">Budget</th>
                                            <th scope="col-2">Last held by </th>
                                            <th scope="col-2">Status</th>
                                            <th scope="col-2">Delivery Date</th>
                                            <th scope="col-2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--</div>-->
                            </div>
                        </div>
                    </div>

                    <!-- table end -->
                </div>
            </div>
        </div>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
        <script src="./javascript/script.js"></script>


        <script>
            // DataTables List
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "responsive": true,
                    "scrollY": "calc(100vh - 355px)",
                    "scrollCollapse": true,
                    "fixedHeader": true,
                    "order": [
                        [0, 'desc']
                    ],
                    "pageLength": 30,
                });

                $('#myInput').on('keyup', function() {
                    table.search($(this).val()).draw();
                });
            });
        </script>

</body>

</html>
