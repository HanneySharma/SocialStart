<?php
/**
 * Custom Helper
 *
 * For custom theme specific methods.
 *
 * If your theme requires custom methods,
 * copy this file to /app/views/themed/your_theme_alias/helpers/custom.php and modify.
 *
 * You can then use this helper from your theme's views using $custom variable.
 *
 * @category Helper
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
namespace App\View;

namespace App\View\Helper;
 
use Cake\View\Helper;
use Cake\ORM\TableRegistry;
 
class CustomHelper extends Helper {

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
    public $helpers = array();
    
   
    
     public function GetOrganizationsNews($id = null)
    {
         $newsOrg =TableRegistry::get('OrganizationsNews')->find('all')->where(['organization_id'=>$id])->hydrate(false)->limit(1)->toArray();
          return $newsOrg;
         
    }
      function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).' Trillion';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).' Billion';
        elseif ($n > 1000000) return round(($n/1000000), 2).' Million';
        elseif ($n > 1000) return round(($n/1000), 2).' Thousand';

        return number_format($n);
    }
  
  
   
    
    
  
    
   

}
