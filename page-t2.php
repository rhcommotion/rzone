<?php
    require_once("lib/account.php");
    require_once 'lib/db.php';
    require_once 'lib/router.php';
    $account->
get_info();
    
    function inject_json($var_name, $obj) {
        echo "
<script>
    var $var_name = JSON.parse('" . json_encode($obj) . "');
</script>
";
    }

    function page_start() {
        global $db, $account, $page;
        header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            RZone :: <?php echo $page;?>
        </title>
        <!-- BEGIN META -->
        <meta charset="utf-8">
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
                <meta content="your,keywords" name="keywords">
                    <meta content="Raffles Hall Information Portal" name="description">
                        <!-- END META -->
                        <!-- BEGIN STYLESHEETS -->
                        <link href="http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900" rel="stylesheet" type="text/css"/>
                        <link href="assets/css/theme-default/bootstrap.css?1422792965" rel="stylesheet" type="text/css"/>
                        <link href="assets/css/theme-default/materialadmin.css?" rel="stylesheet" type="text/css"/>
                        <link href="assets/css/theme-default/font-awesome.min.css?1422529194" rel="stylesheet" type="text/css"/>
                        <link href="assets/css/theme-default/material-design-iconic-font.min.css" rel="stylesheet" type="text/css"/>
                        <link href="assets/css/theme-default/libs/rickshaw/rickshaw.css?1422792967" rel="stylesheet" type="text/css"/>
                        <link href="assets/css/theme-default/libs/morris/morris.core.css?1420463396" rel="stylesheet" type="text/css"/>
                        <link href="assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1424887858" rel="stylesheet" type="text/css"/>
                        <link href="assets/css/theme-default/libs/select2/select2.css?1424887856"  type="text/css" rel="stylesheet"/>
                        <link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/toastr/toastr.css?1425466569" />

        <link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/DataTables/jquery.dataTables.css?1423553989" />
        <link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
        <link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />

                        <!-- END STYLESHEETS -->
                        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
                        <!--[if lt IE 9]>
        <script type="text/javascript" src="assets/js/libs/utils/html5shiv.js?1403934957"></script>
        <script type="text/javascript" src="assets/js/libs/utils/respond.min.js?1403934956"></script>
        <![endif]-->

    </head>
    <body class="menubar-hoverable header-fixed <?php echo (($page=="JCRC Residents Management" || $page== "Router Management" || $page== "Applications Management") ? "" : "menubar-pin");?>">
        <!-- BEGIN HEADER-->
        <header id="header" <?php echo (($page=="JCRC Residents Management" || $page== "Applications Management" || $page== "Router Management") ? "class=\"header-inverse\"" : "");?>>
            <div class="headerbar">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="headerbar-left">
                    <ul class="header-nav header-nav-options">
                        <li class="header-nav-brand">
                            <div class="brand-holder">
                                <a href="index">
                                    <img alt="" src="assets/img/rzone-logo.png"/>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                                <i class="fa fa-bars">
                                </i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="headerbar-right">

                    <!--end .header-nav-options -->
                    <ul class="header-nav header-nav-profile">
                        <li class="dropdown">
                            <a class="dropdown-toggle ink-reaction" data-toggle="dropdown" href="javascript:void(0);">
                                <img alt="" src="assets/img/avatar1.jpg"/>
                                <span class="profile-info">
                                        <?php echo ucwords(strtolower($account->info['name'])); ?>
                                    
                                        <?php
                                        $rows = $db->query('call get_manageable_activities(?);', [$account->nus_id]);
                                        $is_head = $db->query_get1('select is_activity_head(?);', [$account->nus_id]);
                                        if ($account->info['type'] == 'jcrc')
                                            echo '<small class="text-accent"><strong>JCRC</strong></small>';
                                        elseif ($is_head && count(array_column($rows, 1)) <= 2)
                                            echo '<small class="text-primary-dark"><strong>Head (' . implode(', ', array_column($rows, 1)) . ')</strong></small>';
                                        elseif ($is_head && count(array_column($rows, 1)) > 2)
                                            echo '<small class="text-primary-dark"><strong>Head (' . count(array_column($rows, 1)) . ')</strong></small>';
                                        else
                                            echo '<small>RESIDENT</small>';
                                        ?>
                                    
                                </span>
                            </a>
                            <ul class="dropdown-menu animation-dock">
                                <li>
                                    <a href="logout.php">
                                        <i class="fa fa-fw fa-power-off text-danger">
                                        </i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                            <!--end .dropdown-menu -->
                        </li>
                        <!--end .dropdown -->
                    </ul>
                    <!--end .header-nav-profile -->
                </div>
                <!--end #header-navbar-collapse -->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN CONTENT-->
            <!--end #content-->
            <!-- END CONTENT -->
            <!-- BEGIN MENUBAR-->
            <div <?php echo (($page=="JCRC Residents Management" || $page== "Applications Management" || $page== "Router Management") ? "" : "class=\"menubar-inverse\"");?> id="menubar">
                <div class="menubar-fixed-panel">
                    <div>
                        <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i class="fa fa-bars">
                            </i>
                        </a>
                    </div>
                    <div class="expanded">
                        <a href="../../html/dashboards/dashboard.html">
                            <span class="text-lg text-bold text-primary ">
                                Rzone
                            </span>
                        </a>
                    </div>
                </div>
                <div class="menubar-scroll-panel">
                    <!-- BEGIN MAIN MENU -->
                    <ul class="gui-controls" id="main-menu">
                        <!-- BEGIN DASHBOARD -->
                        <li>
                            <a<?php echo ($page == "Resident Profile" ? " class=\"active\"": "")?> href="index">
                                <div class="gui-icon">
                                    <i class="md md-face-unlock">
                                    </i>
                                </div>
                                <span class="title">
                                    Profile
                                </span>
                            </a>
                        </li>
                        <!--end /menu-li -->
                        <!-- END DASHBOARD -->
                        <!-- BEGIN MYACTIVITIES -->
                        <li>
                            <a<?php echo ($page == "My Activities" ? " class=\"active\"": "")?> href="my-activities">
                                <div class="gui-icon">
                                    <i class="md md-group">
                                    </i>
                                </div>
                                <span class="title">
                                    My Activities
                                </span>
                            </a>
                        </li>
                        <!--end /menu-li -->
                        <!-- END MYACTIVITIES-->
                        <!-- BEGIN APP -->
                        <li class="gui-folder">
                            <a>
                                <div class="gui-icon">
                                    <i class="md md-shopping-cart">
                                    </i>
                                </div>
                                <span class="title">
                                    Apply for Activities
                                </span>
                            </a>
                            <!--start submenu -->
                            <ul>
                                <li>
                                    <a href="appl"<?php echo ($page == "Activities Application" ? " class=\"active\"": "")?>>
                                        <span class="title">
                                            Submit Application
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="my-appl"<?php echo ($page == "Current Applications" ? " class=\"active\"": "")?>>
                                        <span class="title">
                                            Current Applications
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="appl-history"<?php echo ($page == "Application History" ? " class=\"active\"": "")?>>
                                        <span class="title">
                                            Application History
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="appl-stat"<?php echo ($page == "Activities Quota Report" ? " class=\"active\"": "")?>>
                                        <span class="title">
                                            Activities Quota Report
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <!--end /submenu -->
                        </li>
                        <!--end /menu-li -->
                        <!-- END APP -->
                        <?php 
                            // Activity head panel
                            if ($is_head) {
                         ?>
                        <li class="gui-folder">
                            <a<?php echo ($page == "Applications Management" ? " class=\"active\"": "")?>>
                                <div class="gui-icon">
                                    <i class="md md-group-add">
                                    </i>
                                </div>
                                <span class="title">
                                    Manage Applications
                                </span>
                            </a>
                            <ul>
                                <?php
                                    
                                    $f = function ($row) {
                                        echo "<li><a href=\"appl-man.php?i=$row[0]\"><span class=\"title\">$row[1]</span></a></li>";
                                        return 0;
                                    };
                                    array_map($f, $rows);
                                ?>
                            </ul>
                        </li>
                        <li class="gui-folder">
                            <a>
                                <div class="gui-icon">
                                    <i class="md md-assistant-photo">
                                    </i>
                                </div>
                                <span class="title">
                                    Activities Management
                                </span>
                            </a>
                            <ul>
                                 <?php
                                    $f = function ($row) {
                                        echo "<li><a href=\"activity-man.php?i=$row[0]\"><span class=\"title\">$row[1]</span></a></li>";
                                        return 0;
                                    };
                                    array_map($f, $rows);
                                ?>
                            </ul>
                        </li>
                    <?php 
                    }
                    ?>
                    <?php 
                    // JCRC Panel
                    if ($account->info['type'] === 'jcrc') {
                    ?>
                        <li class="gui-folder">
                            <a>
                                <div class="gui-icon">
                                    <i class="md md-stars">
                                    </i>
                                </div>
                                <span class="title">
                                    JCRC Panel
                                </span>
                            </a>
                            <ul>
                                <li>
                                    <a href="jcrc-options"<?php echo ($page == "JCRC System Settings" ? " class=\"active\"": "")?>>
                                        <span class="title" >
                                            System Settings
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="jcrc-residents"<?php echo ($page == "JCRC Residents Management" ? " class=\"active\"": "")?>>
                                        <span class="title">
                                            Residents Management
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="jcrc-reports"<?php echo ($page == "JCRC System Reports" ? " class=\"active\"": "")?>>
                                        <span class="title" >
                                            System Reports
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                            }
                        ?>
                        <li class="gui-folder">
                            <a>
                                <div class="gui-icon">
                                    <i class="fa fa-wifi"></i>
                                </div>
                                <span class="title">
                                    Router Config
                                </span>
                            </a>
                            <ul>
                                <li>
                                    <a href="router-index"<?php echo ($page == "Router Info" ? " class=\"active\"": "")?>>
                                        <span class="title" >
                                            Router Info
                                        </span>
                                    </a>
                                </li>
                                <?php if (get_router_priv() != 0) {?>
                                <li>
                                    <a href="router-man"<?php echo ($page == "Router Management" ? " class=\"active\"": "")?>>
                                        <span class="title" >
                                            Router Management 
                                        </span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
                        </li>
                    </ul>
                    <!--end .main-menu -->
                    <!-- END MAIN MENU -->
                    <div class="menubar-foot-panel">
                        <small class="no-linebreak hidden-folded">
                            <span class="opacity-75">
                                © 2016
                            </span>
                            <strong>
                                RH ComMotion
                            </strong>
                        </small>

                    </div>
                </div>
                <!--end .menubar-scroll-panel-->
            </div>
            <!--end #menubar-->
            <!-- END MENUBAR -->

<?php
    }
    //
    function page_end() {
?>

            </div>
        </div>

    </body>
    </html>
    <script src="assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script src="assets/js/libs/bootstrap/bootstrap.min.js"></script>
<script src="assets/js/libs/spin.js/spin.min.js">
</script>
<script src="assets/js/libs/autosize/jquery.autosize.min.js">
</script>
<script src="assets/js/libs/moment/moment.min.js">
</script>
<script src="assets/js/libs/nanoscroller/jquery.nanoscroller.min.js">
</script>
<script src="assets/js/core/source/App.js">
</script>
<script src="assets/js/core/source/AppNavigation.js">
</script>
<script src="assets/js/core/source/AppOffcanvas.js">
</script>
<script src="assets/js/core/source/AppCard.js">
</script>
<script src="assets/js/core/source/AppForm.js">
</script>
<script src="assets/js/core/source/AppNavSearch.js">
</script>
<script src="assets/js/core/source/AppVendor.js">
</script>
<script src="assets/js/libs/jquery-validation/dist/jquery.validate.min.js">
</script>
<script src="assets/js/libs/jquery-validation/dist/additional-methods.min.js">
</script>
<script src="assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js">
</script>
<script src="assets/js/libs/toastr/toastr.js"></script>

<?php
    }
?>
