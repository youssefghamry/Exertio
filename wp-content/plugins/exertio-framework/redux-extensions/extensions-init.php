<?php
// All extensions placed within the extensions directory will be auto-loaded for your Redux instance.
Redux::setExtensions( 'exertio_theme_options', dirname( __FILE__ ) . '/extensions/' );
// Any custom extension configs should be placed within the configs folder.
if ( file_exists( dirname( __FILE__ ) . '/configs/' ) ) {
	$files = glob( dirname( __FILE__ ) . '/configs/*.php' );
	if ( ! empty( $files ) ) {
		foreach ( $files as $file ) {
			include $file;
		}
	}
}
if ( !function_exists( 'exertio_framework_description_text' ) ) {
    function exertio_framework_description_text( $description ) {
        //get ser detials
		$server_memory_limit = $server_max_execution_time = $server_upload_max_size    ='';
		$server_memory_limit       = ini_get( 'memory_limit' );
		$server_max_execution_time = ini_get( 'max_execution_time' );
		$server_upload_max_size    = ini_get('upload_max_filesize');
		//minimum req
		$php_version       = 7.0;
		$min_memory_end        = 256;
		$min_execution_time    = 1000; // 300 seconds = 5 minutes
		$min_filesize    = 32;
		//get php version
		if ( phpversion() >= $php_version )
		{
			$active_clr = 'ok-req';
			$icon = 'yes';
			$msg = '';
		}
		if ( phpversion() < $php_version)
		{
			$active_clr = 'bad-req';
			$icon = 'no';
			$msg = '<p>You have outdated PHP version installed on your server. PHP version 7.0 or higher is required to make sure Propertya Theme and all required plugins work correctly.</p> <a href="https://www.php.net/supported-versions.php"> Click here to read more details </a>';
		}
		//max execution
		if ( $server_max_execution_time >= $min_execution_time)
		{
			$ok_clr = 'ok-req';
			$e_icon = 'yes';
			$e_msg = '';
		}
		if ( $server_max_execution_time < $min_execution_time)
		{
			$ok_clr = 'bad-req';
			$e_icon = 'no';
			$e_msg = '<p>Your server has limited max_execution_time. We recommend you to increase it to 360 (seconds) or more to make sure demo import will have enough time to load all demo content & images</p>';
		}
		//max file size
		if ( $server_upload_max_size >= $min_filesize)
		{
			$f_ok_clr = 'ok-req';
			$f_icon = 'yes';
			$f_msg = '';
		}
		if ( $server_upload_max_size < $min_filesize)
		{
			$f_ok_clr = 'bad-req';
			$f_icon = 'no';
			$f_msg = '<p>Your server has limited upload_max_filesize. We recommend to increase it to 32M or more to make sure demo import will have enough time to load all demo content & images</p>';
		}
		//memory limit
		if ( $server_memory_limit >= $min_memory_end )
		{
			$ok_mem = 'ok-req';
			$mem_icon = 'yes';
			$mem_msg = '';
		}
		if ( $server_memory_limit < $min_memory_end && $server_memory_limit != 0)
		{
			$ok_mem = 'bad-req';
			$mem_icon = 'no';
			$mem_msg = '<p>Your server has very limited memory_limit. Please increase it to 256M or more to make sure DWT Listing Theme and all required plugins work correctly.</p>';
		}
        $message = '<p>'. esc_html__( 'Best if used on new WordPress install & this theme requires PHP version 7.0+', 'exertio_framework' ) .'</p>';
        $message .= '<p>'. esc_html__( 'Images are for demo purpose only.', 'exertio_framework' ) .'</p>';
        $message .= '
        <h3>Server Requirements</h3>
		<div class="theme-server-detials">
			<div class="requirnment-row '.$active_clr.'">
				<div class="req-title">PHP version '.$msg.'</div>
				<div class="req-icon"><span class="dashicons dashicons-'.$icon.'"></span></div>
				<div class="req-figures">'. esc_html( phpversion() ).' </div>
			</div>
			<div class="requirnment-row '.$ok_mem.'">
				<div class="req-title">Memory Limit '.$mem_msg.' </div>
				<div class="req-icon"><span class="dashicons dashicons-'.$mem_icon.'"></span></div>
				<div class="req-figures">'. esc_html( $server_memory_limit ).'</div>
			</div>
			<div class="requirnment-row '.$ok_clr.'">
				<div class="req-title">Max Execution Time '.$e_msg.'</div>
				<div class="req-icon"><span class="dashicons dashicons-'.$e_icon.'"></span></div>
				<div class="req-figures">'. esc_html( $server_max_execution_time ).' seconds </div>
			</div>
			<div class="requirnment-row '.$f_ok_clr.'">
				<div class="req-title">Upload max filesize '.$f_msg.'</div>
				<div class="req-icon"><span class="dashicons dashicons-'.$f_icon.'"></span></div>
				<div class="req-figures">'.$server_upload_max_size.'</div>
			</div>
		</div>
        <h3>What if the Import fails or stalls?</h3>
        If the import stalls and fails to respond after a few minutes You are suffering from PHP configuration limits that are set too low to complete the process. You should contact your hosting provider and ask them to increase those limits to a minimum as follows:
        </p>
        <ul style="margin-left: 60px">
            <li>max_execution_time : 360</li>
            <li>memory_limit : 256M</li>
            <li>post_max_size : 32M</li>
            <li>upload_max_filesize : 32M</li>
        </ul>
        <p>You can verify your PHP configuration limits by installing a simple plugin found here: <a href="https://wordpress.org/plugins/wp-serverinfo/" target="_blank">https://wordpress.org/plugins/wp-serverinfo/</a>. And you can also check your PHP error logs to see the exact error being returned.</p>
        <p>If you were not able to import demo, please contact on our <a target="_blank" href="https://scriptsbundle.ticksy.com/"><b>support forum</b></a>, our technical staff will import demo for you.</p>
        ';
        return $message;
    }
    add_filter( 'wbc_importer_description', 'exertio_framework_description_text', 10 );
}