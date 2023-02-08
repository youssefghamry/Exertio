<footer class="footer">
  <div class="d-sm-flex justify-content-end"> <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><?php echo fl_framework_get_options('footer_copyright_text'); ?></span> </div>
</footer>

<?php
if(isset($_GET['ext']) && $_GET['ext'] !="")
{
	$page_type  = $_GET['ext'];
	if($page_type == "my-proposals")
	{
		?>
		<div class="my-proposal-modal"></div>
		<?php
	}
}
?>
<?php  get_footer(); ?>