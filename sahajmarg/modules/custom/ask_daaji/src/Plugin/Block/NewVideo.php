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
 *   id = "new_video_block",
 *   admin_label = @Translation("New Video Block"),
 *   category = @Translation("New Video Block")
 * )
 */
class NewVideo extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
            
            $viquery = \Drupal::entityQuery('node')
			  ->condition('status', 1) //published or not
			  ->condition('type', 'ask_daaji_vidoes') // ->condition('type', 'ask_daaji_vidoes')
			  ->range(0, 1)
			  ->sort('created' , 'DESC');
			$nids = $viquery->execute();
			
			foreach ($nids as $nid) {
				  $node = \Drupal\node\Entity\Node::load($nid); 
				  $videotitle = $node->title->value;
				 //  $iframebody = check_markup($node->get('field_video_iframe')->value, $node->get('field_video_iframe')->format);
				  $iframebody = check_markup($node->get('field_video_iframe')->value, $node->get('field_video_iframe')->format);
				  $videocreated = date("Y-m-d h:i:s", $node->created->value);
			} 
			
					
					$iframe = array(
					  '#type' => 'inline_template',
					  '#template' => '<div class="container featured-ans-video">
										<div class="row">
										<div class="col-md-8 offset-md-2">'.$iframebody.'</div>
										</div>
								   </div>',
					);

					return $iframe;
				
				
            

    }

}