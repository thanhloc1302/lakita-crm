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
        'https://graph.facebook.com/v2.10/?access_token=EAAI4BG12pyIBABs0IfxMXYuIqBWIu6pN7Y8UUvWjxZCGKV7MGXrANkZBepzoHDfGl6ZA1sYZAkawhtNtNbMwrpCRZBTxeMz1d29gghQYYMGo5pM5v8DzMZBFG5oWCaXbGbH3nvZC7x1ZCAn0pQdHAnWuKRXwTyrGvZBrdfI49pLAcKfcSqxmGkryZAtfdP8ZCdhQMVYBZA7CnDXbFliwA3ART7ZAq&__business_id=503487699812479&_reqName=objects%3AAdsInsightsMetadataNodeDataLoader&_reqSrc=AdsInsightsTableAlphaDataFetchingPolicy.fetchBody.metadata&fields=%5B%22boosted_action_type%22%2C%22brand_lift_studies%22%2C%22buying_type%22%2C%22delivery_info%7Bactive_accelerated_campaign_count%2Cactive_day_parted_campaign_count%2Cactive_rotated_campaign_count%2Care_all_daily_budgets_spent%2Ccompleted_campaign_count%2Ccredit_needed_ads_count%2Cdelivery_insight%2Cdelivery_insights%2Cend_time%2Chas_account_hit_spend_limit%2Chas_campaign_group_hit_spend_limit%2Chas_no_active_ads%2Chas_no_ads%2Cinactive_ads_count%2Cinactive_campaign_count%2Cis_account_closed%2Cis_account_disabled%2Cis_adfarm_penalized%2Cis_adgroup_partially_rejected%2Cis_campaign_accelerated%2Cis_campaign_completed%2Cis_campaign_day_parted%2Cis_campaign_disabled%2Cis_campaign_group_disabled%2Cis_campaign_rotated%2Cis_campaign_scheduled%2Cis_daily_budget_spent%2Cis_reach_and_frequency_misconfigured%2Cis_split_test_active%2Cis_split_test_valid%2Clift_study_time_period%2Climited_campaign_count%2Climited_campaign_ids%2Cneeds_credit%2Cneeds_tax_number%2Cnon_deleted_ads_count%2Cnot_delivering_campaign_count%2Cpending_ads_count%2Creach_frequency_campaign_underdelivery_reason%2Crejected_ads_count%2Cscheduled_campaign_count%2Cstart_time%2Cstatus%2Ctext_penalty_level%7D%22%2C%22effective_status%22%2C%22lifetime_target_spend%22%2C%22name%22%2C%22spend_cap%22%2C%22stop_time%22%5D&ids=6082647403532%2C6085030370132%2C6085109313332%2C6082201667932%2C6079250965532%2C6082194632532%2C6084007119732%2C6084497732532%2C6084250598332%2C6084061512732%2C6083997103532%2C6083626772332%2C6083553716132%2C6083550996332&include_headers=false&locale=vi_VN&method=get&pretty=0&suppress_http_code=1'
        , 
        $matches);

define('FULL_PER_ACCESS_TOKEN', $matches[0]);

define('_CHUYEN_KHOAN_', 2);


define('_LOAD_CACHED_', TRUE);

/*
 * Định nghĩa role id của người dùng
 */
define('MARKETER_ROLE_ID', 6);
define('MARKETING_KPI_PER_DAY', 46);
define('TVTS_KPI_PER_DAY', 30);

define('_VER_CACHED_', '18.01.20182');
