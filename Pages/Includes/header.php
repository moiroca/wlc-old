<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WLC FACILITIES AND EQUIPMENT - Inventory and Monitoring System</title>

    <!-- Bootstrap Core CSS -->
    <?php 

        Assets::renderCss([
            'bootstrap.min.css', 
            'metisMenu.min.css',
            'timeline.css',
            'sb-admin-2.css',
            'morris.css',
            'font-awesome.min.css'
        ]); 
    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">WLC FACILITIES AND EQUIPMENT - Inventory and Monitoring System</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <!-- /.SMS Notifications -->
                <!-- <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <!-- /.Tasks For Inventory Officer-->
                <?php 
                    $notificationObj = new Notification();
                    $notification = $notificationObj->getAllByRecepient(Login::getUserLoggedInId());
                ?>
                <li class="dropdown" <?php echo ($notification) ? "id='view_notif'" :'' ?>>
                    <input type='hidden' value="<?php echo Link::createUrl('Controllers/ChangeNotificationStatus.php'); ?>">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php if ($notification->num_rows): ?>
                            <label style='color:#fff; background-color:red;' class='badge'><?php echo $notification->num_rows; ?></label>
                        <?php endif ?>
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <?php if (0 != $notification->num_rows): ?>
                            <?php while ($notif = $notification->fetch_assoc()): ?>
                                <li data-id='<?php echo $notif['notification_id']; ?>'>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-info fa-fw"></i> <?php echo $notif['notification_msg'];  ?>
                                            <span class="pull-right text-muted small"><?php echo date_create($notif['notification_datetime_sent'])->format('Y-m-d'); ?></span>
                                        </div>
                                    </a>
                                </li>
                            <?php endwhile ?>
                        <?php else: ?>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-info fa-fw"></i> There are <label class='label label-info'>no</label> notifications available.
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>
                            </li>    
                        <?php endif ?>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo Link::createUrl('Pages/Notifications/list.php'); ?>">
                                    <div>
                                        <i class="fa fa-tasks fa-fw"></i> View All Notifications
                                    </div>
                                </a>
                            </li>
                        <!-- <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li> -->
                    </ul>
                </li>
                <!-- /.Notifications For Approved/Decline Item Requeisition -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <!-- <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li> -->
                        <li class="divider"></li>
                        <li><a href="<?php echo Link::createUrl('Controllers/Logout.php'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!-- <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                        </li> -->
                        <!-- /.Search Bar -->
                        <li>
                            <a href="javascript:void(0)"><i class="fa fa-user fa-fw"></i> Welcome: <b><?php echo $_SESSION['type']; ?></b></a>
                        </li>
                        <li>
                            <a href="<?php echo Link::createUrl('Pages/home.php'); ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        
                        <!-- /.Inventory Officer Menus -->
                        <?php if (LoggedInUser::type() == Constant::USER_INVENTORY_OFFICER) { ?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> File Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Stocks/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Stocks/OfficeSupply.php'); ?>"> Office Supply</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Stocks/MaterialsEquipments.php'); ?>"> Materials and Equipments</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Requisitions<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/myrequisitions.php'); ?>"> <i class='fa fa-table'></i> My Request</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Items/listing.php'); ?>">Item Requisition</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Jobs/listing.php'); ?>">Job Requisition</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="<?php echo Link::createUrl('Pages/Areas/list.php'); ?>"><i class="fa fa-dashboard fa-fw"></i> Areas</a>
                            </li>
                            <li>
                                <a href="<?php echo Link::createUrl('Pages/Departments/list.php'); ?>"><i class="fa fa-dashboard fa-fw"></i> Departments</a>
                            </li>
                            <li>    
                                <a href="#"><i class="fa fa-table fa-fw"></i> User Accounts<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Users/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Users/list.php'); ?>"> View List</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-table fa-fw"></i> Reports<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Reports/requisition.php'); ?>"> Requisition</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Reports/stocks.php'); ?>"> Stocks</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        
                        <!-- /.General Services Menus -->
                        <?php if (LoggedInUser::type() == Constant::USER_GSD_OFFICER) { ?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Requisitions<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/myrequisitions.php'); ?>"> <i class='fa fa-table'></i> My Request</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Items/listing.php'); ?>">Item Requisition</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Jobs/listing.php'); ?>">Job Requisition</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> File Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Stocks/OfficeSupply.php'); ?>"> Office Supply</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Stocks/MaterialsEquipments.php'); ?>"> Materials and Equipments</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="<?php echo Link::createUrl('Pages/Reports/list.php'); ?>"><i class="fa fa-edit fa-fw"></i> Reports</a>
                            </li>
                        <?php } ?>

                        <!-- /.President Menus -->
                        <?php if (LoggedInUser::type() == Constant::USER_PRESIDENT) { ?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Requisitions<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/myrequisitions.php'); ?>"> <i class='fa fa-table'></i> My Request</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Items/listing.php'); ?>">Item Requisition</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Jobs/listing.php'); ?>">Job Requisition</a>
                                    </li>
                                    <!-- <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/pending.php'); ?>">Pending Requisitions</a>
                                    </li> -->
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> File Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Stocks/OfficeSupply.php'); ?>"> Office Supply</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Stocks/MaterialsEquipments.php'); ?>"> Materials and Equipments</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="<?php echo Link::createUrl('Pages/Reports/list.php'); ?>"><i class="fa fa-edit fa-fw"></i> Reports</a>
                            </li>
                        <?php } ?>

                        <!-- /.Dean Menus -->
                        <?php if (LoggedInUser::type() == Constant::USER_DEAN) { ?>

                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Requisitions<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/myrequisitions.php'); ?>"> <i class='fa fa-table'></i> My Request</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Stocks<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Stocks/Tools/tools.php'); ?>"> Tools</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Stocks/Equipments/equipments.php'); ?>"> Equipments</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Stocks/Materials/materials.php'); ?>"> Materials</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="<?php echo Link::createUrl('Pages/Reports/list.php'); ?>"><i class="fa fa-edit fa-fw"></i> Reports</a>
                            </li>
                        <?php } ?>

                        <!-- /.Department Head Menus -->
                        <?php if (LoggedInUser::type() == Constant::USER_DEPARTMENT_HEAD) { ?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Requisitions<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/myrequisitions.php'); ?>"> <i class='fa fa-table'></i> My Request</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Items/listing.php'); ?>">Item Requisition</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Jobs/listing.php'); ?>">Job Requisition</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <!-- /.PROPERTY CUSTODIAN Menus -->
                        <?php if (LoggedInUser::type() == Constant::USER_PROPERTY_CUSTODIAN) { ?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Requisitions<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/myrequisitions.php'); ?>"> <i class='fa fa-table'></i> My Request</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Items/listing.php'); ?>">Item Requisition</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <!-- /.PROPERTY CUSTODIAN Menus -->
                        <?php if (LoggedInUser::type() == Constant::USER_COMPTROLLER) { ?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Requisitions<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/myrequisitions.php'); ?>"> <i class='fa fa-table'></i> My Request</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Items/listing.php'); ?>">Item Requisition</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Jobs/listing.php'); ?>">Job Requisition</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <!-- /.Employee Menus -->
                        <?php if (LoggedInUser::type() == Constant::USER_EMPLOYEE) { ?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Requisitions<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/myrequisitions.php'); ?>"> <i class='fa fa-table'></i> My Request</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <!-- /.Treasurer Menus -->
                        <?php if (LoggedInUser::type() == Constant::USER_TREASURER) { ?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Requisitions<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/add.php'); ?>"> <i class="fa fa-plus"></i> Add</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/myrequisitions.php'); ?>"> <i class='fa fa-table'></i> My Request</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Items/listing.php'); ?>">Item Requisition</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Link::createUrl('Pages/Requisitions/Jobs/listing.php'); ?>">Job Requisition</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">