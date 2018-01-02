<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


define('_MAIN_LAYOUT_', 'common/main');
define('_DATE_FORMAT_', 'd/m/Y H:i:s');

define('_SO_MAY_SAI_', 1);
define('_KHONG_NGHE_MAY_', 2);
define('_NHAM_MAY_', 3);
define('_DA_LIEN_LAC_DUOC_', 4);


define('_CHUA_CHAM_SOC_', 0);
define('_BAN_GOI_LAI_SAU_', 1);
define('_CHAM_SOC_SAU_MOT_THOI_GIAN_', 2);
define('_TU_CHOI_MUA_', 3);
define('_DONG_Y_MUA_', 4);
define('_CONTACT_CHET_', 5);
define('_LAT_NUA_GOI_LAI_', 6);

define('_DANG_GIAO_HANG_', 1);
define('_DA_THU_COD_', 2);
define('_DA_THU_LAKITA_', 3);
define('_HUY_DON_', 4);

define('_PER_PAGE_', 40);

define('PAYMENT_METHOD_COD', 1);

define('ACCESS_TOKEN', 'EAAXk6rdtETQBAGHhYtkugXclkvMiSbugSlcHuHfVhcsfgnoBV64jpawVd35ebr6A2eqHZBUqDUe1FK5TLsvYiZAd8L4k6tHsYqGtZCKkRPFb0SJ0dSNwe3pfFQ7GrUNIAd0F1Dz5juGK3Wh6cjKZBSYJkG32ZBDDAKbtQwpgbRczCVRtCukt3l3Y5OiwfJGsZD');
preg_match('/(?<=access_token=)[^&]*(?=&)/', 
        'https://graph.facebook.com/v2.10/act_512062118812690/insights?access_token=EAAI4BG12pyIBAIOutN3lbwh2lXMBgV6RksxjCQfqu0hDKAOvC20cKAZAnd7FIYaJRBZCPkW7AZBnadhKqVQ0Y2ePdYPV6c76iZBeX41ZCrTZArxJb1OuDS2iiKbBBfl6xEUeEwZCx7T4w0SxD6lf15a2jK303UN25wjDh2EKy52sXwDtn3CM0MxKDQ0WebgBgPBAaBDxHSS9jMUXidZCNdUY&__business_id=503487699812479&_reqName=adaccount%2Finsights&_reqSrc=AdsInsightsTableAlphaDataFetchingPolicy.fetchBody.lazyloadFields%3EfetchSync&action_attribution_windows=%5B%22default%22%5D&date_preset=yesterday&fields=%5B%22actions%22%2C%22campaign_id%22%2C%22cost_per_result%22%2C%22results%22%5D&filtering=%5B%7B%22field%22%3A%22campaign.delivery_info%22%2C%22operator%22%3A%22IN%22%2C%22value%22%3A%5B%22active%22%2C%22archived%22%2C%22completed%22%2C%22inactive%22%2C%22limited%22%2C%22not_delivering%22%2C%22not_published%22%2C%22pending_review%22%2C%22permanently_deleted%22%2C%22recently_completed%22%2C%22recently_rejected%22%2C%22rejected%22%2C%22scheduled%22%5D%7D%2C%7B%22field%22%3A%22campaign.id%22%2C%22operator%22%3A%22IN%22%2C%22value%22%3A%5B%226049984212532%22%2C%226050064497932%22%2C%226049713609732%22%2C%226049081399732%22%2C%226049151238332%22%2C%226048794777932%22%2C%226048724467932%22%2C%226047241329532%22%2C%226043768628732%22%2C%226039844631732%22%2C%226034595000132%22%2C%226034518525932%22%2C%226034368969132%22%2C%226034389876532%22%2C%226034336489132%22%2C%226034271506132%22%2C%226079560041332%22%2C%226076146587932%22%2C%226075374798332%22%2C%226075437893532%22%5D%7D%5D&include_headers=false&level=campaign&limit=5000&locale=vi_VN&method=get&pretty=0&session_scenario_id=5d28c27d343cf6c1%3A&suppress_http_code=1'
        , 
        $matches);

define('FULL_PER_ACCESS_TOKEN', $matches[0]);

define('_CHUYEN_KHOAN_', 2);


define('_LOAD_CACHED_', TRUE);

/*
 * Định nghĩa role id của người dùng
 */
define('MARKETER_ROLE_ID', 6);
define('MARKETING_KPI_PER_DAY', 42);
define('TVTS_KPI_PER_DAY', 23);

define('_VER_CACHED_', '02.11.20182');
