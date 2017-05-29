<?php
function boxes_func( $atts ) {
	$atts = shortcode_atts( array(
		'heading' => '',
		'contents' => '',
		'icon_name'=>''
	), $atts, 'box' );

	return '<div class="jw-element span3 ">
                                        <div class="jw-service">
                                            <div class="jw-service-box service3">
                                                <div class="jw-service-icon"><i class="jw-font-awesome fa '.$atts['icon_name'].' circle"></i>
                                                </div>
                                                <div class="jw-service-content desc_unstyle">
												<h3>'.$atts['heading'].'</h3>
                                                    <p>'.$atts['contents'].'</p>
												 </div>
                                            </div>
                                        </div>
                                    </div>
		';
}
add_shortcode( 'box', 'boxes_func' );

function box_func( $atts, $content = "" ) {
	$atts = shortcode_atts( array(
		'box_container_class' => '',
	), $atts, 'box' );
	return '<div class="row-container inside '.$atts['box_container_class'].'">
                    <div class="container" style="width: inside">
                        <div class="row">
                            <div class="span12 ">
                                <div class="row-fluid">
								'.do_shortcode($content).'
								 </div>
                            </div>
                        </div>
                    </div>
                </div>
';
}
add_shortcode( 'box_container', 'box_func' );

function video_box_func( $atts,$content='') {
	$atts = shortcode_atts( array(
		'video_url' => '',
		'title' => '',
		'link'=>'',
		'link_text'=>''
	), $atts, 'video_box' );

	echo '<div class="row-container inside bg-parallax video-section-bg">
                    <div class="container" style="width: inside">
                        <div class="row">
                            <div class="span12 ">
                                <div class="row-fluid">
                                    <div class="jw-element span6 ">
                                        <div class="text-center video-box-content">

                                            <a href="'.$atts['video_url'].'" id="jquery_jplayer_135" class="html5lightbox content-vbtn-color-blue" data-width="900" data-height="420"><i class="icon-play-sign circle"></i></a>

                                        </div>
                                    </div>
                                    <div class="jw-element span6 ">
                                        <div class="jw-text_btn  with-button">
                                            <div class="text_btn-text">
                                                <h1>'.$atts['title'].'</h1>
                                                <div class="text_btn-text-line"></div>'.$content.'<p></p><a href="'.$atts['link'].'"target="_blank" class="btn btn-flat">'.$atts['link_text'].'</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
		';
}
add_shortcode( 'video_box', 'video_box_func' );

function cause_carousel_func( $atts,$content='') {
	$atts = shortcode_atts( array(
		'title' => '',
		'description' => '',
		'number'=>'',
		'read_more_text'=>'',
		'donate_text'=>'',
		'donate_link'=>''
	), $atts, 'video_box' );
	$html='';
	//$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            $args = array(
                            'post_type' => 'cause',
                            'posts_per_page' =>$atts['number'],
                            'order' => 'DESC',
							//'paged' => $paged
                            );
                            $loop = new WP_Query( $args );
								if ( $loop->have_posts() ) {
								while ( $loop->have_posts() ) : $loop->the_post();
								$custom = get_post_custom($post->ID);
       							$donated_amount = $custom["donated_amount"][0];
        						$remaining_amount = $custom["remaining_amount"][0];
								$html.='<li><div class="loop-image "><img src="'.gallery_thumbnail_url($post->ID).'" alt="img12 ">
<div class="cause-overlay "></div></div><div class="image-content "><div class="portfolio-title "><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></div><div class="progress home-progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:'.$donated_amount.'">'.$donated_amount.'</div></div><div class=""><h5><span>'.$donated_amount.' Donated  /</span>'.$remaining_amount.' To Go</h5></div><div class="main-page-causes"><p>        '.get_the_excerpt($post->ID).'</p></div><div class="cause-read"><a href="'.get_the_permalink($post->ID).'">'.$atts['read_more_text'].'</a>
<a href="'.$atts['donate_link'].'" target="_blank">'.$atts['donate_text'].'</a></div></div></li>';
                                endwhile;
								} else {
								$html.='No Results found';
								}
                            wp_reset_query();


	return '<div class="row-container inside " id="new-causes" >
                    <div class="container">
                        <div class="container_title">
                            <h1>'.$atts['title'].'</h1>
                            <div class="bottomdivider clearfix"></div>
                            <p>'.$atts['description'].'</p>
                        </div>
                        <div class="row">
                            <div class="span12 ">
                                <div class="row-fluid">
                                    <div class="jw-element span12 ">
                                        <div class="carousel-container">
                                            <div class="jw-carousel-portfolio list_carousel">
                                                <div class="caroufredsel_wrapper">
                                                    <ul class="jw-carousel cause-carousel">
													'.$html.'
                                                    </ul>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
}
add_shortcode( 'cause_carousel', 'cause_carousel_func' );

function gallery_box_func( $atts,$content='') {
	$atts = shortcode_atts( array(
		'title' => '',
		'subtitle' => '',
	), $atts, 'gallery_carousel' );
	  $term_name='';
	  $html='';
		$terms = get_terms( 'gallerycat' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
			$term_name.='<li><a href="#filter" data-option-value=".category-'.$term->name.'" title="'.$term->name.'">'.$term->name.'</a></li>';
			}
		}
		//$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
		'post_type' => 'gallery'
		);
		$loop = new WP_Query( $args );
			if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
			$class='';
		$terms = get_the_terms( get_the_ID(), 'gallerycat' );
		foreach ( $terms as $term ) {
        	$class.='category-'.$term->name.' ';

    	}
                                                  $html.='<article class="post-132 jw_portfolio type-jw_portfolio status-publish has-post-thumbnail hentry span4 '.$class.' isotope-item">
                                                        <div class="loop-image">
                                                            <div class="full-width">
                                                                <div class="gri">

                                                                    <figure class="effect-layla">
                                                                        <img src="'.gallery_thumbnail_url($post->ID).'" alt="img9">
                                                                        <div class="cause-overlay"></div>

                                                                        <figcaption>
                                                                            <h3>'.get_the_title($post->ID).'</h3>
                                                                            <p></p>

                                        <a class="fancybox" href="'.gallery_thumbnail_url($post->ID).'" target="_blank">
                                                                            </a>

                                                                        </figcaption>
                                                                    </figure>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </article>';
                                                    endwhile;
								} else {
								$html.='No Results found';
								}
                            wp_reset_query();


	  return '<div class="row-container inside">
                    <div class="container" style="width: inside">
                        <div class="container_title">
                            <h1>'.$atts['title'].'</h1>
                            <div class="bottomdivider clearfix"></div>
                            <p>'.$atts['subtitle'].'</p>
                        </div>
                        <div class="row">
                            <div class="span12 ">
                                <div class="row">
                                    <div class="jw-element span12 ">
                                        <div class="jw-portfolio">
                                            <div class="jw-filter">
                                                <ul class="filters option-set clearfix post-category inline" data-option-key="filter">
                                                <li><a href="#filter" data-option-value="*" class="selected">All</a></li>                                                  '.$term_name.'
                                                </ul>
                                            </div>
                                            <div class="row gallery-post">
                                                <div class="isotope-container isotope">
                                               '.$html.'
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
}
add_shortcode( 'gallery_box', 'gallery_box_func' );

function counter_shortcode( $atts, $content = null )
{
	extract( shortcode_atts( array(
      'title' => '',
	  'subtitle' => '',
      'year' => '',
      'month' => '',
      'day' => '',
      'hour' => '',
	  'minute' => '',
      'second' => ''
      ), $atts ) );

	  return'<section class="upcomming_ent_area">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-sm-5 col-xs-12">
							<div class="calv">
								<div class="cicon">
									<i class="fa fa-calendar"></i>
								</div>
								<div class="txtc">
									<h3>'.$title.'</h3>
									<p>'.$subtitle.'</p>
								</div>
							</div>
						</div>
						<div class="col-md-8 col-sm-7 col-xs-12">
							<ul class="counterc jw-coming-soon clearfix" data-years="'.$year.'" data-months="'.$month.'" data-days="'.$day.'" data-hours="'.$hour.'" data-minutes="'.$minute.'" data-seconds="'.$second.'">
								<li class="days">
									<h3 class="count">-62</h3>
									<p>Days</p>
								</li>
								<li class="hours">
									<h3 class="count">0</h3>
									<p>Hours</p>
								</li>
								<li class="minutes">
									<h3 class="count">-51</h3>
									<p>Minutes</p>
								</li>
								<li class="seconds">
									<h3 class="count">-49</h3>
									<p>Seconds</p>
								</li>
							</ul>
						</div>
					</div>
				</div>
            </section>';

	  /*return '<div class="row-container inside start-event">
                    <div class="container">
                        <div class="row">
                            <div class="span12 ">
                                <div class="row-fluid">
                                    <div class="jw-element span12 ">
                                        <div class="jw-cs-container">

                                            <div class="event-main-title clearfix">
                                                <div class="pull-left"><i class="icon-calendar"></i>
                                                </div>
                                                <h1 class="school"><span class="all-events">'.$title.'</span><br>'.$subtitle.'</h1>
                                            </div>
                                            <div class="jw-coming-soon clearfix" data-years="'.$year.'" data-months="'.$month.'" data-days="'.$day.'" data-hours="'.$hour.'" data-minutes="'.$minute.'" data-seconds="'.$second.'">
                                                <div class="days">
                                                    <div class="count">121</div>
                                                    <div class="text">DAYS</div>
                                                </div>
                                                <div class="sep">:</div>
                                                <div class="hours">
                                                    <div class="count">6</div>
                                                    <div class="text">HOURS</div>
                                                </div>
                                                <div class="sep">:</div>
                                                <div class="minutes">
                                                    <div class="count">20</div>
                                                    <div class="text">MINUTES</div>
                                                </div>
                                                <div class="sep">:</div>
                                                <div class="seconds">
                                                    <div class="count">44</div>
                                                    <div class="text">SECONDS</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';*/
}
add_shortcode('counter', 'counter_shortcode');

function donate_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
      'title' => '',
	  'subtitle' => '',
      'donate_text' => '',
      'donate_link' => ''
      ), $atts ) );
	  return '<div class="row-container inside bg-parallax donate-bd">
                    <div class="container">
                        <div class="row">
                            <div class="span12 ">
                                <div class="row-fluid">
                                    <div class="jw-element span12 ">
                                        <div class="callout-container">
                                            <div class="jw-callout container with-button">
                                                <div class="callout-text">
                                                    <h1>'.$title.'</h1>
                                                    <p>'.$subtitle.'</p>
                                                </div>
                                                <div class="callout-btn">
													<a href="'.$donate_link.'" class="btn btn-flat btn-large">'.$donate_text.'</a>

												</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
}
add_shortcode('donate', 'donate_box');


function fun_container_box( $atts, $content ='')
{
	extract( shortcode_atts( array(
      'title' => '',
	  'subtitle' => ''
      ), $atts ) );
	  return ' <div class="row-container inside bg-parallax miles">
                    <div class="container" style="width: inside">
                        <div class="container_title">
                            <h1>'.$title.'</h1>
                            <div class="bottomdivider clearfix"></div>
                            <p>'.$subtitle.'</p>
                        </div>
                        <div class="row">
                            <div class="span12 ">
                                <div class="row-fluid">
								'.do_shortcode($content).'
								</div>
                            </div>
                        </div>
                    </div>
                </div>';
}
add_shortcode('fun_container', 'fun_container_box');

function funfact_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
      'title' => '',
	  'value'=>'',
	  'icon_box'=>''
      ), $atts ) );
	  $val=str_split($value);
	  $size=sizeof($val);
	  $li='';
	  for ($x = 0; $x < $size; $x++) {
		  $li.='<div class="jw-milestones-show"><ul style="bottom: -346px;" class="">';
		  for ($y = 0; $y <= $val[$x]; $y++) {
			  $li.='<li class="">'.$y.'</li>';
		  }
		  $li.='</ul></div>';
    	//
	  }
	  return '<div class="jw-element span3 ">
                                        <div class="jw-milestones">
                                            <div class=" jw-milestones-box span3   jw-animate">
                                                <div class="jw-milestones-icon">
                                                    <i class="jw-font-awesome fa '.$icon_box.' circle"></i>
                                                </div>
                                                <div class="jw-milestones-content">
                                                    <div class="jw-milestones-count clearfix">
                                                       '.$li.'
                                                        <br/>
                                                        <p>'.$title.'</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
}
add_shortcode('fun', 'funfact_box');

function event_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
      'title' => '',
	  'subtitle'=>'',
	  'number'=>''
      ), $atts ) );
	  $html='';
	  //$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
									$args = array(
									'post_type' => 'event',
									'posts_per_page' =>$number,
									'order' => 'DESC',
									//'paged' => $paged
									);
									$loop = new WP_Query( $args );
										if ( $loop->have_posts() ) {
										while ( $loop->have_posts() ) : $loop->the_post();
										$custom = get_post_custom($post->ID);
       							$location_name = $custom["location_name"][0];
        						$event_date = $custom["event_date"][0];
								$event_month = $custom["event_month"][0];
								$event_time = $custom["event_time"][0];
								$html.='<div class="span6">
                                                <div class="loop-image">

                                                    <img src="'.gallery_thumbnail_url($post->ID).'" alt="img17">
                                                </div>
                                                <div class="even-content clearfix">
                                                    <div class="span1 pull-left">
                                                        <h3>'.$event_date.'</h3>
                                                        <p>'.$event_month.'</p>
                                                    </div>
                                                    <div class="pull-left event-title">
                                                        <h3><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h3>
                                                        <p class="event-loc"><i class="icon-time"></i>'.$event_time.'<i class="icon-map-marker sec"></i>'.$location_name.'</p>

                                                    </div>
                                                    <div class="">
                                                        <div class="event-new-content">
                                                            <p>'.get_the_excerpt().'</p>

                                                        </div>
                                                        <div class="event-read">
                                                            <a href="'.get_the_permalink($post->ID).'">Read More</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

										endwhile;
                                        }

	  return '<div class="row-container inside ">
                    <div class="container">
                        <div class="container_title">
                            <h1>'.$title.'</h1>
                            <div class="bottomdivider clearfix"></div>
                            <p>'.$subtitle.'</p>

                        </div>
                        <div class="row">
                            <div class="span12 ">
                                <div class="row-fluid">
                                    <div class="jw-element span12 ">
                                        <div class="jw-carousel events">
										'.$html.'
										</div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
										';
}
add_shortcode('event_box', 'event_box');

function testimonial_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
      'title' => '',
	  'number'=>''
      ), $atts ) );
	  $html='';
								$args = array(
								'post_type' => 'testimonial',
								'posts_per_page' =>$number,
								'order' => 'DESC',
								//'paged' => $paged
								);
								$loop = new WP_Query( $args );
								if ( $loop->have_posts() ) {
								while ( $loop->have_posts() ) : $loop->the_post();
								$html.='<div class="owl-item">
                                                        <div class="item">
                                                            <div class="testimonial-item clearfix">
                                                                <div class="testimonial-author">
                                                                    <img src="'.gallery_thumbnail_url($post->ID).'" alt="img4">
                                                                </div>
                                                                <div class="testimonial-content">
                                                                    <p class="testi-content">'.get_the_excerpt($post->ID).'</p>
                                                                    <p class="auther-name"><span></span> /</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';

										endwhile;
                                        }

	  return '<div class="row-container inside bg-parallax carsol-owl">
                    <div class="container" style="width: inside">
                        <div class="container_title">
                            <h1> WHAT PEOPLE SAYS</h1>
                            <div class="bottomdivider clearfix"></div>
                            <p></p>
                        </div>
                        <div class="row">
                            <div class="span12 ">
                                <div class="row-fluid">
                                    <div class="jw-element span12 ">
                                        <div id="owl-testimonial-1" class="testimonials-ct owl-carousel owl-theme">
                                            <div class="owl-wrapper-outer">
                                                <div class="owl-wrapper">
												'.$html.'
												   </div>
                                            </div>
                                            <div class="owl-controls clickable">
                                                <div class="owl-pagination">
                                                    <div class="owl-page"><span class=""></span>
                                                    </div>
                                                    <div class="owl-page active"><span class=""></span>
                                                    </div>
                                                    <div class="owl-page"><span class=""></span>
                                                    </div>
                                                </div>
                                                <div class="owl-buttons">
                                                    <div class="owl-prev"></div>
                                                    <div class="owl-next"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
}
add_shortcode('testimonial_box', 'testimonial_box');

function blog_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
      'title' => '',
	  'subtitle'=>'',
	  'number'=>''
      ), $atts ) );
	  $html='';
								$args = array(
								'post_type' => 'post',
								'posts_per_page' =>$number,
								'order' => 'DESC',
								//'paged' => $paged
								);
								$loop = new WP_Query( $args );
								if ( $loop->have_posts() ) {
								while ( $loop->have_posts() ) : $loop->the_post();
								 if (have_comments()) $link=get_the_permalink($post->ID).'#comments';
								 else $link=get_the_permalink($post->ID);
								$html.='<article class="category-blog tag-web-site loop span4 isotope-item">

                                                        <div class="loop-media">
                                                            <div class="loop-image">

                                                                <img src="'.gallery_thumbnail_url($post->ID).'" alt="img2">
                                                                <div class="image-overlay">
                                                                    <a href="" title="'.get_the_title($post->ID).'"></a>
                                                                </div>
                                                            </div>
                                                            <div class="image-overlay">
                                                                <a href="" title="'.get_the_title($post->ID).'"></a>
                                                            </div>
                                                        </div>
                                                        <div class="loop-block">
                                                            <h3 class="loop-title"><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h3>

                                                            <div class="meta-containers">
                                                                <div class="carousel-meta clearfix">
                                                                    <div class="one-auther">'.get_the_date('F jS, Y',$post->ID).'</div>
                                                                    <div class="one-auther">By:  '.get_the_author().'</div>
                                                                    <div class="comment-count"><a href="'.$link.'" title="00 Comments" class="comment-count">'.get_comments_number().' comments </a>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="loop-content clearfix">
                                                                <p>'.get_the_excerpt($post->ID).'</p>
                                                            </div>

                                                            <div class="read-more-container">
                                                                <a href="'.get_the_permalink($post->ID).'" class="more-link" target="_blank">Read More</a>
                                                            </div>

                                                        </div>
                                                    </article>';

										endwhile;
                                        }

	  return '<div class="">
                    <div class="container">
                        <div class="container_title">
                            <h1>'.$title.'</h1>
                            <div class="bottomdivider clearfix"></div>
                            <p>'.$subtitle.'</p>
                        </div>
                        <div class="row">
                            <div class="span12 ">
                                <div class="row">
                                    <div class="jw-element span12 ">
                                        <div class="jw-blog">
                                            <div class="row">
                                                <div style="" class="isotope-container">
												'.$html.'
												   </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
}
add_shortcode('blog_box', 'blog_box');

function team_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
      'title' => '',
	  'subtitle'=>'',
	  'number'=>'',
	  'slider'=>''
      ), $atts ) );
	  $html='';
								$args = array(
								'post_type' => 'team',
								'posts_per_page' =>$number,
								'order' => 'DESC',
								//'paged' => $paged
								);
								if($slider=='true') $text='team-carousel'; else $text='';
								$loop = new WP_Query( $args );
								if ( $loop->have_posts() ) {
								while ( $loop->have_posts() ) : $loop->the_post();
								$custom = get_post_custom($post->ID);
       							$position = $custom["position"][0];
        						$facebook = $custom["facebook"][0];
								$google = $custom["google"][0];
								$twitter = $custom["twitter"][0];
								$linkedin = $custom["linkedin"][0];
								$html.='<div class="team-member span3">
                                                <div class="member-image loop-image">
                                                    <div class="team-member-image">
                                                        <img src="'.gallery_thumbnail_url($post->ID).'" alt="img7">
                                                        <div class="team-member-overlay"></div>
                                                    </div>
                                                    <div class="team-detail">
                                                        <div class="member-title">
                                                            <h3>'.get_the_title($post->ID).'</h3><span>'.$position.'</span>
                                                        </div>
                                                        <div class="member-social">
                                                            <div class="jw-social-icon clearfix"><a href="'.$facebook.'" target="_blank"><i class="jw-font-awesome icon-facebook"></i></a><a href="'.$linkedin.'" target="_blank"><i class="jw-font-awesome icon-linkedin"></i></a><a href="'.$twitter.'" target="_blank"><i class="jw-font-awesome icon-twitter"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

										endwhile;
                                        }

	  return '<div class="row-container inside ">
                    <div class="container" style="width: inside">
                        <div class="container_title">
                            <h1>'.$title.'</h1>
                            <div class="bottomdivider clearfix"></div>
                            <p>'.$subtitle.'</p>
                        </div>
                        <div class="row">
                            <div class="span12 ">
                                <div class="row">
                                    <div class="jw-element span12 ">
                                        <div class="jw-our-team '.$text.'">
												'.$html.'
												   </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
}
add_shortcode('team_box', 'team_box');

function partner_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
	  'number'=>'',
	  'slider'=>''
      ), $atts ) );
	  $html='';
								$args = array(
								'post_type' => 'partner',
								'posts_per_page' =>$number,
								'order' => 'DESC',
								//'paged' => $paged
								);
								if($slider=='true') $text='partner-carousel'; else $text='';
								$loop = new WP_Query( $args );
								if ( $loop->have_posts() ) {
								while ( $loop->have_posts() ) : $loop->the_post();
								$custom = get_post_custom($post->ID);
       							$link = $custom["link"][0];
								if($link ==''){
								   $html.='<div class="sitem">
								   <a href="#"><img src="'.gallery_thumbnail_url($post->ID).'" alt="image" />
									</a>
									</div>';
								} else{
								$html.='<div class="sitem">
								   <a href="'.$link.'"><img src="'.gallery_thumbnail_url($post->ID).'" alt="image" />
									</a>
									</div>';
								}

								endwhile;
								}

	  return '<section class="client_area">
                <div class="container">
                    <div class="row">
                        <div id="client" class="owl-carousel">
							'.$html.'
						</div>
                    </div>
                </div>
            </section>';
}
add_shortcode('partner_box', 'partner_box');

function contact_info_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
	  'phone'=>'',
	  'email'=>'',
	  'address'=>'',
      ), $atts ) );
	  return '<div class="jw-element padding-top-30">
                                    <div class="contactinfo_container">
                                        <div class="contact-content">
                                            <p>'.$content.'</p>
                                        </div>
                                        <div class="contact-call cinfo">
                                            <div><i class="icon-phone"></i>
                                            </div>'.$phone.'</div>
                                        <div class="contact-email cinfo">
                                            <div><i class=" icon-envelope"></i>
                                            </div>'.$email.'</div>
                                        <div class="contact-addr cinfo">
                                            <div><i class="icon-map-marker"></i>
                                            </div>'.$address.'</div>
                                    </div>
                                </div>';
}
add_shortcode('contact_info_box', 'contact_info_box');

function info_box_f( $atts, $content ='')
{
	extract( shortcode_atts( array(
	  'phone'=>'',
	  'email'=>'',
	  'address'=>'',
      ), $atts ) );
	  return '<section class="promo_area">
                <div class="container">
                    <div class="row">
					'.do_shortcode($content).'
					</div>
                </div>
            </section>';
}
add_shortcode('box_container_four', 'info_box_f');

function info_box_single( $atts, $content = null )
{
	extract( shortcode_atts( array(
	  'box_title'=>'',
	  'link_title'=>'',
      ), $atts ) );
	  return '<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="promo">
								<h4><img src="'.wp_get_attachment_url($link_title).'" alt="image" /></h4>
								<h3>'.$box_title.'</h3>
							</div>
						</div>';
}
add_shortcode('box_four', 'info_box_single');

function home_cause_container( $atts, $content ='')
{
	extract( shortcode_atts( array(
	  //'phone'=>'',
	  //'email'=>'',
	  //'address'=>'',
      ), $atts ) );
	  return '<section class="family_area">
                <div class="container">
					'.do_shortcode($content).'
					</div>
                </div>
            </section>';
}
add_shortcode('home_cause_container', 'home_cause_container');

function individual_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
	  'individual_title'=>'',
      ), $atts ) );
	  $category='';
			$args = array( 'hide_empty' => 0 );
			$terms = get_terms( 'causeindividual', $args );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			//$count = count( $terms );
			//$i = 0;
			foreach ( $terms as $term ) {
			$t_id = $term->term_id;
			$term_meta = get_option( "department_$t_id" );
			$category.='<li><a href="'.get_term_link( $term ).'">
				<span><img src="'.$term_meta['image'].'" alt="image" /></span>'.$term->name.'
			</a></li>';
				}
			}
			$causes='';
			$custom_terms = get_terms('causeindividual');
			foreach($custom_terms as $custom_term) {
			wp_reset_query();
			$args = array(
			'post_type' => 'cause',
			//'posts_per_page' =>$atts['number'],
			'order' => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => 'causeindividual',
					'field' => 'slug',
					'terms' => $custom_term->slug,
				),
			),
			//'paged' => $paged
			);
			$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();
				$custom = get_post_custom($post->ID);
				$donated_amount = $custom["donated_amount"][0];
				$remaining_amount = $custom["remaining_amount"][0];

                $payment_type = $custom["payment_type"][0];
                $payment_amount = $custom["payment_amount"][0];
                $recurring_amount = $custom["recurring_amount"][0];
                $recurring_cycle_number = $custom["recurring_cycle_number"][0];
                $recurring_by = $custom["recurring_by"][0];
				$donated=(($donated_amount*100)/$remaining_amount);
				$donated=ceil($donated);
				$remains=$remaining_amount-$donated_amount;
                if($payment_type=='one_time'){
                    $paypal_form.='<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="donate_'.get_the_ID ().'">
                    <input type="hidden" name="business" value="info@codexworld.com" />
                    <input type="hidden" name="cancel_return" value="'.get_the_permalink($post->ID).'" />
                    <input type="hidden" name="return" value="'.get_the_permalink($post->ID).'" />
                    <input type="hidden" name="rm" value="2" />
                    <input type="hidden" name="lc" value="" />
                    <input type="hidden" name="no_shipping" value="1" />
                    <input type="hidden" name="no_note" value="1" />
                    <input type="hidden" name="currency_code" value="USD" />
                    <input type="hidden" name="page_style" value="paypal" />
                    <input type="hidden" name="charset" value="utf-8" />
                    <input type="hidden" name="item_name" value="' .get_the_title($post->ID). '" />
                    <input type="hidden" name="item_number" value="'.get_the_ID ().'">
                    <input type="hidden" name="cmd" value="_xclick" />
                    <input type="hidden" name="amount" value="'.$payment_amount.'" />

                    </form>';
                }
                else{
				$paypal_form.='<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="donate_'.get_the_ID ().'">
				<input type="hidden" name="business" value="info@codexworld.com" />
				<input type="hidden" name="cancel_return" value="'.get_the_permalink($post->ID).'" />
				<input type="hidden" name="return" value="'.get_the_permalink($post->ID).'" />
				<input type="hidden" name="rm" value="2" />
				<input type="hidden" name="lc" value="" />
				<input type="hidden" name="no_shipping" value="1" />
				<input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="currency_code" value="USD" />
				<input type="hidden" name="page_style" value="paypal" />
				<input type="hidden" name="charset" value="utf-8" />
				<input type="hidden" name="item_name" value="' .get_the_title($post->ID). '" />
				<input type="hidden" name="item_number" value="'.get_the_ID ().'">
				 <input type="hidden" name="cmd" value="_xclick-subscriptions" />
				<input type="hidden" name="src" value="1" />
				<input type="hidden" name="srt" value="0" />

				<input type="hidden" name="a1" value="'.$payment_amount.'" />
				<input type="hidden" name="p1" value="'.$recurring_cycle_number.'" />
				<input type="hidden" name="t1" value="'.$recurring_by.'"/>
				<input type="hidden" name="a3" value="'.$recurring_amount.'" />
				<input type="hidden" name="p3" value="'.$recurring_cycle_number.'" />
				<input type="hidden" name="t3" value="'.$recurring_by.'" />

				</form>';
                }
                
                if ( is_user_logged_in() ) {
                    $causes.='<div class="sitem">

						<div class="sfam">
							<div class="faimg">
								<a href="'.get_the_permalink($post->ID).'"><img src="'.gallery_thumbnail_url($post->ID).'" alt="image" /></a>
							</div>
							<div class="famtxt">
								<h4>'.get_the_title($post->ID).'</h4>
								<style>
								.prg::after{
								width:'.$donated.'% !important;
								}
								</style>
								<div class="progress home-progress" style="background-color: #eaeaea;height: 15px;margin-left: 0;border-radius:0;">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:'.$donated.'%">&nbsp</div>
								</div>
								<h5>$'.$donated_amount.' Donated  /  $'.$remains.' To Go</h5>
								<p>'.get_the_excerpt($post->ID).'</p>
								<a href="#" data-id="'.get_the_ID ().'" class="donate">DONATE</a>
							</div>
						</div>

				</div>';
                } else {
                    $causes.='<div class="sitem">

						<div class="sfam">
							<div class="faimg">
								<a href="'.get_the_permalink($post->ID).'"><img src="'.gallery_thumbnail_url($post->ID).'" alt="image" /></a>
							</div>
							<div class="famtxt">
								<h4>'.get_the_title($post->ID).'</h4>
								<style>
								.prg::after{
								width:'.$donated.'% !important;
								}
								</style>
								<div class="progress home-progress" style="background-color: #eaeaea;height: 15px;margin-left: 0;border-radius:0;">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:'.$donated.'%">&nbsp</div>
								</div>
								<h5>$'.$donated_amount.' Donated  /  $'.$remains.' To Go</h5>
								<p>'.get_the_excerpt($post->ID).'</p>
								<a href="'.wp_login_url().'" class="show_login" data-id="'.get_the_ID ().'">Login To Donate</a>
							</div>
						</div>

				</div>';
                }

				endwhile;
				}
			}


	  return '<div class="row famiar">
                        <h2 class="famhd">SUPPORT A CAUSE > '.$individual_title.' </h2>
						<div class="col-md-2 col-sm-3 col-xs-12">
							<div class="catpart">
								<h4>All Categories</h4>
								<ul>
								'.$category.'
								</ul>
							</div>
						</div>
						'.$paypal_form.'
						<div class="col-md-10  col-sm-9 col-xs-12">
							<div class="allfrm">
							'.$causes.'
							</div>
						</div>
                    </div>';
}
add_shortcode('individual_box', 'individual_box');

function ngo_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
	  'ngo_title'=>'',
      ), $atts ) );
	  $category='';
			$args = array( 'hide_empty' => 0 );
			$terms = get_terms( 'causengo', $args );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			//$count = count( $terms );
			//$i = 0;
			foreach ( $terms as $term ) {
			$t_id = $term->term_id;
			$term_meta = get_option( "department_$t_id" );
			$category.='<li><a href="'.get_term_link( $term ).'">
				<span><img src="'.$term_meta['image'].'" alt="image" /></span>'.$term->name.'
			</a></li>';
				}
			}
			$causes='';
			$custom_terms = get_terms('causengo');
			foreach($custom_terms as $custom_term) {
			wp_reset_query();
			$args = array(
			'post_type' => 'cause',
			//'posts_per_page' =>$atts['number'],
			'order' => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => 'causengo',
					'field' => 'slug',
					'terms' => $custom_term->slug,
				),
			),
			//'paged' => $paged
			);
			$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();
				$custom = get_post_custom($post->ID);
				$donated_amount = $custom["donated_amount"][0];
				$remaining_amount = $custom["remaining_amount"][0];

                $payment_type = $custom["payment_type"][0];
                $payment_amount = $custom["payment_amount"][0];
                $recurring_amount = $custom["recurring_amount"][0];
                $recurring_cycle_number = $custom["recurring_cycle_number"][0];
                $recurring_by = $custom["recurring_by"][0];

				$donated=(($donated_amount*100)/$remaining_amount);
				$donated=ceil($donated);
				$remains=$remaining_amount-$donated_amount;
				if($payment_type=='one_time'){
                    $paypal_form.='<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="donate_'.get_the_ID ().'">
                    <input type="hidden" name="business" value="info@codexworld.com" />
                    <input type="hidden" name="cancel_return" value="'.get_the_permalink($post->ID).'" />
                    <input type="hidden" name="return" value="'.get_the_permalink($post->ID).'" />
                    <input type="hidden" name="rm" value="2" />
                    <input type="hidden" name="lc" value="" />
                    <input type="hidden" name="no_shipping" value="1" />
                    <input type="hidden" name="no_note" value="1" />
                    <input type="hidden" name="currency_code" value="USD" />
                    <input type="hidden" name="page_style" value="paypal" />
                    <input type="hidden" name="charset" value="utf-8" />
                    <input type="hidden" name="item_name" value="' .get_the_title($post->ID). '" />
                    <input type="hidden" name="item_number" value="'.get_the_ID ().'">
                    <input type="hidden" name="cmd" value="_xclick" />
                    <input type="hidden" name="amount" value="'.$payment_amount.'" />

                    </form>';
                }
                else{
				$paypal_form.='<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="donate_'.get_the_ID ().'">
				<input type="hidden" name="business" value="info@codexworld.com" />
				<input type="hidden" name="cancel_return" value="'.get_the_permalink($post->ID).'" />
				<input type="hidden" name="return" value="'.get_the_permalink($post->ID).'" />
				<input type="hidden" name="rm" value="2" />
				<input type="hidden" name="lc" value="" />
				<input type="hidden" name="no_shipping" value="1" />
				<input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="currency_code" value="USD" />
				<input type="hidden" name="page_style" value="paypal" />
				<input type="hidden" name="charset" value="utf-8" />
				<input type="hidden" name="item_name" value="' .get_the_title($post->ID). '" />
				<input type="hidden" name="item_number" value="'.get_the_ID ().'">
				 <input type="hidden" name="cmd" value="_xclick-subscriptions" />
				<input type="hidden" name="src" value="1" />
				<input type="hidden" name="srt" value="0" />

				<input type="hidden" name="a1" value="'.$payment_amount.'" />
				<input type="hidden" name="p1" value="'.$recurring_cycle_number.'" />
				<input type="hidden" name="t1" value="'.$recurring_by.'"/>
				<input type="hidden" name="a3" value="'.$recurring_amount.'" />
				<input type="hidden" name="p3" value="'.$recurring_cycle_number.'" />
				<input type="hidden" name="t3" value="'.$recurring_by.'" />

				</form>';
                }

				if ( is_user_logged_in() ) {
                    $causes.='<div class="sitem">

						<div class="sfam">
							<div class="faimg">
								<a href="'.get_the_permalink($post->ID).'"><img src="'.gallery_thumbnail_url($post->ID).'" alt="image" /></a>
							</div>
							<div class="famtxt">
								<h4>'.get_the_title($post->ID).'</h4>
								<style>
								.prg::after{
								width:'.$donated.'% !important;
								}
								</style>
								<div class="progress home-progress" style="background-color: #eaeaea;height: 15px;margin-left: 0;border-radius:0;">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:'.$donated.'%">&nbsp</div>
								</div>
								<h5>$'.$donated_amount.' Donated  /  $'.$remains.' To Go</h5>
								<p>'.get_the_excerpt($post->ID).'</p>
								<a href="#" data-id="'.get_the_ID ().'" class="donate">DONATE</a>
							</div>
						</div>

				</div>';
                } else {
                    $causes.='<div class="sitem">

						<div class="sfam">
							<div class="faimg">
								<a href="'.get_the_permalink($post->ID).'"><img src="'.gallery_thumbnail_url($post->ID).'" alt="image" /></a>
							</div>
							<div class="famtxt">
								<h4>'.get_the_title($post->ID).'</h4>
								<style>
								.prg::after{
								width:'.$donated.'% !important;
								}
								</style>
								<div class="progress home-progress" style="background-color: #eaeaea;height: 15px;margin-left: 0;border-radius:0;">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:'.$donated.'%">&nbsp</div>
								</div>
								<h5>$'.$donated_amount.' Donated  /  $'.$remains.' To Go</h5>
								<p>'.get_the_excerpt($post->ID).'</p>
								<a href="'.wp_login_url().'" class="show_login" data-id="'.get_the_ID ().'">Login To Donate</a>
							</div>
						</div>

				</div>';
                }

				endwhile;
				}
			}


	  return '<div class="row famiar">
                        <h2 class="famhd">SUPPORT A CAUSE > '.$ngo_title.' </h2>
						<div class="col-md-2 col-sm-3 col-xs-12">
							<div class="catpart">
								<h4>All Categories</h4>
								<ul>
								'.$category.'
								</ul>
							</div>
						</div>
						'.$paypal_form.'
						<div class="col-md-10  col-sm-9 col-xs-12">
							<div class="allfrm">
							'.$causes.'
							</div>
						</div>
                    </div>';
}
add_shortcode('ngo_box', 'ngo_box');

function adopt_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
	  'adopt_title'=>'',
      ), $atts ) );
	  $category='';
			$args = array( 'hide_empty' => 0 );
			$terms = get_terms( 'causechild', $args );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			//$count = count( $terms );
			//$i = 0;
			foreach ( $terms as $term ) {
			$t_id = $term->term_id;
			$term_meta = get_option( "department_$t_id" );
			$category.='<li><a href="'.get_term_link( $term ).'">
				<span><img src="'.$term_meta['image'].'" alt="image" /></span>'.$term->name.'
			</a></li>';
				}
			}
			$causes='';
			$custom_terms = get_terms('causechild');
			foreach($custom_terms as $custom_term) {
			wp_reset_query();
			$args = array(
			'post_type' => 'cause',
			//'posts_per_page' =>$atts['number'],
			'order' => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => 'causechild',
					'field' => 'slug',
					'terms' => $custom_term->slug,
				),
			),
			//'paged' => $paged
			);
			$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();
				$custom = get_post_custom($post->ID);
				$donated_amount = $custom["donated_amount"][0];
				$remaining_amount = $custom["remaining_amount"][0];
                $payment_type = $custom["payment_type"][0];
                $payment_amount = $custom["payment_amount"][0];
                $recurring_amount = $custom["recurring_amount"][0];
                $recurring_cycle_number = $custom["recurring_cycle_number"][0];
                $recurring_by = $custom["recurring_by"][0];
				$donated=(($donated_amount*100)/$remaining_amount);
				$donated=ceil($donated);
				$remains=$remaining_amount-$donated_amount;
				if($payment_type=='one_time'){
                    $paypal_form.='<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="donate_'.get_the_ID ().'">
                    <input type="hidden" name="business" value="info@codexworld.com" />
                    <input type="hidden" name="cancel_return" value="'.get_the_permalink($post->ID).'" />
                    <input type="hidden" name="return" value="'.get_the_permalink($post->ID).'" />
                    <input type="hidden" name="rm" value="2" />
                    <input type="hidden" name="lc" value="" />
                    <input type="hidden" name="no_shipping" value="1" />
                    <input type="hidden" name="no_note" value="1" />
                    <input type="hidden" name="currency_code" value="USD" />
                    <input type="hidden" name="page_style" value="paypal" />
                    <input type="hidden" name="charset" value="utf-8" />
                    <input type="hidden" name="item_name" value="' .get_the_title($post->ID). '" />
                    <input type="hidden" name="item_number" value="'.get_the_ID ().'">
                    <input type="hidden" name="cmd" value="_xclick" />
                    <input type="hidden" name="amount" value="'.$payment_amount.'" />

                    </form>';
                }
                else{
				$paypal_form.='<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="donate_'.get_the_ID ().'">
				<input type="hidden" name="business" value="info@codexworld.com" />
				<input type="hidden" name="cancel_return" value="'.get_the_permalink($post->ID).'" />
				<input type="hidden" name="return" value="'.get_the_permalink($post->ID).'" />
				<input type="hidden" name="rm" value="2" />
				<input type="hidden" name="lc" value="" />
				<input type="hidden" name="no_shipping" value="1" />
				<input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="currency_code" value="USD" />
				<input type="hidden" name="page_style" value="paypal" />
				<input type="hidden" name="charset" value="utf-8" />
				<input type="hidden" name="item_name" value="' .get_the_title($post->ID). '" />
				<input type="hidden" name="item_number" value="'.get_the_ID ().'">
				 <input type="hidden" name="cmd" value="_xclick-subscriptions" />
				<input type="hidden" name="src" value="1" />
				<input type="hidden" name="srt" value="0" />

				<input type="hidden" name="a1" value="'.$payment_amount.'" />
				<input type="hidden" name="p1" value="'.$recurring_cycle_number.'" />
				<input type="hidden" name="t1" value="'.$recurring_by.'"/>
				<input type="hidden" name="a3" value="'.$recurring_amount.'" />
				<input type="hidden" name="p3" value="'.$recurring_cycle_number.'" />
				<input type="hidden" name="t3" value="'.$recurring_by.'" />

				</form>';
                }

				if ( is_user_logged_in() ) {
                    $causes.='<div class="sitem">

						<div class="sfam">
							<div class="faimg">
								<a href="'.get_the_permalink($post->ID).'"><img src="'.gallery_thumbnail_url($post->ID).'" alt="image" /></a>
							</div>
							<div class="famtxt">
								<h4>'.get_the_title($post->ID).'</h4>
								<style>
								.prg::after{
								width:'.$donated.'% !important;
								}
								</style>
								<div class="progress home-progress" style="background-color: #eaeaea;height: 15px;margin-left: 0;border-radius:0;">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:'.$donated.'%">&nbsp</div>
								</div>
								<h5>$'.$donated_amount.' Donated  /  $'.$remains.' To Go</h5>
								<p>'.get_the_excerpt($post->ID).'</p>
								<a href="#" data-id="'.get_the_ID ().'" class="donate">DONATE</a>
							</div>
						</div>

				</div>';
                } else {
                    $causes.='<div class="sitem">

						<div class="sfam">
							<div class="faimg">
								<a href="'.get_the_permalink($post->ID).'"><img src="'.gallery_thumbnail_url($post->ID).'" alt="image" /></a>
							</div>
							<div class="famtxt">
								<h4>'.get_the_title($post->ID).'</h4>
								<style>
								.prg::after{
								width:'.$donated.'% !important;
								}
								</style>
								<div class="progress home-progress" style="background-color: #eaeaea;height: 15px;margin-left: 0;border-radius:0;">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:'.$donated.'%">&nbsp</div>
								</div>
								<h5>$'.$donated_amount.' Donated  /  $'.$remains.' To Go</h5>
								<p>'.get_the_excerpt($post->ID).'</p>
								<a href="'.wp_login_url().'" class="show_login" data-id="'.get_the_ID ().'">Login To Donate</a>
							</div>
						</div>

				</div>';
                }

				endwhile;
				}
			}


	  return '<div class="row famiar">
                        <h2 class="famhd">SUPPORT A CAUSE > '.$adopt_title.' </h2>
						<div class="col-md-2 col-sm-3 col-xs-12">
							<div class="catpart">
								<h4>All Categories</h4>
								<ul>
								'.$category.'
								</ul>
							</div>
						</div>
						'.$paypal_form.'
						<div class="col-md-10  col-sm-9 col-xs-12">
							<div class="allfrm">
							'.$causes.'
							</div>
						</div>
                    </div>';
}
add_shortcode('adopt_box', 'adopt_box');

function help_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
	  'help_title'=>'',
	  'help_sub_title'=>'',
	  'bg_img'=>'',
      ), $atts ) );

	  return '<section class="givehelp_area" style="background-image:url('.wp_get_attachment_url($bg_img).');">
                <div class="container">
                    <div class="row">
                        <div class="hparea">
							<h4>'.$help_title.'</h4>
							<h1>'.$help_sub_title.'</h1>
						</div>
                    </div>
                </div>
            </section>';
}
add_shortcode('help_box', 'help_box');
?>
