<?php

/**
 * @file
 * Contains \Drupal\article\Plugin\Block\XaiBlock.
 */

namespace Drupal\ask_daaji\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\field\Entity\FieldConfig;

/**
 * Provides a 'article' block.
 *
 * @Block(
 *   id = "ask_daaji_landing_block",
 *   admin_label = @Translation("Ask Daaji Landing Block"),
 *   category = @Translation("Ask Daaji Landing Block")
 * )
 */
class AskDaajiLandinBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
            
            $viquery = \Drupal::entityQuery('node')
			  ->condition('status', 1) //published or not
			  ->condition('type', 'ask_daaji_vidoes') //content type
			  ->range(0, 1)
			  ->sort('created' , 'DESC');
			$nids = $viquery->execute();
			
			foreach ($nids as $nid) {
				  $node = \Drupal\node\Entity\Node::load($nid); 
				  $videotitle = $node->title->value;
				 // $iframebody = $node->body->value;
				  $iframebody = check_markup($node->get('field_video_iframe')->value, $node->get('field_video_iframe')->format);
				  $videocreated = date("Y-m-d h:i:s", $node->created->value);
			} 
			
			$faqquery = \Drupal::entityQuery('node')
			  ->condition('status', 1) //published or not
			  ->condition('type', 'common_questions') //content type
			  ->range(0, 1)
			  ->sort('created' , 'DESC');
			$faqnids = $faqquery->execute();
			
			foreach ($faqnids as $faqnid) {
				  $node = \Drupal\node\Entity\Node::load($faqnid); 
				  $faqtitle = $node->title->value;
				  $faqbody = $node->body->value;
				  $faqcreated = date("Y-m-d h:i:s", $node->created->value);
			} 
				$videodate = strtotime($videocreated); 
				$faqdate = strtotime($faqcreated);
				if ($videodate > $faqdate) {
					
					$iframe = array(
					  '#type' => 'inline_template',
					  '#template' => '<div class="row">
								   <div class="col-lg-12 pt-3">
								   <h2 class="text-center section-title PlayfairDisplay-Regular title-color pb-1">Featured Topic</h2>
								   </div>
								   </div>
								   <div class="container featured-ans-video"><div class="row"><div class="col-md-8 offset-md-2">'.$iframebody.'</div>
								   </div>
								   </div>',
					);

					return $iframe;
				}
				else{
					$result = '<div class="row">
								   <div class="col-lg-12 pt-3">
								   <h2 class="text-center section-title PlayfairDisplay-Regular title-color pb-1">Featured Topic</h2>
								   </div>
								   </div>
								<div class="faq-accord-isgis" id="accordion">
								<div class="card m-5">
								<div class="card-header" id="is-gis-1">
								<h5 class="mb-0 mx-2"><a aria-controls="collapse-1" aria-expanded="true" class="adlanding" data-toggle="collapse" href="#collapse-1" role="button"><strong>'.$faqtitle.'</strong></a></h5>
								</div>
								<div aria-labelledby="is-gis-1" class="collapse show" data-parent="#accordion" id="collapse-1" style="">
								<div class="card-body">
								<p class="content"><a aria-controls="collapse-1" aria-expanded="true" class="adlanding" data-toggle="collapse" href="#collapse-1" role="button">'.$faqbody.'</a></p>
								</div>
								</div>
								</div>
								</div>'; 
					return array(
							'#type' => 'markup',            
							'#markup' => $result,             
						   ); 
				}
            

    }

}