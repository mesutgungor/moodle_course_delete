#!/usr/bin/php
<?php
// Place this script in /<moodle-root-path>/course/ directory and run it
// * To delete one specific course with id:
//   ~# php bulk_delete.php <course_id>
//
// * To delete all courses in the system:
//   ~# php bulk_delete.php
//
// Tested Moodle version:
// * Moodle 2.7 - Web Jun 4, 2014.
// 
// Authors: Trinh Nguyen
// Email: dangtrinhnt[at]gmail[dot]com


// to be able to run this file as command line script
define('CLI_SCRIPT', true);

require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->dirroot . '/course/lib.php');

global $DB;
                                                                                                                          
        $contextid = $argv[1];
        $categoryid = $argv[2];
        $courses = get_courses();
      
      //  $courses = $DB->get_records('course',array('category'=>'6'));
        //$roleassignment = $DB->get_records('role_assignments',array('roleid'=>'2'));
		
		$roleassignment = $DB->get_records_sql("select distinct userid,contextid from {role_assignments} where roleid=?",array("2"));
		
		
		foreach($roleassignment as &$rolly){
			
			if ($rolly->contextid != $contextid){
					
						$record = new stdClass();
						$record->contextid = $contextid;
						$record->userid = $rolly->userid;
						$record->roleid = '2';
						$record->timemodified = time();
						$lastinsertid = $DB->insert_record('role_assignments', $record, false);
			     	
			    }
			}
		
	
        
          if(count($courses) > 1) { // there is one default course of moodle                                                                                                                                   
                foreach ($courses as &$course) {
                        if ($course->category ==  ){
                        echo $course->fullname."\n";
                        delete_course($course);
                        fix_course_sortorder(); 
                        }
                        
                }
        }
        else { 
                print_r("\nNo course in the system!\n");                                                                                                             
        }   

exit;
?>