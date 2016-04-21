<?php
/**
	Template Name: testing
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
		<h1 class="frm-heading"> SUBMIT DATA</h1>
			<p class="mdgggg" style="text-align:center; margin-top:20px;"></p>
			<form action="" class="my-from">
				<p style="text-align:center; margin-top:20px;">Name:</p>
				<input id="name"type="text" placeholder="name" />
				<p style="text-align:center; margin-top:20px;">Email:</p>
				<input id="email" type="text" placeholder="email" />
				<p style="text-align:center; margin-top:20px;">Option:</p>
				<select name="option" id="option">  
					<option value="Option one">Option one</option>
					<option value="Option two">Option two</option>
					<option value="Option three">Option three</option>
				</select>
				<p style="text-align:center; margin-top:20px;">Content:</p>
				<textarea name="" id="pstcontent" cols="10" rows="5"></textarea>
				
				<input id="ourSubmit" type="submit" value="submit" />
				<input type="hidden" value="" id="honeypot" name="<?php apply_filters('honeypot_name', 'date-submitted'); ?>" />
			</form>
			

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>