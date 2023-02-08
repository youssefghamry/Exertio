<?php
/* Template Name: Home Page */ 
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Exertio
 */
?>
<?php get_header(); ?>
<?php 
if (have_posts())
{
	the_post();
	the_content(); 
}
?>
<?php get_footer(); ?>