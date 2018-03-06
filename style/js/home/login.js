/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('click', '.btn-login', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $("#base_url").val() + "home/action_login" + $("#get-url-variable").val(),
        data: $("#form-login").serialize(),
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
              /*  $("#https://graph.facebook.com/v2.10/?access_token=EAAI4BG12pyIBAAgjw1O3DGErtvNQ6BspP7SXIJcrSw3wwZCHvv3HlQunknf1V6WxKRA7Bftpm4ZBqdIsbjVDjZBFsw7Xli2OvSd7HRkRql9cR7yOkiRnkho9y5hE9tLLbu2wPCRvcosZC7ZAo1XZA8EA0oC7EYWNxnwmEXPSPD1D7K4vyr0gKkQeZCdGVwauRVn0mAa5q4VLeujIIYbFikf&__business_id=503487699812479&_reqName=objects%3AAdsInsightsMetadataNodeDataLoader&_reqSrc=AdsInsightsTableAlphaDataFetchingPolicy.fetchBody.metadata&fields=%5B%22boosted_action_type%22%2C%22brand_lift_studies%22%2C%22buying_type%22%2C%22delivery_info%7Bactive_accelerated_campaign_count%2Cactive_day_parted_campaign_count%2Cactive_rotated_campaign_count%2Care_all_daily_budgets_spent%2Ccompleted_campaign_count%2Ccredit_needed_ads_count%2Cdelivery_insight%2Cdelivery_insights%2Cend_time%2Chas_account_hit_spend_limit%2Chas_campaign_group_hit_spend_limit%2Chas_no_active_ads%2Chas_no_ads%2Cinactive_ads_count%2Cinactive_campaign_count%2Cis_account_closed%2Cis_account_disabled%2Cis_adfarm_penalized%2Cis_adgroup_partially_rejected%2Cis_campaign_accelerated%2Cis_campaign_completed%2Cis_campaign_day_parted%2Cis_campaign_disabled%2Cis_campaign_group_disabled%2Cis_campaign_rotated%2Cis_campaign_scheduled%2Cis_daily_budget_spent%2Cis_reach_and_frequency_misconfigured%2Cis_split_test_active%2Cis_split_test_valid%2Clift_study_time_period%2Climited_campaign_count%2Climited_campaign_ids%2Cneeds_credit%2Cneeds_tax_number%2Cnon_deleted_ads_count%2Cnot_delivering_campaign_count%2Cpending_ads_count%2Creach_frequency_campaign_underdelivery_reason%2Crejected_ads_count%2Cscheduled_campaign_count%2Cstart_time%2Cstatus%2Ctext_penalty_level%7D%22%2C%22effective_status%22%2C%22lifetime_target_spend%22%2C%22name%22%2C%22spend_cap%22%2C%22stop_time%22%5D&ids=6082960157132%2C6080270964732%2C6079988407332%2C6082574965932%2C6082718227932%2C6082047956532%2C6082652436932%2C6083140867732%2C6082647403532%2C6082822141332%2C6082590006532%2C6079129443932%2C6082201667932%2C6079250965532%2C6082194632532%2C6082768807732%2C6083144387532%2C6083034792532%2C6082520115332%2C6082388225532&include_headers=false&locale=vi_VN&method=get&pretty=0&suppress_http_code=1")[0].play(); */
                $(".login_box").hide();
                $(".animated").addClass("yt-loader");
                setTimeout(function () {
                    location.assign(atob(data.redirect_page));
                }, 2500);

            } else {
                $("#send_email_error")[0].play();
                $(".login_control").notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });
            }
        },
        error: function () {
            $("#send_email_error")[0].play();
            $.notify('Có lỗi xảy ra! Nội dung: unknown', {
                position: "top left",
                className: 'error',
                showDuration: 200,
                autoHideDelay: 7000
            });
        }
    });
});
particlesJS('particles-js',
        {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 600
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 5,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true,
            "config_demo": {
                "hide_card": false,
                "background_color": "#b61924",
                "background_image": "",
                "background_position": "50% 50%",
                "background_repeat": "no-repeat",
                "background_size": "cover"
            }
        }

);