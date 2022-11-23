<?php

namespace Drupal\newscoop\Controller;

use Drupal\Core\Controller\ControllerBase;
use mpdf\Mpdf;
use Drupal\views\Views;
use Drupal\Core\File;
use Drupal\Core\URL;
/**
 * Class HFNReportController.
 */
class HFNReportController extends ControllerBase {
 
  /**
   * Hfnreportmethod.
   *
   * @return string
   *   Return Hello string.
   */
  public function HFNReportMethod() {
    //file_directory_temp
    // $mpdf = new \Mpdf\Mpdf(['tempDir' => file_directory_temp()]);
    // $mpdf->WriteHTML('<h1>Hello world!</h1>');
    // $mpdf->Output();
    $mpdf = new \Mpdf\Mpdf(['tempDir' => file_directory_temp(),'mode' => 'utf-8',]);
    for($i=0;$i<=11;$i++) {
      $view = Views::getView('hfn_reports');
      if (is_object($view)) {
        $view->setDisplay('page_1');
        $view->setItemsPerPage(50);
        $view->setOffset($i*50);
        $view->preExecute();
        $view->execute();
        $content = $view->buildRenderable('page_1');
        
        $mpdf->WriteHTML("<style>table {
          border: 1mm solid #2b2b2b;
  width: 100%;
  max-width: 15em;
  min-width: 10em;
  margin: 0 3em;
  }
  body {
  font-size: 21pt;
  line-height: 1.5;
  }
  td, th {
  border: 1mm solid #2b2b2b;
  padding: 2em;
  }
  table caption {
      padding-top: 2.75rem;
      padding-bottom: 0.75rem;
      color: #2b2b2b;
      text-align: left;
      caption-side: top;
      font-weight:bold;
      text-align:center;
  }
  .hfn-reports-tables label {
      font-weight:bold;
      
  }
  .views-exposed-form {
    display: none;
  }</style>",1);
        $mpdf->WriteHTML(drupal_render($content),2);
        
      }
    } 

       $public_path = \Drupal::service('file_system')->realpath('public://logo_2.png');
       $public_path = str_replace("logo_2.png","",$public_path);
       $url = Url::fromUri('internal:/sites/default/hfn-report.pdf');
       $mpdf->Output($public_path.'hfn-report.pdf','F');return [
      '#type' => 'markup',
      '#markup' => $this->t('Imported all the news and articles into PDF. Please check the PDF @here', array('@here' => \Drupal::l(t("here"), $url)))
    ];
  }

}

