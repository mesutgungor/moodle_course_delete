#!/usr/bin/php
<?php
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
		
	
        
          if(count($courses) > 1) {                                                                                                                              
                foreach ($courses as &$course) {
                        if ($course->category == $categoryid ){
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