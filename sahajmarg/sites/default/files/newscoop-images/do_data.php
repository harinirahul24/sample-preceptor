<?php
/**
 * @package Campsite
 *
 * @author Petr Jasek <petr.jasek@sourcefabric.org>
 * @copyright 2010 Sourcefabric o.p.s.
 * @license http://www.gnu.org/licenses/gpl.txt
 * @link http://www.sourcefabric.org
 */


require_once dirname(__FILE__) . '/ArticleList.php';
require_once WWW_DIR . '/classes/Article.php';

require_once($GLOBALS['g_campsiteDir'].'/classes/ArticleType.php');

$list = new ArticleList(TRUE);

// start >= 0
$start = max(0,
    empty($_REQUEST['iDisplayStart']) ? 0 : (int) $_REQUEST['iDisplayStart']);

// results num >= 10 && <= 100
$limit = min(100, max(10,
    empty($_REQUEST['iDisplayLength']) ? 0 : (int) $_REQUEST['iDisplayLength']));

// filters - common
$articlesParams = array();
$filters = array(
    'publication' => array('is', 'integer'),
    'issue' => array('is', 'integer'),
    'section' => array('is', 'integer'),
	'country' => array('is', 'integer'),
    'language' => array('is', 'integer'),
    'publish_date' => array('is', 'date'),
    'publish_date_from' => array('greater_equal', 'date'),
    'publish_date_to' => array('smaller_equal', 'date'),
    'author' => array('is', 'integer'),
    'topic' => array('is', 'integer'),
    'workflow_status' => array('is', 'string'),
    'creator' => array('is', 'integer'),
    'type' => array('is', 'string'),
);

// mapping form name => db name
$fields = array(
    'publish_date_from' => 'publish_date',
    'publish_date_to' => 'publish_date',
    'language' => 'idlanguage',
    'creator' => 'iduser',
);

//fix for the new issue filters
if( isset($_REQUEST['issue']) && $_REQUEST['issue'] > 0 ) {
	if($_REQUEST['issue'] != 0) {
		$issueFiltersArray = explode('_', $_REQUEST['issue']);
		if(count($issueFiltersArray) > 1) {
            if (empty($_REQUEST['publication'])) {
			    $_REQUEST['publication'] = $issueFiltersArray[0];
            }

			$_REQUEST['issue'] = $issueFiltersArray[1];
			$_REQUEST['language'] = $issueFiltersArray[2];
		}
	}
}

//fix for the new section filters
if( isset($_REQUEST['section']) && $_REQUEST['section'] > 0 ) {
	if($_REQUEST['section'] != 0) {
		$sectionFiltersArray = explode('_', $_REQUEST['section']);
		if(count($sectionFiltersArray) > 1) {
            if (empty($_REQUEST['publication'])) {
			    $_REQUEST['publication'] = $sectionFiltersArray[0];
            }

            if (empty($_REQUEST['language'])) {
			    $_REQUEST['language'] = $sectionFiltersArray[2];
            }

			$_REQUEST['section'] = $sectionFiltersArray[3];
		}
	}
}

foreach ($filters as $name => $opts) {
    if (isset($_REQUEST[$name])
    && (!empty($_REQUEST[$name]) || $_REQUEST[$name] === 0)) {
        $field = !empty($fields[$name]) ? $fields[$name] : $name;
        //error_log("The field is: ".$field,0);
        $articlesParams[] = new ComparisonOperation($field, new Operator($opts[0], $opts[1]), $_REQUEST[$name]);
    }
}
//error_log("The filters are: ".$filters,0);


if (empty($_REQUEST['showtype']) || $_REQUEST['showtype'] != 'with_filtered') { // limit articles of filtered types by default

    foreach((array) \ArticleType::GetArticleTypes(true) as $one_art_type_name) {
        $one_art_type = new \ArticleType($one_art_type_name);
        //error_log("In articles, what is one_art_type->getTypeName(): ".$one_art_type->getTypeName(),0);
        if ($one_art_type->getFilterStatus()) {
            $articlesParams[] = new ComparisonOperation('type', new Operator('not', 'string'), $one_art_type->getTypeName());
        }
    }

}

// search
if (isset($_REQUEST['sSearch']) && strlen($_REQUEST['sSearch']) > 0) {
    $search_phrase = $_REQUEST['sSearch'];
    //$articlesParams[] = new ComparisonOperation('search_phrase', new Operator('is', 'integer'), $search_phrase);
    $articlesParams[] = new ComparisonOperation('search_phrase', new Operator('like', 'string'), "__match_all.".$search_phrase);
}

// sorting
$cols = $list->getColumnKeys();
$sortOptions = array(
    'Number' => 'bynumber',
    'Order' => 'bysectionorder',
    'Name' => 'byname',
    'Comments' => 'bycomments',
    'Reads' => 'bypopularity',
    'CreateDate' => 'bycreationdate',
    'PublishDate' => 'bypublishdate',
);

$sortBy = 'bysectionorder';
$sortDir = 'asc';
$sortingCols = min(1, (int) $_REQUEST['iSortingCols']);
for ($i = 0; $i < $sortingCols; $i++) {
    $sortOptionsKey = (int) $_REQUEST['iSortCol_' . $i];
    if (!empty($sortOptions[$cols[$sortOptionsKey]])) {
        $sortBy = $sortOptions[$cols[$sortOptionsKey]];
        $sortDir = $_REQUEST['sSortDir_' . $i];
        break;
    }
}

global $g_ado_db;
$f_user_id = $_SESSION["Zend_Auth_Storage"]["storage"];
$sql = 'SELECT  max(group_id) FROM liveuser_groupusers WHERE group_id IN (14,15,16,17) AND perm_user_id = "'.$f_user_id.'"';
$userType = $g_ado_db->getAll($sql);
//foreach($userType as $ust){
  //  foreach($ust as $uust){
    //    error_log("User type key is ".key($ust)." and value is ".$uust,0);
    //}
//}
//error_log("Inside do_data, usertype is ".$userType,0);
switch ($userType['0']['max(group_id)']) {
    case '14':
        //error_log("Entering Switch with case = 16",0);
        $sql = 'SELECT CityId FROM liveuser_users WHERE Id = "'.$f_user_id.'"';
        $userCity = $g_ado_db->getAll($sql);
        array_push($articlesParams, new ComparisonOperation('FCenter', new Operator('like', 'string'), $userCity['0']['CityId']));
        break;
    case '15':
        $sql = 'SELECT StateId FROM liveuser_users WHERE Id = "'.$f_user_id.'"';
        $userState = $g_ado_db->getAll($sql);
        array_push($articlesParams, new ComparisonOperation('FState', new Operator('like', 'string'), $userState['0']['StateId']));
        break;
    case '16':
        //error_log("Entering Switch with case = 16",0);
        $sql = 'SELECT CountryId FROM liveuser_users WHERE Id = "'.$f_user_id.'"';
        $userCountry = $g_ado_db->getAll($sql);
        //error_log("Inside Country Switch in do_data with usercountry = ".$userCountry['0']['CountryId'],0);
        array_push($articlesParams, new ComparisonOperation('FCountry', new Operator('like', 'string'), $userCountry['0']['CountryId']));
        //error_log("Inside Country Switch in do_data with usercountry = ".$userCountry['0']['CountryId'],0);
        break;
}

// get articles
$articles = Article::GetList($articlesParams, array(array('field' => $sortBy, 'dir' => $sortDir)), $start, $limit, $articlesCount, true);

$return = array();
foreach($articles as $article) {
    $return[] = $list->processItem($article);
}

$articleContent = array();
foreach($articles as $article){
    $sql = 'SELECT XAshram_Activity.FDescription FROM XAshram_Activity WHERE XAshram_Activity.NrArticle = "'.$article->getArticleNumber().'" AND XAshram_Activity.IdLanguage = "'.$article->getLanguageId().'" UNION SELECT XCentre_Activity.FDescription FROM XCentre_Activity WHERE XCentre_Activity.NrArticle = "'.$article->getArticleNumber().'" AND XCentre_Activity.IdLanguage = "'.$article->getLanguageId().'" UNION SELECT XRetreat_Centre.FDescription FROM XRetreat_Centre WHERE XRetreat_Centre.NrArticle = "'.$article->getArticleNumber().'" AND XRetreat_Centre.IdLanguage = "'.$article->getLanguageId().'" UNION SELECT XNews_And_Events.FDescription FROM XNews_And_Events WHERE XNews_And_Events.NrArticle = "'.$article->getArticleNumber().'" AND XNews_And_Events.IdLanguage = "'.$article->getLanguageId().'" UNION SELECT XCrest.FDescription FROM XCrest WHERE XCrest.NrArticle = "'.$article->getArticleNumber().'" AND XCrest.IdLanguage = "'.$article->getLanguageId().'" UNION SELECT XMaster.FDescription FROM XMaster WHERE XMaster.NrArticle = "'.$article->getArticleNumber().'" AND XMaster.IdLanguage = "'.$article->getLanguageId().'"';
    $contentTemp = $g_ado_db->getAll($sql);
    //error_log("The article name is: ".$article->getName(),0);
    //foreach($contentTemp as $ct){
    //    foreach($ct as $cct){
    //        error_log("The contents Temp is: ".$cct." and the key is ".key($ct),0);
    //    }
    //}
    //$articleContent[] = $article->getName();
    $to_compare = '/<tr> <td class="xl66" colspan="3" height="20"><strong>Program Title<\/strong><\/td> <td class="xl67" colspan="4"> <\/td> <\/tr> <tr> <td class="xl66" colspan="3" height="20">Date <\/td> <td class="xl67" colspan="4"> <\/td> <\/tr> <tr> <td class="xl66" colspan="3" height="20">No of people attended<\/td> <td class="xl68" colspan="4"> <\/td> <\/tr> <tr> <td class="xl66" colspan="3" height="20">Photos attached<\/td> <td class="xl67" colspan="4"> <\/td> \<\/tr> <tr> <td class="xl65" rowspan="5" colspan="7" valign="top" height="100">Brief Description<\/td> <\/tr>/';
    
    $to_compare = array('/<table style="width: 1293px; height: 200px;" border="1" cellspacing="0" cellpadding="0"><colgroup><col width="161" \/> <col width="66" \/> <col width="82" \/> <col width="68" \/> <col width="62" \/> <col width="68" \/> <col width="120" \/> <\/colgroup><tbody><tr> <td class="xl66" colspan="3" height="20"><strong>Program Title<\/strong><\/td> <td class="xl67" colspan="4"> <\/td> <\/tr> <tr> <td class="xl66" colspan="3" height="20">Date <\/td> <td class="xl67" colspan="4"> <\/td> <\/tr> <tr> <td class="xl66" colspan="3" height="20">No of people attended<\/td> <td class="xl68" colspan="4"> <\/td> <\/tr> <tr> <td class="xl66" colspan="3" height="20">Photos attached<\/td> <td class="xl67" colspan="4"> <\/td> \<\/tr> <tr> <td class="xl65" rowspan="5" colspan="7" valign="top" height="100">Brief Description<\/td> <\/tr><\/tbody><\/table>/',
    '/<table style="width: 1293px; height: 200px;" border="1" cellspacing="0" cellpadding="0"><colgroup><col width="161" \/> <col width="66" \/> <col width="82" \/> <col width="68" \/> <col width="62" \/> <col width="68" \/> <col width="120" \/> <\/colgroup>\r\n<tbody>\r\n<tr>\r\n<td class="xl66" colspan="3" height="20"><strong>Program Title<\/strong><\/td>\r\n<td class="xl67" colspan="4">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl66" colspan="3" height="20">Date<\/td>\r\n<td class="xl67" colspan="4">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl66" colspan="3" height="20">No of people attended<\/td>\r\n<td class="xl68" colspan="4">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl66" colspan="3" height="20">Photos attached<\/td>\r\n<td class="xl67" colspan="4">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl65" rowspan="5" colspan="7" valign="top" height="100">Brief Description<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n/', 
    '/<tr> <td class="xl68" width="234" height="20"><strong>Sunday Satsangh Attendance<\/strong><\/td> <td class="xl69" width="180"> <\/td> <td class="xl69" width="113"> <\/td> <td class="xl69" width="110"> <\/td> <td width="83"> <\/td> <td width="126"> <\/td> <td width="122"> <\/td> <td width="90"> <\/td> <\/tr> <tr> <td class="xl69" height="20"> <\/td> <td class="xl69">Month 1<\/td> <td class="xl69">Month 2<\/td> <td class="xl69">Month 3<\/td> <td class="xl69"> <\/td> <td class="xl69"> <\/td> <td class="xl69"> <\/td> <td> <\/td> <\/tr> <tr> <td class="xl70" height="20">Week 1<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr> <tr> <td class="xl70" height="20">Week 2<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr> <tr> <td class="xl70" height="20">Week 3<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr> <tr> <td class="xl70" height="20">Week 4<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr> <tr> <td class="xl70" height="20">Week 5<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr> <tr> <td height="20"> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr>/', 
    '/<tr> <td class="xl65" height="20">No. of gatherings\/quarter<\/td> <td class="xl66"> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr> <tr> <td height="20"> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr> <tr> <td class="xl72" height="20"><strong>Gathering details<\/strong><\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr> <tr> <td height="20"> <\/td> <td class="xl69">Title\/theme<\/td> <td class="xl69">start date\/end date<\/td> <td class="xl69">No of Participants<\/td> <td class="xl69">Total Sittings<\/td> <td class="xl69">Suggested Donation<\/td> <td class="xl73">Total donation Amt.<\/td> <td class="xl69">Total Expense<\/td> <\/tr> <tr> <td class="xl65" height="20">Gathering 1<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl74"> <\/td> <td class="xl75"> <\/td> <td class="xl76"> <\/td> <td class="xl76"> <\/td> <\/tr> <tr> <td class="xl77" height="20">Gathering 2<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl74"> <\/td> <td class="xl75"> <\/td> <td class="xl76"> <\/td> <td class="xl76"> <\/td> <\/tr> <tr> <td class="xl65" height="20">Gathering 3<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl75"> <\/td> <td class="xl78"> <\/td> <td class="xl78"> <\/td> <\/tr> <tr> <td height="20">Gathering 4<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <\/tr> <tr> <td height="20"> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr>/', 
    '/<tr> <td class="xl65" height="20">Workshops and Open Houses\/qtr<\/td> <td class="xl66"> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <td> <\/td> <\/tr> <tr> <td height="20"> <\/td> <td class="xl69"> <\/td> <td class="xl69"> <\/td> <td class="xl69"> <\/td> <td class="xl69"> <\/td> <td class="xl69"> <\/td> <td class="xl73"> <\/td> <td class="xl69"> <\/td> <\/tr> <tr> <td class="xl72" height="20"><strong>Workshop\/OH details<\/strong><\/td> <td class="xl69"> <\/td> <td class="xl69"> <\/td> <td class="xl69"> <\/td> <td class="xl69"> <\/td> <td class="xl69"> <\/td> <td class="xl73"> <\/td> <td class="xl69"> <\/td> <\/tr> <tr> <td height="20"> <\/td> <td class="xl69">Title\/theme<\/td> <td class="xl69">start date\/end date<\/td> <td class="xl69">No of Participants<\/td> <td class="xl69">Total Sittings<\/td> <td class="xl69">Suggested Donation<\/td> <td class="xl73">Total donation Amt.<\/td> <td class="xl69">Total Expense<\/td> <\/tr> <tr> <td class="xl65" height="20">Workshop\/OH 1  <\/td> <td class="xl71"> <\/td> <td class="xl79"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl80"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <\/tr> <tr> <td class="xl65" height="20">Workshop\/OH 2<\/td> <td class="xl71"> <\/td> <td class="xl79"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <\/tr> <tr> <td class="xl65" height="20">Workshop\/OH 3<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <\/tr> <tr> <td class="xl65" height="20">Workshop\/OH 4<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <\/tr> <tr> <td class="xl65" height="20">Workshop\/OH 5<\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <td class="xl71"> <\/td> <\/tr>/',
    '/<tr>\r\n<td class="xl72" height="20"><strong>Gathering details<\/strong><\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td height="20">\xc2\xa0<\/td>\r\n<td class="xl69">Title\/theme<\/td>\r\n<td class="xl69">start date\/end date<\/td>\r\n<td class="xl69">No of Participants<\/td>\r\n<td class="xl69">Total Sittings<\/td>\r\n<td class="xl69">Suggested Donation<\/td>\r\n<td class="xl73">Total donation Amt.<\/td>\r\n<td class="xl69">Total Expense<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl65" height="20">Gathering 1<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl74">\xc2\xa0<\/td>\r\n<td class="xl75">\xc2\xa0<\/td>\r\n<td class="xl76">\xc2\xa0<\/td>\r\n<td class="xl76">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl77" height="20">Gathering 2<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl74">\xc2\xa0<\/td>\r\n<td class="xl75">\xc2\xa0<\/td>\r\n<td class="xl76">\xc2\xa0<\/td>\r\n<td class="xl76">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl65" height="20">Gathering 3<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl75">\xc2\xa0<\/td>\r\n<td class="xl78">\xc2\xa0<\/td>\r\n<td class="xl78">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td height="20">Gathering 4<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td height="20">\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<\/tr>\r\n/',
    '/<td class="xl72" height="20"><strong>Workshop\/OH details<\/strong><\/td>\r\n<td class="xl69">\xc2\xa0<\/td>\r\n<td class="xl69">\xc2\xa0<\/td>\r\n<td class="xl69">\xc2\xa0<\/td>\r\n<td class="xl69">\xc2\xa0<\/td>\r\n<td class="xl69">\xc2\xa0<\/td>\r\n<td class="xl73">\xc2\xa0<\/td>\r\n<td class="xl69">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td height="20">\xc2\xa0<\/td>\r\n<td class="xl69">Title\/theme<\/td>\r\n<td class="xl69">start date\/end date<\/td>\r\n<td class="xl69">No of Participants<\/td>\r\n<td class="xl69">Total Sittings<\/td>\r\n<td class="xl69">Suggested Donation<\/td>\r\n<td class="xl73">Total donation Amt.<\/td>\r\n<td class="xl69">Total Expense<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl65" height="20">Workshop\/OH 1<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl79">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl80">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl65" height="20">Workshop\/OH 2<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl79">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl65" height="20">Workshop\/OH 3<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl65" height="20">Workshop\/OH 4<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class="xl65" height="20">Workshop\/OH 5<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<td class="xl71">\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td height="20">\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<td>\xc2\xa0<\/td>\r\n<\/tr>\r\n<tr>\r\n<td height="20">\xc2\xa0<\/td>\r\n/'); 
    $to_replace_string = array(" "," "," "," "," "," "," ");
    $string_to_change = $contentTemp['0']['FDescription'];
    global $Campsite;
    //error_log("The length of the article is: ".strlen($string_to_change),0);
    $contentToUpload = preg_replace($to_compare,$to_replace_string,$string_to_change);
    $queryString = 'SELECT Images.ImageFileName'
					.' FROM Images, ArticleImages'
					.' WHERE ArticleImages.NrArticle='.$article->getArticleNumber()
					.' AND ArticleImages.IdImage=Images.Id';
                    
    $queryResult = $g_ado_db->getAll($queryString);
    $images = $queryResult[0]['ImageFileName'];
    //error_log("images contains: ".$images,0);
    //error_log("The location of storage is ",0);
    $imageLocation = "";
    if (is_array($images)){
        foreach($images as $image){
            $imageLocation .= '<img src ='.$Campsite['IMAGE_DIRECTORY'].$image.'></img>';
        }
    }
    else{
        $imageLocation = '<img src ='.$Campsite['IMAGE_DIRECTORY'].$images.'></img>';
    }
    //error_log("The replaced content is: ".$contentToUpload,0);
    //if(strpos($contentToUpload,"table cellspacing") === FALSE){
        $articleContent[] =  "<div class='contentWrapper'><div class='contentHeader'><b style='font-size:30px; border-bottom:15px;'>".$article->getName()."</b></div><div class='contentBody'>".$contentToUpload.$imageLocation."</div></div>";
    //}
    //else{
        
        //$articleContent[] =  "<b style='font-size:30px; border-bottom:15px;'>".$article->getName()."</b><br/>".$contentToUpload."<br/><br/><br/><br/>";
    //}
}
return array(
    'iTotalRecords' => Article::GetTotalCount(),
    'iTotalDisplayRecords' => $articlesCount,
    'sEcho' => (int) $_REQUEST['sEcho'],
    'aaData' => $return,
    'aaContent' => $articleContent,
);
