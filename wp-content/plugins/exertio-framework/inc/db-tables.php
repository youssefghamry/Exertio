<?php
/*
  Create Database Table
 */
class fl_db_tables 
{
    public static function fl_create_db_tables() 
	{
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $sql_project_bids = "
        CREATE TABLE ".EXERTIO_PROJECT_BIDS_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`project_id` int (11),
		`proposed_cost` int (11),
		`service_fee` float(9,2),
		`earned_cost` float(9,2),
		`day_to_complete` int (11),
		`cover_letter` text (300),
		`attachment_ids` varchar (300),
		`freelancer_id` int (11),
		`author_id` int (11),
		`is_top` varchar (300),
		`is_sealed` varchar (300),
		`is_featured` varchar (300),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_PROJECT_BIDS_TBL, $sql_project_bids );
		
		
		$sql_project_msg_history = "
        CREATE TABLE ".EXERTIO_PROJECT_MSG_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`project_id` int (11),
		`message` text (300),
		`freelancer_id` int (11),
		`attachment_ids` varchar (300),
		`msg_author` int (11),
		`status` int (11),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_PROJECT_MSG_TBL, $sql_project_msg_history );
		
		$sql_review_data = "
        CREATE TABLE ".EXERTIO_REVIEWS_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`project_id` int (11),
		`feedback` text (300),
		`star_1` int (11),
		`star_2` int (11),
		`star_3` int (11),
		`star_avg` varchar (300),
		`receiver_id` int (11),
		`giver_id` int (11),
		`type` varchar (300),
		`status` int (11),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_REVIEWS_TBL, $sql_review_data );
		
		$sql_purchased_services_data = "
        CREATE TABLE ".EXERTIO_PURCHASED_SERVICES_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`service_id` int (11),
		`buyer_id` int (11),
		`seller_id` int (11),
		`addon_ids` varchar (300),
		`total_price` int (11),
		`service_price` int (11),
		`addon_price` int (11),
		`status_date` datetime,
		`status` varchar (300),
		`remarks` text (300),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_PURCHASED_SERVICES_TBL, $sql_purchased_services_data );
		
		$sql_service_msgs = "
        CREATE TABLE ".EXERTIO_SERVICE_MSG_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`service_id` int (11),
		`message` text (300),
		`msg_sender_id` int (11),
		`attachment_ids` varchar (300),
		`msg_receiver_id` int (11),
		`status` int (11),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_SERVICE_MSG_TBL, $sql_service_msgs );
		
		$sql_projects_logs = "
        CREATE TABLE ".EXERTIO_PROJECT_LOGS_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`project_id` int (11),
		`employer_id` int (11),
		`freelancer_id` int (11),
		`project_cost` int (11),
		`proposal_cost` int (11),
		`admin_commission` DECIMAL(10,2),
		`commission_percent` int (11),
		`freelacner_earning` DECIMAL(10,2),
		`status` varchar (300),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_PROJECT_LOGS_TBL, $sql_projects_logs );
		
		$sql_services_logs = "
        CREATE TABLE ".EXERTIO_SERVICE_LOGS_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`service_id` int (11),
		`purhcased_sid` int (11),
		`employer_id` int (11),
		`freelancer_id` int (11),
		`service_currency` varchar (30),
		`total_service_cost` int (11),
		`addons_cost` int (11),
		`admin_commission` DECIMAL(10,2),
		`commission_percent` int (11),
		`freelacner_earning` DECIMAL(10,2),
		`status` varchar (300),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_SERVICE_LOGS_TBL, $sql_services_logs );
		
		$sql_dispute = "
        CREATE TABLE ".EXERTIO_DISPUTE_MSG_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`dispute_id` int (11),
		`post_id` int (11),
		`message` text (300),
		`msg_receiver_id` int (11),
		`msg_author_id` int (11),
		`status` int (11),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_DISPUTE_MSG_TBL, $sql_dispute );

        $sql_service_dispute = "
        CREATE TABLE ".EXERTIO_DISPUTE_MSG_SERVICE_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`dispute_id` int (11),
		`post_id` int (11),
		`message` text (300),
		`msg_receiver_id` int (11),
		`msg_author_id` int (11),
		`status` int (11),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_DISPUTE_MSG_SERVICE_TBL, $sql_service_dispute );
		
		
		$sql_notifications = "
        CREATE TABLE ".EXERTIO_NOTIFICATIONS_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`post_id` int (11),
		`n_type` VARCHAR  (30),
		`sender_id` int (11),
		`receiver_id` int (11),
		`sender_type` VARCHAR  (30),
		`status` int (11),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_NOTIFICATIONS_TBL, $sql_notifications );
		
		
		//`t_type` VARCHAR  (30), //wallet fill, sponsored post, package purchase, withdrawal request etc.
		//`t_status` VARCHAR  (30), //amount IN or OUT, 1 for IN 2 for OUT
		//`status` int (11), // Soft delete
		
		$sql_statements = "
        CREATE TABLE ".EXERTIO_STATEMENTS_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`post_id` int (11),
		`price` DECIMAL(10,2),
		`t_type` VARCHAR  (30),
		`t_status` VARCHAR  (30),
		`user_id` int (11),
		`status` int (11),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_STATEMENTS_TBL, $sql_statements );
    }
}
new fl_db_tables();