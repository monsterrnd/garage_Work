<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Гараж</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=TEMPLATE_ADMIN;?>/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?=TEMPLATE_ADMIN;?>/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?=TEMPLATE_ADMIN;?>/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=TEMPLATE_ADMIN;?>/dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom CSS -->
	
    <link href="<?=TEMPLATE_ADMIN;?>/dist/css/style.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?=TEMPLATE_ADMIN;?>/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=TEMPLATE_ADMIN;?>/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<div class="load_site"></div>
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
                <a class="navbar-brand" href="index.html">ГАРАЖ</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Пользователь</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Настройки</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Выход</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
					
                        <li>
                            <a href="index.html"><i class="fa fa-th"></i> Рабочий стол</a>
                        </li>
                        <li>
                            <a href="company.html"><i class="fa fa-users"></i> Компании</a>
                        </li>
                        <li>
                            <a href="index.html"><i class="fa fa-comment"></i> Отзывы</a>
                        </li>
                        <li>
                            <a href="/core/admin/user_list.php"><i class="fa fa-user"></i> Пользователи</a>
                        </li>
                        <li>
                            <a href="index.html"><i class="fa fa-files-o"></i> Заявки</a>
                        </li>
                        <li>
                            <a href="index.html"><i class="fa fa-wrench"></i> Типы услуг</a>
                        </li>                       
						<li>
                            <a href="index.html"><i class="fa fa-gear"></i> Настройки</a>
                        </li>


                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<div id="page-wrapper">
