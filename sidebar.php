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
                    	<?php 
                    		if(privilege()!='admin'){
								
                    	?>
                        <li <?php echo (Session::get('side-nav-active')==='home'?'class=active':'') ?> >
                            <a href="home.php">
                                <i class="fa fa-home"></i> <span>Home</span>
                            </a>
                        </li>
                        <?php 
                        	}
                        ?>
                        <li <?php echo (Session::get('side-nav-active')==='departments'?'class="treeview active"':'class=treeview') ?> >
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Departments</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php 
                                	if(privilege()=='hod' || privilege()=='dean' || privilege()=='director' || privilege()=='admin'){
									
                                ?>
                                <li <?php echo (Session::get('side-nav-active-sub')==='add_department'?'class=active':'') ?>><a href="add_department.php"><i class="fa fa-angle-double-right"></i> Create new department</a></li>
                                <?php }
                                
                                ?>
                                <li <?php echo (Session::get('side-nav-active-sub')==='view_departments'?'class=active':'') ?> ><a href="view_department.php"><i class="fa fa-angle-double-right"></i> View all departments</a></li>
                            </ul>
                        </li>
                        <li <?php echo (Session::get('side-nav-active')==='teachers'?'class="treeview active"':'class=treeview') ?> >
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span>Teachers</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo (Session::get('side-nav-active-sub')==='add_teacher'?'class=active':'') ?> ><a href="add_teacher.php"><i class="fa fa-angle-double-right"></i> Add teacher</a></li>
                                <li <?php echo (Session::get('side-nav-active-sub')==='view_teachers'?'class=active':'') ?> ><a href="view_teacher.php"><i class="fa fa-angle-double-right"></i> View all teachers</a></li>
                            </ul>
                        </li>
                        <li <?php echo (Session::get('side-nav-active')==='courses'?'class="treeview active"':'class=treeview') ?> >
                            <a href="#">
                                <i class="fa fa-list-alt"></i>
                                <span>Courses</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo (Session::get('side-nav-active-sub')==='add_course'?'class=active':'') ?> ><a href="add_course.php"><i class="fa fa-angle-double-right"></i> Create new course</a></li>
                                <li <?php echo (Session::get('side-nav-active-sub')==='view_courses'?'class=active':'') ?> ><a href="view_courses.php"><i class="fa fa-angle-double-right"></i> View all courses</a></li>
                            </ul>
                        </li>
                        <li <?php echo (Session::get('side-nav-active')==='course_allotment'?'class="treeview active"':'class=treeview') ?> >
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Course Allotment</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo (Session::get('side-nav-active-sub')==='assign_course'?'class=active':'') ?> ><a href="assign_course.php"><i class="fa fa-angle-double-right"></i> Assign a course to teacher</a></li>
                                <li <?php echo (Session::get('side-nav-active-sub')==='courses_appointed'?'class=active':'') ?>><a href="view_courses_appointed.php"><i class="fa fa-angle-double-right"></i> View all courses assigned</a></li>
                            </ul>
                        </li>
                        <li <?php echo (Session::get('side-nav-active')==='view_students'?'class=active':'') ?> >
                            <a href="view_students.php">
                                <i class="fa fa-graduation-cap"></i> <span>Students</span>
                            </a>
                        </li>
                        <li <?php echo (Session::get('side-nav-active')==='marks_entry_system'?'class="treeview active"':'class=treeview') ?>>
                            <a href="#">
                                <i class="fa fa-edit"></i>
                                <span>Marks Entry System</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo (Session::get('side-nav-active-sub')==='last_date'?'class=active':'') ?> ><a href="last_date.php"><i class="fa fa-angle-double-right"></i> Last dates</a></li>
                                <?php 
                                	if(privilege()!='admin'){
                                ?>
                                <li <?php echo (Session::get('side-nav-active-sub')==='marks'?'class=active':'') ?> ><a href="marks.php"><i class="fa fa-angle-double-right"></i> Marks entry &amp; your settings</a></li>
                                <li <?php echo (Session::get('side-nav-active-sub')==='approval'?'class=active':'') ?> ><a href="approval.php"><i class="fa fa-angle-double-right"></i> Generate result &amp; approval</a></li>
                                <?php 
                                	}
                                ?>
                            </ul>
                        </li>
                        <?php 
                        	if(privilege()!='admin'){
                        ?>
                        <li <?php echo (Session::get('side-nav-active')==='attendance'?'class=active':'') ?> >
                            <a href="attendance.php">
                                <i class="fa fa-calendar"></i> <span>Attendance System</span>
                            </a>
                        </li>
                        <?php
                        	}
                        	if(privilege()==='admin' || privilege()==='director' || privilege()==='dean'){
                        ?>
                        <li <?php echo (Session::get('side-nav-active')==='settings'?'class=active':'') ?> >
                            <a href="settings.php">
                                <i class="fa fa-wrench"></i> <span>System Settings</span>
                            </a>
                        </li>
                        <?php 
                        	}
                        ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">