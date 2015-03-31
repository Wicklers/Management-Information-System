<?php
if(!loggedIn() || privilege()==NULL){
	die();
}
?>
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                	                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="images/logo.png" class="img-circle" alt="NIT Silchar" />
                        </div>
                    </div>
                    <!-- sidebar menu -->
                    <ul class="sidebar-menu">
                        <li <?php echo (Session::get('side-nav-active')==='home'?'class=active':'') ?> >
                            <a href="home.php">
                                <i class="fa fa-home"></i> <span>Home</span>
                            </a>
                        </li>
                        <li <?php echo (Session::get('side-nav-active')==='academic'?'class=active':'') ?> >
                            <a href="academics.php">
                                <i class="fa fa-files-o"></i> <span>Academics</span>
                            </a>
                        </li>
                        <li <?php echo (Session::get('side-nav-active')==='profile'?'class=active':'') ?> >
                            <a href="profile.php">
                                <i class="fa fa-camera-retro"></i> <span>Public Profile</span>
                            </a>
                        </li>
                        <li <?php echo (Session::get('side-nav-active')==='attendance'?'class=active':'') ?> >
                            <a href="attendance.php">
                                <i class="fa fa-calendar"></i> <span>Attendance</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
