
var revapi2,
    tpj;
(function() {
    if (!/loaded|interactive|complete/.test(document.readyState)) document.addEventListener("DOMContentLoaded",onLoad); else onLoad();

    function onLoad() {
        if (tpj===undefined) { tpj = jQuery; if("off" == "on") tpj.noConflict();}
        if(tpj("#rev_slider_2_1").revolution == undefined){
            revslider_showDoubleJqueryError("#rev_slider_2_1");
        }else{
            revapi2 = tpj("#rev_slider_2_1").show().revolution({
                sliderType:"standard",
                jsFileLocation:"//localhost:82/revslider/revslider/public/assets/js/",
                sliderLayout:"fullscreen",
                dottedOverlay:"none",
                delay:9000,
                navigation: {
                    keyboardNavigation:"off",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation:"off",
                    mouseScrollReverse:"default",
                    onHoverStop:"off",
                    arrows: {
                        style:"uranus",
                        enable:true,
                        hide_onmobile:false,
                        hide_onleave:false,
                        tmp:'',
                        left: {
                            h_align:"left",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        },
                        right: {
                            h_align:"right",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        }
                    }
                },
                responsiveLevels:[1240,1024,778,480],
                visibilityLevels:[1240,1024,778,480],
                gridwidth:[1240,1024,778,480],
                gridheight:[868,768,960,720],
                lazyType:"none",
                parallax: {
                    type:"3D",
                    origo:"slidercenter",
                    speed:400,
                    speedbg:0,
                    speedls:0,
                    levels:[5,10,15,20,25,30,35,40,-2,-4,-6,-8,-10,-12,-14,55],
                    ddd_shadow:"off",
                    ddd_bgfreeze:"on",
                    ddd_overflow:"hidden",
                    ddd_layer_overflow:"hidden",
                    ddd_z_correction:150,
                    disable_onmobile:"on"
                },
                spinner:"off",
                stopLoop:"on",
                stopAfterLoops:0,
                stopAtSlide:1,
                shuffle:"off",
                autoHeight:"off",
                fullScreenAutoWidth:"off",
                fullScreenAlignForce:"off",
                fullScreenOffsetContainer: "",
                fullScreenOffset: "",
                disableProgressBar:"on",
                hideThumbsOnMobile:"off",
                hideSliderAtLimit:0,
                hideCaptionAtLimit:0,
                hideAllCaptionAtLilmit:0,
                debugMode:false,
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            });
        }; /* END OF revapi call */

        if(typeof ExplodingLayersAddOn !== "undefined") ExplodingLayersAddOn(tpj, revapi2);

        RevSliderPaintBrush(tpj, revapi2);
    }; /* END OF ON LOAD FUNCTION */
}()); /* END OF WRAPPING FUNCTION */

